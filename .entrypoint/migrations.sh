#!/bin/bash
set -e
/var/www/html/bin/cake migrations migrate

apache2-foreground
