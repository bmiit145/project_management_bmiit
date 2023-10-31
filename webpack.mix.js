const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */


// Copy Toastr CSS and JS files from node_modules to public directory
mix.copy('node_modules/toastr/build/toastr.min.css', 'public/css/toastr.min.css');
mix.copy('node_modules/toastr/build/toastr.min.js', 'public/js/toastr.min.js');

// Copy Select2 CSS and JS files from node_modules to public directory

// mix.copy('node_modules/select2/dist/css/select2.min.css', 'public/css/select2.min.css');
// mix.copy('node_modules/select2/dist/js/select2.min.js', 'public/js/select2.min.js');


// I want to access all js and css files in the public folder
// without the need to run npm run dev or npm run watch
// so I added this snippet to the webpack.mix.js file
// so that it will copy all the files in the public folder
// to the public folder in the root directory
// so that I can access them directly
mix.copyDirectory('public', '../public');

mix.js('resources/js/app.js', 'public/js')
    .setPublicPath('public');

mix.js('node_modules/choices.js/public/assets/scripts/choices.min.js', 'public/js');
