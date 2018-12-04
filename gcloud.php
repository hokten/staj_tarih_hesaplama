<?php

//date_default_timezone_set('Europe/Istanbul');
   ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

# Includes the autoloader for libraries installed with compose
require __DIR__ . '/vendor/autoload.php';
putenv('GOOGLE_APPLICATION_CREDENTIALS=google.json');

# Imports the Google Cloud client library
use Google\Cloud\Datastore\DatastoreClient;
use Carbon\Carbon;

# Your Google Cloud Platform project ID
$projectId = 'disco-history-206419';

# Instantiates a client
$datastore = new DatastoreClient([

'projectId' => $projectId,
'namespaceId' => 'vt'
]);

# The kind for the new entity
$kind = 'kayitlar';

# The name/ID for the new entity
#$name = 'vt';

$transaction = $datastore->transaction();

$query = $datastore->query()
->kind('kayitlar');
//->filter('ogrencino', '=', 1236)
//->limit(1);

$result = $datastore->runQuery($query);

//var_dump($result->current());

$bastarihi=Carbon::now('UTC');
var_dump($bastarihi);

$bitistarihi=Carbon::createFromFormat('Y-m-d H:i:s', '2017-01-02 00:00:00', 'UTC');
var_dump($bitistarihi);


foreach ($result as $task) {
   $date=$task['baslamatarihi'];
   var_dump($date);
   $date1=$task['bitistarihi'];
   var_dump($date1);



  /*
   $kayit=$transaction->lookup($task->key());
   $kayit['ogrencino'] = 231122312;
   $transaction->update($kayit);
   $transaction->commit();
   */
}

# The Cloud Datastore key for the new entity


$taskKey = $datastore->key('kayitlar');

# Prepares the new entity
$task1 = $datastore->entity($taskKey,  [
'ogrencino' => 125,
'tckimlikno' => 23232,
'stajkodu' => 'xxxxxr',
'baslamatarihi' => $bastarihi,
'bitistarihi' => $bitistarihi
]);

# Saves the entity
$datastore->upsert($task1);

echo 'Saved ' . $task1->key() . ': ' . $task1['ogrencino'] . PHP_EOL;
?>
