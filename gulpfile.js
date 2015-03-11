var gulp = require('gulp');
var gutil = require('gulp-util');
var size = require('gulp-size');
var uglify = require('gulp-uglify');
var uglifycss = require('gulp-uglifycss');
var minify = require('gulp-minify');
var concat = require('gulp-concat');
var symlink = require('gulp-sym');

gulp.task('default', ['js', 'json', 'css', 'fonts', 'images', 'sounds', 'production'], function() {
    // place code for your default task here

});

gulp.task('js', function() {
    return gulp.src('./assets/development/js/**/*.js')
        .pipe(uglify({mangle: true}))
        //.pipe(concat('all.js'))
        .pipe(size())
        .pipe(gulp.dest('./assets/production/js'))
});

gulp.task('json', function() {
    return gulp.src('./assets/development/js/**/*.json')
        .pipe(size())
        .pipe(gulp.dest('./assets/production/js'))
});

gulp.task('css', function() {
    return gulp.src('./assets/development/css/**/*.css')
        .pipe(uglifycss())
        //.pipe(concat('all.js'))
        .pipe(size())
        .pipe(gulp.dest('./assets/production/css'))
});

gulp.task('fonts', function() {
    gulp.src('./assets/development/fonts/**/*')
        .pipe(gulp.dest('./assets/production/fonts'))
});

gulp.task('images', function() {
    gulp.src('./assets/development/images/**/*')
        .pipe(gulp.dest('./assets/production/images'))
});

gulp.task('sounds', function() {
    gulp.src('./assets/development/sounds/**/*')
        .pipe(gulp.dest('./assets/production/sounds'))
});

gulp.task('development', function() {
    gulp.src('./assets/development')
        .pipe(symlink('./public', {force: true, relative: true}))
});

gulp.task('production', function() {
    gulp.src('./assets/production')
        .pipe(symlink('./public', {force: true, relative: true}))
});
