const mix_ = require('laravel-mix');


mix_.setPublicPath('./dist')
  .copy('./assets/images/*', 'dist/images/')
  .copy('./assets/webfonts/*', 'dist/webfonts/')
  .sass('./assets/scss/style.scss', 'css/style.min.css')
  .sass('./assets/scss/style-gutenburg.scss', 'css/style-gutenburg.min.css')
  .sass('./assets/scss/custom-branding.scss', 'css/custom-branding.min.css')
  .sass('./assets/scss/editor-branding.scss', 'css/editor-branding.min.css')
  .sass('./assets/scss/brandings-dark-background--php-used.scss', 'css/dark-background.min.css')
  .copy('./assets/js/*', 'dist/js/')
  //.copy('./node_modules/govuk-frontend/dist/govuk/govuk-frontend.min.js', 'dist/js/govuk-frontend.js')
  .scripts(['./assets/js/hale-scripts.js','./assets/js/skip-link-focus-fix.js','./assets/js/navigation.js','./assets/js/banner-close-button.js'], 'dist/js/hale-combined-scripts.js')
  .scripts(['./node_modules/govuk-frontend/dist/govuk/govuk-frontend.min.js', './assets/js/gov-overrides.js'], 'dist/js/govuk-frontend.js')
  .options({
    processCssUrls: false
  });

if (mix_.inProduction()) {
  mix_.version();
} else {
  mix_.sourceMaps();
}
