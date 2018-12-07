<?php

//date_default_timezone_set('Europe/Istanbul');
   ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

# Includes the autoloader for libraries installed with compose
require __DIR__ . '/vendor/autoload.php';
putenv('GOOGLE_APPLICATION_CREDENTIALS=google.json');
use Google\Cloud\Firestore\FirestoreClient;

    // Create the Cloud Firestore client
    $db = new FirestoreClient();
    printf('Created Cloud Firestore client with default project ID.' . PHP_EOL);

    $docRef = $db->collection('stajlarkoleksiyonu')->document('981010_EDE101');
    $snapshot = $docRef->snapshot();
    if ($snapshot->exists()) {
        printf('Document data:' . PHP_EOL);
        print_r($snapshot->data());
    } else {
        printf('Document %s does not exist!' . PHP_EOL, $snapshot->id());
    }
?>
