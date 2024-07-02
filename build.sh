#!/bin/bash

# Install dependencies using Docker
docker run --rm -v $(pwd):/app -w /app php:7.4-cli bash -c "apt-get update && apt-get install -y libssl1.0.0 && composer install"
