#!/usr/bin/env bash

[ "$DEBUG" = "true" ] && set -x

[ "$PHP_ENABLE_XDEBUG" = "true" ] && docker-php-ext-enable xdebug && echo "Xdebug is enabled"

exec "$@"
