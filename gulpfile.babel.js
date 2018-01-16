'use strict';

// Core Node
import * as fs from 'fs';

// Core Gulp
import gulp from 'gulp';

// Other Tools
import notifier from 'node-notifier';
import newer from 'gulp-newer';
import {create as bsCreate} from 'browser-sync';
const browserSync = bsCreate();

// Style Processing
import sass from 'gulp-sass';
import sassGlob from 'gulp-sass-bulk-import';
import postcss from 'gulp-postcss';
import autoprefixer from 'autoprefixer';
import cssnano from 'cssnano';
import normalize from 'postcss-normalize';

// Javascript Processing
import browserify from 'browserify';
import babelify from 'babelify';
import source from 'vinyl-source-stream';
import buffer from 'vinyl-buffer';
import es from 'event-stream';
import rename from 'gulp-rename';
import uglify from 'gulp-uglify';

// Image Processing
import imagemin from 'gulp-imagemin';
import imageminJpegoptim from 'imagemin-jpegoptim';

// Template Processing
import nunjucksRender from 'gulp-nunjucks-render';
import htmlmin from 'gulp-htmlmin';

const packageJson = JSON.parse(fs.readFileSync('./package.json'));
const targets = packageJson.browserslist;

const env = process.env.NODE_ENV; // eslint-disable-line
const paths = {
    'src': {
        'styles': 'src/assets/sass',
        'scripts': 'src/assets/js',
        'images': 'src/assets/images',
        'static': 'src/static',
        'template': 'src/templates'
    },
    'dest': {
        'styles': 'public/assets/css',
        'scripts': 'public/assets/js',
        'images': 'public/assets/images',
        'static': 'public/',
        'template': 'public/'
    }
};

function emitLog(stage, err) {
    if (err) {
        notifier.notify({
            'title': `ERROR: ${stage}`,
            'message': `There was an error within ${stage}`
        });
        console.log(err); // eslint-disable-line
    }
}

// Styles Task
gulp.task('styles', () => {
    let processors = [
        autoprefixer(),
        normalize()
    ];
    if (env !== 'development') {
        processors.push(cssnano);
    }
    return gulp.src(`${paths.src.styles}/**/*.scss`)
        .pipe(sassGlob())
        .pipe(
            sass()
                .on('error', (err) => {
                    emitLog('styles', err);
                    this.emit('end');
                })
        )
        .pipe(postcss(processors))
        .pipe(gulp.dest(paths.dest.styles));
});

// Scripts Task
gulp.task('scripts', () => {
    return gulp.src(`${paths.src.scripts}/**/*.js`, (err, files) => {
        let tasks = files.map((entry) => {
            return browserify({entries: [entry]})
                .transform(babelify, {
                    presets: [[
                        'env', {
                            'targets': targets[env]
                        }]]
                })
                .bundle()
                .pipe(source(entry))
                .pipe(buffer())
                .pipe(env !== 'development' ? uglify() : buffer())
                .pipe(rename((fileObj) => {
                    fileObj.dirname = '';
                }))
                .pipe(gulp.dest(paths.dest.scripts));
        });
        es.merge(tasks);
    })
        .on('end', (err) => {
            emitLog('scripts', err);
        });
});

// Images Task
gulp.task('images', () => {
    if (env === 'development') {
        return gulp.src(`${paths.src.images}/**/*.+(jpg|jpeg|gif|png|svg)`)
            .pipe(newer(paths.dest.images))
            .pipe(gulp.dest(paths.dest.images))
            .on('end', (err) => {
                emitLog('images', err);
            });
    }
    return gulp.src(`${paths.src.images}/**/*.+(jpg|jpeg|gif|png|svg)`)
        .pipe(imagemin([
            imagemin.gifsicle({interlaced: true}),
            imagemin.optipng({optimzationLevel: 5}),
            imagemin.svgo({
                plugins: [
                    {
                        cleanupIDs: false,
                        removeEmptyAttrs: false,
                        removeViewBox: false
                    }
                ]
            }),
            imageminJpegoptim({
                max: 85,
                progressive: true
            })
        ]))
        .pipe(gulp.dest(paths.dest.images))
        .on('end', (err) => {
            emitLog('images', err);
        });
});

// Templates Task
gulp.task('templates',['styles'], () => {
    let extension = '.php';
    if (env === 'development') {
        extension = '.html';
    }
    const styleData = fs.readFileSync('./public/assets/css/main.css', 'utf-8');
    return gulp.src(`${paths.src.template}/**/*.njk`)
        .pipe(nunjucksRender({
            path: [paths.src.template],
            data: {
                styleData: styleData,
                stylePath: './assets/css',
                scriptPath: './assets/js',
                imagePath: './assets/images',
                staticPath: './static',
                composerPath: './app',
                env: env
            },
            envOptions: {
                autoescape: false,
                trimBlocks: true,
                lstripBlocks: true
            },
            ext: extension
        }))
        .pipe(env !== 'development' ? htmlmin({collapseWhitespace: true, minifyJS: true, minifyCSS: true}) : buffer())
        .pipe(gulp.dest(paths.dest.template))
        .on('end', (err) => {
            emitLog('template', err);
        });
});

gulp.task('script-watch', ['scripts'], (done) => {
    browserSync.reload();
    done();
});

gulp.task('template-watch', ['templates'], (done) => {
    browserSync.reload();
    done();
});

gulp.task('browserSync', () => {
    browserSync.init({
        server: {
            baseDir: './public/',
            serveStaticOptions: {
                extensions: ['html']
            }
        }
    });
});

// Watch Task
gulp.task('watch', ['browserSync', 'default'], () => {
    gulp.watch(`${paths.src.styles}/**/*.scss`,['template-watch']);
    gulp.watch(`${paths.src.scripts}/**/*.js`,['script-watch']);
    gulp.watch(`${paths.src.template}/**/*`,['template-watch']);
    gulp.watch(`${paths.src.images}/**/*.+(jpg|jpeg|gif|png|svg)`,['images']);
});

// Compilation Task
gulp.task('default', ['styles', 'scripts', 'images', 'templates']);
