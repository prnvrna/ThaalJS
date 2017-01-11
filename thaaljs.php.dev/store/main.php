<?php
namespace store;

class properties{
	public static $store_directory_path;

	public function __construct(){
		# set dynamic values
		self::$store_directory_path = __dir__.'/data/';
	}
}new properties();

function read($key_phrase_file){ # in the format: here:goes:the:file:name
	$file_path_becomes = properties::$store_directory_path.$key_phrase_file;

	if(is_file($file_path_becomes)) return file_get_contents($file_path_becomes);
	else throw new \Exception('store.file.dont.exist');
}

function write($key_phrase_file, $data_to_write){
	$fp = fopen(properties::$store_directory_path.$key_phrase_file, 'w');

	start_writing:
	if(flock($fp, \LOCK_EX)){
		fwrite($fp, $data_to_write);
		flock($fp, \LOCK_UN);
	}else goto start_writing; # keep on trying unless the lock cannot be acquired

	fclose($fp);
}

function delete($key_phrase_file){
	return !unlink(properties::$store_directory_path.$key_phrase_file) ? false : true; # required permissions must have been set for deletion to take place
}