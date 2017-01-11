#!/usr/bin/php5

<?php
# getting data from stdin (be sure to apply limit here)
$thaaljs = array(
	'delimeter' => $argv[1],
	'url' => $argv[2],
	'method' => $argv[3],
	'headers' => json_decode($argv[4], true),
	'basepath' => dirname(getcwd().substr($argv[0], 1)),
	'language_code' => 'en',
	'charset' => 'utf-8',
	'cdn_url' => '//cdn.thaaljs.dev/thaaljs.php.dev/'
);
# errors/exceptions handling
function catchall_exceptions($exception){
	global $thaaljs;
	try{
		echo 500, PHP_EOL;
		echo 'Content-Type: text/html; charset=utf-8', PHP_EOL;
		echo $thaaljs['delimeter'];
		echo '<pre>', print_r($exception, true), '</pre>';
	}catch(Exception $ex){
		exit(1); # if still an error occurs, we just bail
	}
}
set_exception_handler('catchall_exceptions');
set_error_handler(function($error_number, $error_string, $error_file, $error_line){
	throw new ErrorException($error_string, 0, $error_number, $error_file, $error_line);
}, E_ALL);

# including store library
require_once $thaaljs['basepath'].DIRECTORY_SEPARATOR.'store'.DIRECTORY_SEPARATOR.'main.php';

# mustache engine initializer
$mustache = null;
function initialize_mustache(){
	global $mustache, $thaaljs;
	require_once $thaaljs['basepath'].DIRECTORY_SEPARATOR.'library'.DIRECTORY_SEPARATOR.'third-party'.DIRECTORY_SEPARATOR.'mustache.php'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Mustache'.DIRECTORY_SEPARATOR.'Autoloader.php';
	Mustache_Autoloader::register();
	$mustache = new Mustache_Engine;
}

# passing request to the applicable handler
$handler = str_replace(array('/', '\\'), '-', $thaaljs['url']);
if(strpos($handler, '?') !== false) $handler = explode('?', $handler)[0];
if(substr($handler, 0, 1) == '-') $handler = substr($handler, 1);
if(substr($handler, -1) == '-') $handler = substr($handler, 0, -1);
$handler = $thaaljs['basepath'].DIRECTORY_SEPARATOR.'handlers'.DIRECTORY_SEPARATOR.$handler.'.php';
if(is_file($handler)) require_once $handler;
else throw new Exception('Handler does not exist.');
