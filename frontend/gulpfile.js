var del = require('del');
var gulp = require('gulp');
var sass = require('gulp-sass');
var gulpIf = require('gulp-if');
var cache = require('gulp-cache');
var image = require('gulp-image');
var useref = require('gulp-useref');
var uglify = require('gulp-uglify');
var cssnano = require('gulp-cssnano');
var browserSync = require('browser-sync');
var runSequence = require('run-sequence');
var sourcemaps = require('gulp-sourcemaps');
var autoprefixer = require('gulp-autoprefixer');
var historyApiFallback = require('connect-history-api-fallback');

/**
 * Development Tasks 
 */

// Start browserSync server
gulp.task('browserSync', function() {
  browserSync.init({
    server: {
      baseDir: "app",
      middleware: [ historyApiFallback() ]
    }
  });
})

gulp.task('sass', function() {
  return gulp.src('app/assets/scss/**/*.scss') // Gets all files ending with .scss in app/scss and children dirs
    .pipe(sass()) // Passes it through a gulp-sass
    .pipe(gulp.dest('app/assets/css')) // Outputs it in the css folder
    .pipe(browserSync.reload({ // Reloading with Browser Sync
      stream: true
    }));
})

gulp.task('apache', function() {
  return gulp.src('app/.htaccess')
    .pipe(gulp.dest('dist'))
})

// Watchers
gulp.task('watch', function() {
  gulp.watch('app/assets/scss/**/*.scss', ['sass']);
  gulp.watch('app/assets/css/**/*.css', browserSync.reload);
  gulp.watch('app/**/*.html', browserSync.reload);
  gulp.watch('app/**/*.js', browserSync.reload);
})

/**
 * Optimization Tasks 
 */

// Optimizing CSS and JavaScript 
gulp.task('useref', function() {
  return gulp.src('app/*.html')
    .pipe(useref())
    .pipe(gulpIf('*.js', uglify()))
    .pipe(gulpIf('*.css', cssnano()))
    .pipe(gulp.dest('dist'));
})

// Optimizing Images 
gulp.task('images', function() {
  return gulp.src('app/assets/img/**/*')
  .pipe(image())
  .pipe(gulp.dest('dist/assets/img'))
})

// Copying fonts 
gulp.task('fonts', function() {
  return gulp.src('app/assets/fonts/**/*')
    .pipe(gulp.dest('dist/fonts'))
})

// Copying partials templates
gulp.task('uib', function() {
  return gulp.src('app/uib/**/*')
  .pipe(gulp.dest('dist/uib'))
})

gulp.task('templates', ['uib'], function() {
  return gulp.src('app/partials/**/*')
    .pipe(gulp.dest('dist/partials'));
})

// Cleaning 
gulp.task('clean:dist', function() {
  return del.sync(['dist/**/*', '!dist/assets/img', '!dist/assets/img/**/*']);
})

/**
 * Build Sequences
 */
gulp.task('default', function(callback) {
  runSequence(['sass', 'browserSync', 'watch'],
    callback
  )
})

gulp.task('build', function(callback) {
  runSequence(
    'clean:dist',
    ['sass', 'useref', 'images', 'fonts', 'templates', 'apache'],
    callback
  )
})