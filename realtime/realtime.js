import express from 'express';
import cors from 'cors';
import mysql from "mysql";
/* import https from "https"
import fs from 'fs' */
import chapterPermission from './handlers/chapterPermission.js';
import testcaseResult from './handlers/testcaseResult.js';
import submissionResult from './handlers/submissionResult.js';
import onlineStudents from './handlers/onlineStudents.js';
import classLogs from './handlers/classLogs.js';
import redis from "redis";

// SSL certificate and key files
/* const sslOptions = {
  key: fs.readFileSync('/etc/ssl/localhost-key.pem'),
  cert: fs.readFileSync('/etc/ssl/localhost.pem')
}; */

const DB_CONFIG = {
  host: "db",
  user: process.env.DATABASE_USER,
  password: process.env.DATABASE_PASSWORD,
  database: process.env.DATABASE_NAME,
};

const REDIS_CONFIG = {
  username: 'default',
  password: process.env.REDIS_PASSWORD,
  socket: {
    host: 'redis',
    port: 6379,
  }
};

const redisClient = redis.createClient(REDIS_CONFIG);

redisClient.on('connect', function () {
  console.log('Connected to Redis');
});

redisClient.on('error', function (err) {
  console.log('Redis error: ' + err);
});

await redisClient.connect();

// Create a connection pool instead of a single connection
const db_pool = mysql.createPool(DB_CONFIG);

const app = express();

app.use(cors());

app.use((req, res, next) => {
  console.log(req.path);
  next();
});

app.get('/', (req, res) => {
  res.send('/ is working');
});

app.get('/subscribe/testcase-result/:job_id', (req, res, next) => testcaseResult(req, res, next, redisClient))
app.get('/subscribe/submission-result/:job_id', (req, res, next) => submissionResult(req, res, next, redisClient))
app.get('/subscribe/chapter-permission/:group_id', (req, res, next) => chapterPermission(req, res, next, redisClient))
app.get('/subscribe/online-students/:group_id', (req, res, next) => onlineStudents(req, res, next, db_pool, redisClient))
app.get('/subscribe/class-logs/:group_id', (req, res, next) => classLogs(req, res, next, db_pool, redisClient))

app.listen(3002, () => {
  console.log('Server is running on port 3002');
});

/* https.createServer(sslOptions, app).listen(3001, () => {
  console.log('Server is running on port 3001');
}); */