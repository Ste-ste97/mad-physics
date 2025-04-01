#!/bin/bash

supervisord
# Start PHP-FPM (Laravel app)
php-fpm

