<?php
$baseurl = "http://rin.cs.ndsu.nodak.edu:4567";
function api($path)
{ global $baseurl; return $baseurl . $path; }
$head = "<link rel='stylesheet' type='text/css' href='style/theme.css'>";
$navbar = "<div class='navbar'><ul><li><a href='list_venues.php'>list venues</a></li><li><a href='new_meal.php'>new meal</a></li><li><a href='new_recommendation.php'>new recommendation</a></li><li class='last'><a href='new_venue.php'>new venue</a></li></div>";
$footer = "<footer><a href='http://github.com/TeamRedRocks'>team red rocks</a> - fall 2016 - <a href='mailto:tyler.johnson.13@ndsu.edu'>webmaster</a></footer>";
?>