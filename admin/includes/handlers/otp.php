<?php

if (isset($_POST["contactno"]) && isset($_POST["username"]) ) {


    $contactno = $_POST["contactno"];
    $username = $_POST["username"];
    $_SESSION['contactno']=$contactno;
    
    $db = mysqli_connect('localhost', 'root', '', 'sms') or
    die('Error connecting to MySQL server.');

    $query = "SELECT * FROM admin WHERE ContactNumber='{$contactno}'and Username='{$username}' ;";
    //echo $query;
    $result = mysqli_query($db, $query);

    if ($result) {

        $count = mysqli_num_rows($result);

        if ($count == 0 && isset($_SESSION['contactno'])) {
            echo "<script>alert('Either username or contact number is not correct. Please try again!');</script>";
        } else {

            $otp = rand(100000, 999999);

            $fields = array(
                "sender_id" => "CHKSMS",
                "message" => "2",
                "variables_values" => $otp,
                "route" => "s",
                "numbers" => $contactno,
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
            
                $_SESSION["otp"] = $otp;
                $_SESSION['isverified'] = "";
                echo'<script>window.location.replace("./forgotpass.php")</script>';
            }
        }

    }


    mysqli_close($db);
}
?>