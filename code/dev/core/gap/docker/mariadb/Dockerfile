#docker-machine 需要修改，否则会有一个mysql集群的组件报错。
FROM tecposter/mariadb:latest

MAINTAINER "zhanjh@126.com"

VOLUME ["/var/data"] 

COPY docker-entrypoint.sh /usr/local/bin/
COPY my.cnf /etc/mysql/my.cnf
COPY scripts/ /docker-entrypoint-initdb.d/

RUN set -ex \

&& ln -s /usr/local/mysql/bin/mysqld /usr/local/bin/ \
&& ln -s /usr/local/mysql/bin/mysqld_safe /usr/local/bin/ \
&& ln -s /usr/local/mysql/bin/mysql /usr/local/bin/ \
&& ln -s /usr/local/mysql/bin/mysqladmin /usr/local/bin/ \

&& mkdir /etc/mysql/conf.d/ -p \

&& ln -s /usr/local/bin/docker-entrypoint.sh / \

&& groupadd -r mysql \
&& useradd -r -g mysql mysql \
&& chown mysql.mysql /etc/mysql/conf.d -R \
&& chown -R mysql.mysql /var/data

#docker-machine 需要下面这一行，不然会抛出找不到文件错误
RUN usermod -u 1000 mysql

EXPOSE 3306 4444 4567 4568

ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["mysqld_safe"]
