<?php
include("../../../config.php");
// echo $_POST["block"];
if (!empty($_POST["block"])) {
    echo "<option value=''>Select Block</option>";
    $x = $_POST["block"];
    $sql = "SELECT DISTINCT(BlockNumber) from flatarea where FlatSeries='" . $x . "'";
    $res = mysqli_query($con, $sql);
    // echo $sql;
    while ($row = mysqli_fetch_assoc($res)) {
        echo "<option value='" . $row['BlockNumber'] . "'>" . $row["BlockNumber"] . "</option>";
    }
    exit();
}