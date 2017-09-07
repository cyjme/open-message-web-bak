FROM tecposter/nginx:latest

MAINTAINER "zhanjh@126.com"


COPY nginx.conf /usr/local/conf/nginx.conf

RUN ln -sf /dev/stdout /usr/local/logs/access.log \
    && ln -sf /dev/stderr /usr/local/logs/error.log

VOLUME ["/var/code"]
VOLUME ["/usr/local/conf/sites-enabled"]

EXPOSE 80 443

CMD ["nginx", "-c", "/usr/local/conf/nginx.conf", "-g", "daemon off;"]
