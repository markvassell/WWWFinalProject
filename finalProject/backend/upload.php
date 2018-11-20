<?php

  if(isset($_POST["submit"]) && !empty($_FILES["fileUpload"]["name"])){
    $filename = basename($_FILES["fileUpload"]["name"]);
    $fileFolder = "../files/";
    $filePath = $fileFolder.$filename;
    $fileType = pathinfo($filePath,PATHINFO_EXTENSION);
    echo $_FILES["fileUpload"]["tmp_name"];
    if(move_uploaded_file($_FILES["fileUpload"]["tmp_name"], $filePath)){
      header("Location: https://www.mdvy96.club/finalProject/#!/viewFiles");
      die();
    }
  }else{
    echo "File upload failed";
  }
?>
