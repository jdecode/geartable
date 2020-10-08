FROM jdecode/php7.4:2

COPY composer.json .
RUN composer install -n --prefer-dist

COPY . .

ARG BUILD
ENV BUILD=${BUILD}

## Disabled following when running locally (keep it enabled for GCP Cloud Run)
RUN if [ "$BUILD" = "local" ] ; then ls -al ; else sed -i 's/80/${PORT}/g' /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf ; fi

ENTRYPOINT ["/var/www/html/.entrypoint/migrations.sh"]

CMD ["apache2-foreground"]
