#!/bin/bash

# Install Composer dependencies
curl -sS https://getcomposer.org/installer | php
php composer.phar install
