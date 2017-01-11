<?php # couchdb with php (using cURL)
namespace handlers\php_couch_ello;
# getting data from stdin (we can control all parts of the stream)
$request_body = file_get_contents('php://stdin');
# sending response headers
echo 200, PHP_EOL;
echo 'Content-Type: text/html; charset=utf-8', PHP_EOL;
echo $thaaljs['delimeter'];

# all further prints would be the response body
## properties
$couchdb = [
  'address' => 'http://localhost:5984',
  'db' => 'movies'
];

## checking if the couchdb is running
$channel = curl_init();
curl_setopt($channel, CURLOPT_URL, $couchdb['address']);
curl_setopt($channel, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($channel);
curl_close($channel);
$status = json_decode($response, true);
if(is_null($status)){ # couchdb is not running
  echo 'CouchDB is not running.';
  exit(1);
}

## getting a list of available databases
$command = '/_all_dbs'; # this gives us the list of all the DBs
$channel = curl_init();
curl_setopt($channel, CURLOPT_URL, $couchdb['address'].$command);
curl_setopt($channel, CURLOPT_RETURNTRANSFER, true);
$databases = curl_exec($channel);
curl_close($channel);
$databases = json_decode($databases, true); # converting to array
if(is_null($databases)){ # we have our result set
  echo 'Some problem occurred while retrieving the list of databases';
  exit(1);
}

## creating our database if it does not exist
if(!in_array($couchdb['db'], $databases)){ # we don't have our database, lets create it
  $command = '/'.$couchdb['db']; # this will be the name of our database
  $channel = curl_init();
  curl_setopt($channel, CURLOPT_URL, $couchdb['address'].$command);
  curl_setopt($channel, CURLOPT_CUSTOMREQUEST, 'PUT'); # it has to be a 'PUT' request to create the database
  curl_setopt($channel, CURLOPT_RETURNTRANSFER, true);
  $db_creation_status = curl_exec($channel);
  curl_close($channel);
  $db_creation_status = json_decode($db_creation_status, true); # converting to array
  if(!isset($db_creation_status['ok']) || $db_creation_status['ok'] !== true){ # db could not be created
    echo 'Some problem occurred while creating the database';
    exit(1);
  }
}

## lets be double sure that our database exists (lets retry creating our database, it should probably return an error)
$command = '/'.$couchdb['db']; # this will be the name of our database
$channel = curl_init();
curl_setopt($channel, CURLOPT_URL, $couchdb['address'].$command);
curl_setopt($channel, CURLOPT_CUSTOMREQUEST, 'PUT'); # it has to be a 'PUT' request to create the database
curl_setopt($channel, CURLOPT_RETURNTRANSFER, true);
$db_recreation_status = curl_exec($channel);
curl_close($channel);
$db_recreation_status = json_decode($db_recreation_status, true); # converting to array
if(!isset($db_recreation_status['error']) || $db_recreation_status['error'] != 'file_exists'){ # database with this name already exists
  echo 'Looks like the database does not exist';
  exit(1);
}

## code for deletion of database
/*$command = '/'.$couchdb['db']; # this will be the name of our database
$channel = curl_init();
curl_setopt($channel, CURLOPT_URL, $couchdb['address'].$command);
curl_setopt($channel, CURLOPT_CUSTOMREQUEST, 'DELETE'); # it has to be a 'DELETE' request to delete the database
curl_setopt($channel, CURLOPT_RETURNTRANSFER, true);
$db_deletion_status = curl_exec($channel);
curl_close($channel);
if(!isset($db_deletion_status['ok']) || $db_deletion_status['ok'] !== true){ # for some reason db could not be deleted
  echo 'Some problem occurred while deleting the database';
  print_r($db_deletion_status);
  exit(1);
}*/

## past this point, we can be assured that our database exists, so lets create our json document record
// code goes here
