# Docker Repository for PHP images

[![Build Status](https://travis-ci.org/ambimax/docker-php.svg?branch=master)](https://travis-ci.org/ambimax/docker-php)

Repository for generating php docker images used for Magento and other php projects.

## Docker Images

 - [php7.0-stretch-cli](https://hub.docker.com/r/ambimax/php7.0-cli-stretch/)
 - [php7.0-stretch-fpm](https://hub.docker.com/r/ambimax/php7.0-cli-fpm/)
 - [php7.1-stretch-cli](https://hub.docker.com/r/ambimax/php7.1-cli-stretch/)
 - [php7.1-stretch-fpm](https://hub.docker.com/r/ambimax/php7.1-cli-fpm/)
 - [php7.2-stretch-cli](https://hub.docker.com/r/ambimax/php7.2-cli-stretch/)
 - [php7.2-stretch-fpm](https://hub.docker.com/r/ambimax/php7.2-cli-fpm/)

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
 - mcrypt _(Deprecated and removed in php7.2)_
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
 - modman
 - mysql-client
 - redis-cli
 - zettr

## Environment Variables

- `DEBUG` 
   Enable debug output in container
   
- `PHP_ENABLE_XDEBUG` 
   Enable XDebug

## License

[MIT License](http://choosealicense.com/licenses/mit/)

## Author Information

 - [Tobias Schifftner](https://twitter.com/tschifftner), [ambimax® GmbH](https://www.ambimax.de)