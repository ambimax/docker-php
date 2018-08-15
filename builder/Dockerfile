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
