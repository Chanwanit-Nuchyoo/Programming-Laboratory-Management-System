export default async function classLogs(req, res, next, db_pool, redisClient) {
  const subscriber = redisClient.duplicate();
  await subscriber.connect();

  res.set({
    "Content-Type": "text/event-stream",
    "Cache-Control": "no-cache",
    "Connection": "keep-alive"
  })

  const { group_id } = req.params;

  const query = `
  SELECT *
  FROM activity_logs
  WHERE group_id = ?;
  `

  const fetchClassLogs = () => {
    return new Promise((resolve, reject) => {
      db_pool.getConnection((err, connection) => {
        if (err) {
          reject(new Error("Failed to connect to the database."));
        }

        connection.query(query, [group_id], (err, results, fields) => {
          if (err) {
            console.error(err);
            connection.release();
            reject([]);
          }
          connection.release();
          resolve(results);
        });
      });
    });
  }

  let logs = await fetchClassLogs();

  // initially send the all the logs
  res.write(`data: ${JSON.stringify(logs)}\n\n`);

  // when there is an update send that update to client not the whole logs
  subscriber.subscribe(`logs:${group_id}`, (message) => {
    const data = JSON.parse(message);
    res.write(`data: ${JSON.stringify(data)}\n\n`);
  });

  req.on('close', () => {
    subscriber.unsubscribe(`logs:${group_id}`);
    subscriber.quit();
  });
}