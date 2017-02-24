<?php # couchdb with php (using cURL)
namespace handlers\php_couch_ello;
# getting data from stdin (we can control all parts of the stream)
$request_body = file_get_contents('php://stdin');
# sending response headers
echo 200, PHP_EOL;
echo 'Content-Type: text/html; charset=utf-8', PHP_EOL;
echo $thaaljs['delimeter'];
$thaaljs['headers_sent'] = true;

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
/*$command = '/_all_dbs'; # this gives us the list of all the DBs
$channel = curl_init();
curl_setopt($channel, CURLOPT_URL, $couchdb['address'].$command);
curl_setopt($channel, CURLOPT_RETURNTRANSFER, true);
$databases = curl_exec($channel);
curl_close($channel);
$databases = json_decode($databases, true); # converting to array
if(is_null($databases)){ # we have our result set
  echo 'Some problem occurred while retrieving the list of databases';
  exit(1);
}*/

## creating our database if it does not exist
/*if(!in_array($couchdb['db'], $databases)){ # we don't have our database, lets create it
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
}*/

## lets be double sure that our database exists (lets retry creating our database, it should probably return an error)
/*$command = '/'.$couchdb['db']; # this will be the name of our database
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
}*/

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
### lets ask couchdb for a UUID for our new record (it is gurranted to get a unique id everytime)
/*$command = '/'.'_uuids'; # this is the command to get unique id from couchdb
$channel = curl_init();
curl_setopt($channel, CURLOPT_URL, $couchdb['address'].$command);
curl_setopt($channel, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($channel, CURLOPT_RETURNTRANSFER, true);
$uuid_for_document_creation = curl_exec($channel);
curl_close($channel);
$uuid_for_document_creation = json_decode($uuid_for_document_creation, true); # converting to array*/
# now lets create a sample document
/*$document_name = 'sholay';
$document_data = json_encode([ # this is the document that we are going to create
  'actors' => [
    'Jai',
    'Veeru',
    'Basanti',
    'Jaya',
    'Jailer',
    'Gabbar Singh',
    'Thaakur',
    'Ramu Kaka'
  ]
]);
# lets insert this document in our db
$command = '/'.$couchdb['db'].'/'.$document_name;
$channel = curl_init();
curl_setopt($channel, CURLOPT_URL, $couchdb['address'].$command);
curl_setopt($channel, CURLOPT_CUSTOMREQUEST, 'PUT');
curl_setopt($channel, CURLOPT_POSTFIELDS, $document_data);
curl_setopt($channel, CURLOPT_RETURNTRANSFER, true);
$document_creation_status = curl_exec($channel);
curl_close($channel);
$document_creation_status = json_decode($document_creation_status, true);
if(isset($document_creation_status['ok']) && $document_creation_status['ok'] === true){ # document successfully created
  # all good
}else{ # some error occurred
  echo 'Some problem occurred while creating the document';
  print_r($document_creation_status);
  exit(1);
}*/

