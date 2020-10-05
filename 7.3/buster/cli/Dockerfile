
FROM php:7.3-cli-buster

LABEL maintainer="Fabian Köhnen <fk@ambimax.de>"

COPY --from=ambimax/phptools:latest /tools/codecept /tools/codecept
COPY --from=ambimax/phptools:latest /tools/codesniffer /tools/codesniffer
COPY --from=ambimax/phptools:latest /tools/composer /tools/composer
COPY --from=ambimax/phptools:latest /tools/mhsendmail /tools/mhsendmail
COPY --from=ambimax/phptools:latest /tools/phpcbf3 /tools/phpcbf3
COPY --from=ambimax/phptools:latest /tools/phpcs3 /tools/phpcs3
COPY --from=ambimax/phptools:latest /tools/phplint /tools/phplint
COPY --from=ambimax/phptools:latest /tools/phpmd /tools/phpmd
COPY --from=ambimax/phptools:latest /tools/phpunit8 /tools/phpunit8
COPY --from=ambimax/phptools:latest /tools/phpunit9 /tools/phpunit9
COPY --from=ambimax/phptools:latest /tools/php-cs-fixer /tools/php-cs-fixer
COPY --from=ambimax/phptools:latest /tools/xmllint /tools/xmllint

ENV PATH="/tools:${PATH}"

# Install dependencies
RUN apt-get update \
  && apt-get install -y --no-install-recommends \
  	libgmp-dev \
    libmemcached-dev \
    libmemcached11 \
  	libpq-dev \
    libtidy-dev \
    libfreetype6-dev \
    libicu-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libonig-dev \
    zlib1g-dev \
    libxml2-dev \
    libzip-dev \
    libmcrypt-dev \
    graphviz \
    libxslt1-dev \
    sudo \
    mariadb-client \
    git \
    redis-tools \
    curl \
#
# Cleanup
  && rm -rf /var/lib/apt/lists/*

# Install php extensions
RUN pecl install \
    apcu \
    igbinary \
#    imagick \
    lzf \
    memcached \
    redis \
#
# Install Xdebug (but don't enable)
  && pecl install -o -f xdebug

#
# Configure the gd library
RUN docker-php-ext-configure \
    gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
#
# Install required PHP extensions
  && docker-php-ext-install \
      bcmath \
      calendar \
      dom \
      exif \
      gd \
      gmp \
      gettext \
      intl \
      mbstring \
      mysqli \
      opcache \
      pdo_mysql \
      pdo_pgsql \
      pgsql \
      soap \
      sockets \
      tidy \
      xmlrpc \
      xsl \
      zip \
  && docker-php-ext-enable \
    apcu \
    igbinary \
    lzf \
    memcached \
    redis \
    tidy \
    xmlrpc


ENV PHP_ENABLE_XDEBUG false

COPY xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini
COPY php.ini /usr/local/etc/php/conf.d/zz-php.ini
COPY entrypoint.sh /usr/local/bin/entrypoint.sh

RUN chmod +x /usr/local/bin/entrypoint.sh

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]

WORKDIR /var/www/htdocs

CMD ["bash"]
