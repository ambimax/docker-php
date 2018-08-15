#!/usr/bin/env bash

## Build dependencies for caching
(cd builder && docker build --pull --cache-from "ambimax/php-builder" -t "ambimax/php-builder" --target builder .)

# PHP 7.0
(cd 7.0/stretch/cli && docker build --pull --cache-from "php7.0-cli-stretch" -t php7.0-cli-stretch .)
(cd 7.0/stretch/fpm && docker build --pull --cache-from "php7.0-fpm-stretch" -t php7.0-fpm-stretch .)

# PHP 7.1
(cd 7.1/stretch/cli && docker build --pull --cache-from "php7.1-cli-stretch" -t php7.1-cli-stretch .)
(cd 7.1/stretch/fpm && docker build --pull --cache-from "php7.1-fpm-stretch" -t php7.1-fpm-stretch .)

# PHP 7.2
(cd 7.2/stretch/cli && docker build --pull --cache-from "php7.2-cli-stretch" -t php7.2-cli-stretch .)
(cd 7.2/stretch/fpm && docker build --pull --cache-from "php7.2-fpm-stretch" -t php7.2-fpm-stretch .)
