const mix = require('laravel-mix');
const webpack = require('webpack');

var tailwindcss = require('tailwindcss');

mix.setPublicPath('public')
    .js('resources/assets/js/app.js', 'public/js')
    .sass('resources/assets/sass/app.scss', 'public/css')
    .copy('resources/assets/img', 'public/img')
    .options({
        processCssUrls: false,
        postCss: [tailwindcss('./tailwind.js')],
    });