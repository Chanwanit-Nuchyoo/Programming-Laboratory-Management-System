<?php
defined('BASEPATH') or exit('No direct script access allowed');

$config['socket_type'] = 'tcp';
$config['socket'] = '/var/run/redis.sock'; // in case of `unix` socket type
$config['host'] = 'redis';
$config['password'] = getenv("REDIS_PASSWORD");
$config['port'] = 6379;
$config['timeout'] = 0;
