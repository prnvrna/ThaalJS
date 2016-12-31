#!/usr/bin/php5

<?php
# getting data from stdin (be sure to apply limit here)
$thaaljs = call_user_func(function(){
	global $argv;
	$to_return = array(
		'headers' => array(),
		'body' => '',
		'delimeter' => $argv[1],
		'current_directory_path' => dirname(getcwd().substr($argv[0], 1))
	);
	# setting request headers and request body
	$input_from_stdin = '';
	$file = fopen('php://stdin', 'r');
	while($line = fgets($file)) $input_from_stdin .= $line;
	fclose($file);
	$tmp_request_data = explode($argv[1], $input_from_stdin, 2);
	$to_return['headers'] = json_decode($tmp_request_data[0], true);
	$to_return['body'] = $tmp_request_data[1]; # well, in many cases, this might have to be further broken like in case of form datas (they have their own data separators)
	return $to_return;
});
# errors/exceptions handling
function catchall_exceptions($exception){
	global $thaaljs;
	try{
		echo 500, PHP_EOL;
		echo 'Content-Type: text/html; charset=utf-8', PHP_EOL;
		echo $thaaljs['delimeter']; # this is it for headers, here comes our delimeter to separate headers from body
		echo $exception->getMessage();
	}catch(Exception $ex){
		exit(1); # if still an error occurs, we just bail
	}
}
set_exception_handler('catchall_exceptions');
set_error_handler(function($error_number, $error_string, $error_file, $error_line){
	throw new ErrorException($error_string, 0, $error_number, $error_file, $error_line);
}, E_ALL);

# passing request to the applicable handler
$handler = str_replace(array('/', '\\'), '-', $thaaljs['headers']['request-url']);
if(substr($handler, 0, 1) == '-') $handler = substr($handler, 1);
if(substr($handler, -1) == '-') $handler = substr($handler, 0, -1);
$handler = $thaaljs['current_directory_path'].DIRECTORY_SEPARATOR.'handlers'.DIRECTORY_SEPARATOR.$handler.'.php';
if(is_file($handler)) require_once $handler;
else throw new Exception('Handler does not exist.');