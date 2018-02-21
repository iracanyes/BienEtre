var Encore = require('@symfony/webpack-encore');
var path = require('path');

Encore
    // the project directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // the public path used by the web server to access the previous directory
    .setPublicPath('/build')
    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isProduction())
    // uncomment to create hashed filenames (e.g. app.abc123.css)
    // .enableVersioning(Encore.isProduction())

    // uncomment to define the assets of the project
    .addEntry('js/main', './assets/js/main.js')
    .addEntry('js/add-collection-widget',"./assets/libraries/custom/add-collection-widget.js")
    // Création d'entrées partagés par plusieurs scripts et pages.
    .createSharedEntry("js/vendors",[
        "./assets/js/jquery.js",
        "./assets/js/superlist.js",
        "./assets/js/map.js",
        "./assets/libraries/bootstrap-select/bootstrap-select.min.js",
        "./assets/libraries/bootstrap-fileinput/fileinput.min.js",
        "./assets/libraries/jquery-google-map/jquery-google-map.js",
        "./assets/libraries/bootstrap-sass/javascripts/bootstrap/collapse.js",
        "./assets/libraries/bootstrap-sass/javascripts/bootstrap/carousel.js",
        "./assets/libraries/bootstrap-sass/javascripts/bootstrap/transition.js",
        "./assets/libraries/bootstrap-sass/javascripts/bootstrap/dropdown.js",
        "./assets/libraries/bootstrap-sass/javascripts/bootstrap/tooltip.js",
        "./assets/libraries/bootstrap-sass/javascripts/bootstrap/tab.js",
        "./assets/libraries/bootstrap-sass/javascripts/bootstrap/alert.js",
        "./assets/libraries/colorbox/jquery.colorbox-min.js",
        "./assets/libraries/jquery-google-map/infobox.js",
        "./assets/libraries/jquery-google-map/markerclusterer.js",
        "./assets/libraries/flot/jquery.flot.min.js",
        "./assets/libraries/flot/jquery.flot.spline.js",
        "./assets/libraries/owl.carousel/owl.carousel.js",
    ])
     .addStyleEntry('css/vendors',
         './assets/scss/superlist.scss',
         "./assets/libraries/bootstrap-select/bootstrap-select.min.css",
         "./assets/libraries/owl.carousel/assets/owl.carousel.css",
         "./assets/libraries/colorbox/example1/colorbox.css",
         "./assets/libraries/bootstrap-fileinput/fileinput.min.css",
     )

    // uncomment if you use Sass/SCSS files
     .enableSassLoader()

    // uncomment for legacy applications that require $/jQuery as a global variable
     .autoProvidejQuery()



;

module.exports = Encore.getWebpackConfig();
