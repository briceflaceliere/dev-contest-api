FROM php:5.5.30-apache

MAINTAINER Fabien Foulgoc <fabien.foulgoc@ecolutis.com>

# grab gosu for easy step-down from root
RUN gpg --keyserver pool.sks-keyservers.net --recv-keys B42F6819007F00F88E364FD4036A9C25BF357DD4
RUN curl -o /usr/local/bin/gosu -SL "https://github.com/tianon/gosu/releases/download/1.7/gosu-$(dpkg --print-architecture)" \
	&& curl -o /usr/local/bin/gosu.asc -SL "https://github.com/tianon/gosu/releases/download/1.7/gosu-$(dpkg --print-architecture).asc" \
	&& gpg --verify /usr/local/bin/gosu.asc \
	&& rm /usr/local/bin/gosu.asc \
	&& chmod +x /usr/local/bin/gosu

RUN groupadd -r --gid 1000 webdev && useradd -m -s /bin/bash --uid 1000 --gid 1000 -G www-data webdev

RUN sed -i  's/User www-data/User ${APACHE_RUN_USER}/' /etc/apache2/apache2.conf \
    && sed -i  's/Group www-data/Group ${APACHE_RUN_GROUP}/' /etc/apache2/apache2.conf

# Install modules (libssl-dev for mongo)
RUN apt-get update \
    && apt-get install -y \
        libbz2-dev \
        libssl-dev \
        ssl-cert \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libpng12-dev \
        libpq-dev \
        libicu-dev \
        libxslt-dev \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install bcmath \
        bz2 \
        calendar \
        exif \
        ftp \
        gd \
        gettext \
        intl \
        mbstring \
        mcrypt \
	mysql \
        mysqli \
        opcache \
        pcntl \
        pdo_mysql \
        pdo_pgsql \
        pgsql \
        soap \
        sockets \
        xmlrpc \
        xsl \
        zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Install xDebug
RUN pecl install xdebug \
    && echo 'zend_extension=/usr/local/lib/php/extensions/no-debug-non-zts-20121212/xdebug.so' | \
        tee /usr/local/etc/php/conf.d/ext-xdebug.ini

