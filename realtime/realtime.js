import express from 'express';
import cors from 'cors';
import mysql from "mysql";
import chapterPermission from './handlers/chapterPermission.js';
import testcaseResult from './handlers/testcaseResult.js';
import submissionResult from './handlers/submissionResult.js';
import redis from "redis";

const DB_CONFIG = {
  host: "db",
  user: process.env.DATABASE_USER,
  password: process.env.DATABASE_PASSWORD,
  database: process.env.DATABASE_NAME,
};

const REDIS_CONFIG = {
  username: 'default', // use your Redis user. More info https://redis.io/docs/management/security/acl/
  password: process.env.REDIS_PASSWORD, // use your password here
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

const db_connection = mysql.createConnection(DB_CONFIG);

const connectToDatabase = () => {
  db_connection.connect((err) => {
    if (err) {
      console.error('Failed to connect to the database. Retrying in 5 seconds...', err);
      setTimeout(connectToDatabase, 5000);
    } else {
      console.log("Connected to the database!");
    }
  });
};

connectToDatabase();

const app = express();

app.use(cors());

app.get('/subscribe/testcase-result/:job_id', (req, res, next) => testcaseResult(req, res, next, redisClient))
app.get('/subscribe/submission-result/:job_id', (req, res, next) => submissionResult(req, res, next, redisClient))
app.get('/subscribe/chapter-permission/:group_id', (req, res, next) => chapterPermission(req, res, next, redisClient))

app.listen(3001, () => {
  console.log('Server is running on port 3001');
});

