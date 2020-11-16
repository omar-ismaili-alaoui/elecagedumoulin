/*global require: false*/
"use strict";

var gulp             = require('gulp'),
    autoprefixer     = require('gulp-autoprefixer'),
    cleanCSS         = require('gulp-clean-css'),
    combinemq        = require('gulp-combine-mq'),
    concat           = require('gulp-concat'),
    del              = require('del'),
    Fontmin          = require('fontmin'),
    preservetime     = require('gulp-preservetime'),
    replace          = require('gulp-replace'),
    rev              = require('gulp-rev'),
    runSequence      = require('run-sequence'),
    sass             = require('gulp-sass'),
    sourcemaps       = require('gulp-sourcemaps'),
    stripCssComments = require('gulp-strip-css-comments'),
    ttf2woff2        = require('gulp-ttf2woff2'),
    uglify           = require("gulp-uglify"),
    gulpMinifyCssNames = require('gulp-minify-css-names')
;


gulp.task('css', function() {
    return gulp.src('assets/css/app.scss')
    //        .pipe(sourcemaps.init())
        .pipe(sass({
            includePaths: [
                'node_modules/bootstrap-sass/assets/stylesheets',
                'node_modules/font-awesome/scss',
                'node_modules/select2/src/scss',
            ],
        }).on('error', sass.logError))
        .pipe(autoprefixer())
        .pipe(stripCssComments({
            preserve: false,
        }))
        .pipe(replace('@charset "UTF-8";', ''))
        .pipe(cleanCSS({compatibility: 'ie8'}))
        //        .pipe(sourcemaps.write('./'))

        .pipe(rev())
        .pipe(gulp.dest('public/assets/css/'))
        .pipe(rev.manifest({
            base:  '.',
            merge: true,
        }))
        .pipe(gulp.dest('.'))
        ;
});


gulp.task('css_admin', function() {
    return gulp.src('assets_admin/css/app-admin.scss')
    //        .pipe(sourcemaps.init())
        .pipe(sass({
            includePaths: [
                'node_modules/bootstrap-sass/assets/stylesheets',
                'node_modules/font-awesome/scss',
                'node_modules/select2/src/scss',
            ],
        }).on('error', sass.logError))
        .pipe(autoprefixer())
        .pipe(stripCssComments({
            preserve: false,
        }))
        .pipe(replace('@charset "UTF-8";', ''))
        .pipe(cleanCSS({compatibility: 'ie8'}))
        //        .pipe(sourcemaps.write('./'))

        .pipe(rev())
        .pipe(gulp.dest('public/assets_admin/css/'))
        .pipe(rev.manifest("rev-manifest-admin.json", {
            base:  '.',
            merge: true,
        }))
        //        .pipe(concat('node_modules/select2/dist/css/select2.min.css'))
        .pipe(gulp.dest('.'))
        ;
});

gulp.task('font', function() {
    var fontmin = new Fontmin()
        .src('assets/font/src/**/*.ttf')
        .use(Fontmin.ttf2eot())
        .use(Fontmin.ttf2woff({
            deflate: true,
        }))
        .dest('public/assets/font/')
    ;

    fontmin.run(function(err, files) {
        if (err) {
            throw err;
        }

        del.sync(['public/assets/font/**/*.ttf']);
        //console.log('Please add fontname.scss in assets/font/css/');
    });

    return gulp.src('assets/font/src/**/*.ttf')
        .pipe(ttf2woff2())
        .pipe(gulp.dest('public/assets/font/'))
        .pipe(preservetime())
        ;
});

gulp.task('media', function() {
    return gulp.src('assets/media/**/*')
        .pipe(gulp.dest('public/assets/media/'))
        .pipe(preservetime())
        ;
});

