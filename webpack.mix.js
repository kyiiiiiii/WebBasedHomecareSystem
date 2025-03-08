const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/circliful.custom.js', 'public/js')
    .js('resources/js/chart.js', 'public/js')
    .js('resources/js/d3.js', 'public/js')
    .js('resources/js/cropper.js', 'public/js')
    .js('resources/js/calendar.js', 'public/js')
    .vue()
    .sass('resources/sass/app.scss', 'public/css')
    .postCss('resources/css/app.css', 'public/css', [
        require('autoprefixer'),
    ]);;

