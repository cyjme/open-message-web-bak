#!/bin/bash

script=$(readlink -f "$0")
scriptDir=$(dirname "$script")
baseDir=$(dirname "$scriptDir")
baseDir="$baseDir/code"

cd $baseDir
set -ex \
    && rm -rf $baseDir/site/doc/* \
    && rm -rf $baseDir/site/static/css/*  \
    && rm -rf $baseDir/site/static/js/* \
    && rm -rf $baseDir/site/ui/* \
    && rm -rf $baseDir/cache/*
