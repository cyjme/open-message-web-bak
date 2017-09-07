FROM node:latest

MAINTAINER "zhanjh@126.com"

COPY package.json /var/js/
COPY docker-entrypoint.sh /usr/local/bin/

VOLUME ["/var/js/code"]
VOLUME ["/var/js/node_modules"]

WORKDIR /var/js

EXPOSE 8787

RUN ln -s /usr/local/bin/docker-entrypoint.sh /

ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["./code/dev/core/gap/sbin/js-server"]
