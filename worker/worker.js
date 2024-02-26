import amqp from "amqplib";
import mysql from "mysql";
import redis from "redis";
import { addAndUpdateTestcase } from "./runTestcase.js";
import { runSubmission } from "./runSubmission.js";

// Database configuration
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

// RabbitMQ configuration
const RABBITMQ_URL = `amqp://${process.env.RMQ_USER}:${process.env.DATABASE_PASSWORD}@rabbitmq`;
const QUEUE_NAME = process.env.RMQ_QUEUE_NAME;

// Create and connect to the database
const db_pool = mysql.createPool(DB_CONFIG);

// Create a Redis client
const redisClient = redis.createClient(REDIS_CONFIG);

redisClient.on('connect', function () {
  console.log('Connected to Redis');
});

redisClient.on('error', function (err) {
  console.log('Redis error: ' + err);
});

/* const connectToDatabase = () => {
  db_pool.getConnection((err) => {
    if (err) {
      console.error('Failed to connect to the database. Retrying in 5 seconds...', err);
      setTimeout(connectToDatabase, 5000);
    } else {
      console.log("Connected to the database!");
    }
  });
}; */

async function python_consumer() {
  try {
    // Wait for 10 seconds before starting
    await new Promise(resolve => setTimeout(resolve, 10000));

    // Connect to RabbitMQ and create a channel
    const conn = await amqp.connect(RABBITMQ_URL);
    const channel = await conn.createChannel();

    // Assert the queue
    await channel.assertQueue(QUEUE_NAME, { durable: true });

    console.log("Waiting for messages...")

    // Set prefetch count
    channel.prefetch(1);

    // Consume messages from the queue
    channel.consume(QUEUE_NAME, (msg) => {
      const msg_body = JSON.parse(msg.content.toString());
      const { job_type } = msg_body;

      // console.log("-----------------------------------------")
      // console.log("Received a message from the queue:", msg_body);

      if (job_type === "upsert-testcase") {
        addAndUpdateTestcase(channel, db_pool, msg, msg_body, redisClient);
      } else if (job_type === "exercise-submit") {
        runSubmission(channel, db_pool, msg, msg_body, redisClient);
      }

      // console.log("-----------------------------------------")
    });
  } catch (err) {
    console.error('Failed to connect to RabbitMQ. Retrying in 5 seconds...', err);
    setTimeout(python_consumer, 5000);
  }
}

// Start the consumer and database connection
try {
  /* connectToDatabase();
  await redisClient.connect(); */
  python_consumer();
} catch (err) {
  console.log(err.message);
  process.exit(1);
}