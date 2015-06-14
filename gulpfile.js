var gulp = require('gulp');
var gutil = require('gulp-util');
var size = require('gulp-size');
var uglify = require('gulp-uglify');
var uglifycss = require('gulp-uglifycss');
var minify = require('gulp-minify');
var concat = require('gulp-concat');
var symlink = require('gulp-sym');
var sass = require('gulp-sass');
var copy = require('gulp-copy');
var debug = require('gulp-debug');
var eventstream = require('event-stream');

/* default sass task */
gulp.task('default', ['dev-sass', 'build-js', 'build-json', 'build-css', 'production'], function() {
    // place code for your default task here
});

/* generate css files from scss files */
gulp.task('dev-sass', function () {
    return gulp.src('./assets/development/scss/**/*.scss')
        .pipe(sass.sync().on('error', sass.logError))
        .pipe(gulp.dest('./assets/development/css'));
});

/* watch for the task above */
gulp.task('dev-sass:watch', function () {
    return gulp.watch('./assets/development/scss/**/*.scss', ['dev-sass']);
});gitgi

/* generate js files for production */
gulp.task('build-js', function() {
    return gulp.src('./assets/development/js/**/*.js')
        .pipe(uglify({mangle: true}))
        //.pipe(concat('all.js'))
        .pipe(size())
        .pipe(gulp.dest('./assets/production/js'))
});

gulp.task('build-json', function() {
    return gulp.src('./assets/development/js/**/*.json')
        .pipe(size())
        .pipe(gulp.dest('./assets/production/js'))
});

/* generate css files for production */
gulp.task('build-css', function() {
    return gulp.src('./assets/development/css/**/*.css')
        .pipe(uglifycss())
        //.pipe(concat('all.js'))
        .pipe(size())
        .pipe(gulp.dest('./assets/production/css'))
});

/* use the development environment */
gulp.task('development', function() {
    return gulp.src('./assets/development')
        .pipe(symlink('./public', {force: true, relative: true}))
});


/* set up the symlink environment for production */
gulp.task('production-symlinks', function(cb) {
    eventstream.concat(
        gulp.src('./assets/fonts')
            .pipe(symlink('./assets/production/fonts', {force: true, relative: true})),
        gulp.src('./assets/images')
            .pipe(symlink('./assets/production/images', {force: true, relative: true})),
        gulp.src('./assets/sounds')
            .pipe(symlink('./assets/production/sounds', {force: true, relative: true})),
        gulp.src('./assets/lib/js')
            .pipe(symlink('./assets/production/js/lib', {force: true, relative: true})),
        gulp.src('./assets/lib/css')
            .pipe(symlink('./assets/production/css/lib', {force: true, relative: true}))
    ).on('end', cb);
});


/* use the production environment */
gulp.task('production', ['production-symlinks'], function() {
    return gulp.src('./assets/production')
        .pipe(symlink('./public', {force: true, relative: true}))
});
