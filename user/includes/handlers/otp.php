<?php

//session_start();

$otp = rand(100000, 999999);

$number = $_SESSION["contactno"];

$fields = array(
    "sender_id" => "CHKSMS",
    "message" => "2",
    "variables_values" => $otp,
    "route" => "s",
    "numbers" => $number,
);

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://www.fast2sms.com/dev/bulkV2",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 300,
  CURLOPT_SSL_VERIFYHOST => 0,
  CURLOPT_SSL_VERIFYPEER => 0,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => json_encode($fields),
  CURLOPT_HTTPHEADER => array(
    "authorization: 4XTW3u2vgelpOVUiDj0K1RSd9fc8GHNyYsFqL5aJoM7PAwQBIbuFjJ8IVgKcLQhrvdOfmzYB1WplUMo2",
    "accept: */*",
    "cache-control: no-cache",
    "content-type: application/json"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  //echo $response;
  $_SESSION["otp"] = $otp;
  echo'<script>window.location.replace("./login.php")</script>';
  //print_r($_SESSION);

  
}