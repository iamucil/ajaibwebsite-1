var elixir = require('laravel-elixir');

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

elixir(function(mix) {
    mix	    	 
	    .styles(['**/*.css'],'public/css/main.css')  
	    .scripts(['libs/**/*.js'],'public/js/vendor.js')
	    .scripts(['angular/**/*.js'],'public/js/main.js')
	    .version([	      
	      'js/vendor.js',
	      'js/main.js',
	      'css/main.css'
	    ]);
});
