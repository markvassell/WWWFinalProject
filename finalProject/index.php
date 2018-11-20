<?php
  require 'vendor/autoload.php';
  $client = new MongoDB\Client("mongodb://localhost:27017");

  session_start();

?>
<!DOCTYPE html>
<html>
  <head>
    <title>Evans Scholars: Home</title>
    <!-- Angular js -->
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/lodash@4.17.11/lodash.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
          crossorigin="anonymous">
    <script
        src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular-route.js"></script>
  </head>

  <body ng-app="finalProject" ng-controller="addStudents">
    <!-- <div class="container"> -->
      <div class="row">
        <div class="col-md-8 offset-md-2">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link my_click" ng-class="{active: location === '/'}" id="home" href="#!home">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link my_click" ng-class="{active: location === '/newScholar'}" id="challenges"  href="#!newScholar">Add Scholars</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link my_click" ng-class="{active: location === '/viewScholars'}" id="explorations" href="#!viewScholars">View Scholars</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link my_click" ng-class="{active: location === '/uploadFile'}" id="fileUpload"  href="#!uploadFile">Upload Documents</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link my_click" ng-class="{active: location === '/viewFiles'}" id="viewFiles"  href="#!viewFiles">View Files</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link my_click" ng-class="{active: location === '/admin'}" id="lectures"  href="#!admin">Admin</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link my_click"  id="lectures" ng-click="logout()" href="#">Logout</a>
                </li>



            </ul>
            <div class="alert alert-success" role="alert" ng-if="logged_in" class="animate-if">
              <p>Logged in as: {{logged_in_user}}</p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 offset-md-2" ng-view></div>
    </div>

  <!-- </div> -->
    <script>
      var app = angular.module('finalProject', ["ngRoute"]);
      // Handle the rounting when a new route is clicked.
      app.config(($routeProvider) => {
          $routeProvider
          .when("/newScholar", {
              templateUrl : "templates/addScholars.php",
              controller : "addStudents",
              title : "Add Scholar"
          })
          .when("/viewScholars",{
            templateUrl : "templates/viewScholar.php",
            controller : "viewScholarsCtrl"
          })
          .when("/admin",{
            templateUrl : "templates/adminLogin.php"
          })
          .when("/uploadFile",{
            templateUrl : "templates/uploadFile.php",
          })
          .when("/viewFiles", {
            templateUrl : "templates/viewFiles.php"
          })
          .otherwise({
              templateUrl : "templates/home.php",
              controller : "homeCtrl"
          });
      });
      app.controller('addStudents', function ($scope, $rootScope, $http, $location){
        $scope.location = $location.path();

        $scope.logged_in = false;
        $scope.logged_in_user = "None";

        $scope.logout = () => {
          $scope.logged_in = false;
          $scope.logged_in_user = "None";
        }
        $rootScope.$on('$routeChangeSuccess', function() {
          // Sets the page's title based on the current route
          $scope.location = $location.path();
          if($scope.location == "/home"){
            document.title = "Evans Scholars: Home";
          }else if($scope.location == "/viewScholars"){
            document.title = "Evans Scholars: View Scholars";
          }else if($scope.location == "/newScholar"){
            document.title = "Evans Scholars: Add Scholar";
          }else if($scope.location == "/admin"){
            document.title = "Evans Scholars: Admin Login";
          }else if ($scope.location == "/uploadFile") {
            document.title = "Evans Scholars: File Upload";
          }else if ($scope.location == "/viewFiles") {
            document.title = "Evans Scholars: View Files";
          }

        });

        $( "#myAlert" ).hide();
        $scope.currentScholars = [];
        $scope.classOptions = ["Freshman", "Sophmore", "Junior", "Senior", "Super Senior","Graduate Resident Advisor", "Alumnus", "Alumnae"];
        $scope.rooms = [];
        $scope.parkingSpots = [];

        // Check to make sure that the user doesn't input a null value or a value with only spaces.
        $scope.validateInput = (info) =>{
          if(!info || !info.replace(/\s/g, '').length){
            return -1;
          }
          return 0;
        }

        // Populate the array that holds the room numbers.
        $scope.initRooms = (numRooms) => {
          for (i = 1; i <= numRooms; i++) {
            $scope.rooms.push(i);
            if (i == 13){
              $scope.rooms.push("Chapter");
            }
          }
        };
        $scope.initParking = (numSpots, scholars) => {
          var usedRooms = [];
          for (var j = 0; j < scholars.length; j++){
            usedRooms.push(scholars[j].parkingSpot);
          }

          for (i = 1; i <= numSpots; i++) {
            // If the parking spot number is not used show it as available
            if(_.includes(usedRooms, i.toString()) == false) {
              $scope.parkingSpots.push(i);
            }
          }
        };

        $scope.loadScholars = () => {
          $http({
            method : "GET",
            url : "backend/getScholars.php"
          }).then((response) =>{
            // On success takes the response (The scholars data) from the databese
            // and populates the current scholars array.
            $scope.currentScholars = response.data;
            for (var i = 0; i < $scope.currentScholars.length; i++) {

              $scope.currentScholars[i].parkingSpot = Number($scope.currentScholars[i].parkingSpot);


              $scope.currentScholars[i].room = Number($scope.currentScholars[i].room);


            }
            // Populate the parking spots array with the spots not already used.
            $scope.initParking(26, $scope.currentScholars);

            $scope.parkingSpots.push("None");

          }, (response) =>{ // handle error condition
            console.log("Something Went wrong");
          });
        };
        // Loads the scholars from the database
        $scope.loadScholars();

        $scope.handFormSubmit = () => {
          if (!$scope.logged_in){
            alert("You need to be logged in as an admin to take this action");
            return;
          }
          // Gets all the information from the form used to add scholars.
          var formData = $("#newScholarForm :input");
          // Only take valid scholar names
          if ($scope.validateInput(formData[0].value) == -1){
            alert("Please enter a valid username!");
            return;
          }
          $http({
            method : "POST",
            data : $.param({
              name: formData[0].value,
              class: formData[1].value,
              room: formData[2].value,
              parkingSpot: formData[3].value
            }),
            url : "backend/newScholar.php",
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}

          }).then((response) =>{  // handle success condition
            $("#myAlert").show();
            $scope.type = "success";
            $scope.alertMessage = response.data + " has been added to the database";
            // Removes the used parking spots from the parking spots list.
            if(formData[3].value != "None"){
              $scope.parkingSpots = $scope.parkingSpots.filter(spot => Number(spot) != Number(formData[3].value));
            }
          //  console.log($scope.parkingSpots);


          }, (response) =>{ // handle error condition
            console.log("Something Went wrong");
          });

        };

        $scope.initRooms(20);
        $scope.rooms.push("None");

        $scope.handleAdminLoging = () => {

          var adminForm = $("#adminLogin :input");

          var adminInfo = $.param({
            username: adminForm[0].value,
            password: adminForm[1].value
          });


          $http({
            method : "POST",
            data : adminInfo,
            url : "backend/checkCredentials.php",
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}

          }).then((response) =>{  // handle success condition
            console.log(response.data);
            if(response.data == "true"){
              alert("loging was successful");
              $scope.logged_in = true;
              $scope.logged_in_user = adminForm[0].value;
              <?php
                //$_SESSION["logged_in"] = "true";
               ?>

              adminForm[0].value = "";
              adminForm[1].value = "";
            }else{
              alert("Credentials do not match");
              $scope.logged_in = false;
            }

          }, (response) =>{ // handle error condition
            console.log("Something Went wrong");
          });


        };



      });
      // Controller for the home page
      app.controller('homeCtrl', function ($scope){
        $scope.title = "Evans Scholars Home";

        $scope.contents = [
          "View Current Scholars",
          "Add New Scholars",
          "View Parking Spots",
          "Delete Scholars",
          "Modifiy Schoalrs' Information"
        ];
      });





      // Controller for the view page
      app.controller('viewScholarsCtrl', function($scope, $http){
        $("#editInfo").hide();
        //$scope.currentScholars = [];
        $scope.sortOptions = ["Name", "Class", "Room Number", "Parking Spot"];

        // Handles the sorting option for the scholar view
        $scope.sortList = (option) => {
          //console.log($scope.selectedItem);
          if($scope.selectedItem == "Room Number"){
            $scope.currentScholars = _.sortBy($scope.currentScholars, 'room');
          }else if($scope.selectedItem == "Name"){
            $scope.currentScholars = _.sortBy($scope.currentScholars, 'name');
          }else if($scope.selectedItem == "Parking Spot"){
            $scope.currentScholars = _.sortBy($scope.currentScholars, 'parkingSpot');
          }else{
            $scope.currentScholars = _.sortBy($scope.currentScholars, 'class');
          }
        };



        $scope.deleteScholar = (name, parkingSpot, currentIndex) => {
          if (!$scope.logged_in){
            alert("You need to be logged in as an admin to take this action");
            return;
          }
          // Extra check to make sure the user doesn't accidentally delete a scholar
          if (confirm("Are you sure you want to remove " + name + " from the databases")){
            $scope.currentScholars.splice(currentIndex, 1);
            $http({
              method : "POST",
              data : $.param({
                name: name,
                spot: parkingSpot
              }),
              url : "backend/deleteScholar.php",
              headers: {'Content-Type': 'application/x-www-form-urlencoded'}

            }).then((response) =>{  // handle success condition
              alert(name + " was deleted");
            }, (response) =>{ // handle error condition
              console.log("Something Went wrong");
            });
          }
        };

        $scope.editScholar = (student, currentIndex)=>{
          if (!$scope.logged_in){
            alert("You need to be logged in as an admin to take this action");
            return;
          }


          if(isNaN(student.room)){
            //console.log(typeof student.room);
            student.room = "Chapter";
            //console.log(student);
          }
          if(isNaN(student.parkingSpot)){
            //console.log(typeof student.parkingSpot);
            student.parkingSpot = "None";

          }
          $scope.selectedScholar = student;


          $scope.selectedScholarIndex = currentIndex;
          $("#editInfo").show();
          $("#viewTable").hide();
        };

        $scope.updateScholar = (currentdata) => {
          var updateForm = $("#editInfo :input");
          $("#editInfo").hide();
          $(".table").show();
          var errorMessage = '';
          if ($scope.validateInput(updateForm[0].value) == -1){
            errorMessage += "Please enter a valid name\n";

          }
          if($scope.validateInput(updateForm[1].value) == -1){
            errorMessage += "Please select a class\n";

          }
          if($scope.validateInput(updateForm[2].value) == -1){

            errorMessage += "Please select a room\n";

          }
          if($scope.validateInput(updateForm[3].value) == -1){
            errorMessage += "Please select a parkingSpot\n";

          }
          if (errorMessage != ''){
            alert(errorMessage);
            return;
          }


          console.log(currentdata);
          var phpData = {
            updatedName: updateForm[0].value,
            updatedClass: updateForm[1].value,
            updatedRoom: updateForm[2].value,
            updatedParkingSpot: updateForm[3].value,
            currentName: currentdata.name,
            currentClass: currentdata.class,
            currentRoom: currentdata.room,
            currentParkingSpot: currentdata.parkingSpot
          };
          $scope.currentScholars[$scope.selectedScholarIndex].name = updateForm[0].value;
          $scope.currentScholars[$scope.selectedScholarIndex].class = updateForm[1].value;
          $scope.currentScholars[$scope.selectedScholarIndex].room = updateForm[2].value;
          $scope.currentScholars[$scope.selectedScholarIndex].spot = updateForm[3].value;
          console.log(phpData);


          $http({
            method : "POST",
            data : $.param(phpData),
            url : "backend/updateScholar.php",
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}

          }).then((response) =>{  // handle success condition
            // Handles the update of scholar

            alert($scope.currentScholars[$scope.selectedScholarIndex].name + " has been updated in the database");

          }, (response) =>{ // handle error condition
            console.log("Something Went wrong");
          });


        }


      });



    </script>

  </body>
</html>


<?php
/*
require 'vendor/autoload.php';

$client = new MongoDB\Client("mongodb://localhost:27017");
$collection = $client->scholars->evans;

$insetResult = $collection->insertOne(
  [
    'name' => 'Mark Vassell',
    'class' => 'Graduate Resident Advisor',
    'room' => '3',
    'parkingSpot' => '6'

  ]

);
$result = $collection->insertOne( [ 'name' => 'Hinterland', 'brewery' => 'BrewDog' ] );
echo "Inserted with Object ID '{$result->getInsertedId()}'";




//  sudo apt-get install php-pear
// sudo pecl install mongodb
// cd /etc/php/7.0/apache2/
// sudo nano php.ini
// extension=mongodb.so
// sudo apt install composer
// composer require mongodb/mongodb
*/
?>
