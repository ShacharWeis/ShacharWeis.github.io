'use strict';

// Core Node
// Core Gulp
import gulp from "gulp";

// Style Processing

// Javascript Processing

// Image Processing

// Template Processing

// function emitLog(stage, err) {
//     let object = {
//         title: 'COMPLETE: ' + stage,
//         message: 'The ' + stage + ' task is complete'
//     };
//     if (err) {
//         object.title = 'ERROR: ' + stage;
//         object.message = 'There was an error within ' + stage;
//         console.log(err);
//     }
//     notifier.notify(object);
// }

gulp.task('default', () => {
   console.log(process.env.NODE_ENV);
});
//
// gulp.task('set-development', function () {
//     environ = 'development';
// });
//
// // SCSS processing
// gulp.task('styles', function () {
//     var srcPath = cms.src.themes + '/' + config.themeName + '/' + assetDir.styles;
//     var destPath = cms.dest.themes + '/' + themeName + '/' + assetDir.styles;
//     var hasError = false;
//     var processors = [
//         autoprefixer(),
//         flexibility
//     ];
//     if (environ != 'development') {
//         processors.push(cssnano);
//     }
//     return gulp.src(srcPath + '/**/*.scss')
//         .pipe(sassGlob())
//         .pipe(sassVariables({
//             $APPLICATION_ENV: environ
//         }))
//         .pipe(
//             sass()
//                 .on('error', function (err) {
//                     hasError = true;
//                     emitLog('styles', err);
//                     this.emit('end');
//                 })
//         )
//         .pipe(postcss(processors))
//         .pipe(gulp.dest(destPath))
//         .on('end', function (err) {
//             if (!hasError) {
//                 emitLog('styles', err);
//             }
//         });
// });
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
// // Image processing
// gulp.task('images', function () {
//     var srcPath = cms.src.themes + '/' + config.themeName + '/' + assetDir.images;
//     var destPath = cms.dest.themes + '/' + themeName + '/' + assetDir.images;
//     return gulp.src('./src/themes/' + config.themeName + '/images/**/*')
//         .pipe(newer(destPath)) //Note: NOT using srcPath
//         .pipe(imagemin({
//             progressive: true,
//             optimizationLevel: 7,
//             interlaced: true
//         }))
//         .pipe(gulp.dest(destPath))
//         .on('end', function () {
//             emitLog('images');
//         });
// });
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