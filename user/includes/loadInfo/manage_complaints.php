<?php
include_once '../../../config.php';

$draw = $_POST['draw'];
$row = $_POST['start'];
$flatno = $_SESSION['flatno'];
// $contactno = $_SESSION['contactno'];
$block = $_SESSION['blockno'];

// echo $flatno;
// echo $contactno;
// echo $block;

// $contactno = '9029996333';
// $flatno = '802';
// $block = 'A';

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
    $searchQuery = "(RequestID like '%" . $searchValue . "%' or ComplaintType like '%" . $searchValue . "%' or
        Description like '%" . $searchValue . "%' or
        RaisedDate like '%" . $searchValue . "%' or AdminRemark like '%" . $searchValue . "%'
        or Status like '%" . $searchValue . "%' or updated_at like '%." . $searchValue . ".%' or ResolvedDate like '%" . $searchValue . "%' ) ";

    $searchQuery2 = "(RequestID like '%" . $searchValue . "%' or ComplaintType like '%" . $searchValue . "%' or
        Description like '%" . $searchValue . "%' or
        RaisedDate like '%" . $searchValue . "%' or AdminRemark like '%" . $searchValue . "%'
        or Status like '%" . $searchValue . "%' or updated_at like '%." . $searchValue . ".%' or ResolvedDate like '%" . $searchValue . "%' or complaint_type like '%" . $searchValue . "%' ) ";
}

$filterQuery = "1 ";

#filters
if (isset($_POST['filters'])) {
    $filters = $_POST['filters'];

    if (isset($filters['complaint'])) {
        $filterQuery .= "&& ComplaintType in(" . "'" . implode("', '", $filters['complaint']) . "'" . ")" . " ";
    }

    if (isset($filters['status'])) {
        $filterQuery .= "&& Status in(" . "'" . implode("', '", $filters['status']) . "'" . ")" . " ";
    }

}

## Total number of records without filtering
$sel = mysqli_query($con, "select count(*) as totalcount from complaints c where BlockNumber='" . $block . "' and FlatNumber=" . $flatno . ";");

$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['totalcount'];

## Total number of record with filtering
$sel = mysqli_query($con, "select count(*) as totalcountfilters from complaints c where BlockNumber='" . $block . "' and FlatNumber=" . $flatno . " and " . $searchQuery . "&& (" . $filterQuery . ")");

$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['totalcountfilters'];

## Fetch records

$sql = "select RequestID, complaint_type,Description,RaisedDate,AdminRemark,Status,ResolvedDate,updated_at FROM complaints inner join complainttypes on complainttypes.complaint_id = complaints.ComplaintType WHERE BlockNumber='" . $block . "' and FlatNumber=" . $flatno . " and "
    . $searchQuery2 . "&& (" . $filterQuery . ")" . $orderQuery . " limit " . $row . "," . $rowperpage;

$complaintRecords = mysqli_query($con, $sql);
$data = array();
$statustype = array("0" => "Unresolved", "1" => "In-progress", "2" => "Resolved");
$count = 0;
while ($row = mysqli_fetch_assoc($complaintRecords)) {

    $data[] = array(

        // "select-cbox"=>'<input type="checkbox">',
        "select-cbox" => '<div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input selectrow" id="selectrow' . $count . '">
                        <label class="custom-control-label" for="selectrow' . $count . '"></label>
                     </div>',
        "RequestID" => $row['RequestID'],
        "ComplaintType" => $row['complaint_type'],
        "Description" => ucfirst($row['Description']),
        "RaisedDate" => $row['RaisedDate'],
        "AdminRemark" => ucfirst($row['AdminRemark']),
        "Status" => $statustype[$row['Status']],
        "ResolvedDate" => $row['ResolvedDate'],
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