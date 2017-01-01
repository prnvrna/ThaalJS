<?php
namespace handlers\phpinfo;

# getting data from stdin (we can control all parts of the stream)
$request_body = file_get_contents('php://stdin');

# sending response headers
echo 200, PHP_EOL;
echo 'Content-Type: text/html; charset=utf-8', PHP_EOL;
echo $thaaljs['delimeter'];

# sending response body
echo '<pre>';
phpinfo();
echo '</pre>';