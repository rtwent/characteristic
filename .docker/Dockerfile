FROM php:7.4-fpm-alpine

# Configure version constraints
ENV PHP_ENABLE_XDEBUG=1 \
    PATH=/app:/app/vendor/bin:/root/.composer/vendor/bin:$PATH \
    TERM=linux \
    VERSION_PRESTISSIMO_PLUGIN=^0.3.7 \
    COMPOSER_ALLOW_SUPERUSER=1 \
    GIT_USER_EMAIL=rtwent@ukr.net \
    GIT_USER_NAME=R22symfony

RUN apk --update --virtual build-deps add \
        autoconf \
        make \
        gcc \
        g++ \
        libtool \
        icu-dev \
        curl-dev \
        freetype-dev \
        imagemagick-dev \
        oniguruma-dev \
        pcre-dev \
        postgresql-dev \
        libjpeg-turbo-dev \
        libpng-dev \
        libxml2-dev && \
    apk add \
        git \
        curl \
        bash \
        bash-completion \
        icu \
        imagemagick \
        pcre \
        freetype \
        libintl \
        libjpeg-turbo \
        libpng \
        libzip-dev \
        libltdl \
        libxml2 \
        mysql-client \
        postgresql && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-configure bcmath && \
    docker-php-ext-install \
        soap \
        calendar \
        curl \
        bcmath \
        exif \
        gd \
        iconv \
        intl \
        mbstring \
        opcache \
        pcntl \
        pdo_mysql \
        pdo_pgsql \
        zip \
        tokenizer \
        xml \
        pgsql && \
    pecl install \
        imagick \
		xdebug \
        mongodb && \
    docker-php-ext-enable xdebug && \
    apk del \
        build-deps

RUN echo "extension=imagick.so" > /usr/local/etc/php/conf.d/pecl-imagick.ini && \
    echo "extension=mongodb.so" > /usr/local/etc/php/conf.d/pecl-mongodb.ini


# Add configuration files
COPY image-files/ /


# Add GITHUB_API_TOKEN support for composer
RUN chmod 700 \
        /usr/local/bin/docker-php-entrypoint \
        /usr/local/bin/composer

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- \
        --filename=composer.phar \
        --install-dir=/usr/local/bin && \
    composer clear-cache

# Install composer plugins
#RUN composer global require --optimize-autoloader \
#        "hirak/prestissimo:${VERSION_PRESTISSIMO_PLUGIN}" && \
#    composer global dumpautoload --optimize && \
#    composer clear-cache

# Symfony installer
RUN wget https://get.symfony.com/cli/installer -O - | bash
RUN mv /root/.symfony/bin/symfony /usr/local/bin/symfony
RUN git config --global user.email "${GIT_USER_EMAIL}"
RUN git config --global user.name "${GIT_USER_NAME}"
RUN rm -rf /var/www/html/public

# Не могу понять где устанавливается, но только тне в прописанной директории
# RUN symfony new --dir /var/www/html