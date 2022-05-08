FROM php:7.4-apache

LABEL maintainer="Lukáš Šiška <lukas.siska@b2a.cz>"

ARG PSR_VERSION=1.0.1
ARG PHALCON_VERSION=4.1.0
ARG PHALCON_EXT_PATH=php7/64bits

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY . /var/www
COPY docker/conf/vhost.conf /etc/apache2/sites-available/000-default.conf

RUN a2enmod rewrite && \
	a2enmod headers && \
	service apache2 restart

WORKDIR /var/www

RUN apt-get update && \
	apt-get install --no-install-recommends -y \
		git \
		nano

RUN set -xe && \
        # Download PSR, see https://github.com/jbboehr/php-psr
        curl -LO https://github.com/jbboehr/php-psr/archive/v${PSR_VERSION}.tar.gz && \
        tar xzf ${PWD}/v${PSR_VERSION}.tar.gz && \
        # Download Phalcon
        curl -LO https://github.com/phalcon/cphalcon/archive/v${PHALCON_VERSION}.tar.gz && \
        tar xzf ${PWD}/v${PHALCON_VERSION}.tar.gz && \
        docker-php-ext-install -j $(getconf _NPROCESSORS_ONLN) \
            ${PWD}/php-psr-${PSR_VERSION} \
            ${PWD}/cphalcon-${PHALCON_VERSION}/build/${PHALCON_EXT_PATH} \
        && \
        # Remove all temp files
        rm -r \
            ${PWD}/v${PSR_VERSION}.tar.gz \
            ${PWD}/php-psr-${PSR_VERSION} \
            ${PWD}/v${PHALCON_VERSION}.tar.gz \
            ${PWD}/cphalcon-${PHALCON_VERSION} \
        && \
        php -m

# Install PostgresSQL drivers
RUN apt-get install -y libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql