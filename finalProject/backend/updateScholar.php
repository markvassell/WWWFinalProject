<?php
require 'vendor/autoload.php';

$client = new MongoDB\Client("mongodb://localhost:27017");
$collection = $client->scholars->evans;

if(isset($_POST)){
  //print_r($_POST);
  $filter = [
      'name' => $_POST['currentName'],
      'class' => $_POST['currentClass'],
      'room' => $_POST['currentRoom'],
      'parkingSpot' => $_POST['currentParkingSpot']
    ];
  $parmas = [
    'name' => $_POST['updatedName'],
    'class' => $_POST['updatedClass'],
    'room' => $_POST['updatedRoom'],
    'parkingSpot' => $_POST['updatedParkingSpot']

  ];
  echo json_encode($filter);
  echo json_encode($parmas);
  $updateResult = $collection->replaceOne($filter,$parmas);


  if($updateResult->getModifiedCount() == 0){
    echo "No updates were made";
  }else{

  }
  //print_r($_POST);

}


?>
