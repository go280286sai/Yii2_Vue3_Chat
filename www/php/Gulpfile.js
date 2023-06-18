const gulp = require('gulp');
const concat = require('gulp-concat');
const uglify = require('gulp-uglify');
const sass = require('gulp-sass');
const autoprefixer = require('gulp-autoprefixer');
const cleanCSS = require('gulp-clean-css');
const concatCss = require('gulp-concat-css');

gulp.task('scripts', function() {
    return gulp.src('frontend/dist/js/*.js')
        .pipe(concat('app.js'))
        .pipe(uglify())
        .pipe(gulp.dest('web/js'));
});

// gulp.task('styles', function() {
//     return gulp.src('frontend/dist/scss/*.scss')
//         .pipe(sass().on('error', sass.logError))
//         .pipe(autoprefixer())
//         .pipe(cleanCSS())
//         .pipe(gulp.dest('web/css'));
// });

gulp.task('css', function () {
    return gulp.src('frontend/dist/**/*.css')
        .pipe(concatCss("styles/bundle.css"))
        .pipe(gulp.dest('web/css'));
});
gulp.task('default', gulp.series('scripts', 'css'));