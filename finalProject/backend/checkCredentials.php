<?php

require '../vendor/autoload.php';


$client = new MongoDB\Client("mongodb://localhost:27017");
$collection = $client->scholars->admins;

if(isset($_POST['username']) && isset($_POST['password'])){

  $username = htmlspecialchars($_POST['username']);
  $saltString = '$5$rounds=5000$ChickEvans001968$';
  $logged_pass = crypt($_POST['password'],$saltString);
  $checkUsername = $collection->findOne(['username' => $username, 'password' => $logged_pass]);

  if(!$checkUsername){
    echo "false";
  }else{
    echo "true";
  }
}




?>
