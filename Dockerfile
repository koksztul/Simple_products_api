FROM php:8.1-fpm

# Set working directory
WORKDIR /var/www

RUN apt-get update && \
    apt-get install -y --force-yes --no-install-recommends \
        libmemcached-dev \
        libzip-dev \
        libz-dev \
        libzip-dev \
        libpq-dev \
        libjpeg-dev \
        libpng-dev \
        libfreetype6-dev \
        libssl-dev \
        openssh-server \
        libmagickwand-dev \
        git \
        cron \
        nano \
        libxml2-dev \
        libreadline-dev \
        libgmp-dev \
        mariadb-client \
        unzip

# Install soap extention
RUN docker-php-ext-install soap

# Install for image manipulation
RUN docker-php-ext-install exif

# Install the PHP pcntl extention
RUN docker-php-ext-install pcntl

# Install the PHP zip extention
RUN docker-php-ext-install zip

# Install the PHP pdo_mysql extention
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install mysqli

# Install the PHP pdo_pgsql extention
RUN docker-php-ext-install pdo_pgsql

# Install the PHP bcmath extension
RUN docker-php-ext-install bcmath

# Install the PHP intl extention
RUN docker-php-ext-install intl

# Install the PHP gmp extention
RUN docker-php-ext-install gmp

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Copy existing application directory contents
COPY . /var/www

# Copy existing application directory permissions
COPY --chown=www:www . /var/www

# Change current user to www
USER www

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]