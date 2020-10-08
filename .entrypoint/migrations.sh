#!/bin/bash
set -e
/var/www/html/bin/cake migrations migrate
exec "$@"
