
<div id="viewTable">
  <h3>Sort By</h3>
  <select ng-options="option for option in sortOptions" ng-model="selectedItem" ng-change="sortList()" ng-init="selectedItem=sortOptions[1]">
  </select>
  <table class="table">
    <tr>
      <th scope="col">Name</th>
      <th scope="col">Class</th>
      <th scope="col">Room Number</th>
      <th scope="col">Parking Spot</th>
      <th scope="col">Delete</th>
      <th scope="col">Edit</th?
    </tr>
    <tr ng-repeat="student in currentScholars">
      <td>{{student.name}}</td>
      <td>{{student.class}}</td>
      <td>{{student.room}}</td>
      <td>{{student.parkingSpot}}</td>
      <td><button ng-click="deleteScholar(student.name, student.parkingSpot, $index)" type="button" class="btn btn-danger">Delete</button></td>
      <td><button ng-click="editScholar(student, $index)" type="button" class="btn btn-info">Edit</button></td>
    </tr>
  </table>

</div>
<form id="editInfo">
  <h3>Update Scholar </h3>
  <div class="form-group">
    <label for="selectedScholarName">Name</label>
    <input type="text" class="form-control" id="selectedScholarName" value={{selectedScholar.name}}>
  </div>
  <div class="form-group">
    <label for="selectedScholarClass">Class</label>
    <select class="form-control" id="selectedScholarClass" ng-model="selectedScholar.class">
      <option ng-selected="{{level == selectedScholar.class}}" ng-repeat = "level in classOptions" value={{level}}> {{level}}</option>
    </select>
  </div>
  <div class="form-group">
    <label for="selectedScholarRoom">Room Number</label>
    <select class="form-control" id="selectedScholarRoom" ng-model="selectedScholar.room">
      <option ng-selected="{{room == selectedScholar.room}}" ng-repeat = "room in rooms" value = "{{room}}">{{room}}</option>
    </select>
  </div>
  <div class="form-group">
    <label for="selectedScholarParkingSpot">Parking Spot</label>
    <select class="form-control" id="selectedScholarParkingSpot" ng-model="selectedScholar.parkingSpot">
      <option ng-selected="{{spot == selectedScholar.parkingSpot}}" ng-repeat = "spot in parkingSpots" value = "{{spot}}">{{spot}}</option>
    </select>
  </div>
  <button type="submit" class="btn btn-primary" id="updateInfo" ng-click="updateScholar(selectedScholar)">Update</button>
</form>
