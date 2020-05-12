#!/usr/bin/env bash

# PHP 7.0
(cd 7.0/stretch/cli && docker build --pull --cache-from "php7.0-cli-stretch" -t php7.0-cli-stretch .)
(cd 7.0/stretch/fpm && docker build --pull --cache-from "php7.0-fpm-stretch" -t php7.0-fpm-stretch .)

# PHP 7.1
(cd 7.1/stretch/cli && docker build --pull --cache-from "php7.1-cli-stretch" -t php7.1-cli-stretch .)
(cd 7.1/stretch/fpm && docker build --pull --cache-from "php7.1-fpm-stretch" -t php7.1-fpm-stretch .)

# PHP 7.2
(cd 7.2/stretch/cli && docker build --pull --cache-from "php7.2-cli-stretch" -t php7.2-cli-stretch .)
(cd 7.2/stretch/fpm && docker build --pull --cache-from "php7.2-fpm-stretch" -t php7.2-fpm-stretch .)

# PHP 7.4
(cd 7.4/buster/cli && docker build --pull --cache-from "php7.4-cli-buster" -t php7.4-cli-buster .)
(cd 7.4/buster/fpm && docker build --pull --cache-from "php7.4-fpm-buster" -t php7.4-fpm-buster .)
