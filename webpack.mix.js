const mix = require('laravel-mix');
const tailwindcss = require('tailwindcss');
const path = require('path');
const paths = {
  js: path.join(__dirname, 'resources/assets/js'),
  css: path.join(__dirname, 'resources/assets/css/'),
};

require('laravel-mix-purgecss');

mix.webpackConfig({
  resolve: {
    alias: {
      'core': paths.js + '/core',
      '@': paths.js + '/components',
      'services': paths.js + '/services',
    },
  },
});

mix
  .js(paths.js + '/app.js', 'public/js')
  .postCss(paths.css + 'app.css', 'public/css', [
    tailwindcss('./tailwind.js')
  ])
  .purgeCss();

if (mix.inProduction()) {
  mix.version();
}
