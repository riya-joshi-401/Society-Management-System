<?php
include_once '../../../config.php';

$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page

if (isset($_POST['order'])) {
    $columnIndex = $_POST['order'][0]['column']; // Column index
    $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
    $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
    $orderQuery = " order by $columnName $columnSortOrder ";
} else {
    // $columnName='sem';
    // $columnSortOrder='asc';
    $orderQuery = ' order by BlockNumber asc ';
}
$searchValue = $_POST['search']['value']; // Search value

## Search
$searchQuery = "1";
if ($searchValue != '') {
    $searchQuery = "(BlockNumber like '%" . $searchValue . "%' or
        FlatNumber like '%" . $searchValue . "%' or
        VisitorName like '%" . $searchValue .  "%' or
        AlternateVisitorContactNo like '%" . $searchValue .  "%' or 
        OTP like '%" . $searchValue .  "%' or 
        VisitorContactNo like '%" . $searchValue . "%') ";
}

## Total number of records without filtering
$sel = mysqli_query($con, "select count(*) as totalcount from visitors v where 1");

$records = mysqli_fetch_assoc($sel);
//echo $records;
$totalRecords = $records['totalcount'];

## Fetch records
//VisitorID, 
$sql = "select BlockNumber, FlatNumber, VisitorName, VisitorContactNo, AlternateVisitorContactNo, NoOfPeople, StartDate, Duration, OTP from visitors v WHERE 1 and "
    . $searchQuery . $orderQuery . " limit " . $row . "," . $rowperpage;
// echo $sql;
$visitorsRecords = mysqli_query($con, $sql);
$data = array();
$total = array();
$count = 0;
$fullname = "";
while ($row = mysqli_fetch_assoc($visitorsRecords)) {
    /* $vid = $row['VisitorID'];
    $sql1 = "select Date, Duration from visitors_sec v WHERE VisitorID = '$vid' ";
    $visitorsRecords1 = mysqli_query($con, $sql1);
    $row1 = mysqli_fetch_assoc($visitorsRecords1);
    $total[] = array(
        "Date" => $row1['Date'],
        "Duration" => $row1['Duration'],
    ); */
    $data[] = array(

        "BlockNumber" => $row['BlockNumber'],
        "FlatNumber" => $row['FlatNumber'],
        "VisitorName" => $row['VisitorName'],
        "VisitorContactNo" => $row['VisitorContactNo'],
        "AlternateVisitorContactNo" => $row['AlternateVisitorContactNo'],
        "NoOfPeople" => $row['NoOfPeople'], 
        "StartDate" => $row['StartDate'],
        "Duration" => $row['Duration'],
        "OTP"=> $row['OTP'],
        /* "action" => '<!-- Button trigger modal -->
                  <button type="button" class="btn btn-primary icon-btn action-btn" >
                    <i class="fas fa-check"></i>
                  </button>', */
    );
    $count++;
}

## Response
$response = array(
    "draw" => intval($draw),
    "iTotalRecords" => $totalRecords,
    "iTotalDisplayRecords" => $totalRecords,
    "aaData" => $data,
);

echo json_encode($response);