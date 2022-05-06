const mix_ = require('laravel-mix');


mix_.setPublicPath('./dist')
  .copy('./assets/images/*', 'dist/images/')
  .copy('./assets/webfonts/*', 'dist/webfonts/')
  .sass('./assets/scss/style.scss', 'css/style.min.css')
  .sass('./assets/scss/style-gutenburg.scss', 'css/style-gutenburg.min.css')
  .sass('./assets/scss/page-colours.scss', 'css/page-colours.min.css')
 // .sass('./assets/scss/branding.scss', 'css/branding.min.css')
  .copy('./assets/js/*', 'dist/js/')
  .options({
    processCssUrls: false
  });

if (mix_.inProduction()) {
  mix_.version();
} else {
  mix_.sourceMaps();
}
