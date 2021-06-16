FROM php:7.4.0-fpm

RUN apt-get update && apt-get install -y \
        wget \
        libicu-dev \
        libzip-dev \
        git \
        zip \
        && docker-php-ext-install intl \
        && docker-php-ext-install zip 




COPY ./composer.sh /tmp/
RUN sh /tmp/composer.sh


# WORKDIR /code
# RUN composer install

# Clean up APT when done.
RUN apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*