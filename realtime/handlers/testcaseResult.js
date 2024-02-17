export default async function testcaseResult(req, res, next, redisClient) {
  const subscriber = redisClient.duplicate();
  await subscriber.connect();
  res.set({
    "Content-Type": "text/event-stream",
    "Cache-Control": "no-cache",
    "Connection": "keep-alive"
  });

  const { job_id } = req.params;

  subscriber.subscribe(`testcase-result:${job_id}`, (message) => {
    console.log(`testcase-result:${job_id}\n`, message);
    res.write(`data: ${message}\n\n`);
  });

  req.on('close', () => {
    subscriber.unsubscribe();
    subscriber.quit();
  });
}