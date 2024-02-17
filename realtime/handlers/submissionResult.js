export default async function submissionResult(req, res, next, redisClient) {
  const subscriber = redisClient.duplicate();
  await subscriber.connect();
  res.set({
    "Content-Type": "text/event-stream",
    "Cache-Control": "no-cache",
    "Connection": "keep-alive"
  });

  const { job_id } = req.params;

  subscriber.subscribe(`submission-result:${job_id}`, (message) => {
    console.log(`submission-result:${job_id}\n`, message);
    res.write(`data: ${message}\n\n`);
  });

  req.on('close', () => {
    subscriber.unsubscribe();
    subscriber.quit();
  });
}