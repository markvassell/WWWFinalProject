<div class="alert alert-{{type}} alert-dismissible" role="alert" id="myAlert">
  {{alertMessage}}
</div>

<form id="newScholarForm">
  <div class="form-group">
    <label for="scholarName">Scholar Name</label>
    <input type="text" class="form-control" id="scholarName"  placeholder="Scholar Name">
  </div>
  <div class="form-group">
    <label for="scholarClass">Class</label>
    <select class="form-control" id="scholarClass">
      <option ng-repeat = "level in classOptions" value = "{{level}}">{{level}}</option>
    </select>
  </div>
  <div class="form-group">
    <label for="roomNumber">Room Number</label>
    <select class="form-control" id="roomNumber">
      <option ng-repeat = "room in rooms" value = "{{room}}">{{room}}</option>
    </select>
  </div>
  <div class="form-group">
    <label for="lotNumber">Parking Spot</label>
    <select class="form-control" id="lotNumber">
      <option ng-repeat = "spot in parkingSpots" value = "{{spot}}">{{spot}}</option>
    </select>
  </div>
  <button type="submit" class="btn btn-primary" ng-click="handFormSubmit()">Submit</button>
</form>
