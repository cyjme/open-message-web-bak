#!/bin/bash

set -ex

datadir=/var/data

. "/docker-entrypoint-initdb.d/init_cluster_conf.sh"

if [ ! -d "$datadir/mysql" ]; then
    if [ -z "$MYSQL_ROOT_PASSWORD" ]; then
        echo >&2 'error: MYSQL_ROOT_PASSWORD not set'
        exit 1
    fi

    cd /usr/local/mysql

    echo 'Running mysql_install_db ...'
    ./scripts/mysql_install_db --user=mysql --datadir="$datadir"
    echo 'Finished mysql_install_db'

    tmp_sql_file='/tmp/mysql-first-time.sql'

    cat > "$tmp_sql_file" <<-EOSQL
        DELETE FROM mysql.user ;
        CREATE USER 'root'@'%' IDENTIFIED BY '${MYSQL_ROOT_PASSWORD}' ;
        GRANT ALL ON *.* TO 'root'@'%' WITH GRANT OPTION ;
        DROP DATABASE IF EXISTS test ;

        CREATE USER '${MAXSCALE_USER}'@'%' identified by '${MAXSCALE_PASS}';
        GRANT SELECT on mysql.user to '${MAXSCALE_USER}'@'%';
        GRANT SELECT ON mysql.db TO '${MAXSCALE_USER}'@'%';
        GRANT SELECT ON mysql.tables_priv TO '${MAXSCALE_USER}'@'%';
        GRANT REPLICATION CLIENT ON *.* to ${MAXSCALE_USER}@'%';
        GRANT SHOW DATABASES ON *.* TO '${MAXSCALE_USER}'@'%';

        FLUSH PRIVILEGES ;
EOSQL



    chown mysql:mysql -R "$datadir"
    set -- "$@" --init-file="$tmp_sql_file"
fi


#wsrep="--wsrep_cluster_address=gcomm://$GCOMM"
#if [ -z "$GCOMM" ]; then
#    wsrep="--wsrep-new-cluster"
#fi
#set -- "$@" --datadir="$datadir" --user=mysql "$wsrep"
#echo "$@"

rm $datadir/*.piA -rf
rm $datadir/*.err -rf

wsrep="--wsrep-new-cluster"
if [ -n "$CLUSTER_MEMBERS" ]; then
    wsrep=""
fi

set -- "$@" --datadir="$datadir" --user=mysql $wsrep
exec "$@"
