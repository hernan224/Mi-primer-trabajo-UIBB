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
    //  validacion js
    mix.jshint( [src+'/js/*.js'] )
    // compilacion scss
    .sass('estilos.scss')
    .sass('print.scss')
    .sass('generar-pdf.scss')
    //  concatenacion y copia js
    //  script principal, incluido en la base (es decir, en todas las paginas)
    .scripts(['main.js'], dest+'/js/main.js')
    // script formulario creacion/edicion
    .scripts(
        ['vendor/moment.min.js','vendor/moment.locale.es.js','vendor/bootstrap-datetimepicker.min.js',
        'vendor/jquery.bootstrap-touchspin.min.js','vendor/jquery.mask.min.js','form_egresado.js'],
        dest+'/js/form_egresado.js'
    )
    // script listado
    .scripts(
        ['vendor/moment.min.js','vendor/handlebars-v4.0.5.js','vendor/jquery.twbsPagination.js',
        'listado_egresados.js'],
        dest+'/js/listado_egresados.js'
    )
    .scripts(
        ['vendor/handlebars-v4.0.5.js','vendor/jquery.twbsPagination.js','listado_publicaciones.js'],
        dest+'/js/listado_publicaciones.js'
    )
    // copio css sueltos
    .copy(src+'/css/vendor', dest+'/css/vendor')
    // copio fonts para PDF
    .copy(src+'/css/fuentes-pdf', dest+'/css/fuentes-pdf')
    // copio js sueltos
    .copy(src+'/js/vendor/tinymce', dest+'/js/vendor/tinymce')
    // copio img
    .copy(src+'/img', dest+'/img');

    // versionado de js y css (para evitar que use cache si cambian assets)
    // mix.version(['css/estilos.css', 'js/main.js']);
});
