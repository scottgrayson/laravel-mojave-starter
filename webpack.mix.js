let mix = require('laravel-mix')
require('dotenv').config()

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

mix.js('resources/assets/js/app.js', 'public/js')
  //.extract([
    //'vue',
    //'jquery',
    //'fullcalendar',
    //'moment',
    //'select2',
    //'simplemde',
    //'codemirror',
    //'sortablejs',
    //'sweetalert',
    //'bootstrap',
    //'popper.js',
  //])

  .sass('resources/assets/sass/app.scss', 'public/css')

mix.browserSync(process.env.APP_URL)

if (mix.config.inProduction) {
  mix.version()
}
