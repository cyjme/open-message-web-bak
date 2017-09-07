#!/usr/bin/env node

var Validate = require('git-validate');

Validate.installScript('eslint', 'eslint .');
Validate.installScript('phpcs', 'phpcs --report=full --standard=psr2 --extensions=php dev/');
Validate.installScript('sass-lint', 'sass-lint -v');
Validate.configureHook('pre-commit', ['eslint', 'phpcs', 'sass-lint']);
