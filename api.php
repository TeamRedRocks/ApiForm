<?php
// this component exists because of CORS protection
// essentially, rin.js cannot request from the API directly because
// your browser will think a cross-site scripting attack is happening
// so, this php page requests the URI from the API and returns the headers, content, etc
// requesting from this page will act just like requesting from the API

// all the shenanigans above may be false
// todo: investigate enabling cross-domain ajax calls
//   for the ruby api, this may work:
//      headers['Access-Control-Allow-Origin'] = "students.cs.ndsu.nodak.edu"

$apiURL = "http://rin.cs.ndsu.nodak.edu:4567";

$startURI = strpos($_SERVER['PHP_SELF'], "api.php");
$forwardURI = substr($_SERVER['PHP_SELF'], $startURI + 7);

if ($_SERVER['REQUEST_METHOD'] === "GET")
{
  $handle = fopen($apiURL . $forwardURI, "rb");
}
elseif ($_SERVER['REQUEST_METHOD'] === "POST")
{
  $postdata = http_build_query($_POST);
  $opts = array('http' =>
    array(
      'method'  => 'POST',
      'header'  => 'Content-type: application/x-www-form-urlencoded',
      'content' => $postdata
    )
  );
  $context = stream_context_create($opts);
  $handle = fopen($apiURL . $forwardURI, "rb", false, $context);
}
else
{
  http_response_code(405);
  exit(0);
}

// forward http response code (418 im a teapot)
$returnResponse = explode(' ', $http_response_header[0]);
http_response_code((int) $returnResponse[1]);

if ($handle == false)
  exit(0);

// forward response 
do {
  $data = fread($handle, 1024);
  echo $data;
}
while (strlen($data) > 0);
fclose($handle);
?>