FROM alpine AS builder

RUN apk add --update \
  curl

# composer
RUN curl -sS -o /usr/bin/composer https://getcomposer.org/download/1.7.1/composer.phar \
  && echo "1c0e95dc3f33985f9eeabb6f57896c0f9d46b7c9e70ad7bf2210a5508869a8fa  /usr/bin/composer" | sha256sum -c - \
  && chmod +x /usr/bin/composer

# n98-magerun
RUN curl -sS -o /usr/bin/n98-magerun https://files.magerun.net/n98-magerun-1.101.1.phar \
  && echo "3c48fb685e569f2c7c97cca1dfbe2d20e6d7841db594b0d706924f517d8d3fd3  /usr/bin/n98-magerun" | sha256sum -c - \
  && chmod +x /usr/bin/n98-magerun

# mhsendmail
RUN curl -sS -o /usr/bin/mhsendmail  https://github.com/mailhog/mhsendmail/releases/download/v0.2.0/mhsendmail_linux_amd64 \
  && sha256sum /usr/bin/mhsendmail \
  && chmod +x /usr/bin/mhsendmail
