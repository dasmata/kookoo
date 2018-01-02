let Encore = require('@symfony/webpack-encore');

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
    .addEntry('js/app', './assets/js/app.js')
    .addEntry('js/login', './assets/js/Pages/Login.js')
    .addEntry('js/profile', './assets/js/Pages/Profile.js')
    .addEntry('js/picker', './assets/js/Pages/Picker.js')

    .addStyleEntry('css/main', './assets/scss/main.scss')

    // uncomment if you use Sass/SCSS files
    .enableSassLoader()

    // uncomment for legacy applications that require $/jQuery as a global variable
    // .autoProvidejQuery()
    .enableVueLoader()
;

module.exports = Encore.getWebpackConfig();
