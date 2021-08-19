<?php
include "../../../config.php";

if (isset($_POST['name'])) {
    $admin = mysqli_escape_string($con, $_POST['name']);
    $output = "";
    $sql_query = "SELECT * FROM shoutbox;";
    $res = mysqli_query($con, $sql_query);

    if (mysqli_num_rows($res) > 0) {
        while ($row = mysqli_fetch_assoc($res)) {
            if ($row['Admin'] == $admin) {
                $output .= '<div class="chat-outgoing flex-column">
                                    <div class="msger">
                                        '.$row['Admin'].', '.$row['created_at'].'
                                    </div>
                                <div class="details">
                                    <p>' . $row['Chat'] . '</p>
                                </div>
                            </div>';
            } else {
                if ($row['Admin'] != '') {
                    $output .= '<div class="chat-incoming flex-column">
                                    <div class="msger">
                                        '.$row['Admin'].', '.$row['created_at'].'
                                    </div>
                                    <div class="details align-items-center">
                                        <p>' . $row['Chat'] . '</p>
                                    </div>
                                </div>';
                } 
                else {
                    $flatid = $row["FlatID"];
                    $query2 = "SELECT FlatNumber,BlockNumber from flats where FlatID='$flatid'";
                    $res2= mysqli_query($con,$query2);
                    $row2 = mysqli_fetch_assoc($res2);
                    $output .= '<div class="chat-incoming flex-column">
                                    <div class="msger">
                                       '.$row2['BlockNumber'].' -'.$row2['FlatNumber'].' , '.$row['created_at'].'
                                    </div>
                                    <div class="details align-items-center">
                                        <p>' . $row['Chat'] . '</p>
                                    </div>
                                </div>';
                }
            }
        }

        echo $output;
    }

}