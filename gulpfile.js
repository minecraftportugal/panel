var gulp = require('gulp');
var gutil = require('gulp-util');
var size = require('gulp-size');
var uglify = require('gulp-uglify');
var uglifycss = require('gulp-uglifycss');
var minify = require('gulp-minify');
var concat = require('gulp-concat');
var symlink = require('gulp-sym');
var sass = require('gulp-sass');

/* default sass task */
gulp.task('default', ['dev-sass', 'build-js', 'build-json', 'build-css', 'build-fonts', 'build-images', 'build-sounds', 'production'], function() {
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
    gulp.watch('./assets/development/scss/**/*.scss', ['dev-sass']);
});

/* generate js files for production */
gulp.task('build-js', function() {
    return gulp.src('./assets/development/js/**/*.js')
        .pipe(uglify({mangle: true}))
        //.pipe(concat('all.js'))
        .pipe(size())
        .pipe(gulp.dest('./assets/production/js'))
});

/* generate json files for production */
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

/* generate fonts files for production */
gulp.task('build-fonts', function() {
    return gulp.src('./assets/development/fonts/**/*')
        .pipe(gulp.dest('./assets/production/fonts'))
});

/* generate images files for production */
gulp.task('build-images', function() {
    return gulp.src('./assets/development/images/**/*')
        .pipe(gulp.dest('./assets/production/images'))
});

/* generate sounds files for production */
gulp.task('build-sounds', function() {
    return gulp.src('./assets/development/sounds/**/*')
        .pipe(gulp.dest('./assets/production/sounds'))
});

/* use the development environment */
gulp.task('development', function() {
    return gulp.src('./assets/development')
        .pipe(symlink('./public', {force: true, relative: true}))
});

/* use the production environment */
gulp.task('production', function() {
    return gulp.src('./assets/production')
        .pipe(symlink('./public', {force: true, relative: true}))
});
