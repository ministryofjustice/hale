const mix_ = require('laravel-mix');


mix_.setPublicPath('./dist')
  .copy('./assets/webfonts/*', 'dist/webfonts/')
  .sass('./style.scss', 'css/style.min.css')
  .sass('./style-gutenburg.scss', 'css/style-gutenburg.min.css')
  .sass('./page-colours.scss', 'css/page-colours.min.css')
  .copy('./assets/js/*', 'dist/js/')
  .options({
    processCssUrls: false
  });
  //.copy('./assets/img/*', 'dist/images/');
 //.js('./assets/js/_main.js', 'js/main.min.js')

if (mix_.inProduction()) {
  mix_.version();
} else {
  mix_.sourceMaps();
}
