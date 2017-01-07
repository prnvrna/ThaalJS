<?php
namespace handlers\ello;

# getting data from stdin (we can control all parts of the stream)
$request_body = file_get_contents('php://stdin');

# sending response headers
echo 200, PHP_EOL;
echo 'Content-Type: text/plain; charset=utf-8', PHP_EOL;
echo $thaaljs['delimeter'];

# sending response body
$handle = popen('/bin/bash', 'w');
fwrite($handle, 'echo $0');
fwrite($handle, "\n");
fwrite($handle, 'bash --version');
pclose($handle);