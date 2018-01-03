let mix = require('laravel-mix');

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

mix.styles([
  'resources/assets/css/bootstrap.css',
  'resources/assets/css/font-awesome.css',
  'resources/assets/css/app.css',
  'resources/assets/css/magnific-popup.css',
  'resources/assets/css/sweetalert2.css'
], 'public/css/app.css')
.scripts([
  'resources/assets/js/jquery-3.2.1.js',
  'resources/assets/js/popper.js',
  'resources/assets/js/bootstrap.js',
  'resources/assets/js/jquery.magnific-popup.js',
  'resources/assets/js/sweetalert2.js'
], 'public/js/app.js');
