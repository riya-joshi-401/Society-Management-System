<?php

include '../../../config.php';
// if(isset($_SESSION['username']) && isset($_SESSION['role']) && $_SESSION['role']=="user")
// {
if (isset($_POST['update_unresolved_complaints'])){

    //get the hidden variables of previous form
    $flat = mysqli_escape_string($con, $_POST['flatno']);   
    $block = mysqli_escape_string($con, $_POST['blockno']);
    $timestamp = mysqli_escape_string($con, $_POST['timestamp']);
    $status_new = mysqli_escape_string($con, $_POST['status_new']);
    $remark_new = mysqli_escape_string($con, $_POST['remark_new']);
    $recordID = mysqli_escape_string($con, $_POST['recordID']);
    
    //update query
    if($status_new == '1' || $status_new=='In-progress'){
        $sql = "UPDATE complaints set AdminRemark='" . $remark_new . "' , Status='" . $status_new. "' , updated_at='".$timestamp. "' where RequestID='" .$recordID. "' and FlatNumber='" .$flat. "' and BlockNumber='".$block. "'";
        echo $status_new;
        mysqli_query($con, $sql);
    }
    elseif($status_new == '2' || $status_new=='Resolved'){
        $sql = "UPDATE complaints set AdminRemark='" . $remark_new . "' , Status='" . $status_new. "' , updated_at='".$timestamp. "'  , ResolvedDate='".$timestamp. "' where RequestID='" .$recordID. "' and FlatNumber='" .$flat. "' and BlockNumber='".$block. "'";
        echo $status_new;
        mysqli_query($con, $sql);
    }
    exit();
}

elseif(isset($_POST['update_inprogress_complaints']))
{
    //get the hidden variables of previous form
    $flat = mysqli_escape_string($con, $_POST['flatno']);   
    $block = mysqli_escape_string($con, $_POST['blockno']);
    $timestamp = mysqli_escape_string($con, $_POST['timestamp']);
    $status_new = mysqli_escape_string($con, $_POST['status_new']);
    $remark_new = mysqli_escape_string($con, $_POST['remark_new']);
    $recordID = mysqli_escape_string($con, $_POST['recordID']);
    
    //update query
    if($status_new == '1'){
        $sql = "UPDATE complaints set AdminRemark='" . $remark_new . "' , Status='" . $status_new. "' , updated_at='".$timestamp. "' where RequestID='" .$recordID. "' and FlatNumber='" .$flat. "' and BlockNumber='".$block. "'";
        echo $status_new;
        mysqli_query($con, $sql);
    }
    else{
        $sql = "UPDATE complaints set AdminRemark='" . $remark_new . "' , Status='" . $status_new. "' , updated_at='".$timestamp. "'  , ResolvedDate='".$timestamp. "' where RequestID='" .$recordID. "' and FlatNumber='" .$flat. "' and BlockNumber='".$block. "'";
        echo $status_new;
        mysqli_query($con, $sql);
    }
    exit();
}

// }