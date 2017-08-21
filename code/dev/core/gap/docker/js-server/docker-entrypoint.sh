#!/bin/bash

set -ex

cd /var/js

npm install
npm update
sleep 1

set -- "$@"
exec "$@"
