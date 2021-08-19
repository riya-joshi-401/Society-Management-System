<?php
include_once('../../../config.php');
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
    $orderQuery = ' order by RequestID asc ';
}
$searchValue = $_POST['search']['value']; // Search value

## Search
$searchQuery = "1";
$searchQuery2 = "1";
if ($searchValue != '') {
    $searchQuery = "(FlatNumber like '%" . $searchValue . "%' or BlockNumber like '%" . $searchValue . "%' or RequestID like '%" . $searchValue . "%' or ComplaintType like '%" . $searchValue . "%' or
        Description like '%" . $searchValue . "%' or
        RaisedDate like '%" . $searchValue . "%' or AdminRemark like '%" . $searchValue . "%'
        or Status like '%" . $searchValue . "%' or updated_at like '%." . $searchValue . ".%' or ResolvedDate like '%" . $searchValue . "%' ) ";

    $searchQuery2 = "(FlatNumber like '%" . $searchValue . "%' or BlockNumber like '%" . $searchValue . "%' or RequestID like '%" . $searchValue . "%' or ComplaintType like '%" . $searchValue . "%' or
        Description like '%" . $searchValue . "%' or RaisedDate like '%" . $searchValue . "%' or AdminRemark like '%" . $searchValue . "%'
        or Status like '%" . $searchValue . "%' or updated_at like '%." . $searchValue . ".%' or ResolvedDate like '%" . $searchValue . "%' or complaint_type like '%" . $searchValue . "%' ) ";
}

$filterQuery = "1 ";
#filters
if (isset($_POST['filters'])) {
    $filters = $_POST['filters'];

    if (isset($filters['complaint'])) {
        $filterQuery .= "&& ComplaintType in(" . "'" . implode("', '", $filters['complaint']) . "'" . ")" . " ";
    }

    if (isset($filters['block'])) {
        $filterQuery .= "&& BlockNumber in(" . "'" . implode("', '", $filters['block']) . "'" . ")" . " ";
    }

    
}

## Total number of records without filtering
$sel = mysqli_query($con, "select count(*) as totalcount from complaints c where Status='1'");

$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['totalcount'];

## Total number of record with filtering
$sel = mysqli_query($con, "select count(*) as totalcountfilters from complaints c WHERE Status='1' and " . $searchQuery . "&& (" . $filterQuery . ")");

$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['totalcountfilters'];

## Fetch records

$sql ="select RequestID,BlockNumber,FlatNumber,complaint_type,Description,RaisedDate,AdminRemark,Status,ResolvedDate,updated_at FROM complaints inner join complainttypes on complainttypes.complaint_id = complaints.ComplaintType WHERE Status='1' and "
. $searchQuery2 . "&& (" . $filterQuery . ")" . $orderQuery . " limit " . $row . "," . $rowperpage;

$complaintRecords = mysqli_query($con, $sql);
$data = array();
$count = 0;
$statustype = array("0" => "Unresolved", "1" => "In-progress", "2" => "Resolved");
while ($row = mysqli_fetch_assoc($complaintRecords)) {

    $data[] = array(

        // "select-cbox"=>'<input type="checkbox">',
        "RequestID" => $row['RequestID'],
        "BlockNumber" => $row['BlockNumber'],
        "FlatNumber" => $row['FlatNumber'],
        "ComplaintType" => $row['complaint_type'],
        "Description" => $row['Description'],
        "RaisedDate" => $row['RaisedDate'],
        "AdminRemark" => $row['AdminRemark'],
        "Status" =>$statustype[$row['Status']],
        "ResolvedDate" => $row['ResolvedDate'],
        "updated_at" => $row['updated_at'],
        //"updated_at" => $row['updated_at'],
        "action" => '<!-- Button trigger modal -->
                  <button type="button" class="btn btn-primary icon-btn action-btn" >
                    <i class="fas fa-pencil-alt"></i>
                  </button>',
    );
    $count++;
}

## Response
$response = array(
    "draw" => intval($draw),
    "iTotalRecords" => $totalRecords,
    "iTotalDisplayRecords" => $totalRecordwithFilter,
    "aaData" => $data
);

echo json_encode($response);