gulp.task('js', function() {
    return gulp.src(
        [
            'node_modules/jquery/dist/jquery.js',

            // images lazyload
            'node_modules/vanilla-lazyload/dist/lazyload.js',
            'assets/js/lazyload.js',


//            'node_modules/jquery-ui/ui/core.js',
//            'node_modules/jquery-ui/ui/data.js',
//            'node_modules/jquery-ui/ui/disable-selection.js',
//            'node_modules/jquery-ui/ui/effect.js',
//            'node_modules/jquery-ui/ui/effects/effect-blind.js',
//            'node_modules/jquery-ui/ui/effects/effect-bounce.js',
//            'node_modules/jquery-ui/ui/effects/effect-clip.js',
//            'node_modules/jquery-ui/ui/effects/effect-drop.js',
//            'node_modules/jquery-ui/ui/effects/effect-explode.js',
//            'node_modules/jquery-ui/ui/effects/effect-fade.js',
//            'node_modules/jquery-ui/ui/effects/effect-fold.js',
//            'node_modules/jquery-ui/ui/effects/effect-highlight.js',
//            'node_modules/jquery-ui/ui/effects/effect-puff.js',
//            'node_modules/jquery-ui/ui/effects/effect-pulsate.js',
//            'node_modules/jquery-ui/ui/effects/effect-scale.js',
//            'node_modules/jquery-ui/ui/effects/effect-shake.js',
//            'node_modules/jquery-ui/ui/effects/effect-size.js',
//            'node_modules/jquery-ui/ui/effects/effect-slide.js',
//            'node_modules/jquery-ui/ui/effects/effect-transfer.js',
//            'node_modules/jquery-ui/ui/escape-selector.js',
//            'node_modules/jquery-ui/ui/focusable.js',
//            'node_modules/jquery-ui/ui/form-reset-mixin.js',
//            'node_modules/jquery-ui/ui/form.js',
//            'node_modules/jquery-ui/ui/i18n/datepicker-fr.js',
//            'node_modules/jquery-ui/ui/ie.js',
//            'node_modules/jquery-ui/ui/jquery-1-7.js',
//            'node_modules/jquery-ui/ui/keycode.js',
//            'node_modules/jquery-ui/ui/labels.js',
//            'node_modules/jquery-ui/ui/plugin.js',
//            'node_modules/jquery-ui/ui/position.js',
//            'node_modules/jquery-ui/ui/safe-active-element.js',
//            'node_modules/jquery-ui/ui/safe-blur.js',
//            'node_modules/jquery-ui/ui/scroll-parent.js',
//            'node_modules/jquery-ui/ui/tabbable.js',
//            'node_modules/jquery-ui/ui/unique-id.js',
//            'node_modules/jquery-ui/ui/version.js',
//            'node_modules/jquery-ui/ui/widget.js',
//            'node_modules/jquery-ui/ui/widgets/accordion.js',
//            'node_modules/jquery-ui/ui/widgets/autocomplete.js',
//            'node_modules/jquery-ui/ui/widgets/button.js',
//            'node_modules/jquery-ui/ui/widgets/checkboxradio.js',
//            'node_modules/jquery-ui/ui/widgets/controlgroup.js',
//            'node_modules/jquery-ui/ui/widgets/datepicker.js',
//            'node_modules/jquery-ui/ui/widgets/dialog.js',
//            'node_modules/jquery-ui/ui/widgets/draggable.js',
//            'node_modules/jquery-ui/ui/widgets/droppable.js',
//            'node_modules/jquery-ui/ui/widgets/menu.js',
//            'node_modules/jquery-ui/ui/widgets/mouse.js',
//            'node_modules/jquery-ui/ui/widgets/progressbar.js',
//            'node_modules/jquery-ui/ui/widgets/resizable.js',
//            'node_modules/jquery-ui/ui/widgets/selectable.js',
//            'node_modules/jquery-ui/ui/widgets/selectmenu.js',
//            'node_modules/jquery-ui/ui/widgets/slider.js',
//            'node_modules/jquery-ui/ui/widgets/sortable.js',
//            'node_modules/jquery-ui/ui/widgets/spinner.js',
//            'node_modules/jquery-ui/ui/widgets/tabs.js',
//            'node_modules/jquery-ui/ui/widgets/tooltip.js',

            //bootstrap
            'node_modules/bootstrap-sass/assets/javascripts/bootstrap/transition.js',
            'node_modules/bootstrap-sass/assets/javascripts/bootstrap/alert.js',
            'node_modules/bootstrap-sass/assets/javascripts/bootstrap/button.js',
            'node_modules/bootstrap-sass/assets/javascripts/bootstrap/carousel.js',
            'node_modules/bootstrap-sass/assets/javascripts/bootstrap/collapse.js',
            'node_modules/bootstrap-sass/assets/javascripts/bootstrap/dropdown.js',
            'node_modules/bootstrap-sass/assets/javascripts/bootstrap/modal.js',
            'node_modules/bootstrap-sass/assets/javascripts/bootstrap/tab.js',
            'node_modules/bootstrap-sass/assets/javascripts/bootstrap/affix.js',
            'node_modules/bootstrap-sass/assets/javascripts/bootstrap/scrollspy.js',
            'node_modules/bootstrap-sass/assets/javascripts/bootstrap/tooltip.js',
            'node_modules/bootstrap-sass/assets/javascripts/bootstrap/popover.js',

            // select2
            'node_modules/select2/dist/js/select2.full.js',
            'node_modules/select2/dist/js/i18n/fr.js',

            // multiple-select
            'node_modules/multiple-select/dist/multiple-select.js',

            'node_modules/moment/moment.js',
            'node_modules/moment/locale/fr.js',
            'node_modules/eonasdan-bootstrap-datetimepicker/src/js/bootstrap-datetimepicker.js',

            'assets/js/croppie.min.js',

            // mobile detection for SmartAds
            'node_modules/mobile-detect/mobile-detect.js',
            //'node_modules/mobile-detect/mobile-detect-modernizr.js',

            // custom
            'assets/js/all.js',

        ])
    /*        .pipe(sourcemaps.init({
                debug: true,
            }))*/

        .pipe(concat('public/assets/js/app.js'))
        .pipe(uglify())

        .pipe(rev())
        .pipe(gulp.dest('.'))
        .pipe(rev.manifest({
            base:  '.',
            merge: true,
        }))
        .pipe(gulp.dest('.'))

        /*        .pipe(sourcemaps.write('.'))
                .pipe(gulp.dest('.'))*/
        ;
});


gulp.task('watch', gulp.series('css', 'font', 'media', 'js', 'css_admin', function () {

    gulp.watch(
        [
            'assets/css/**/*.scss',
            'assets/css/**/*.css',
            'assets/font/css/**/*.scss',
            'node_modules/bootstrap-sass/assets/stylesheets/**/*.scss',
        ],
        gulp.series('css'));

    gulp.watch(
        [
            'assets/font/src/**/*',
        ],
        gulp.series('font'));

    gulp.watch(
        [
            'assets/media/**/*',
        ],
        gulp.series('media'));

    gulp.watch(
        [
            'node_modules/jquery/dist/**/*.js',
            'node_modules/moment/**/*.js',
            'node_modules/moment/locale/**/*.js',
            'node_modules/bootstrap-sass/assets/javascripts/bootstrap/**/*.js',
            'assets/js/**/*.js',
        ],
        gulp.series('js'));

    })
);

gulp.task('default', gulp.series('css', 'font', 'media', 'js', 'css_admin'));