# Install runkit
RUN cd /tmp \
    && curl -LO https://github.com/zenovich/runkit/archive/master.tar.gz \
    && tar -zxf master.tar.gz \
    && cd runkit-master \
    && pecl install package.xml \
    && echo 'extension=runkit.so' | tee /usr/local/etc/php/conf.d/ext-runkit.ini \
    && rm -rf /tmp/*

# Install XCache
RUN cd /tmp \
    && curl -LO http://xcache.lighttpd.net/pub/Releases/3.2.0/xcache-3.2.0.tar.gz \
    && tar -xf xcache-3.2.0.tar.gz \
    && mv xcache-3.2.0 /usr/src/php/ext/xcache  \
    && docker-php-ext-configure xcache \
    && docker-php-ext-install xcache \
    && echo 'extension=xcache.so' | tee /usr/local/etc/php/conf.d/ext-xcache.ini \
	&& rm /usr/local/etc/php/conf.d/docker-php-ext-xcache.ini \
    && rm -rf /tmp/*

# Install ImageMagick from sources (without : pango svg2 wmf [require x11])+ imagick via pecl
RUN apt-get update \
    && apt-get install -y \
        libltdl-dev \
        libbz2-dev \
        libdjvulibre-dev \
        libfftw3-dev \
        libfontconfig1-dev \
        libjbig-dev \
        liblqr-1-0-dev \
        liblzma-dev \
        libopenexr-dev \
        libopenjp2-7-dev \
        libperl-dev \
        libtiff-dev \
        libwebp-dev \
        libxml2-dev \
        liblcms2-dev \
        liblqr-1-0-dev \
        gsfonts \
    && cd /tmp \
    && curl -O http://www.imagemagick.org/download/ImageMagick.tar.gz \
    && tar -C /usr/local/src -xf ImageMagick.tar.gz \
    && cd /usr/local/src/ImageMagick* \
    && ./configure \
        --prefix=/usr/local \
        --libdir=/usr/lib/x86_64-linux-gnu \
        --sysconfdir=/etc \
        --with-includearch-dir=/usr/include/x86_64-linux-gnu/ \
        --disable-docs \
        --with-modules \
        --with-gs-font-dir=/usr/share/fonts/type1/gsfonts \
        --with-magick-plus-plus \
        --with-djvu \
        --without-gvc \
        --enable-shared \
        --without-dps \
        --without-fpx \
        --without-pango \
        --with-perl \
        --with-perl-options='INSTALLDIRS=vendor' \
        --without-rsvg \
        --without-x \
    && make \
    && make install clean \
    && yes '' | pecl install imagick-3.1.2 \
    && echo 'extension=imagick.so' | tee /usr/local/etc/php/conf.d/ext-imagick.ini \
    && apt-get autoremove -y --purge \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN pecl install mongo \
    && echo 'extension=mongo.so' | tee /usr/local/etc/php/conf.d/ext-mongo.ini

# Install phantomjs dependencies + lsof to kill it :)
RUN apt-get update \
    && apt-get install -y \
        libfreetype6 \
        libfontconfig \
        bzip2 \
        lsof \
    && apt-get autoremove -y --purge \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# TEMP : yui-compressor + git for npm + python for npm
RUN apt-get update \
    && apt-get install -fy \
        yui-compressor \
        git-core \
        python-minimal \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# add all node.js contributors public keys
RUN for key in \
        9554F04D7259F04124DE6B476D5A82AC7E37093B \
        94AE36675C464D64BAFA68DD7434390BDBE9B9C5 \
        0034A06D9D9B0064CE8ADF6BF1747F4AD2306D93 \
        FD3A5288F042B6850C66B31F09FE44734EB7990E \
        71DCFD284A79C3B38668286BC97EC7A07EDE3FC1 \
        DD8F2338BAE7501E3DD5AC78C273792F7D83545D \
        114F43EE0176B71C7BC219DD50A3051F888C628D \
        7937DFD2AB06298B2293C3187D33FF9D0246406D \
        93C7E9E91B49E432C2F75674B0A78B0A6C481CF6 \
	; do \
		gpg --keyserver ha.pool.sks-keyservers.net --recv-keys "$key"; \
	done

ENV NODE_VERSION 0.12.8
ENV NPM_VERSION 2.14.13

# Temp : install bless
RUN buildDeps='curl' \
	&& set -x \
	&& apt-get update && apt-get install -y $buildDeps --no-install-recommends \
	&& rm -rf /var/lib/apt/lists/* \
	&& curl -SLO "http://nodejs.org/dist/v$NODE_VERSION/node-v$NODE_VERSION-linux-x64.tar.gz" \
	&& curl -SLO "http://nodejs.org/dist/v$NODE_VERSION/SHASUMS256.txt.asc" \
	&& gpg --verify SHASUMS256.txt.asc \
	&& grep " node-v$NODE_VERSION-linux-x64.tar.gz\$" SHASUMS256.txt.asc | sha256sum -c - \
	&& tar -xzf "node-v$NODE_VERSION-linux-x64.tar.gz" -C /usr/local --strip-components=1 \
	&& rm "node-v$NODE_VERSION-linux-x64.tar.gz" SHASUMS256.txt.asc \
	&& npm install -g npm@"$NPM_VERSION" \
    && npm install -g bless \
	&& npm cache clear

# Install mysql-client and mongodb-client : used in carpooling commands
RUN apt-get update \
    && apt-get install -fy \
        mysql-client \
        mongodb-clients \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# composer install
RUN curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/local/bin \
	--filename=composer.phar \
	--version=1.0.0-alpha11

# wrap composer to increase php memory_limit
COPY composer /usr/local/bin/composer

# VIM
RUN apt-get update \
    && apt-get install -fy \
        vim-common \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# jq
RUN curl -o /usr/local/bin/jq -SL "https://github.com/stedolan/jq/releases/download/jq-1.5/jq-linux64" \
    && chmod +x /usr/local/bin/jq

COPY config/httpd/10-site-*.conf  /etc/apache2/sites-available/
COPY config/httpd/10-conf-*.conf  /etc/apache2/conf-available/
COPY config/php/php.ini /usr/local/etc/php/php.ini

RUN a2enmod headers \
        rewrite \
        ssl \
        vhost_alias \
    && a2ensite \
        10-site-dir-aliases \
        10-site-00-xcache-admin \
    && a2enconf 10-conf-change-user

RUN mkdir -p /var/www/vhosts \
        /var/www/data/cache \
        /var/www/data/uploads \
        /var/www/data/statistics \
    && chown -R www-data:www-data /var/www/vhosts \
    && chown -R www-data:www-data /var/www/data \
    && chmod -R 777 /var/www/data

#USER www-data
VOLUME /var/www/vhosts
VOLUME /var/www/data

WORKDIR /var/www/vhosts/

COPY docker-entrypoint.sh /

ENTRYPOINT ["/docker-entrypoint.sh"]

EXPOSE 443
EXPOSE 9000

# http is not a real command. It is handled in entrypoint
CMD ["httpd"]
#CMD ["apache2-foreground"]
