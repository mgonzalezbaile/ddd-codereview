FROM php:7.2

ARG userid

RUN [ -n "${userid}" ]] && usermod -u ${userid} www-data || true

COPY . /srv/app

RUN mkdir -p /srv/app/var /srv/app/vendor; \
    chown -R www-data. /srv/app/var /srv/app/vendor

RUN set -xeu \
    && apt-get update && apt-get install -y --no-install-recommends \
        git \
        zlib1g-dev \
    && docker-php-ext-install \
        zip
