let mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .vue();

mix.autoload({
      jquery: ['$', 'jQuery', 'window.jQuery'],
});

if (mix.inProduction()) {
      mix.version();
}
