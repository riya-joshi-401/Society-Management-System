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
        VisitorContactNo like '%" . $searchValue . "%' or 
        WhomToMeet like '%" . $searchValue . "%') ";
}

$filterQuery = "1 ";
#filters
if (isset($_POST['filters'])) {
    $filters = $_POST['filters'];

    if (isset($filters['block'])) {
        $filterQuery .= "&& BlockNumber in(" . "'" . implode("', '", $filters['block']) . "'" . ")" . " ";
    }

    if (isset($filters['flatno'])) {
        $filterQuery .= "&& FlatNumber in(" . "'" . implode("', '", $filters['flatno']) . "'" . ")" . " ";
    }

    if (isset($filters['vname'])) {
        $filterQuery .= "&& VisitorName in(" . "'" . implode("', '", $filters['vname']) . "'" . ")" . " ";
    }

}

## Total number of records without filtering
$sel = mysqli_query($con, "select count(*) as totalcount from visitors v where 1");

$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['totalcount'];

## Total number of record with filtering
$sel = mysqli_query($con, "select count(*) as totalcountfilters from visitors v WHERE 1 and " . $searchQuery . "&& (" . $filterQuery . ")");

$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['totalcountfilters'];

## Fetch records

$sql = "select BlockNumber, FlatNumber, VisitorName, VisitorContactNo, AlternateVisitorContactNo,NoOfPeople, WhomToMeet, ReasonToMeet, StartDate, Duration, updated_by, updated_at from visitors v WHERE 1 and "
    . $searchQuery . "&& (" . $filterQuery . ")" . $orderQuery . " limit " . $row . "," . $rowperpage;
// echo $sql;
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
        "BlockNumber" => $row['BlockNumber'],
        "FlatNumber" => $row['FlatNumber'],
        "VisitorName" => $row['VisitorName'],
        "VisitorContactNo" => $row['VisitorContactNo'],
        "AlternateVisitorContactNo" => $row['AlternateVisitorContactNo'],
        "NoOfPeople" => $row['NoOfPeople'], 
        "WhomToMeet" => $row['WhomToMeet'], 
        "ReasonToMeet" => $row['ReasonToMeet'],
        "StartDate" => $row['StartDate'],
        "Duration" => $row['Duration'],
        "updated_by" => $row['updated_by'],
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