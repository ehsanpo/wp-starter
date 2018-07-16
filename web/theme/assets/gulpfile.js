var gulp        = require('gulp');
var browserSync = require('browser-sync').create();
var sass        = require('gulp-sass');
var reload      = browserSync.reload;
var concat = require('gulp-concat');  
var rename = require('gulp-rename');  
var uglify = require('gulp-uglify');  
var sourcemaps = require('gulp-sourcemaps');
var autoprefixer = require('gulp-autoprefixer');
var svgstore = require('gulp-svgstore');
var rbcss  = require('gulp-rb-validate-css');
var jshint = require('gulp-jshint');
var notify = require("gulp-notify");


var src = {
    scss: 'sass/main.scss',
    allscss: 'sass/**/*.*',
    css:  'css/',
    jsFiles: [ 'scripts/jquery.js', 'scripts/lib/*.js', 'scripts/main.js'],
    jsDest: 'js/',
    svgstore: 'img/icons/*.svg',
    svgdest: 'img/'
};

gulp.task('icons', function () {
    return gulp
        .src(src.svgstore, { base: 'src/svg' })
        .pipe(rename({prefix: 'icon-'}))
        .pipe(svgstore())
        .pipe(gulp.dest(src.svgdest));
});

gulp.task('sass', function () {
  return gulp
    .src(src.scss)
    .pipe(sourcemaps.init())
    .pipe(sass({outputStyle: 'compressed'}).on('error', notify.onError("Error: <%= error.message %>")))
    .pipe(sourcemaps.write())
    .pipe(autoprefixer())
    .pipe(rbcss({
          exitOnError: true,
          indentPattern: '\t',
          checkRemoteUrl: false,
          linewidth: 100,
          checkRem: false
        }))
    .pipe(gulp.dest(src.css))
    .pipe(reload({stream: true}));
});

gulp.task('js-hint', function() { 
    return gulp.src('scripts/main.js')
        .pipe(jshint())
        .pipe(jshint.reporter('default'))
        .pipe(jshint.reporter('fail'))
        .on('error', notify.onError({ message: 'JS hint fail'}));


});

gulp.task('scripts',['js-hint'], function() {  
    return gulp.src(src.jsFiles)
        .pipe(concat('scripts.js'))
        .pipe(gulp.dest(src.jsDest))
        .pipe(rename('scripts.min.js'))
        .pipe(uglify())
        .on('error', notify.onError("Error: <%= error.message %>"))
        .pipe(gulp.dest(src.jsDest));
});

// Static Server + watching scss/html files
gulp.task('serve', ['sass'], function() {

    browserSync.init({
        proxy: "gg-start.loc",
    });

    gulp.watch(src.jsFiles, ['scripts']);
    gulp.watch(src.allscss, ['sass']);
    gulp.watch(src.svgstore, ['icons']);
});




gulp.task('default', ['serve']);

