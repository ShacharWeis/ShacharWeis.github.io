'use strict';

import gulp from "gulp";
import requireDir from "require-dir";
import sequence from "run-sequence";

requireDir('./tasks', { recurse: true });

let tasks = ['sass', 'javascript', 'start'];

gulp.task('default', () => {
    sequence( tasks );
});