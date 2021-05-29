FROM php:7.4-fpm

RUN apt-get update && apt-get clean && apt-get install -y \
	libpq-dev \
	git-core \
    zlib1g-dev \
    unzip \
    libzip-dev \
	&& docker-php-ext-install -j$(nproc) pgsql pdo pdo_pgsql \
	&& docker-php-ext-configure zip \
	&& docker-php-ext-install zip

# PHP COMPOSER
COPY ./config/install_composer.sh /install_composer.sh
RUN chmod +x /install_composer.sh; sync && /install_composer.sh \

# DISPLAY PHP ERRORS
ARG DISPLAY_PHP_ERRORS=false
RUN if [ ${DISPLAY_PHP_ERRORS} = true ]; then \
    sed -i "s/;php_flag\[display_errors\] = off/php_flag\[display_errors\] = on/" /usr/local/etc/php-fpm.d/www.conf && \
    sed -i "s/;catch_workers_output = yes/catch_workers_output = yes/" /usr/local/etc/php-fpm.d/www.conf && \
    echo 'php_flag[display_startup_errors] = on' >> /usr/local/etc/php-fpm.d/www.conf && \
    echo 'php_admin_value[error_reporting] = E_ALL' >> /usr/local/etc/php-fpm.d/www.conf \
;fi

WORKDIR /usr/local/apache2/htdocs
