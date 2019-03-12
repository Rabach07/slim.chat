const mix = require('laravel-mix');

var tailwindcss = require('tailwindcss');

mix.js('resources/js/widget/widget.js', 'public/js')
    .sass('resources/sass/widget.scss', 'public/css')
    .options({
        processCssUrls: false,
        postCss: [ tailwindcss('./tailwind.js') ],
    });
