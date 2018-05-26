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

mix.sass('resources/assets/sass/app.scss', 'public/css')
.styles(['node_modules/datatables.net-bs4/css/dataTables.bootstrap4.css',
'node_modules/inputmask/css/inputmask.css',
'node_modules/parsleyjs/src/parsley.css','resources/assets/plugin/waitMe/waitMe.css'],'public/css/datatable.css')
.js('resources/assets/js/bootstrap.js','public/js/')
.js(['bower_components/knockout-daterangepicker/dist/daterangepicker.js'],'public/js/daterangepicker.js')
.js(['node_modules/startbootstrap-sb-admin/vendor/jquery-easing/jquery.easing.js','node_modules/startbootstrap-sb-admin/js/sb-admin.js',
'resources/assets/plugin/waitMe/waitMe.js'],'public/js/template.js');
