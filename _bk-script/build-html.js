#!/usr/bin/env node

const pug = require('pug');
const path = require('path');
const fs = require('fs');
const mkdirp = require('mkdirp');
const meow = require('meow');
const chalk = require('chalk');
const util = require('util');

const glob = require('glob');

const getEmitter = require('./lib/getEmitter.js');


const config = require('./../code/dev/front/setting/config/config.local');

function run(inputDir, outputDir, emitter)
{
    var globPath = path.resolve(inputDir, '**/*.page.pug');

    glob(globPath, {follow: true}, function (err, files) {
        var index;
        var file;
        var outputFile;

        if (err) {
            return emitter.emit('error', util.format('You do not have permission to access this path: %s.', err.path));
        }
        if (!files.length) {
            return emitter.emit('error', 'No input file was found.');
        }

        for (index in files) {
            file = files[index];
            outputFile = file.replace(inputDir, outputDir);
            outputFile = outputFile.replace('.pug', '.html');

            renderFile(file, outputFile);
        }
    });
}

function renderFile(inputFile, outputFile)
{
    var html = pug.renderFile(inputFile, {'config' : config});
    mkdirp(path.dirname(outputFile), function (err) {
        if (err) {
            return emitter.emit('error', chalk.red(err));
        }

        fs.writeFile(outputFile, html, function (err) {
            if (err) {
                return emitter.emit('error', chalk.red(err));
            }
            emitter.emit('warn', chalk.green('Wrote html to ' + outputFile));
        });
    });
}

const baseDir = path.join(__dirname, './../');
const defaultInputDir = path.join(baseDir, './code/dev/front/html/');
const defaultOutputDir = path.join(baseDir, './code/site/ui/');

var cli = meow({
    pkg: '../package.json',
    version: '1.0',
    help: 'help'
}, {
    default: {
        'input': defaultInputDir,
        'output': defaultOutputDir
    }
});

var inputDir = cli.flags.input;
var outputDir = cli.flags.output;
var emitter = getEmitter();

run(inputDir, outputDir, emitter);
