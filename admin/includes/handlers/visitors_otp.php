<?php
function generateOTP( $visitorOTP,$vcno, $duration){ 
    
    // $enddate = date('Y-m-d', strtotime($startdate . " + ". $duration." day"));
    // echo $enddate;
    
    $fields = array(
        "sender_id" => "CHKSMS",
        // "message" => $vname." your Visiting OTP is <strong>". $visitorOTP ." </strong>valid from <strong> ". $startdate . " to ". $enddate ."</strong>",
        "message" => "2",
        "variables_values" => $visitorOTP,
        "route" => "s", //check
        // "numbers" => '"' . $number1 . ', ' . $number2 . '"', //not working
        "numbers" => $vcno ,
    );
    // print_r($fields);

    // echo '<script>console.log('.$fields.')</script>';
    $curl = curl_init();

    curl_setopt_array($curl, array(
    CURLOPT_URL => "https://www.fast2sms.com/dev/bulkV2",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10, //c
    CURLOPT_TIMEOUT => $duration*24*3600,//c
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
    // echo "<script>console.log('Done succ')</script>";
    // return $visitorOTP;
    }
}
?>