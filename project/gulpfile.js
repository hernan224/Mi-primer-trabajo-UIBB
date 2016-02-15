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
    //  concatenacion y copia js
    //  script principal, incluido en la base (es decir, en todas las paginas)
    .scripts(['main.js'], dest+'/js/main.js')
    // script formulario creacion/edicion
    .scripts(
        ['vendor/moment.min.js','vendor/moment.locale.es.js','vendor/bootstrap-datetimepicker.min.js',
        'vendor/jquery.bootstrap-touchspin.min.js','form_alumno.js'],
        dest+'/js/form_alumno.js'
    )
    // script listado
    .scripts(
        ['vendor/moment.min.js','vendor/handlebars-v4.0.5.js','vendor/jquery.twbsPagination.js',
        'listado_alumnos.js'],
        dest+'/js/listado_alumnos.js'
    )
    // copio css sueltos
    .copy(src+'/css/vendor', dest+'/css/vendor')
    // copio js sueltos
    // copio img
    .copy(src+'/img', dest+'/img');

    // versionado de js y css (para evitar que use cache si cambian assets)
    // mix.version(['css/estilos.css', 'js/main.js']);
});
