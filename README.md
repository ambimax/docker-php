# Docker Repository for PHP images

[![Build Status](https://travis-ci.org/ambimax/docker-php.svg?branch=master)](https://travis-ci.org/ambimax/docker-php)

Repository for generating php docker images used for Magento and other php projects.

## Docker Images

 - [php7.0-stretch-cli](https://hub.docker.com/r/ambimax/php7.0-cli-stretch/) *OUTDATED*
 - [php7.0-stretch-fpm](https://hub.docker.com/r/ambimax/php7.0-fpm-stretch/) *OUTDATED*
 - [php7.1-stretch-cli](https://hub.docker.com/r/ambimax/php7.1-cli-stretch/) *OUTDATED*
 - [php7.1-stretch-fpm](https://hub.docker.com/r/ambimax/php7.1-fpm-stretch/) *OUTDATED*
 - [php7.2-stretch-cli](https://hub.docker.com/r/ambimax/php7.2-cli-stretch/)
 - [php7.2-stretch-fpm](https://hub.docker.com/r/ambimax/php7.2-fpm-stretch/)
 - [php7.3-buster-cli](https://hub.docker.com/r/ambimax/php7.3-fpm-buster/)
 - [php7.3-buster-fpm](https://hub.docker.com/r/ambimax/php7.3-cli-buster/) 
 - [php7.4-buster-cli](https://hub.docker.com/r/ambimax/php7.4-fpm-buster/)
 - [php7.4-buster-fpm](https://hub.docker.com/r/ambimax/php7.4-cli-buster/)

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
 - gmp
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
 - pdo_pgsql
 - pgsql
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

cli contains also the following tools:

 - codeception
 - composer
 - git
 - [modman](https://github.com/colinmollenhour/modman)
 - mysql-client nano
 - nano
 - phpcbf3
 - phpcs3
 - phpmd
 - phpunit5
 - phpunit6
 - phpunit7 _(>= php7.1)_
 - redis-cli
 - unzip
 - wget
 - [zettr](https://github.com/AOEpeople/zettr)

 Since PHP 7.4 and 7.3 won't be used in magento1 some tools have been removed in this image.

 Therefor `php7.4-cli-buster` and `php7.3-cli-buster` contains the following tools:
 * codecept
 * composer
 * git
 * mhsendmail
 * mysql-client
 * phpcbf3
 * phpcs3
 * phpmd
 * phpunit8
 * phpunit9
 * php-cs-fixer
 * redis-cli


## Environment Variables

- `DEBUG` 
   Enable debug output in container
   
- `PHP_ENABLE_XDEBUG` 
   Enable XDebug

## Testing

 - [container-structure-test](https://github.com/GoogleContainerTools/container-structure-test)

## Workflow for adding changes to image

 Enter desired image base path
 
 ```
 cd 7.0/stretch/cli
 ```

 Create new image:
 
 ```
 make build-image
 ```
 Run tests before committing any changes
 
 ``` 
 make test
 ```
 
## License

[MIT License](http://choosealicense.com/licenses/mit/)

## Author Information

 - [Tobias Schifftner](https://twitter.com/tschifftner), [ambimax® GmbH](https://www.ambimax.de)
 - Dominik Wißler, [ambimax® GmbH](https://www.ambimax.de) (`php7.4-cli-buster`, `php7.4-fpm-buster`) 
 - Fabian Köhnen, [ambimax® GmbH](https://www.ambimax.de) (`php7.3-cli-buster`, `php7.3-fpm-buster`)
 
