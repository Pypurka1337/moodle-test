FROM phpdockerio/php72-fpm:latest
WORKDIR "/application"

RUN apt-get update; \
    apt-get -y install \
        php7.2-soap \
        php7.2-gd \
        php7.2-intl \
        php7.2-mysql \
        php7.2-xmlrpc; \
    apt-get clean; \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*
