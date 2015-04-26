<?php defined('SYSPATH') or die('No direct script access.');

// -- Environment setup --------------------------------------------------------

// Load the core Kohana class
require SYSPATH.'classes/kohana/core'.EXT;

if (is_file(APPPATH.'classes/kohana'.EXT))
{
	// Application extends the core
	require APPPATH.'classes/kohana'.EXT;
}
else
{
	// Load empty core extension
	require SYSPATH.'classes/kohana'.EXT;
}




/**
 * Set the default time zone.
 *
 * @link http://kohanaframework.org/guide/using.configuration
 * @link http://www.php.net/manual/timezones
 */
date_default_timezone_set('America/Mexico_City');

/**
 * Set the default locale.
 *
 * @link http://kohanaframework.org/guide/using.configuration
 * @link http://www.php.net/manual/function.setlocale
 */
setlocale(LC_ALL, 'es_ES.utf-8');

/**
 * Enable the Kohana auto-loader.
 *
 * @link http://kohanaframework.org/guide/using.autoloading
 * @link http://www.php.net/manual/function.spl-autoload-register
 */
spl_autoload_register(array('Kohana', 'auto_load'));

/**
 * Enable the Kohana auto-loader for unserialization.
 *
 * @link http://www.php.net/manual/function.spl-autoload-call
 * @link http://www.php.net/manual/var.configuration#unserialize-callback-func
 */
ini_set('unserialize_callback_func', 'spl_autoload_call');

// -- Configuration and initialization -----------------------------------------

/**
 * Set the default language
 */
I18n::lang('es-mx');

/**
 * Set Kohana::$environment if a 'KOHANA_ENV' environment variable has been supplied.
 *
 * Note: If you supply an invalid environment name, a PHP warning will be thrown
 * saying "Couldn't find constant Kohana::<INVALID_ENV_NAME>"
 */
switch ($_SERVER['SERVER_NAME'])
{
    case 'new.amanc.org':
		Kohana::$environment = Kohana::PRODUCTION;
		break;
	case 'amanc.myfusionspace.net':
		Kohana::$environment = Kohana::STAGING;
		break;
	default:
		Kohana::$environment = Kohana::DEVELOPMENT;
		break;
}
		//Kohana::$environment = Kohana::DEVELOPMENT;

//Kohana::$environment = Kohana::DEVELOPMENT;

/**
 * Initialize Kohana, setting the default options.
 *
 * The following options are available:
 *
 * - string   base_url    path, and optionally domain, of your application   NULL
 * - string   index_file  name of your index file, usually "index.php"       index.php
 * - string   charset     internal character set used for input and output   utf-8
 * - string   cache_dir   set the internal cache directory                   APPPATH/cache
 * - integer  cache_life  lifetime, in seconds, of items cached              60
 * - boolean  errors      enable or disable error handling                   TRUE
 * - boolean  profile     enable or disable internal profiling               TRUE
 * - boolean  caching     enable or disable internal caching                 FALSE
 * - boolean  expose      set the X-Powered-By header                        FALSE
 */
Kohana::init(array(
	'base_url'   => '/',
	'index_file' => FALSE,
	'errors'     => TRUE,
	'profile'    => FALSE,
));


/**
 * Attach the file write to logging. Multiple writers are supported.
 */
Kohana::$log->attach(new Log_File(APPPATH.'logs'));

/**
 * Attach a file reader to config. Multiple readers are supported.
 */
Kohana::$config->attach(new Config_File);

/**
 * Enable modules. Modules are referenced by a relative or absolute path.
 */
Kohana::modules(array(
	'auth'       => MODPATH.'auth',       // Basic authentication
	// 'cache'      => MODPATH.'cache',      // Caching with multiple backends
	// 'codebench'  => MODPATH.'codebench',  // Benchmarking tool
	'database'   => MODPATH.'database',   // Database access
	'contento'   => MODPATH.'contento',   // Contento modules: Auth, Pagination, etc
	'image'      => MODPATH.'image',      // Image manipulation
	// 'orm'        => MODPATH.'orm',        // Object Relationship Mapping
	// 'unittest'   => MODPATH.'unittest',   // Unit testing
	// 'userguide'  => MODPATH.'userguide',  // User guide and API documentation
	));

/**
 * Set the cookie salt.
 */
Cookie::$salt     = 'caDruYUFrAWr6neBr5*PaWe$';
Cookie::$httponly = TRUE;

/**
 * Set the routes. Each route must have a minimum of a name, a URI and a set of
 * defaults for the URI.
 */
 
Route::set('backend', array('Controller_Backend_Template', 'route'));

