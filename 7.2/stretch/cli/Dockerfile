FROM alpine AS builder

RUN apk add --update \
  curl \
  && rm -rf /var/lib/apt/lists/* \
  && mkdir -p /builder

# composer
RUN curl -sS -o /builder/composer https://getcomposer.org/download/1.7.1/composer.phar \
  && echo "1c0e95dc3f33985f9eeabb6f57896c0f9d46b7c9e70ad7bf2210a5508869a8fa  /builder/composer" | sha256sum -c - \
  && chmod +x /builder/composer

# n98-magerun
RUN curl -sS -o /builder/n98-magerun https://files.magerun.net/n98-magerun-1.101.1.phar \
  && echo "3c48fb685e569f2c7c97cca1dfbe2d20e6d7841db594b0d706924f517d8d3fd3  /builder/n98-magerun" | sha256sum -c - \
  && chmod +x /builder/n98-magerun

# mhsendmail
RUN wget -O /builder/mhsendmail https://github.com/mailhog/mhsendmail/releases/download/v0.2.0/mhsendmail_linux_amd64 \
  && echo "be5acdc8ce3f380dcb9d02caed77c845affa9a447d0860961529b699dcd0c613  /builder/mhsendmail" | sha256sum -c - \
  && chmod +x /builder/mhsendmail

# zettr
RUN curl -sS -o /builder/zettr https://raw.githubusercontent.com/tschifftner/zettr/master/zettr.phar \
  && echo "527dcabc6b080bdaa65d253d1982ffdb7b5b337d5df3ad285b93f13ee256fc55  /builder/zettr" | sha256sum -c - \
  && chmod +x /builder/zettr

# modman
RUN curl -sS -o /builder/modman https://raw.githubusercontent.com/colinmollenhour/modman/master/modman \
  && echo "6db573ade6802408fa7a509d8fa045b7cdf57d703e89d0b93e457dc2466b5176  /builder/modman" | sha256sum -c - \
  && chmod +x /builder/modman





FROM php:7.2-cli-stretch

LABEL maintainer="Tobias Schifftner <ts@ambimax.de>"

COPY --from=builder /builder/composer       /usr/local/bin/composer
COPY --from=builder /builder/n98-magerun    /usr/local/bin/n98-magerun
COPY --from=builder /builder/mhsendmail     /usr/local/bin/mhsendmail
COPY --from=builder /builder/modman         /usr/local/bin/modman
COPY --from=builder /builder/zettr          /usr/local/bin/zettr

# Install dependencies
RUN apt-get update \
  && apt-get install -y --no-install-recommends \
    libmemcached-dev \
    libmemcached11 \
    libtidy-dev \
    libfreetype6-dev \
    libicu-dev \
    libjpeg62-turbo-dev \
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