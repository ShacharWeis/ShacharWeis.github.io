'use strict';

// Core lib
var rimraf = require('rimraf');

// Core Gulp
var gulp            = require('gulp'),
    rename          = require('gulp-rename'),
    del             = require('del');

// General Plugins
var runSequence     = require('run-sequence'),
    source          = require('vinyl-source-stream'),
    buffer          = require('vinyl-buffer'),
    newer           = require('gulp-newer'),
    es              = require('event-stream'),
    notifier        = require('node-notifier');

// Image Processing
var imagemin        = require('gulp-imagemin');

// Javascript Processing
var browserify      = require('browserify'),
    uglify          = require('gulp-uglify'),
    babelify        = require('babelify');

// Stylesheet Processing
var sass            = require('gulp-sass'),
    sassVariables   = require('gulp-sass-variables'),
    postcss         = require('gulp-postcss'),
    autoprefixer    = require('autoprefixer'),
    cssnano         = require('cssnano'),
    flexibility     = require('postcss-flexibility'),
    sassGlob        = require('gulp-sass-bulk-import'),
    spliter         = require('postcss-esplit');

// General Config for file placement
var config          = require('./gulpfig.json');
var defaultPaths    = require('./defaultpaths.json');
var environ         = 'production';

var cms             = defaultPaths.cms[config.cms];
var assetDir        = defaultPaths.assetDir;
var themeName       = '';

if (config.cms !== 'flatfile') {
    themeName = config.themeName;
}

function emitLog(stage, err)
{
    var object = {
        title: 'COMPLETE: ' + stage,
        message: 'The ' + stage + ' task is complete'
    };
    if (err) {
        object.title   = 'ERROR: '+ stage;
        object.message = 'There was an error within ' + stage;
        console.log(err);
    }
    notifier.notify(object);
}

gulp.task('set-development', function()
{
    environ = 'development';
});

// SCSS processing
gulp.task('styles', function()
{
    var srcPath    = cms.src.themes+'/'+config.themeName+'/'+assetDir.styles;
    var destPath   = cms.dest.themes+'/'+themeName+'/'+assetDir.styles;
    var hasError   = false;
    var processors = [
        autoprefixer({browsers :['last 2 version', 'safari 5', 'ie 8', 'ie 9', 'opera 12.1', 'ios 6', 'android 4']}),
        flexibility
    ];
    if (environ != 'development') {
        processors.push(cssnano);
    }
    return gulp.src(srcPath + '/**/*.scss')
        .pipe(sassGlob())
        .pipe(sassVariables({
            $APPLICATION_ENV: environ
        }))
        .pipe(
            sass()
                .on('error', function(err) {
                    hasError = true;
                    emitLog('styles', err);
                    this.emit('end');
                })
        )
        .pipe(postcss(processors))
        .pipe(gulp.dest(destPath))
        .on('end', function(err) {
            if (!hasError) {
                emitLog('styles', err);
            }
        });
});

gulp.task('styleClean', function()
{
    var destPath = cms.dest.themes+'/'+themeName+'/'+assetDir.styles;
    rimraf(destPath, function(err){
        if (err) {
            console.log(err) //eslint-disable-line
        }
    });
});

gulp.task('IE9Split', function()
{
    var processors = [
        spliter({
            writeImport: true
        })
    ];
    var destPath = cms.dest.themes+'/'+themeName+'/'+assetDir.styles;
    return gulp.src(destPath + '/**/*.css')
        .pipe(postcss(processors))
        .pipe(gulp.dest(destPath));
});

gulp.task('styleChain', function()
{
    runSequence('styles', 'IE9Split');
})

// JS processing
// Browserified Scripts
gulp.task('browserifyScript', function()
{
    var srcPath  = cms.src.themes+'/'+config.themeName+'/'+assetDir.scripts;
    var destPath = cms.dest.themes+'/'+themeName+'/'+assetDir.scripts;
    var hasError = false;
    return gulp.src(srcPath + '/*.bundle.js', function(err,files){
        var tasks = files.map(function(entry) {
            return browserify({ entries: [entry] })
                .transform('babelify', {
                    presets: [
                        'es2015',
                        'stage-1'
                    ]
                })
                .bundle()
                .pipe(source(entry))
                .pipe(buffer())
                .pipe(environ != 'development' ? uglify() : buffer() )
                .pipe(rename( function(fileObj){
                    fileObj.extname = '.min.js';
                    fileObj.dirname = '';
                    fileObj.basename = fileObj.basename.replace('.bundle','');
                }))
                .pipe(gulp.dest(destPath));
        });
        es.merge(tasks);
    })
        .on('end', function(err) {
            if (!hasError) { emitLog('browserify scripts',err); }
        });
});
// Non browserified scripts
gulp.task('otherScripts', function()
{
    var srcPath  = cms.src.themes+'/'+config.themeName+'/'+assetDir.scripts;
    var destPath = cms.dest.themes+'/'+themeName+'/'+assetDir.scripts;
    return gulp.src([
        srcPath+'/**.js',
        '!'+srcPath+'/*.bundle.js'
    ])
        .pipe(environ != 'development' ? uglify() : buffer() )
        .pipe(rename( function(fileObj){
            fileObj.basename = fileObj.basename.replace('.min','');
            fileObj.extname = '.min.js';
            fileObj.dirname = '';
        }))
        .pipe(gulp.dest(destPath))
        .on('end', function() {
            emitLog('regular scripts');
        });
});
gulp.task('scripts', ['browserifyScript', 'otherScripts']);

