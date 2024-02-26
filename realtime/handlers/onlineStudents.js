export default async function onlineStudents(req, res, next, db_pool, redisClient) {
  const subscriber = redisClient.duplicate();
  await subscriber.connect();
  res.set({
    "Content-Type": "text/event-stream",
    "Cache-Control": "no-cache",
    "Connection": "keep-alive"
  });

  const { group_id } = req.params;
  const query = `
  SELECT user.id
  FROM user
  JOIN user_student ON user.id = user_student.stu_id
  WHERE user_student.stu_group = ? AND user.status = ?;
  `;

  // Function to fetch online students from the database
  const fetchOnlineStudents = () => {
    return new Promise((resolve, reject) => {
      db_pool.getConnection((err, connection) => {
        if (err) {
          reject(new Error("Failed to connect to the database."));
        }

        connection.query(query, [group_id, 'online'], (err, results, fields) => {
          if (err) {
            console.error(err);
            connection.release();
            reject([]);
          }
          connection.release();
          resolve(results.map(row => String(row.id)));
        });
      });
    });
  };

  // Fetch online students initially
  let idList = await fetchOnlineStudents();

  res.write(`data: ${JSON.stringify(idList)}\n\n`);

  subscriber.subscribe(`online-students:${group_id}`, (message) => {
    console.log(message);
    const data = JSON.parse(message)

    if (data.action === 'login' && !idList.includes(data.id)) {
      idList.push(data.id);
    } else if (data.action === 'logout') {
      idList = idList.filter(id => id !== data.id);
    }

    res.write(`data: ${JSON.stringify(idList)}\n\n`);
  });

  // Refetch online students from the database periodically
  const intervalId = setInterval(async () => {
    idList = await fetchOnlineStudents();
    res.write(`data: ${JSON.stringify(idList)}\n\n`);
  }, 1000 * 60 * 5); // adjust the interval as needed

  req.on('close', () => {
    subscriber.unsubscribe();
    subscriber.quit();
    clearInterval(intervalId);
  });
}