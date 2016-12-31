<?php
namespace handlers\ello;

# getting data from stdin (we can control all parts of the stream)
$request = array();
$input_from_stdin = '';
$file = fopen('php://stdin', 'r');
while($line = fgets($file)) $input_from_stdin .= $line;
fclose($file);
$tmp_request_data = explode($argv[1], $input_from_stdin, 2);
$request['headers'] = json_decode($tmp_request_data[0], true);
$request['body'] = $tmp_request_data[1];

# sending response headers
echo 200, PHP_EOL;
echo 'Content-Type: text/html; charset=utf-8', PHP_EOL;
echo $thaaljs['delimeter'];

# sending response body
echo "ello planet earth!";