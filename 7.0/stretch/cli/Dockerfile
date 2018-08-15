FROM php:7.0-cli-stretch

MAINTAINER Tobias Schifftner <ts@ambimax.de>

COPY --from=ambimax/php-builder /builder/composer       /usr/local/bin/composer
COPY --from=ambimax/php-builder /builder/n98-magerun    /usr/local/bin/n98-magerun
COPY --from=ambimax/php-builder /builder/mhsendmail     /usr/local/bin/mhsendmail

# Install dependencies
RUN apt-get update \
  && apt-get install -y --no-install-recommends \
    libmemcached-dev \
    libmemcached11 \
    libtidy-dev \
    libfreetype6-dev \
    libicu-dev \
    libjpeg62-turbo-dev \
    libmcrypt-dev \
    libpng-dev \
    libxslt1-dev \
    sudo \
    mysql-client \
    git \
    redis-tools \
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
      gettext \
      intl \
      mbstring \
      mcrypt \
      mysqli \
      opcache \
      pdo_mysql \
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