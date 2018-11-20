<?php
require '../vendor/autoload.php';

$client = new MongoDB\Client("mongodb://localhost:27017");
$collection = $client->scholars->evans;

if(isset($_POST)){
  //print_r ($_POST);
  $insetResult = $collection->insertOne(
    [
      'name' => $_POST['name'],
      'class' => $_POST['class'],
      'room' => $_POST['room'],
      'parkingSpot' => $_POST['parkingSpot']
    ]
  );

  echo $_POST['name'];

}else{
  echo "Ntn happened";
}



?>