## now getting our created document
$document_name = 'sholay';
$command = '/'.$couchdb['db'].'/'.$document_name;
$channel = curl_init();
curl_setopt($channel, CURLOPT_URL, $couchdb['address'].$command);
curl_setopt($channel, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($channel, CURLOPT_RETURNTRANSFER, true);
$document_read_status = curl_exec($channel);
curl_close($channel);
$document_read_status = json_decode($document_read_status, true);
if(isset($document_read_status['_id']) && isset($document_read_status['_rev'])){ # document successfully read
  echo '<pre>', json_encode($document_read_status, JSON_PRETTY_PRINT), '</pre>';
}else{ # some error occurred
  echo 'Some problem occurred while reading the document';
  print_r($document_read_status);
  exit(1);
}

## lets update our existing document
/*$document_data = json_encode([ # this is the document that we are going to create
  '_rev' => $document_read_status['_rev'], # this is a required field when updating
  'actors' => [
    'Jai',
    'Veeru',
    'Basanti',
    'Jaya',
    'Jailer',
    'Gabbar Singh',
    'Thaakur',
    'Ramu Kaka',
    'Haath' # this is the new entry
  ]
]);
$command = '/'.$couchdb['db'].'/'.$document_name;
$channel = curl_init();
curl_setopt($channel, CURLOPT_URL, $couchdb['address'].$command);
curl_setopt($channel, CURLOPT_CUSTOMREQUEST, 'PUT');
curl_setopt($channel, CURLOPT_POSTFIELDS, $document_data);
curl_setopt($channel, CURLOPT_RETURNTRANSFER, true);
$document_creation_status = curl_exec($channel);
curl_close($channel);
$document_updation_status = json_decode($document_creation_status, true);
if(isset($document_updation_status['ok']) && $document_updation_status['ok'] === true){ # document successfully updated
  # all good
}else{ # some error occurred
  echo 'Some problem occurred while updating the document';
  print_r($document_updation_status);
  exit(1);
}*/

## now getting our created document to see if our changes show up
/*$document_name = 'sholay';
$command = '/'.$couchdb['db'].'/'.$document_name;
$channel = curl_init();
curl_setopt($channel, CURLOPT_URL, $couchdb['address'].$command);
curl_setopt($channel, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($channel, CURLOPT_RETURNTRANSFER, true);
$document_reread_status = curl_exec($channel);
curl_close($channel);
$document_reread_status = json_decode($document_reread_status, true);
if(isset($document_reread_status['_id']) && isset($document_reread_status['_rev'])){ # document successfully read
  echo '<pre>', json_encode($document_reread_status, JSON_PRETTY_PRINT), '</pre>';
}else{ # some error occurred
  echo 'Some problem occurred while reading the document';
  print_r($document_reread_status);
  exit(1);
}*/

## now lets try deleting our document
/*$command = '/'.$couchdb['db'].'/'.$document_name.'?rev='.$document_reread_status['_rev'];
$channel = curl_init();
curl_setopt($channel, CURLOPT_URL, $couchdb['address'].$command);
curl_setopt($channel, CURLOPT_CUSTOMREQUEST, 'DELETE');
curl_setopt($channel, CURLOPT_RETURNTRANSFER, true);
$document_deletion_status = curl_exec($channel);
curl_close($channel);
$document_deletion_status = json_decode($document_deletion_status, true);
if(isset($document_deletion_status['ok']) && $document_deletion_status['ok'] === true){ # document successfully deleted
  echo 'Document successfully deleted.';
  print_r($document_deletion_status);
}else{ # some error occurred
  echo 'Some problem occurred while deleting the document';
  print_r($document_deletion_status);
  exit(1);
}*/

## lets add sholay poster to our document
/*$cover_file_path = '/home/pranav/Desktop/sholay.jpg';
$command = '/'.$couchdb['db'].'/'.$document_name.'/'.pathinfo($cover_file_path)['basename'].'?rev='.$document_read_status['_rev'];
$channel = curl_init();
curl_setopt($channel, CURLOPT_URL, $couchdb['address'].$command);
curl_setopt($channel, CURLOPT_CUSTOMREQUEST, 'PUT');
curl_setopt($channel, CURLOPT_HTTPHEADER, array('Content-Type: '.trim(explode(' ', shell_exec('file -bi '.$cover_file_path))[0])));
curl_setopt($channel, CURLOPT_POSTFIELDS, file_get_contents($cover_file_path));
curl_setopt($channel, CURLOPT_RETURNTRANSFER, true);
$document_updation_status = curl_exec($channel);
curl_close($channel);
$document_updation_status = json_decode($document_updation_status, true);
if(isset($document_updation_status['ok']) && $document_updation_status['ok'] === true){ # document successfully updated
  echo 'Mission accomplshed.<br />';
  print_r($document_updation_status);
}else{ # some error occurred
  echo 'Some problem occurred while attaching our cover';
  print_r($document_updation_status);
}*/
