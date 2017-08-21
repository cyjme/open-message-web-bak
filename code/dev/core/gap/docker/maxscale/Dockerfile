FROM tecposter/maxscale:latest

MAINTAINER "zhanjh@126.com"

COPY maxscale.cnf /etc/maxscale.cnf

RUN set -ex && mkdir -p /usr/log/maxscale && mkdir -p /var/run/maxscale

EXPOSE 3306 4006 4008 4442 6603

CMD ["/usr/local/bin/maxscale", "-d"]
