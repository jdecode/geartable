#duh! Pick the base image (this is latest as of May 2020)
FROM php:7.4-apache

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

#duh!
RUN apt-get update

#Install zip+icu dev libs
RUN apt-get install libzip-dev zip libicu-dev -y

#Install PHP extensions zip and intl (intl requires to be configured)
RUN docker-php-ext-install zip && docker-php-ext-configure intl && docker-php-ext-install intl

#Required for htaccess rewrite rules
RUN a2enmod rewrite


