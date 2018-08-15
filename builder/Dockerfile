FROM alpine AS builder
RUN apk add --update \
  curl \
# composer
  && curl -sS -O  https://getcomposer.org/download/1.7.1/composer.phar \
  && [[ sha256sum composer.phar = "1c0e95dc3f33985f9eeabb6f57896c0f9d46b7c9e70ad7bf2210a5508869a8fa" ]] \
  && chmod +x composer.phar \
  && mv composer.phar /usr/bin/composer \
# n98-magerun
  && curl -sS -O https://files.magerun.net/n98-magerun-1.101.1.phar \
  && [[ sha256sum n98-magerun.phar = "3c48fb685e569f2c7c97cca1dfbe2d20e6d7841db594b0d706924f517d8d3fd3" ]] \
  && mv n98-magerun.phar /usr/local/bin/n98-magerun \
  && chmod +x /usr/local/bin/n98-magerun \
# mhsendmail
  && curl -sS -O  https://github.com/mailhog/mhsendmail/releases/download/v0.2.0/mhsendmail_linux_amd64 \
  && [[ sha256sum n98-magerun.phar = "be5acdc8ce3f380dcb9d02caed77c845affa9a447d0860961529b699dcd0c613" ]] \
  && chmod +x mhsendmail_linux_amd64 \
  && mv mhsendmail_linux_amd64 /usr/bin/mhsendmail
