FROM php:7-fpm
MAINTAINER Flaceliere Brice <contact@b-flaceliere.fr>

RUN apt-get update

RUN apt-get install -y \
        git \
        vim \
        telnet \
        bzip2 \
        libbz2-dev \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libpng12-dev \
        libghc-postgresql-libpq-dev \
        zlib1g-dev \
        libicu-dev \
        g++

RUN curl -L -o /tmp/xdebug-2.4.0.tgz http://xdebug.org/files/xdebug-2.4.0.tgz \
    && tar xfz /tmp/xdebug-2.4.0.tgz \
    && rm -r /tmp/xdebug-2.4.0.tgz \
    && mv xdebug-2.4.0 /usr/src/php/ext/xdebug


RUN docker-php-ext-install \
        mcrypt \
        mbstring \
        bz2 \
        zip \
        xdebug \
        intl \
        opcache

RUN docker-php-ext-configure gd -with-freetype-dir=/usr/include/ -with-jpeg-dir=/usr/include/
RUN docker-php-ext-configure pgsql -with-pgsql=/usr/include/postgresql/ \
	&& docker-php-ext-install pgsql pdo_pgsql


RUN curl -sS https://getcomposer.org/installer | php \
	&& mv composer.phar /usr/bin/composer

RUN echo "alias php='php -dzend_extension=xdebug.so'" >> ~/.bashrc
RUN echo "alias composer='php $(which composer)'" >> ~/.bashrc

RUN addgroup --gid 1000 usrdocker
RUN addgroup --gid 111 jenkins
RUN useradd -m -s /bin/bash -u 1000 -g 1000 usrdocker
RUN useradd -m -s /bin/bash -u 106 -g 111 jenkins