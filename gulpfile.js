// 引用 gulp plugin
var gulp = require('gulp'),               // 載入 gulp
    gulpUglify = require('gulp-uglify');  // 載入 gulp-uglify
    gulpSass = require('gulp-sass');      // 載入 gulp-sass
var rev = require('gulp-rev');
var revCollector = require('gulp-rev-collector');
var revDel = require('rev-del');
var gutil           = require('gulp-util');
var rimraf          = require('rimraf');
var revOutdated     = require('gulp-rev-outdated');
var path            = require('path');
var through         = require('through2');


gulp.task('default', ['styles', 'watch']);

gulp.task('watch', function () {
    gulp.watch('public/scss/**/*.scss' ,['styles']);
});

gulp.task('styles', function () {
	gulp.src('public/scss/**/*.scss')    // 指定要處理的 Scss 檔案目錄
	    .pipe(gulpSass({                 // 編譯 Scss
	    	outputStyle: 'compressed'
	    }))
	    .pipe(gulp.dest('public/css_release'));  // 指定編譯後的 css 檔案目錄
});

gulp.task('script', function () {
    // views_releases 正常讀取的檔案
    gulp.src('public/js/**/*.js')              // 指定要處理的原始 JavaScript 檔案目錄
        .pipe(gulpUglify())                    // 將 JavaScript 做最小化
        .pipe(rev())
        .pipe(gulp.dest('public/js_release'))  // 指定最小化後的 JavaScript 檔案目錄
        .pipe(rev.manifest())
        .pipe(revDel('some-other-manifest.json'))
        .pipe(gulp.dest('./rev'));

    // views_releases 刪掉重建期間， views 會暫時讀底下的檔案
    gulp.src('public/js/**/*.js')              // 指定要處理的原始 JavaScript 檔案目錄
        .pipe(gulpUglify())                    // 將 JavaScript 做最小化
        .pipe(gulp.dest('public/js_release'));  // 指定最小化後的 JavaScript 檔案目錄

    // views_releases 正常讀取的檔案
    gulp.src('public/scss/**/*.scss')    // 指定要處理的 Scss 檔案目錄
        .pipe(gulpSass({                 // 編譯 Scss
            outputStyle: 'compressed'
        }))
        .pipe(rev())
        .pipe(gulp.dest('public/css_release'))  // 指定最小化後的 JavaScript 檔案目錄
        .pipe(rev.manifest({path : 'rev-manifest-css.json'}))
        .pipe(gulp.dest('./rev'));

    // views_releases 刪掉重建期間， views 會暫時讀底下的檔案
    gulp.src('public/scss/**/*.scss')    // 指定要處理的 Scss 檔案目錄
        .pipe(gulpSass({                 // 編譯 Scss
            outputStyle: 'compressed'
        }))
        .pipe(gulp.dest('public/css_release'));  // 指定編譯後的 css 檔案目錄
});

gulp.task('rev', function() {
    // 讀取 rev-manifest.json 文件以及需要進行css名替換的文件
    gulp.src(['./rev/*.json', './application/views/**/**/*.php'])
        .pipe(revCollector())
        .pipe( gulp.dest('./application/views_release/') );
});

function cleaner() {
    return through.obj(function(file, enc, cb){
        rimraf( path.resolve( (file.cwd || process.cwd()), file.path), function (err) {
            if (err) {
                this.emit('error', new gutil.PluginError('Cleanup old files', err));
            }
            this.push(file);
            cb();
        }.bind(this));
    });
}

gulp.task('clean', function() {
    gulp.src( ['public/js_release/**/*.js'], {read: false})
        .pipe( revOutdated(2) ) // leave 1 latest asset file
        .pipe( cleaner() );
    gulp.src( ['public/css_release/**/*.css'], {read: false})
        .pipe( revOutdated(2) ) // leave 1 latest asset file
        .pipe( cleaner() );
    return;
});