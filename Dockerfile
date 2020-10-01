FROM jdecode/php7.4:2

COPY composer.json .
RUN composer install -n --prefer-dist

