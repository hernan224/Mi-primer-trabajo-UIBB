var elixir = require('laravel-elixir');
require( 'elixir-jshint' );

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

var src = '../maquetas',
    dest = '../www'

elixir.config.publicPath = dest;
elixir.config.assetsPath = src;
elixir.config.css.sass.folder = 'scss';

elixir(function(mix) {
    // compilacion scss
    mix.sass('estilos.scss')
    //  validacion js
    .jshint( [src+'/js/*.js'] )
    //  concatenacion y copia js
    .scripts(['main.js','app.js'], dest+'/js/main.js')
    .scripts(
        ['vendor/moment.min.js','vendor/moment.locale.es.js','vendor/bootstrap-datetimepicker.min.js',
        'vendor/jquery.bootstrap-touchspin.min.js','form_alumno.js'],
        dest+'/js/form_alumno.js'
    )
    // copio css sueltos
    .copy(src+'/css/vendor', dest+'/css/vendor')
    // copio js sueltos
    // copio img
    .copy(src+'/img', dest+'/img');

    // versionado de js y css (para evitar que use cache si cambian assets)
    // mix.version(['css/estilos.css', 'js/main.js']);
});
