#!/usr/bin/env bash

## Build dependencies for caching
docker build --tag=builder --file=builder/Dockerfile --target builder .

# PHP 7.0
(cd 7.0/stretch/cli && docker build -t php7.0-cli-stretch .)
(cd 7.0/stretch/fpm && docker build -t php7.0-fpm-stretch .)

# PHP 7.1
(cd 7.1/stretch/cli && docker build -t php7.1-cli-stretch .)
(cd 7.1/stretch/fpm && docker build -t php7.1-fpm-stretch .)
