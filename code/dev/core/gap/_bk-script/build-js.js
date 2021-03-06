#!/usr/bin/env node

var __dirname = __dirname || '';
const path = require('path');
//const fs = require('fs');
const scriptDir = path.dirname(process.argv[1]);
const baseDir = path.resolve(scriptDir, './../');
//const baseDir = path.resolve(__dirname, './../');
const glob = require('glob');
const pathinfo = require('pathinfo');
const webpack = require('webpack');
const gutil = require('gutil');
const meow = require('meow');
//const fs = require('fs');

var contextDir = path.join(baseDir, './code/dev/front/js');

var siteConfig = require(path.join(baseDir, './code/dev/front/setting/config/site.local.js'));
var appConfig = require(path.join(baseDir, './code/dev/front/setting/config/app.local.js'));
//var frontConfig = require(path.join(baseDir, './code/dev/front/setting/config/front.local.js')).front;

var options = {
    output: {
        filename: '[name].js',
        chunkFilename: '[hash]-[id].js',
        path: path.join(baseDir, './code/site/static/js'),
        publicPath: '//' + siteConfig.static.host + '/js/'
    },
    entry: {},
    module: {}
};

function buildResolve(options)
{
    var modules = [
        path.resolve(baseDir, 'node_modules'),
        contextDir
    ];

    var jsDir;
    var appName;

    for (appName in appConfig) {
        jsDir = path.resolve(baseDir, './code' + appConfig[appName].dir + '/front/js');
        modules.push(jsDir);
    }
    var gapJsDir = path.resolve(baseDir, './code/dev/core/gap/front/js');
    modules.push(gapJsDir);

    options.resolve = {
        modules: modules
    };
}

function run(options) {
    function runWebpack(dir, options) {
        var globPath = path.resolve(dir, '*.js');
        var files = glob.sync(globPath, {follow: true});
        var i;
        var len;
        var info;

        options.context = dir;

        len = files.length;

        if (!len) {
            //console.log('No input file was found in ' + dir);
            return;
        }

        options.entry = {
        };

        for (i = 0; i < len; i++) {
            info = pathinfo(files[i]);
            options.entry[info.basename] = './' + info.filename;
        }

        //console.log(options);

        webpack(options, function (err, stats) {
            if (err) {
                console.log(err);
                throw err;
            }

            gutil.log('[webpack:build ' + dir + ' ]', stats.toString({
                chunks: false, // Makes the build much quieter
                colors: true
            }));
        });
    }

    /*
    buildCommonJs();
    for (appName in appConfig) {
        buildAppJs(appName, appConfig[appName].dir + '/front/js');
    }
    buildEntryJs();
    */

    runWebpack(contextDir, options);
}


buildResolve(options);

var cli = meow({
    //pkg: '../package.json',
    version: '0.1',
    help: `
        Usage:,
         ./bin/build-js.js [options],

        Options:
            --source-map
            --minimize
    `
}, {
    alias: {
        o: 'output'
    },
    default: {
        'minimize': 'false',
        'source-map': 'true',
        'uglify': 'false'
    }
});

var sourceMap = cli.flags.sourceMap === 'false' ? false : true;
var minimize = cli.flags.minimize === 'true' ? true : false;

options.plugins = [];

if (sourceMap) {
    options.devtool = 'source-map';
}

if (minimize) {
    options.plugins.push(
        new webpack.DefinePlugin({
            'process.env': {
                'NODE_ENV': JSON.stringify('production')
            }
        }),
        new webpack.LoaderOptionsPlugin({
            minimize: true,
            debug: false
        }),
        new webpack.optimize.UglifyJsPlugin({
            compress: {
                warnings: false,
                //screw_ie8: true,
                //conditionals: true,
                //unused: true,
                //comparisons: true,
                //sequences: true,
                //dead_code: true,
                //evaluate: true,
                //if_return: true,
                //join_vars: true,
            },
            output: {
                comments: false,
            },
        }),
        new webpack.optimize.AggressiveMergingPlugin()
    );
}

run(options);
