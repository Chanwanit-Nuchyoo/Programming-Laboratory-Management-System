#!/bin/bash
chown -R root:root /var/www/html
chmod -R 777 /var/www/html
cd /var/www/html
composer install

apache2-foreground