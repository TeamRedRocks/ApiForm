<!DOCTYPE html>
<html>
<head>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="custom.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="http://students.cs.ndsu.nodak.edu/~johns327/rinformstrap/rin.js"></script>

</head>
<body style="background-image: url('bg.png')">

<nav class="navbar navbar-default navbar-fixed-top" id="main-navbar">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">Nutrition App</a>
    </div>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="http://github.com/TeamRedRocks" style="font-size:24px"><i class="fa fa-github"></i></a></li>
    </ul>
    <ul class="nav nav-tabs">
      <li class="active"><a data-toggle="tab" href="#venues">Venues</a></li>
      <li><a data-toggle="tab" href="#meals">Meals</a></li>
      <li><a data-toggle="tab" href="#recommendations">Recommendations</a></li>
    </ul>
  </div>
</nav>

<div class="container" >
  
  <div class="tab-content" style='background-color: #FFF'>
    <div id="venues" class="tab-pane active">
      <table id="venues-table" class="table table-striped"></table>
      <div class="input-group">
        <span class="input-group-addon">Venue name:</span>
        <input id="addVenueName" type="text" class="form-control" placeholder="name your venue...">
        <span class="input-group-btn">
          <button id="addVenueBtn" type="button" class="btn btn-default">create</button>
        </span>
      </div>
      <div id="addVenue_success" class="alert alert-success" style="display:none"></div>
      <div id="addVenue_failure" class="alert alert-danger" style="display:none"></div>
    </div>
    <div id="meals" class="tab-pane">
      <div class="panel panel-default">
        <div class="panel-heading">Select Venue</div>
        <div class="panel-body">
          <div class="input-group col-sm-4">
            <span class="input-group-addon">Venue:</span>
            <div class="input-group-btn">
              <button id='btnSelectVenue' class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
                Select venue
                <span class="caret"></span>
              </button>
              <ul id="meals-venueDropdown" class="dropdown-menu"></ul>
            </div>
          </div>
        </div>
      </div>
      <div class="panel panel-default">
        <div class="panel-heading">Meals <button id="minimizeMeals" class="pull-right">-</button></div>
        <div id="mealsPanelBody" class="panel-body">
          <table id="meals-table" class="table table-striped"></table>
        </div>
      </div>
      <div class="panel panel-default">
        <div class="panel-heading">Add Meal</div>
        <div class="panel-body">
          <form id="frmNewMeal">
            <div id="errNewMeal" class="alert alert-danger" style="display: none"></div>
            <div id="sucNewMeal" class="alert alert-success" style="display: none"></div>
            <div class="input-group col-sm-6">
              <label for="newMeal_name">Name:</label>
              <input id="newMeal_name" type="text" class="form-control" placeholder="Name your new meal...">
            </div>
            <div class="input-group col-sm-6">
              <label for="newMeal_servingSizeOz">Serving Size (oz):</label>
              <input id="newMeal_servingSizeOz" type="text" class="form-control" placeholder="Serving size in ounces...">
            </div>
            <div class="input-group col-sm-6">
              <label for="newMeal_nutritionData">Nutrition data<br />Each line is a nutrient in the form 'nutrientname=quantity(unit)'</label>
              <textarea class="form-control" id="newMeal_nutritionData" rows="10"></textarea>
            </div>
            <div class="input-group col-sm-6">
              <button id="btnNewMeal" class="btn btn-default disabled">Add</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div id="recommendations" class="tab-pane">
      <div class="panel panel-default">
        <div class="panel-heading">Add recommendation</div>
        <div class="panel-body">
          <div id="errNewRecommendation" class="alert alert-danger" style="display: none"></div>
          <div id="sucNewRecommendation" class="alert alert-success" style="display: none"></div>
          <div class="input-group col-sm-6">
            <label for="newRec_key">Key:</label>
            <input id="newRec_key" type="text" class="form-control" placeholder="Assign a key to your new recommendation...">
          </div>
          <div class="input-group col-sm-6">
            <label for="newRec_nutrient">Nutrient:</label>
            <input id="newRec_nutrient" type="text" class="form-control" placeholder="Tell me what nutrient this recommendation is for...">
          </div>
          <div class="input-group col-sm-6">
            <label for="newRec_msg">Recommendation:</label>
            <input id="newRec_msg" type="text" class="form-control" placeholder="Tell me what you suggest people to do if they're low on this nutrient...">
          </div>
          <div class="input-group col-sm-6">
            <label for="newRec_datasource">Data Source:</label>
            <input id="newRec_datasource" type="text" class="form-control" placeholder="Tell me where you got this information...">
          </div>
          <div class="input-group col-sm-6">
            <button id="btnNewRec" class="btn btn-default">Add</button>
          </div>
        </div>
      </div>
      <div class="panel panel-default">
        <div class="panel-heading">Recommendations</div>
        <div class="panel-body">
          <table id="recommendations-table" class="table table-striped"></table>
        </div>
      </div>
    </div>
  </div>
</div>

</body>
</html>