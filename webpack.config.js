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
    // Création d'entrées partagés par plusieurs scripts et pages.
    .createSharedEntry('js/vendors',[
        './assets/js/jquery.js',
        './assets/js/map.js',
        './assets/js/superlist.js'
    ])
     .addStyleEntry('css/vendors', './assets/scss/superlist.scss')

    // uncomment if you use Sass/SCSS files
     .enableSassLoader()

    // uncomment for legacy applications that require $/jQuery as a global variable
     .autoProvidejQuery()



;

module.exports = Encore.getWebpackConfig();
