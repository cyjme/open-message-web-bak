FROM tecposter/php7-ext:latest

MAINTAINER "zhanjh@126.com"


COPY php-fpm.conf /usr/local/etc/php-fpm.conf
COPY php.ini /usr/local/lib/php.ini
COPY docker-entrypoint.sh /usr/local/bin/

VOLUME ["/var/code"]

WORKDIR /var/code

EXPOSE 9502

RUN ln -s /usr/local/bin/docker-entrypoint.sh /

ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["./dev/core/gap/sbin/task-server"]
