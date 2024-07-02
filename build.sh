#!/bin/bash

# Update package list
apt-get update

# Install required libraries
apt-get install -y libssl1.0.0

# Run composer install
composer install
