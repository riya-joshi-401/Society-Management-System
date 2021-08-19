<?php
include_once '../../../config.php';

$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page
    
$block = $_SESSION['blockno'];
$flatno = $_SESSION['flatno'];

// $block = 'A' ;//remove it later
// $flatno = '101';//remove it later

if (isset($_POST['order'])) {
    $columnIndex = $_POST['order'][0]['column']; // Column index
    $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
    $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
    $orderQuery = " order by $columnName $columnSortOrder ";
} else {
    // $columnName='sem';
    // $columnSortOrder='asc';
    $orderQuery = ' order by VisitorID asc ';
}
$searchValue = $_POST['search']['value']; // Search value

## Search
$searchQuery = "1";
if ($searchValue != '') {
    $searchQuery = "(VisitorName like '%" . $searchValue .  "%' or 
        VisitorContactNo like '%" . $searchValue . "%' or
        Duration like '%" . $searchValue . "%' or 
        NoOfPeople like '%" . $searchValue . "%') ";
}

$filterQuery = "1 ";
#filters
if (isset($_POST['filters'])) {
    $filters = $_POST['filters'];

    if (isset($filters['vname'])) {
        $filterQuery .= "&& VisitorName in(" . "'" . implode("', '", $filters['vname']) . "'" . ")" . " ";
    }

    if (isset($filters['people'])) {
        $filterQuery .= "&& NoOfPeople in(" . "'" . implode("', '", $filters['people']) . "'" . ")" . " ";
    }

    if (isset($filters['duration'])) {
        $filterQuery .= "&& Duration in(" . "'" . implode("', '", $filters['duration']) . "'" . ")" . " ";
    }



}

## Total number of records without filtering
$sel = mysqli_query($con, "select count(*) as totalcount from visitors v where BlockNumber='" . $block ."' AND  FlatNumber=" . $flatno . ";");


$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['totalcount'];

## Total number of record with filtering
$sel = mysqli_query($con, "select count(*) as totalcountfilters from visitors v WHERE BlockNumber='" . $block ."' AND  FlatNumber=" . $flatno . " AND " . $searchQuery . "&& (" . $filterQuery . ")");

$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['totalcountfilters'];

## Fetch records

$sql = "select VisitorName, VisitorContactNo, AlternateVisitorContactNo, NoOfPeople, ReasonToMeet, StartDate, Duration, updated_by, updated_at from visitors v WHERE BlockNumber='" . $block ."' AND  FlatNumber=" . $flatno . " AND "
    . $searchQuery . "&& (" . $filterQuery . ")" . $orderQuery . " limit " . $row . "," . $rowperpage;

$visitorsRecords = mysqli_query($con, $sql);
$data = array();
$count = 0;
$fullname = "";
while ($row = mysqli_fetch_assoc($visitorsRecords)) {
    $data[] = array(

        // "select-cbox"=>'<input type="checkbox">',
        "select-cbox" => '<div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input selectrow" id="selectrow' . $count . '">
                        <label class="custom-control-label" for="selectrow' . $count . '"></label>
                     </div>',
        "VisitorName" => $row['VisitorName'],
        "VisitorContactNo" => $row['VisitorContactNo'],
        "AlternateVisitorContactNo" => $row['AlternateVisitorContactNo'],
        "NoOfPeople" => $row['NoOfPeople'], 
        "ReasonToMeet" => $row['ReasonToMeet'],
        "StartDate" => $row['StartDate'],
        "Duration" => $row['Duration'],
        "updated_at" => $row['updated_at'],
        "action" => '<!-- Button trigger modal -->
                  <button type="button" class="btn btn-primary icon-btn action-btn" >
                    <i class="fas fa-tools"></i>
                  </button>',
    );
    $count++;
}

## Response
$response = array(
    "draw" => intval($draw),
    "iTotalRecords" => $totalRecords,
    "iTotalDisplayRecords" => $totalRecordwithFilter,
    "aaData" => $data,
);

echo json_encode($response);