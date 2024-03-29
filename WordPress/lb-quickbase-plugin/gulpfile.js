// Load Gulp...of course
var gulp         = require( 'gulp' );

// CSS related plugins
var sass         = require( 'gulp-sass' )(require('sass'));
var autoprefixer = require( 'gulp-autoprefixer' );
var minifycss    = require( 'gulp-uglifycss' );

// JS related plugins
var concat       = require( 'gulp-concat' );
var uglify       = require( 'gulp-uglify' );
var babelify     = require( 'babelify' );
var browserify   = require( 'browserify' );
var source       = require( 'vinyl-source-stream' );
var buffer       = require( 'vinyl-buffer' );
var stripDebug   = require( 'gulp-strip-debug' );

// Utility plugins
var rename       = require( 'gulp-rename' );
var sourcemaps   = require( 'gulp-sourcemaps' );
var notify       = require( 'gulp-notify' );
var plumber      = require( 'gulp-plumber' );
var options      = require( 'gulp-options' );
var gulpif       = require( 'gulp-if' );

// Browers related plugins
var browserSync  = require( 'browser-sync' ).create();
var reload       = browserSync.reload;

// Project related variables
var projectURL   = 'http://leadballer.local';

var styleSRC     = './src/scss/lb-quickbase.scss';
var styleURL     = './assets/css/';
var mapURL       = './';

var jsSRC        = './src/js/lb-quickbase.js';
var jsURL        = './assets/js/';

var styleWatch   = './src/scss/**/*.scss';
var jsWatch      = './src/js/**/*.js';
var phpWatch     = './**/*.php';

//Tasks
gulp.task( 'browser-sync', function() {
	browserSync.init({
		proxy: projectURL,
		//https: {
		//	key: '/Users/jeremylahners/.valet/Certificates/leadballer.local.key',
		//	cert: '/Users/jeremylahners/.valet/Certificates/leadballer.local.crt'
		//},
		injectChanges: true,
		open: false
	});
});

gulp.task( 'styles', function() {
	gulp.src( styleSRC )
		.pipe( sourcemaps.init() )
		.pipe( sass({
			errLogToConsole: true,
			outputStyle: 'compressed'
		}) )
		.on( 'error', console.error.bind( console ) )
		.pipe( autoprefixer({ browsers: [ 'last 2 versions', '> 5%', 'Firefox ESR' ] }) )
		.pipe( sourcemaps.write( mapURL ) )
		.pipe( gulp.dest( styleURL ) )
		.pipe( browserSync.stream() );
});

gulp.task( 'js', function() {
	return browserify({
		entries: [jsSRC]
	})
	.transform( babelify, { presets: [ 'env' ] } )
	.bundle()
	.pipe( source( 'lb-quickbase.js' ) )
	.pipe( buffer() )
	.pipe( gulpif( options.has( 'production' ), stripDebug() ) )
	.pipe( sourcemaps.init({ loadMaps: true }) )
	.pipe( uglify() )
	.pipe( sourcemaps.write( '.' ) )
	.pipe( gulp.dest( jsURL ) )
	.pipe( browserSync.stream() );
 });

function triggerPlumber( src, url ) {
	return gulp.src( src )
	.pipe( plumber() )
	.pipe( gulp.dest( url ) );
}

 gulp.task( 'default', ['styles', 'js'], function() {
	gulp.src( jsURL + 'lb-quickbase.min.js' )
		.pipe( notify({ message: 'Assets Compiled!' }) );
 });

gulp.task( 'watch', ['default', 'browser-sync'], function() {
	gulp.watch( phpWatch, reload );
	gulp.watch( styleWatch, [ 'styles' ] );
	gulp.watch( jsWatch, [ 'js', reload ] );
	gulp.src( jsURL + 'lb-quickbase.min.js' )
		.pipe( notify({ message: 'Gulp is Watching, Happy Coding!' }) );
 });