Route::set('homepage', '(index(/<action>))', array('action' => '[a-z0-9\-]+'))
	->defaults(array(
		'directory'  => 'frontend',
		'controller' => 'homepage',
	));
	
//News details
Route::set('news_detils', '(noticias/<id_news>/<slug>)', array('slug' => '[a-z0-9\-]+', 'id_news' => '[0-9\-]+'))
->defaults(array(
	'directory'  => 'frontend',
	'controller' => 'news',
	'action' => 'details',
));	

Route::set('registro', 'registro')
	->defaults(array(
		'directory'  => 'frontend',
		'controller' => 'homepage',
		'action'     => 'register',
	));
	
Route::set('registrofin', 'registrofin')
	->defaults(array(
		'directory'  => 'frontend',
		'controller' => 'homepage',
		'action'     => 'registerend',
	));	

Route::set('privadologin', 'privado/login')
	->defaults(array(
		'directory'  => 'frontend',
		'controller' => 'privado',
		'action' => 'login',
	));
	
Route::set('privadologout', 'privado/logout')
	->defaults(array(
		'directory'  => 'frontend',
		'controller' => 'privado',
		'action' => 'logout',
	));
	
Route::set('vencido', 'vencido')
	->defaults(array(
		'directory'  => 'frontend',
		'controller' => 'homepage',
		'action'     => 'vencido',
	));
	
Route::set('noactivo', 'noactivo')
	->defaults(array(
		'directory'  => 'frontend',
		'controller' => 'homepage',
		'action'     => 'noactivo',
	));
	
Route::set('perfil', 'privado/profile')
	->defaults(array(
		'directory'  => 'frontend',
		'controller' => 'privado',
		'action'     => 'profile',
	));
	
Route::set('editperfil', 'privado/editprofile')
	->defaults(array(
		'directory'  => 'frontend',
		'controller' => 'privado',
		'action'     => 'editprofile',
	));
	
Route::set('editprofilefin', 'editprofilefin')
	->defaults(array(
		'directory'  => 'frontend',
		'controller' => 'privado',
		'action'     => 'editprofilefin',
	));	

// Voluntariado------------------------------------
	Route::set('voluntario_registro', 'voluntarios/registro')
	->defaults(array(
		'directory'  => 'frontend',
		'controller' => 'voluntario',
		'action' => 'voluntario_registro',
	));

// Fin Voluntariado------------------------------------


// Actividades ------------------------------------
	//Ultimas actividades
	Route::set('ultimas_actividades', '(actividades)')
	->defaults(array(
		'directory'  => 'frontend',
		'controller' => 'actividades',
		'action' => 'por_estado',
	));
	//Detalle de actividad
	Route::set('detalle_actividad', '(actividades/detalle/<id_actividad>)', array('id_actividad' => '[0-9\-]+'))
	->defaults(array(
		'directory'  => 'frontend',
		'controller' => 'actividades',
		'action' => 'detalle',
	));
	//Actividades por estado
	Route::set('actividades_por_estado', '(actividades/estado/<slug>)', array('slug' => '[a-z0-9\-]+'))
	->defaults(array(
		'directory'  => 'frontend',
		'controller' => 'actividades',
		'action' => 'por_estado',
	));
	//Actividades por tag
	Route::set('actividades_por_tag', '(actividades/tag/<id_tag>)', array('id_tag' => '[0-9\-]+'))
	->defaults(array(
		'directory'  => 'frontend',
		'controller' => 'actividades',
		'action' => 'por_tag',
	));
// Fin Actividades ------------------------------------



// AJAX ------------------------------------
	
	Route::set('voluntario_guardar', 'save_volunteer')
	->defaults(array(
		'directory'  => 'frontend',
		'controller' => 'ajax',
		'action' => 'save_volunteer',
	));
// Fin AJAX ------------------------------------
	

Route::set('contacto', 'contacto')
	->defaults(array(
		'directory'  => 'frontend',
		'controller' => 'homepage',
		'action' => 'contact',
	));


Route::set('api', 'api/<action>')
	->defaults(array(
		'directory'  => '',
		'controller' => 'api',
		'action'     => 'index'
	));

Route::set('content', '<section>(/<page>(/<subpage>))', array('section' => '[a-z0-9\-]+', 'page' => '[a-z0-9\-]+', 'subpage' => '[a-z0-9\-]+'))
	->defaults(array(
		'directory'  => 'frontend',
		'controller' => 'homepage',
		'action'     => 'content'
	));


/*
Route::set('error', 'error/<action>(/<message>)', array('action' => '[0-9]++', 'message' => '.+'))
	->defaults(array(
		'controller' => 'error_handler'
	));
*/

/**
* Set the custom exception handler
*/
//set_exception_handler(array('Kohana_Exception', 'handler'));
