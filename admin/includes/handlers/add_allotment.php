<?php
include("../../../config.php");
// echo $_POST["block"];
if (!empty($_POST["block"])) { 
    echo "<option value=''>Select a Flat</option>";
    $x=$_POST["block"]; 
    $sql = "SELECT DISTINCT(FlatNumber) from flats where BlockNumber='".$x. "'";    
    $res=mysqli_query($con,$sql);
    // echo $sql;
    while($row = mysqli_fetch_assoc($res)){
        echo "<option value='". $row['FlatNumber']. "'>" . $row["FlatNumber"]. "</option>";
    }
    exit();
}