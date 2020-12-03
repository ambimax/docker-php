
FROM php:7.2-fpm-stretch

LABEL maintainer="Tobias Schifftner <ts@ambimax.de>"

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
    libxslt1-dev \
    sudo \
# Install newer version of libsodium for proper Magento 2.3.2+ support
  && wget https://download.libsodium.org/libsodium/releases/libsodium-1.0.18.tar.gz \
    && tar xfvz libsodium-1.0.18.tar.gz \
    && cd libsodium-1.0.18 \
    && ./configure \
    && make && make install \
#
# Cleanup
  && rm -rf /var/lib/apt/lists/* libsodium-1.0.18

# Install php extensions
RUN pecl install \
    apcu \
    igbinary \
#    imagick \
    libsodium \
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
    sodium \
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