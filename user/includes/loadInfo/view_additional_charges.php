<?php
include_once '../../../config.php';

$draw = $_POST['draw'];
$row = $_POST['start'];
// $flatno = $_SESSION['flatno'];
// $contactno = $_SESSION['contactno'];
// $block = $_SESSION['blockno'];

$rowperpage = $_POST['length']; // Rows display per page
if (isset($_POST['order'])) {
    $columnIndex = $_POST['order'][0]['column']; // Column index
    $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
    $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
    $orderQuery = " order by $columnName $columnSortOrder ";
} else {
    // $columnName='sem';
    // $columnSortOrder='asc';
    $orderQuery = ' order by additional_charges.Updated_at asc ';
}

$searchValue = $_POST['search']['value']; // Search value

## Search
$searchQuery = "1";
if ($searchValue != '') {
    $searchQuery = "(additional_charges.Reason like '%" . $searchValue . "%' or additional_charges.Amount like '%" . $searchValue . "%' or
    additional_charges.Bill_month like '%" . $searchValue . "%' or
    additional_charges.Updated_by like '%" . $searchValue . "%' or additional_charges.Updated_at like '%" . $searchValue . "%') ";
}

$filterQuery = "1 ";

#filters
if (isset($_POST['filters'])) {
    $filters = $_POST['filters'];

    if (isset($filters['reason'])) {
        $filterQuery .= "&& additional_charges.Reason in(" . "'" . implode("', '", $filters['reason']) . "'" . ")" . " ";
    }

    if (isset($filters['bmonth'])) {
        $filterQuery .= "&& additional_charges.Bill_month in(" . "'" . implode("', '", $filters['bmonth']) . "'" . ")" . " ";
    }

}

## Total number of records without filtering
$sel = mysqli_query($con, "select count(*) as totalcount from additional_charges INNER JOIN flats on additional_charges.FlatID=flats.FlatID where flats.BlockNumber='{$_SESSION['blockno']}' and flats.FlatNumber={$_SESSION['flatno']};");

$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['totalcount'];

## Total number of record with filtering 
$sel = mysqli_query($con, "select count(*) as totalcountfilters from additional_charges INNER JOIN flats on additional_charges.FlatID=flats.FlatID where flats.BlockNumber='{$_SESSION['blockno']}' and flats.FlatNumber={$_SESSION['flatno']} and " . $searchQuery . "&& (" . $filterQuery . ")");

$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['totalcountfilters'];

## Fetch records

$sql = "SELECT additional_charges.Amount, additional_charges.Reason, additional_charges.Bill_month,additional_charges.Updated_at,additional_charges.Updated_by from additional_charges inner join flats on additional_charges.FlatID=flats.FlatID where flats.FlatNumber='{$_SESSION['flatno']}' and flats.BlockNumber='{$_SESSION['blockno']}' and "
    . $searchQuery . "&& (" . $filterQuery . ")" . $orderQuery . " limit " . $row . "," . $rowperpage;

$chargeRecords = mysqli_query($con, $sql);
$data = array();
$count = 0;
while ($row = mysqli_fetch_assoc($chargeRecords)) {

    $data[] = array(
        // "select-cbox"=>'<input type="checkbox">',
        "Amount" =>  $row['Amount'],
        "Reason" => $row['Reason'],
        "Bill_month" => $row['Bill_month'],
        "Updated_by" => $row['Updated_by'],
        "Updated_at" => $row['Updated_at'],
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