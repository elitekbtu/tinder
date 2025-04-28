FROM composer:latest

WORKDIR /var/www/tinder

ENTRYPOINT ["composer", "--ignore-platform-reqs"]