export default async function chapterPermission(req, res, next, redisClient) {
  const subscriber = redisClient.duplicate();
  await subscriber.connect();
  res.set({
    "Content-Type": "text/event-stream",
    "Cache-Control": "no-cache",
    "Connection": "keep-alive"
  });

  const { group_id } = req.params;
  const { chapter_id } = req.query;

  subscriber.subscribe(`chapter-permission:${group_id}`, (message) => {
    console.log(`chapter-permission:${group_id}`, message);
    res.write(`data: ${message}\n\n`);
  });

  req.on('close', () => {
    subscriber.unsubscribe();
    subscriber.quit();
  });
}