// stop navbar from clipping container //
$(window).on('resize', function () { 
   $('body').css('padding-top', $('#main-navbar').height());
});
$(window).on('load', function () { 
   $('body').css('padding-top', $('#main-navbar').height());         
});   
// //

 
$(document).ready(function() {
  
  // when addVenue button clicked, send add venue request to API, then refresh venues
  $("#addVenueBtn").click(function () { 
    var newVenueName = $("#addVenueName").val();
    $.ajax({
      type: "POST",
      url: "api.php/venues",
      data: { 'name': newVenueName },
      success:
        function(data) {
          $("#addVenue_success").text("Venue addition successful");
          $("#addVenue_success").show();
          setTimeout(function(){ $("#addVenue_success").fadeOut("500"); }, 2000);
        },
      error:
        function(data) {
          $("#addVenue_failure").text("Venue addition unsuccessful: " + data);
          $("#addVenue_failure").show();
          setTimeout(function(){ $("#addVenue_failure").fadeOut("500"); }, 2000);
        }
    })
  });  
  
  // handle minimizing and maximizing the meals table (it can get big)
  $("#minimizeMeals").click(function() {
    if ($("#mealsPanelBody").is(":visible"))
    {
      $("#mealsPanelBody").hide();
      $(this).text("+");
    }
    else
    {
      $("#mealsPanelBody").show();
      $(this).text("-");
    }
  });
  
  // when newMeal button is clicked, send new meal request to API, then refresh meals
  $("#btnNewMeal").click(function() {
    var venueId = $("#btnSelectVenue").val();
    var name = $("#newMeal_name").val();
    var servingSize = $("#newMeal_servingSizeOz").val();
    var nutritionDataRaw = $("#newMeal_nutritionData").val();
    var nutritionData = new Object();
    
    var errors = [];
    
    if (name == "")
      errors += "No name was specified";
    
    if (isNaN(servingSize))
      errors += "Serving size must be a number";
    
    var nutrientPat = /^(\w+)=(\d+)(\w+)?$/
    nutritionDataRaw.split("\n").forEach(function(str) {
      if (str == "")
        return;
      
      var match = nutrientPat.exec(str);
      if (match == null)
        errors.push("Incorrect format in '" + str + "'");
      else if (match.length == 3)
      {
        nutritionData[match[1]] = match[2];
      }
      else if (match.length == 4)
      {
        nutritionData[match[1]] = { 'count': match[2], 'unit': match[3] };
      }
    });
    var nutritionDataPost = JSON.stringify(nutritionData);
    
    if (errors.length > 0)
    {
      var error = "Adding new meal failed: <br />";
      
      error += errors.join("<br />");
      
      $("#errNewMeal").html(error);
      $("#errNewMeal").show();
    }
    else
    {
      $("#errNewMeal").hide();
      $.ajax({
        url: "api.php/venues/" + venueId + "/meals",
        type: "POST",
        data: {
          'name': name,
          'servingsizeoz': servingSize,
          'nutritionvaluesjson': nutritionDataPost
        },
        success: function(data) {
          // inform user of success
          $("#sucNewMeal").text("Meal addition successful");
          $("#sucNewMeal").show();
          
          // clear form
          $("#newMeal_name").val("");
          $("#newMeal_servingSizeOz").val("");
          $("#newMeal_nutritionData").val("");
          
          // reload meals
          loadVenueMeals(venueId);
          
          // fade success message out after 2 seconds
          setTimeout(function(){ $("#sucNewMeal").fadeOut("500"); }, 2000);
        },
        error: function (jqXHR, exception) {
          
          if (jqXHR.status == 409)
            $("#errNewMeal").text("A meal already exists with this name under this venue.");
          else
            $("#errNewMeal").text("There was an error adding the meal (" + jqXHR.status + "): " + exception);
          $("#errNewMeal").show();
        }
      });
    }
  });
  
  // when newRecommendation button is clicked, send new recommendation request to API, then refresh recommendations
  $("#btnNewRec").click(function() {
    var newRec_key        = $("#newRec_key").val();
    var newRec_nutrient   = $("#newRec_nutrient").val();
    var newRec_msg        = $("#newRec_msg").val();
    var newRec_datasource = $("#newRec_datasource").val();
    $.ajax({
      type: "POST",
      url: "api.php/recommendation",
      data: {
        'key': newRec_key,
        'nutrient': newRec_nutrient,
        'recommendation': newRec_msg,
        'datasource': newRec_datasource
      },
      success:
        function(data) {
          $("#sucNewRecommendation").text("Recommendation addition successful");
          $("#sucNewRecommendation").show();
          readRecommendations();
          $("#newRec_key").val("");
          $("#newRec_nutrient").val("");
          $("#newRec_msg").val("");
          $("#newRec_datasource").val("");
          setTimeout(function(){ $("#sucNewRecommendation").fadeOut("500"); }, 2000);
        },
      error:
        function (jqXHR, exception) {
          $("#errNewRecommendation").text("Recommendation addition unsuccessful (" + jqHXR.status + "): " + exception);
          $("#errNewRecommendation").show();
        }
    })
  });
  
  readVenues();
  readRecommendations();
  
});

