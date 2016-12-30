#!/usr/bin/php5

<?php
# getting data from stdin (be sure to apply limit here)
$request = array(
  'headers' => array(),
  'body' => ''
);
## request headers and request body
$input_from_stdin = '';
$file = fopen('php://stdin', 'r');
while($line = fgets($file)) $input_from_stdin .= $line;
fclose($file);
$tmp_request_data = explode($argv[1], $input_from_stdin, 2);
$request['headers'] = json_decode($tmp_request_data[0], true);
$request['body'] = $tmp_request_data[1]; # well, in many cases, this might have to be further broken like in case of form datas (they have their own data separators)

# sending status & headers
echo 200, PHP_EOL;
echo 'Content-Type: text/html; charset=utf-8', PHP_EOL;
echo $argv[1]; # this is it for headers, here comes our delimeter to separate headers from body

# our body
echo '~~~卐~卐~ॐ~卐~卐~~~';