<?php
namespace handlers\dir;

# getting data from stdin (we can control all parts of the stream)
$request_body = file_get_contents('php://stdin');

# sending response headers
echo 200, PHP_EOL;
echo 'Content-Type: text/html; charset=utf-8', PHP_EOL;
echo $thaaljs['delimeter'];

# sending response body (we'll use mustache for this example)
$data = array();
foreach(glob(__dir__.DIRECTORY_SEPARATOR.'*.php') AS $file){
  if($file != __file__) $data[] = array(
    'filename' => pathinfo($file)['basename'],
    'fileurl' => '/'.basename(pathinfo($file)['basename'], '.php')
  );
}
initialize_mustache();
echo $mustache->render(\store\read('template:web2:dir-page'), array(
  'language_code' => $thaaljs['language_code'],
  'meta_charset' => $thaaljs['charset'],
  'cdn_url' => $thaaljs['cdn_url'],
  'data' => $data
));