// Image processing
gulp.task('images', function()
{
    var srcPath  = cms.src.themes+'/'+config.themeName+'/'+assetDir.images;
    var destPath = cms.dest.themes+'/'+themeName+'/'+assetDir.images;
    return gulp.src('./src/themes/'+config.themeName+'/images/**/*')
        .pipe(newer(destPath)) //Note: NOT using srcPath
        .pipe(imagemin({
            progressive: true,
            optimizationLevel: 7,
            interlaced: true
        }))
        .pipe(gulp.dest(destPath))
        .on('end', function() {
            emitLog('images');
        });
});

// All other files processing
gulp.task('themeFiles', function()
{
    var srcPath  = cms.src.themes+'/'+config.themeName;
    var destPath = cms.dest.themes+'/'+themeName;
    return gulp.src([
        srcPath+'/**/*',
        '!'+srcPath+'/'+assetDir.images+'/**/*',
        '!'+srcPath+'/'+assetDir.styles+'/**/*',
        '!'+srcPath+'/'+assetDir.scripts+'/**/*'
    ])
        .pipe(newer(destPath))
        .pipe(gulp.dest(destPath))
        .on('end', function() {
            emitLog('theme files');
        });
});

gulp.task('packages', function()
{
    var srcPath  = cms.src.packages;
    var destPath = cms.dest.packages;
    return gulp.src([srcPath + '/**/*'])
        .pipe(newer(destPath))
        .pipe(gulp.dest(destPath))
        .on('end', function() {
            emitLog('package files');
        });
});

gulp.task('cmsFiles', function()
{
    var srcPath  = cms.src.cmsFiles;
    var destPath = cms.dest.cmsFiles;
    return gulp.src([
        srcPath + '/**/*',
        '!'+srcPath+'/themes/**/*',
        '!'+srcPath+'/packages/**/*'
    ])
        .pipe(newer(destPath))
        .pipe(gulp.dest(destPath))
        .on('end', function() {
            emitLog('cms files');
        });
});

gulp.task('wordpressPlugins', function()
{
    if (config.cms !== 'wordpress') {
        return;
    }
    var srcPath  = cms.src.WPplugins;
    var destPath = cms.dest.WPplugins;
    return gulp.src(srcPath + '/**/*')
        .pipe(newer(cms.WPplugins))
        .pipe(gulp.dest(destPath))
        .on('end', function() {
            emitLog('wordpress plugins');
        });
});

// Delete Cache Files during development
gulp.task('delete', function()
{
    return del([cms.dest.cache]);
});

// Gulp watch task
gulp.task('watch', function() {
    gulp.watch(
        [
            cms.src.cmsFiles+'/**/*',
            '!'+cms.src.themes+'/**/*',
            '!'+cms.src.packages+'/**/*'
        ],
        [
            'cmsFiles',
            'delete'
        ]
    );
    gulp.watch(
        cms.src.packages+'/**/*',
        [
            'packages',
            'delete'
        ]
    );
    gulp.watch(
        [
            cms.src.themes+'/'+config.themeName+'/**/*',
            '!'+cms.src.themes+'/'+config.themeName+'/'+assetDir.images+'/**/*',
            '!'+cms.src.themes+'/'+config.themeName+'/'+assetDir.styles+'/**/*',
            '!'+cms.src.themes+'/'+config.themeName+'/'+assetDir.scripts+'/**/*',
            '!'+cms.src.themes+'/'+config.themeName+'/'+assetDir.media+'/**/*'
        ],
        [
            'themeFiles',
            'delete'
        ]
    );
    gulp.watch(
        cms.src.themes+'/'+config.themeName+'/'+assetDir.scripts+'/**/*',
        [
            'scripts',
            'delete'
        ]
    );
    gulp.watch(
        cms.src.themes+'/'+config.themeName+'/'+assetDir.images+'/**/*',
        [
            'images',
            'delete'
        ]
    );
    gulp.watch(
        cms.src.themes+'/'+config.themeName+'/'+assetDir.styles+'/**/*.scss',
        [
            'styleChain', //styles
            'delete'
        ]
    );
    if (config.cms === 'wordpress'){
        gulp.watch(
            cms.src.WPplugins+'/**/*',
            ['wordpressPlugins']
        );
    }
});

gulp.task('default', function(){
    runSequence('set-development','init','watch');
});

//gulp.task('init', ['themeFiles', 'cmsFiles', 'styles', 'scripts', 'images', 'packages', 'wordpressPlugins']);
// Gulp task to compile all assets
gulp.task('init', function(){
    runSequence('styleClean', ['styleChain', 'scripts', 'images', 'themeFiles', 'cmsFiles', 'packages', 'wordpressPlugins']);
});

// Production task
gulp.task('production', ['init']);