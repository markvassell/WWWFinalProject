<?php

require '../vendor/autoload.php';

$client = new MongoDB\Client("mongodb://localhost:27017");
$collection = $client->scholars->evans;

$deleteResult = $collection->deleteOne(['name' => $_POST['name'], 'parkingSpot' => $_POST['spot']]);

if ($deleteResult->getDeletedCount() == 1) {
  echo $_POST['name']. " has been deleted!";
} else{
  echo "No one was deleted";
}
?>
