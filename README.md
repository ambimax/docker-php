# docker-php

[![Test Suite](https://github.com/ambimax/docker-php/actions/workflows/default.yaml/badge.svg?branch=v2)](https://github.com/ambimax/docker-php/actions/workflows/default.yaml)

New generation of php containers. All settings can be adjusted on the fly by ENV variables.

Currently supported Frameworks and Apps:

-   Symfony
-   Shopware 6
-   Open Mage / Magento 1
-   Magento 2

## Docker Images on hub.docker.com

### Debian Buster

| PHP Version | Image                                                                                     |
| ----------- | ----------------------------------------------------------------------------------------- |
| 7.3         | [ambimax/php-7.3-buster](https://hub.docker.com/repository/docker/ambimax/php-7.3-buster) |
| 7.4         | [ambimax/php-7.4-buster](https://hub.docker.com/repository/docker/ambimax/php-7.4-buster) |
| 8.0         | [ambimax/php-8.0-buster](https://hub.docker.com/repository/docker/ambimax/php-8.0-buster) |

### Alpine 3.13

| PHP Version | Image                                                                                             |
| ----------- | ------------------------------------------------------------------------------------------------- |
| 7.3         | [ambimax/php-7.3-alpine3.13](https://hub.docker.com/repository/docker/ambimax/php-7.3-alpine3.13) |
| 7.4         | [ambimax/php-7.4-alpine3.13](https://hub.docker.com/repository/docker/ambimax/php-7.4-alpine3.13) |
| 8.0         | [ambimax/php-8.0-alpine3.13](https://hub.docker.com/repository/docker/ambimax/php-8.0-alpine3.13) |

## Environment Variables

| PHP Version | Link                                                                                     |
| ----------- | ---------------------------------------------------------------------------------------- |
| 7.3         | [template/components/php/7.3/assets/all.env](template/components/php/7.3/assets/all.env) |
| 7.4         | [template/components/php/7.4/assets/all.env](template/components/php/7.4/assets/all.env) |
| 8.0         | [template/components/php/8.0/assets/all.env](template/components/php/8.0/assets/all.env) |

## End Of Life

|     Name      |  End Of Life   |
| :-----------: | :------------: |
| Debian Buster |   June, 2024   |
|  Alpine 3.6   | November, 2022 |

## Installed php extensions

| PHP Module   | 7.3 | 7.4 | 8.0 |
| ------------ | --- | --- | --- |
| Core         | ✓   | ✓   | ✓   |
| PDO          | ✓   | ✓   | ✓   |
| Phar         | ✓   | ✓   | ✓   |
| Reflection   | ✓   | ✓   | ✓   |
| SPL          | ✓   | ✓   | ✓   |
| SimpleXML    | ✓   | ✓   | ✓   |
| Zend OPcache | ✓   | ✓   | ✓   |
| apcu         | ✓   | ✓   | ✓   |
| bcmath       | ✓   | ✓   | ✓   |
| calendar     | ✓   | ✓   | ✓   |
| ctype        | ✓   | ✓   | ✓   |
| curl         | ✓   | ✓   | ✓   |
| date         | ✓   | ✓   | ✓   |
| dom          | ✓   | ✓   | ✓   |
| exif         | ✓   | ✓   | ✓   |
| fileinfo     | ✓   | ✓   | ✓   |
| filter       | ✓   | ✓   | ✓   |
| ftp          | ✓   | ✓   | ✓   |
| gd           | ✓   | ✓   | ✓   |
| gettext      | ✓   | ✓   | ✓   |
| gmp          | ✓   | ✓   | ✓   |
| hash         | ✓   | ✓   | ✓   |
| iconv        | ✓   | ✓   | ✓   |
| igbinary     | ✓   | ✓   | ✓   |
| intl         | ✓   | ✓   | ✓   |
| json         | ✓   | ✓   | ✓   |
| libxml       | ✓   | ✓   | ✓   |
| lzf          | ✓   | ✓   | ✓   |
| mbstring     | ✓   | ✓   | ✓   |
| memcached    | ✓   | ✓   | ✓   |
| mysqlnd      | ✓   | ✓   | ✓   |
| openssl      | ✓   | ✓   | ✓   |
| pcre         | ✓   | ✓   | ✓   |
| pdo_mysql    | ✓   | ✓   | ✓   |
| pdo_sqlite   | ✓   | ✓   | ✓   |
| posix        | ✓   | ✓   | ✓   |
| readline     | ✓   | ✓   | ✓   |
| redis        | ✓   | ✓   | ✓   |
| session      | ✓   | ✓   | ✓   |
| soap         | ✓   | ✓   | ✓   |
| sockets      | ✓   | ✓   | ✓   |
| sodium       | ✓   | ✓   | ✓   |
| sqlite3      | ✓   | ✓   | ✓   |
| standard     | ✓   | ✓   | ✓   |
| tokenizer    | ✓   | ✓   | ✓   |
| xml          | ✓   | ✓   | ✓   |
| xmlreader    | ✓   | ✓   | ✓   |
| xmlrpc       | ✓   | ✓   | ✓   |
| xmlwriter    | ✓   | ✓   | ✓   |
| xsl          | ✓   | ✓   | ✓   |
| zip          | ✓   | ✓   | ✓   |
| zlib         | ✓   | ✓   | ✓   |

## Docker Examples

Show installed version of PHP

```bash
docker run --rm  ambimax/php-7.4-alpine3.13:latest php -v
```

Show installed modules of PHP

```bash
docker run --rm  ambimax/php-7.4-alpine3.13:latest php -m
```

Mount folder, set env variables and enter

```bash
docker run --interactive --tty --rm \
  --env PHP_ERROR_REPORTING=-1 \
  --env PHP_DISPLAY_ERRORS=Off \
  --env "PHP_DATE_TIMEZONE=Europe/Berlin" \
  --volume=$PWD:/app \
  --workdir /app \
  ambimax/php-7.4-alpine3.13:latest bash
```

## Docker-Compose Examples

Minimal setup (ensure proper nginx configuration!)

```yaml
version: '3.7'

services:
    fpm:
        image: 'ambimax/php-7.4-alpine3.13:latest'
        volumes:
            - '${PWD}/src:/var/www/'
        command: ['php-fpm', '-F']
        expose:
            - 9000
        networks:
            backend:

    nginx:
        image: nginx:1.19-alpine
        volumes:
            - '${PWD}/config/nginx:/etc/nginx/templates'
            - '${PWD}/src:/var/www/'
        environment:
            API_HOST: fpm:9000
        ports:
            - '8080:80'
        networks:
            backend:

networks:
    backend:
```

**Important:** Command (CMD) must be defined!

Extended setup example:

```yaml
version: '3.7'

services:
    fpm:
        image: 'ambimax/php-7.4-alpine3.13:latest'
        volumes:
            - '${PWD}/src:/var/www/'
        environment:
            PHP_FPM_LISTEN_PORT: 9002
            FCGI_CONNECT: 'localhost:9002'
            PHP_OPCACHE_ERROR_LOG: '/var/www/my.log'
            PHP_OPCACHE_FAST_SHUTDOWN: 1
            PHP_OPCACHE_MAX_WASTED_PERCENTAGE: 10
            PHP_OPCACHE_ENABALE_FILE_OVERRIDE: 1
        command: ['php-fpm', '-F']
        expose:
            - 9002
        networks:
            backend:

    nginx:
        image: nginx:1.19-alpine
        volumes:
            - '${PWD}/config/nginx:/etc/nginx/templates'
            - '${PWD}/src:/var/www/'
        environment:
            API_HOST: fpm:9002
            TEST: 7.4
        ports:
            - '8800:80'
        networks:
            backend:

    exporter:
        image: hipages/php-fpm_exporter:latest
        ports:
            - '9253:9253'
        environment:
            PHP_FPM_SCRAPE_URI: 'tcp://fpm:9002/status'
            PHP_FPM_LOG_LEVEL: 'debug'

networks:
    backend:
```

## Performance improvements

Use igbinary for serizializion:

```yaml
PHP_SESSION_SERIALIZE_HANDLER: igbinary
PHP_IGBINARY_COMPACT_STRINGS: 1
PHP_APC_SERIALIZER: igbinary
```

## Improvements

-   Syntaxhighlighting in nano
-   Colored bash prompt (not yet in alpine)

## Changelog to v1 docker images

-   No cli container
-   No /tools
-   Removed php modules
    -   mysqli
    -   pdo_pgsql
    -   pgsql
    -   tidy

## Tools

-   [Container Structure Test](https://github.com/GoogleContainerTools/container-structure-test)
-   [healthcheck](https://github.com/renatomefi/php-fpm-healthcheck)
-   [Orca](https://github.com/orca-build/orca)
-   [Docker PHP Extension Installer](https://github.com/mlocati/docker-php-extension-installer)

## License

[MIT License](https://choosealicense.com/licenses/mit/)

## Authors

Initialized by [Tobias Schifftner](https://www.twitter.com/tschifftner) for [Ambimax GmbH](https://www.ambimax.de)