function readVenues()
{
  $.ajax({
    url: "api.php/venues"
  })
  .done(function(json) {
    var response = JSON.parse(json);
    
    // initialize venue tab venues table
    $("#venues-table").html("<tr><th>loading...</th></tr>");
    var venueTableContent = "<thead><tr><th>identifier</th><th>venue name</th></tr></thead>";
    venueTableContent += "<tbody>";
    
    // initialize meal tab venue dropdown
    $("#meals-venueDropdown").html("<tr><th>loading...</th></tr>");
    var mealVenueDropdownContent = "";
    
    response.venues.forEach(function(venue) {
      // in venue tab venue table, add row for venue
      venueTableContent += "<tr><td>" + venue.id + "</td><td>" + venue.name + "</td></tr>";
      // in meal tab venue dropdown, add item for venue
      mealVenueDropdownContent += "<li><a href='#' data-value='" + venue.id + "'>" + venue.name + "</a></li>";
    });
    
    venueTableContent += "</tbody>";
    
    $("#venues-table").html(venueTableContent);
    $("#meals-venueDropdown").html(mealVenueDropdownContent);
    
    // bind meal tab venue dropdown to click function
    $(".dropdown-menu li a").click(function(){
      $(this).parents(".input-group-btn").find('.btn').html($(this).text() + ' <span class="caret"></span>');
      $(this).parents(".input-group-btn").find('.btn').val($(this).data('value'));
      
      var venueId = $(this).data('value');
      
      loadVenueMeals(venueId);
      
    });
  });
}

function loadVenueMeals(venueId)
{
  // inform user that this table is loading
  $("#meals-table").html("<tr><th>loading...</th></tr>");

  // populate meal tab meals table
  $.ajax({
    url: 'api.php/venues/' + venueId + '/meals'
  })
  .done(function(json) {
    var response = JSON.parse(json);
    var content = "<thead><tr><th>name</th><th>nutrition facts</th></tr></thead>";
    content += "<tbody>";
    response.meals.forEach(function(meal){
      content += "<tr data-value='" + meal.id + "'><td>" + meal.name + "</td><td>";
      content += "<table class='table table-condensed'>";
      content += "<thead><tr><th colspan=2>Amount Per Serving (" + meal.servingsizeoz + "oz)</th></tr></thead>";
      content += "<tbody>";
      for(var key in meal.nutritionvalues){
        if (typeof(meal.nutritionvalues[key]) === "object")
          content += "<tr><td>" + key + "</td><td>" + meal.nutritionvalues[key].count + meal.nutritionvalues[key].unit + "</td></tr>";
        else
          content += "<tr><td>" + key + "</td><td>" + meal.nutritionvalues[key] + "</td></tr>";
      }
      content += "</tbody>";
      content += "</table>";
      content += "</tr>";
    });
    $("#meals-table").html(content);
    
    // enable add meal
    if ($("#btnNewMeal").hasClass("disabled"))
      $("#btnNewMeal").removeClass("disabled");
  });
}

function readRecommendations() {
  
  $("#recommendations-table").html("<thead><tr><th>loading...</th></tr></thead>");
  
  $.ajax({
    url: 'api.php/recommendations'
  })
  .done(function(json) {
    var content = "<thead><tr><th>key</th><th>nutrient</th><th>recommendation</th><th>data source</th></tr></thead>";
    content += "<tbody>";
    
    var response = JSON.parse(json);
    response.recommendations.forEach(function(recommendation) {
      content += "<tr><td>" + recommendation.key + "</td><td>" + recommendation.nutrient + "</td><td>" + recommendation.recommendation + "</td><td>" + recommendation.datasource + "</td></tr>";
    });
    content += "</tbody>";
    $("#recommendations-table").html(content);
  });
}

function clearVenueTable()
{
  document.getElementById("venues-table").innerHTML = "";
}
function clearMealsVenueDropdown()
{
  document.getElementById("meals-venueDropdown").innerHTML = "";
}