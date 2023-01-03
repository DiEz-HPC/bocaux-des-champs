const Encore = require('@symfony/webpack-encore');

// Manually configure the runtime environment if not already configured yet by the "encore" command.
// It's useful when you use tools that rely on webpack.config.js file.
if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    // directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // public path used by the web server to access the output path
    .setPublicPath('/build')
    // only needed for CDN's or sub-directory deploy
    //.setManifestKeyPrefix('build/')

    /*
     * ENTRY CONFIG
     *
     * Each entry will result in one JavaScript file (e.g. app.js)
     * and one CSS file (e.g. app.css) if your JavaScript imports CSS.
     */
    /* STYLES */
    .addStyleEntry('appStyle', './public/theme/bocauxdeschamps/css/style.css')
    .addStyleEntry('actualityStyle', './public/theme/bocauxdeschamps/css/actuality.css')
    .addStyleEntry('actualitySingle', './public/theme/bocauxdeschamps/css/actualitySingle.css')
    .addStyleEntry('contactStyle', './public/theme/bocauxdeschamps/css/contact.css')
    .addStyleEntry('engagementStyle', './public/theme/bocauxdeschamps/css/engagements.css')
    .addStyleEntry('eventStyle', './public/theme/bocauxdeschamps/css/events.css')
    .addStyleEntry('footerStyle', './public/theme/bocauxdeschamps/css/footer.css')
    .addStyleEntry('historyStyle', './public/theme/bocauxdeschamps/css/histoire.css')
    .addStyleEntry('homeStyle', './public/theme/bocauxdeschamps/css/homepage.css')
    .addStyleEntry('picturesStyle', './public/theme/bocauxdeschamps/css/pictures.css')
    .addStyleEntry('productStyle', './public/theme/bocauxdeschamps/css/produits.css')
    .addStyleEntry('variables', './public/theme/bocauxdeschamps/css/variables.css')
    .addStyleEntry('videoStyle', './public/theme/bocauxdeschamps/css/videos.css')
    
    .addStyleEntry('cardEventStyle', './public/theme/bocauxdeschamps/css/componentStyle/cardEvent.css')
    .addStyleEntry('headerStyle', './public/theme/bocauxdeschamps/css/componentStyle/header.css')
    .addStyleEntry('paginationStyle', './public/theme/bocauxdeschamps/css/componentStyle/pagination.css')
    .addStyleEntry('productCardStyle', './public/theme/bocauxdeschamps/css/componentStyle/productCard.css')
    .addStyleEntry('productCardQrStyle', './public/theme/bocauxdeschamps/css/componentStyle/productCardQr.css')
    .addStyleEntry('tagBadgeStyle', './public/theme/bocauxdeschamps/css/componentStyle/tagBadge.css')
    .addStyleEntry('videoCardStyle', './public/theme/bocauxdeschamps/css/componentStyle/videoCard.css')
    .addStyleEntry('videoModalStyle', './public/theme/bocauxdeschamps/css/componentStyle/videoModal.css')
    /* SCRIPT */
    .addEntry('navbar', './public/theme/bocauxdeschamps/js/navbar.js')
    .addEntry('toggleRecipe', './public/theme/bocauxdeschamps/js/toggleRecipe.js')
    .addEntry('youtubePlayer', './public/theme/bocauxdeschamps/js/youtubePlayer.js')
    .addEntry('tagCloud', './public/theme/bocauxdeschamps/js/tagCloud/tagCloud.js')
    // enables the Symfony UX Stimulus bridge (used in assets/bootstrap.js)
   // .enableStimulusBridge('./assets/controllers.json')

    // When enabled, Webpack "splits" your files into smaller pieces for greater optimization.
    .splitEntryChunks()

    // will require an extra script tag for runtime.js
    // but, you probably want this, unless you're building a single-page app
    .enableSingleRuntimeChunk()

    /*
     * FEATURE CONFIG
     *
     * Enable & configure other features below. For a full
     * list of features, see:
     * https://symfony.com/doc/current/frontend.html#adding-more-features
     */
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    // enables hashed filenames (e.g. app.abc123.css)
    .enableVersioning(Encore.isProduction())

    .configureBabel((config) => {
        config.plugins.push('@babel/plugin-proposal-class-properties');
    })

    // enables @babel/preset-env polyfills
    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = 3;
    })

    // enables Sass/SCSS support
    //.enableSassLoader()

    // uncomment if you use TypeScript
    //.enableTypeScriptLoader()

    // uncomment if you use React
    //.enableReactPreset()

    // uncomment to get integrity="..." attributes on your script & link tags
    // requires WebpackEncoreBundle 1.4 or higher
    //.enableIntegrityHashes(Encore.isProduction())

    // uncomment if you're having problems with a jQuery plugin
    //.autoProvidejQuery()
;

module.exports = Encore.getWebpackConfig();