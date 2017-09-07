#!/usr/bin/env node

// https://github.com/sass/node-sass/blob/master/bin/node-sass
// https://github.com/keithamus/npm-scripts-example/blob/master/package.json

const sass = require('node-sass');
const path = require('path');
const fs = require('fs');
const meow = require('meow');
const chalk = require('chalk');
const mkdirp = require('mkdirp');

const getEmitter = require('./lib/getEmitter.js');
const glob = require('glob');
const util = require('util');
const forEach = require('async-foreach').forEach;

let scriptDir = path.dirname(process.argv[1]);

//var process = process || null;
//const stdout = require('stdout-stream');


function getOptions(baseDir, appConfig, options)
{
    var appName;

    /*
    if (!Array.isArray(options.includePath)) {
        options.includePath = [options.includePath];
    }
    */
    options.includePath = [];
    options.includePath.push(path.join(baseDir, './node_modules/foundation-sites/scss/'));

    for (appName in appConfig) {
        options.includePath.push(
            path.join(path.join(baseDir, './code' + appConfig[appName].dir, './front/scss/'))
        );
    }

    options.includePath.push(path.join(baseDir, './code/dev/core/gap/front/scss/'));

    return options;
}

function renderFile(file, inputDir, options, emitter)
{
    var includePaths = Array.isArray(options.includePath) ? options.includePath : [options.includePath];
    /*
    var outFile = path.join(
        path.resolve(options.output),
        [path.basename(file, path.extname(file)), '.css'].join('')
    );
    */
    var outFile = file.replace(inputDir, options.output).replace('.scss', '.css');
    var sourceMapFile = path.resolve(outFile + '.map');

    var renderOptions = {
        file: file,
        outFile: outFile,
        includePaths: includePaths,
        outputStyle: options.outputStyle
    };

    if (options.sourceMap !== 'false') {
        renderOptions.sourceMap = true;
        renderOptions.sourceMapContents = true;
    } else {
        renderOptions.omitSourceMapUrl = true;
    }

    var success = function (result) {
        emitter.emit('warn', chalk.green('Rendering Complete, saving .css file...'));
        fs.writeFile(outFile, result.css.toString(), function (err) {
            if (err) {
                return emitter.emit('error', chalk.red(err));
            }

            emitter.emit('warn', chalk.green('Wrote CSS to ' + outFile));
        });


        if (renderOptions.sourceMap) {
            fs.writeFile(sourceMapFile, result.map, function (err) {
                if (err) {
                    return emitter.emit('error', chalk.red(err));
                }
                emitter.emit('warn', chalk.green('Wrote Source Map to ' + sourceMapFile));
            });
        }
    };

    var error = function (error) {
        emitter.emit('error', chalk.red(JSON.stringify(error, null, 2)));
    };

    var renderCallback = function (err, result) {
        if (err) {
            error(err);
        } else {
            success(result);
        }
    };

    mkdirp(path.dirname(outFile), function (err) {
        if (err) {
            emitter.emit('error', chalk.red(err));
        }

        sass.render(renderOptions, renderCallback);
    });
}

function renderDir(input, options, emitter)
{
    var globPath = path.resolve(input, '**/*.{sass,scss}');
    glob(globPath, {ignore: '**/_*', follow: options.follow}, function (err, files) {
        if (err) {
            return emitter.emit('error', util.format('You do not have permission to access this path: %s.', err.path));
        }
        if (!files.length) {
            return emitter.emit('warn', util.format('No input file was found in %s.', input));
        }

        forEach(files, function (subject) {
            subject == files[files.length -1] && this.async();
            renderFile(subject, input, options, emitter);
        }, function (successful, arr) {
            var outputDir = path.join(process.cwd(), options.output);
            emitter.emit(
                'warn',
                util.format('Wrote %s CSS files to %s', arr.length, outputDir)
            );
            process.exit();
        });
    });
}

function run(baseDir, appConfig, options, emitter)
{
    renderDir(
        path.join(baseDir, './code/dev/front/scss/'),
        options,
        emitter
    );

    /*
    var appName;

    renderDir(
        path.join(baseDir, './code/dev/front/scss/'),
        options,
        emitter
    );

    for (appName in appConfig) {
        renderDir(
            path.join(appConfig[appName].dir, './front/scss/'),
            options,
            emitter
        );
    }

    render({
        dest: path.join(baseDir, './site/static/css/ipar.css')
    }, emitter);
    */
}

var baseDir = path.join(scriptDir, './../');
var outputDir = path.join(baseDir, './code/site/static/css/');
var appConfig = require(path.join(baseDir, './code/dev/front/setting/config/app.local.js'));

var cli = meow({
    //pkg: path.resolve(baseDir, 'package.json'),
    version: sass.info,
    help: `
        Usage:,
         ./bin/build-css.js [options],

        Options:
            -o, --output                Output directory
            --follow                    Follow symlinked directories
    `
}, {
    alias: {
        o: 'output'
    },
    default: {
        'output-style': 'nested',
        'source-map': true,
        'output': outputDir,
        'follow': true
    }
});

var emitter = getEmitter();
var options = getOptions(baseDir, appConfig, cli.flags);

run(baseDir, appConfig, options, emitter);
