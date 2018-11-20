<?php
require '../vendor/autoload.php';

$client = new MongoDB\Client("mongodb://localhost:27017");
$collection = $client->scholars->evans;
$options = ['sort' => ['class' => 1]]; // sort scholars by name
$cursor = $collection->find([], $options);
foreach ($cursor as $student) {
  $out_array[] = array("name"=>$student['name'], "class"=>$student["class"], "room"=>$student["room"], "parkingSpot"=>$student["parkingSpot"]);
}

echo json_encode($out_array);
?>
