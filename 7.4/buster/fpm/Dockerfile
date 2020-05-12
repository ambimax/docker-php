
FROM php:7.4-fpm-buster

LABEL maintainer="Dominik Wißler <dw@ambimax.de>"

COPY --from=ambimax/phptools:latest /tools/mhsendmail      /tools/mhsendmail
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
    gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ \
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
COPY php-fpm.conf /usr/local/etc/

COPY entrypoint.sh /usr/local/bin/entrypoint.sh

RUN chmod +x /usr/local/bin/entrypoint.sh

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]

WORKDIR /var/www/htdocs

CMD ["php-fpm", "-F"]