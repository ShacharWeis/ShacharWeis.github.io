'use strict';

import gulp from "gulp";
import requireDir from "require-dir";
import sequence from "run-sequence";
import yaml from "js-yaml";

requireDir('./tasks', { recurse: true });

yaml.safeLoad('./build.yml', (file) => {
    console.log(file);
});

let tasks = ['sass', 'browserify', 'start'];

gulp.task('default', () => {
    sequence( tasks );
});