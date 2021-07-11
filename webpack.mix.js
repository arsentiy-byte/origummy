const mix = require('laravel-mix');
const path = require('path');

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


// admin
mix
  .alias({
    '@': path.join(__dirname, 'resources/js')
  })
  .js('resources/js/admin/admin.js', 'public/js').vue()
  .js('resources/js/user/app.js', 'public/js').vue()
  .sass('resources/sass/admin.scss', 'public/css')
  .sass('resources/sass/app.scss', 'public/css')
  .styles([
    'node_modules/@mdi/font/css/materialdesignicons.css'
  ], 'public/css/vendor.css')
  .copyDirectory('node_modules/@mdi/font/fonts', 'public/fonts')
  .copyDirectory('resources/images', 'public/images')
  .version();
