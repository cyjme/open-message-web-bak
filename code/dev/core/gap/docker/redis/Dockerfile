FROM tecposter/redis:latest

MAINTAINER "zhanjh@126.com"

COPY redis.conf /usr/local/etc/redis.conf

EXPOSE 6379
CMD [ "redis-server", "/usr/local/etc/redis.conf"]
