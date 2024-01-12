import amqp from "amqplib";
import mysql from "mysql";
import { addAndUpdateTestcase } from "./utils.js";

// Database configuration
const DB_CONFIG = {
  host: "db",
  user: "root",
  password: "plmskmitl2023",
  database: "plms-php",
};

// RabbitMQ configuration
const RABBITMQ_URL = "amqp://plms:plmskmitl2023@rabbitmq";
const QUEUE_NAME = "task-queue";

// Create and connect to the database
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
    channel.prefetch(3);

    // Consume messages from the queue
    channel.consume(QUEUE_NAME, (msg) => {
      const msg_body = JSON.parse(msg.content.toString());
      const { job_type } = msg_body;

      console.log("-----------------------------------------")
      console.log("Received a message from the queue:", msg_body);

      if (job_type === "upsert-testcase") {
        addAndUpdateTestcase(channel, db_connection, msg, msg_body);
      } else if (job_type === "exercise-submit") {

      }

      console.log("-----------------------------------------")
    });
  } catch (err) {
    console.error('Failed to connect to RabbitMQ. Retrying in 5 seconds...', err);
    setTimeout(python_consumer, 5000);
  }
}

// Start the consumer and database connection
try {
  connectToDatabase();
  python_consumer();
} catch (err) {
  console.log(err);
  process.exit(1);
}