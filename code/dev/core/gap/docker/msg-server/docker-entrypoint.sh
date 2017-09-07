#!/bin/bash

set -ex

chmod 777 /var/code/cache

set -- "$@"
exec "$@"
