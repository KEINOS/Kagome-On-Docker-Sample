FROM keinos/php7-alpine

RUN apk update \
    && apk add --update \
      php-mbstring@php \
      php-json@php \
      php-ctype@php \
      php-openssl@php \
    && rm -rf /var/cache/apk/*

COPY ./src /app

WORKDIR /app

ENTRYPOINT [ "/usr/bin/php" ]
