#!/usr/bin/env bash

COMPOSER1=https://getcomposer.org/composer-1.phar
COMPOSER2=https://getcomposer.org/composer-2.phar

read -p "Are you sure? " -n 1 -r
echo    # (optional) move to a new line
if [[ $REPLY =~ ^[Yy]$ ]]; then
    # do dangerous stuff
    echo 1
fi
