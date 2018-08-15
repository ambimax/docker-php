# Docker Repository for PHP images

[![Build Status](https://travis-ci.org/ambimax/docker-php.svg?branch=master)](https://travis-ci.org/ambimax/docker-php)

## Docker Images

 - php7.0-stretch-cli
 - php7.0-stretch-fpm

## PHP Modules

 - apcu
 - bcmath
 - calendar
 - Core
 - ctype
 - curl
 - date
 - dom
 - exif
 - fileinfo
 - filter
 - ftp
 - gd
 - gettext
 - hash
 - iconv
 - igbinary
 - intl
 - json
 - libxml
 - lzf
 - mbstring
 - mcrypt
 - memcached
 - mysqli
 - mysqlnd
 - openssl
 - pcre
 - PDO
 - pdo_mysql
 - pdo_sqlite
 - Phar
 - posix
 - readline
 - redis
 - Reflection
 - session
 - SimpleXML
 - soap
 - sockets
 - SPL
 - sqlite3
 - standard
 - tidy
 - tokenizer
 - xml
 - xmlreader
 - xmlwriter
 - xsl
 - Zend OPcache
 - zip
 - zlib

## Differences between CLI and FPM

fpm does not contain the following tools:

 - git
 - mysql-client
 - redis-cli

## Environment Variables

- `DEBUG` 
   Enable debug output in container
   
- `PHP_ENABLE_XDEBUG` 
   Enable XDebug

## License

[MIT License](http://choosealicense.com/licenses/mit/)

## Author Information

 - [Tobias Schifftner](https://twitter.com/tschifftner), [ambimax® GmbH](https://www.ambimax.de)