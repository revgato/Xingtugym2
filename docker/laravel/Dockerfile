FROM php:8.1.9-fpm
RUN cd /usr/bin && curl -s http://getcomposer.org/installer | php && ln -s /usr/bin/composer.phar /usr/bin/composer
RUN apt-get update \
&& apt-get install -y \
git \
zip \
unzip \
zlib1g-dev \
libzip-dev \
libpng-dev \
libjpeg-dev \
vim
RUN apt-get update \
    && apt-get install -y libpq-dev locales cron \
    && pecl install xdebug-3.1.5 \
    && docker-php-ext-install zip \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-configure gd  --with-jpeg=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-enable xdebug
RUN locale-gen ja_JP UTF-8
WORKDIR /var/www/code
CMD docker-php-entrypoint php-fpm