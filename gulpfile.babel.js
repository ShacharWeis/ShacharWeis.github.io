'use strict';

// Core Node

// Core Gulp
import gulp from 'gulp';

// Other Tools
import notifier from 'node-notifier';
import newer from 'gulp-newer';

// Style Processing
import sass from 'gulp-sass';
import sassGlob from 'gulp-sass-bulk-import';
import postcss from 'gulp-postcss';
import autoprefixer from 'autoprefixer';
import cssnano from 'cssnano';
import normalize from 'postcss-normalize';

// Javascript Processing

// Image Processing
import imagemin from 'gulp-imagemin';
import imageminJpegoptim from 'imagemin-jpegoptim';

// Template Processing

const env = process.env.NODE_ENV; // eslint-disable-line
const paths = {
    'src': {
        'styles': 'src/assets/sass',
        'images': 'src/assets/images',
        'static': 'src/static'
    },
    'dest': {
        'styles': 'public/assets/css',
        'images': 'public/assets/images',
        'static': 'public/'
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

});

// Images Task
gulp.task('images', () => {
    if(env === 'development'){
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

// Static Files
gulp.task('static', () => {
    return gulp.src(`${paths.src.static}/**/*`)
        .pipe(newer(paths.dest.static))
        .pipe(gulp.dest(paths.dest.static))
        .on('end', (err) => {
            emitLog('static', err);
        });
});

// Templates Task
gulp.task('templates', () => {

});

// Watch Task
gulp.task('watch', ['default'], () => {

});

// Compilation Task
gulp.task('default', ['styles', 'scripts', 'images', 'templates', 'static']);

//
// // JS processing
// // Browserified Scripts
// gulp.task('browserifyScript', function () {
//     var srcPath = cms.src.themes + '/' + config.themeName + '/' + assetDir.scripts;
//     var destPath = cms.dest.themes + '/' + themeName + '/' + assetDir.scripts;
//     var hasError = false;
//     return gulp.src(srcPath + '/*.bundle.js', function (err, files) {
//         var tasks = files.map(function (entry) {
//             return browserify({entries: [entry]})
//                 .transform('babelify', {
//                     presets: [
//                         'es2015',
//                         'stage-1'
//                     ]
//                 })
//                 .bundle()
//                 .pipe(source(entry))
//                 .pipe(buffer())
//                 .pipe(environ != 'development' ? uglify() : buffer())
//                 .pipe(rename(function (fileObj) {
//                     fileObj.extname = '.min.js';
//                     fileObj.dirname = '';
//                     fileObj.basename = fileObj.basename.replace('.bundle', '');
//                 }))
//                 .pipe(gulp.dest(destPath));
//         });
//         es.merge(tasks);
//     })
//         .on('end', function (err) {
//             if (!hasError) {
//                 emitLog('browserify scripts', err);
//             }
//         });
// });
// // Non browserified scripts
// gulp.task('otherScripts', function () {
//     var srcPath = cms.src.themes + '/' + config.themeName + '/' + assetDir.scripts;
//     var destPath = cms.dest.themes + '/' + themeName + '/' + assetDir.scripts;
//     return gulp.src([
//         srcPath + '/**.js',
//         '!' + srcPath + '/*.bundle.js'
//     ])
//         .pipe(environ != 'development' ? uglify() : buffer())
//         .pipe(rename(function (fileObj) {
//             fileObj.basename = fileObj.basename.replace('.min', '');
//             fileObj.extname = '.min.js';
//             fileObj.dirname = '';
//         }))
//         .pipe(gulp.dest(destPath))
//         .on('end', function () {
//             emitLog('regular scripts');
//         });
// });
// gulp.task('scripts', ['browserifyScript', 'otherScripts']);
//
//
// // All other files processing
// gulp.task('themeFiles', function () {
//     var srcPath = cms.src.themes + '/' + config.themeName;
//     var destPath = cms.dest.themes + '/' + themeName;
//     return gulp.src([
//         srcPath + '/**/*',
//         '!' + srcPath + '/' + assetDir.images + '/**/*',
//         '!' + srcPath + '/' + assetDir.styles + '/**/*',
//         '!' + srcPath + '/' + assetDir.scripts + '/**/*'
//     ])
//         .pipe(newer(destPath))
//         .pipe(gulp.dest(destPath))
//         .on('end', function () {
//             emitLog('theme files');
//         });
// });
//
// // Gulp watch task
// gulp.task('watch', function () {
//     gulp.watch(
//         [
//             cms.src.cmsFiles + '/**/*',
//             '!' + cms.src.themes + '/**/*',
//             '!' + cms.src.packages + '/**/*'
//         ],
//         [
//             'cmsFiles',
//             'delete'
//         ]
//     );
//     gulp.watch(
//         cms.src.packages + '/**/*',
//         [
//             'packages',
//             'delete'
//         ]
//     );
//     gulp.watch(
//         [
//             cms.src.themes + '/' + config.themeName + '/**/*',
//             '!' + cms.src.themes + '/' + config.themeName + '/' + assetDir.images + '/**/*',
//             '!' + cms.src.themes + '/' + config.themeName + '/' + assetDir.styles + '/**/*',
//             '!' + cms.src.themes + '/' + config.themeName + '/' + assetDir.scripts + '/**/*',
//             '!' + cms.src.themes + '/' + config.themeName + '/' + assetDir.media + '/**/*'
//         ],
//         [
//             'themeFiles',
//             'delete'
//         ]
//     );
//     gulp.watch(
//         cms.src.themes + '/' + config.themeName + '/' + assetDir.scripts + '/**/*',
//         [
//             'scripts',
//             'delete'
//         ]
//     );
//     gulp.watch(
//         cms.src.themes + '/' + config.themeName + '/' + assetDir.images + '/**/*',
//         [
//             'images',
//             'delete'
//         ]
//     );
//     gulp.watch(
//         cms.src.themes + '/' + config.themeName + '/' + assetDir.styles + '/**/*.scss',
//         [
//             'styles', //styles
//             'delete'
//         ]
//     );
// });
//
// gulp.task('default', function () {
//     runSequence('set-development', 'init', 'watch');
// });
//
// // Gulp task to compile all assets
// gulp.task('init', function () {
//     runSequence('styleClean', ['styleChain', 'scripts', 'images', 'themeFiles', 'cmsFiles', 'packages', 'wordpressPlugins']);
// });
//
// // Production task
// gulp.task('production', ['init']);