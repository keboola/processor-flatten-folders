FROM php:8-cli

ARG DEBIAN_FRONTEND=noninteractive
ENV COMPOSER_ALLOW_SUPERUSER 1

WORKDIR /tmp/

RUN apt-get update && apt-get install -y --no-install-recommends \
        zlib1g-dev \
        unzip \
	&& rm -r /var/lib/apt/lists/* \
	&& docker-php-ext-install -j$(nproc) zip \
	&& curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin/ --filename=composer

COPY . /code/
WORKDIR /code/
RUN composer install --no-interaction
CMD ["php", "/code/src/run.php"]
