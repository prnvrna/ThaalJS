#!/usr/bin/php5

<?php
# getting data from stdin (be sure to apply limit here)
$thaaljs = call_user_func(function(){
	global $argv;
	$to_return = array(
		'delimeter' => $argv[1],
		'url' => $argv[2],
		'current_directory_path' => dirname(getcwd().substr($argv[0], 1))
	);
	return $to_return;
});
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

# passing request to the applicable handler
$handler = str_replace(array('/', '\\'), '-', $thaaljs['url']);
if(strpos($handler, '?') !== false) $handler = explode('?', $handler)[0];
if(substr($handler, 0, 1) == '-') $handler = substr($handler, 1);
if(substr($handler, -1) == '-') $handler = substr($handler, 0, -1);
$handler = $thaaljs['current_directory_path'].DIRECTORY_SEPARATOR.'handlers'.DIRECTORY_SEPARATOR.$handler.'.php';
if(is_file($handler)) require_once $handler;
else throw new Exception('Handler does not exist.');