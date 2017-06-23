var gulp = require('gulp'),
  wpPot = require('gulp-wp-pot')

/* Generate the latest language files */
gulp.task('language', function () {
  return gulp.src(['src/**/*.php', '*.php'])
    .pipe(wpPot({
      domain: 'gravity-pdf-core-booster',
      package: 'Gravity PDF Core Booster'
    }))
    .pipe(gulp.dest('languages/gravity-pdf-core-booster.pot'))
})

gulp.task('default', ['language'])