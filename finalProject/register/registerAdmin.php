<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
        crossorigin="anonymous">
</head>
<body>
  <div class="container">
    <h3>Admin Registration</h3>
    <form id="registerAdmin" action="registerAdmin.php" method="POST">
      <div class="form-group">
        <label for="userName">Username</label>
        <input type="text" class="form-control" id="userName" name="username" placeholder="User Name">

      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
      </div>
      <button type="submit" class="btn btn-primary">Register</button>
    </form>
    <?php
    require '../vendor/autoload.php';

    if (isset($_POST['password']) && strlen($_POST['password']) > 0 && strlen($_POST['username']) > 0){
      $username = htmlspecialchars($_POST['username']);
      $saltString = '$5$rounds=5000$ChickEvans001968$';
      $logged_pass = crypt($_POST['password'],$saltString);
      $client = new MongoDB\Client("mongodb://localhost:27017");
      $collection = $client->scholars->admins;
      $checkUsername = $collection->findOne(['useruame' => $username]);
      if (!$checkUsername){
        $insertOneResult = $collection->insertOne([
            'username' => $username,
            'password' => $logged_pass
        ]);
        if($insertOneResult->getInsertedCount() > 0){
          echo $username." has been added to the Database";
          echo "You'll be redirected shortly";
          sleep(3);
          header("Location: https://www.mdvy96.club/finalProject/#!/admin");

          die();
        }
      }else{
        echo "Username already taken";
      }

      unset($_POST['password']);
      unset($_POST['username']);

    }


    ?>
  </div>
</body>
</html>
