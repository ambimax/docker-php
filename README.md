# docker-php

[![Test Suite](https://github.com/ambimax/docker-php/actions/workflows/default.yaml/badge.svg?branch=v2)](https://github.com/ambimax/docker-php/actions/workflows/default.yaml)

New generation of php containers. All settings can be adjusted on the fly by ENV variables.

Currently supported Frameworks and Apps:

-   Symfony
-   Shopware 6
-   Open Mage / Magento 1
-   Magento 2

## Docker Images on hub.docker.com

### PHP 8.0

| Distro     | Image                                                                             |
| ---------- | --------------------------------------------------------------------------------- |
| Buster     | [ambimax/php-8.0-buster](https://hub.docker.com/r/ambimax/php-8.0-buster)         |
| Alpine3.16 | [ambimax/php-8.0-alpine3.16](https://hub.docker.com/r/ambimax/php-8.0-alpine3.16) |

### PHP 8.1

| Distro     | Image                                                                             |
| ---------- | --------------------------------------------------------------------------------- |
| Bullseye   | [ambimax/php-8.1-bullseye](https://hub.docker.com/r/ambimax/php-8.1-bullseye)     |
| Alpine3.16 | [ambimax/php-8.1-alpine3.16](https://hub.docker.com/r/ambimax/php-8.1-alpine3.16) |
| Alpine3.17 | [ambimax/php-8.1-alpine3.17](https://hub.docker.com/r/ambimax/php-8.1-alpine3.17) |

### PHP 8.2

| Distro     | Image                                                                             |
| ---------- | --------------------------------------------------------------------------------- |
| Bullseye   | [ambimax/php-8.2-bullseye](https://hub.docker.com/r/ambimax/php-8.2-bullseye)     |
| Alpine3.17 | [ambimax/php-8.2-alpine3.17](https://hub.docker.com/r/ambimax/php-8.2-alpine3.17) |

**Older images** can be found on https://hub.docker.com/u/ambimax

## Environment Variables

| PHP Version | Link                                                                                     |
| ----------- | ---------------------------------------------------------------------------------------- |
| 8.0         | [template/components/php/8.0/assets/all.env](template/components/php/8.0/assets/all.env) |
| 8.1         | [template/components/php/8.1/assets/all.env](template/components/php/8.1/assets/all.env) |
| 8.2         | [template/components/php/8.2/assets/all.env](template/components/php/8.2/assets/all.env) |

## End Of Life

| Name            | End Of Life |
| --------------- | ----------- |
| PHP 8.0         | 2023-11-26  |
| PHP 8.1         | 2024-11-25  |
| PHP 8.2         | 2025-12-08  |
| Alpine 3.16     | 2024-05-23  |
| Alpine 3.17     | 2024-11-22  |
| Debian Bullseye | 2024-07-01  |
| Debian Buster   | 2022-09-10  |

## Installed php extensions

| PHP Module   | 8.0 | 8.1 | 8.2 |
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
| random       |     |     | ✓   |
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
docker run --rm  ambimax/php-8.1-alpine3.16:latest php -v
```

Show installed modules of PHP

```bash
docker run --rm  ambimax/php-8.1-alpine3.16:latest php -m
```

Mount folder, set env variables and enter

```bash
docker run --interactive --tty --rm \
  --env PHP_ERROR_REPORTING=-1 \
  --env PHP_DISPLAY_ERRORS=Off \
  --env "PHP_DATE_TIMEZONE=Europe/Berlin" \
  --volume=$PWD:/app \
  --workdir /app \
  ambimax/php-8.1-alpine3.16:latest bash
```

## Docker-Compose Examples

Minimal setup (ensure proper nginx configuration!)

```yaml
version: '3.7'

services:
    fpm:
        image: 'ambimax/php-8.1-alpine3.16:latest'
        volumes:
            - '${PWD}/src:/var/www/'
        command: ['php-fpm', '-F']
        expose:
            - 9000
        networks:
            backend:

    nginx:
        image: nginx:1.23-alpine
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

**Important:** Command `command: ['php-fpm', '-F']` must be defined!

Extended setup example:

```yaml
version: '3.7'

services:
    fpm:
        image: 'ambimax/php-8.1-alpine3.16:latest'
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
        image: nginx:1.23-alpine
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

Use igbinary for serialization:

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

## Tools used for image building

-   [Container Structure Test](https://github.com/GoogleContainerTools/container-structure-test)
-   [healthcheck](https://github.com/renatomefi/php-fpm-healthcheck)
-   [Orca](https://github.com/orca-build/orca)
-   [Docker PHP Extension Installer](https://github.com/mlocati/docker-php-extension-installer)

## Updating this README.md

Edit template file `template/README.md.twig` and run

```bash
make generate
```

If libraries are missing, use [composer](https://getcomposer.org/) for installation

```bash
composer install
```

## Adding new PHP version or PHP modules

### Add PHP version

1. Add variant to `manifest.json`
2. Add variant template file to variants/
3. Generate defaults

### Generate defaults

```bash
make VERSION=8.1 VARIANT=alpine3.16 copybuild
```

What happens?

1. Build new php variant image (ignoring errors)
2. Copy generated files from new image to asset folder
3. Rebuild image with generated configuration

## License

[MIT License](https://choosealicense.com/licenses/mit/)

## Authors

Initialized by [Tobias Schifftner](https://www.twitter.com/tschifftner) for [Ambimax GmbH](https://www.ambimax.de)
