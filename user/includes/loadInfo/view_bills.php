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
    $orderQuery = ' order by bill_queue.bill_month asc ';
}

$searchValue = $_POST['search']['value']; // Search value

## Search
$searchQuery = "1";
if ($searchValue != '') {
    $searchQuery = "(bill_queue.bill_month like '%" . $searchValue . "%' or bills_paid.Status like '%" . $searchValue . "%' or
    bills_paid.ReceiptName like '%" . $searchValue . "%' or
    bills_paid.updated_at like '%" . $searchValue . "%') ";
}

$filterQuery = "1 ";

#filters
if (isset($_POST['filters'])) {
    $filters = $_POST['filters'];

    if (isset($filters['status'])) {
        $filterQuery .= "&& bills_paid.Status in(" . "'" . implode("', '", $filters['status']) . "'" . ")" . " ";
    }

    if (isset($filters['bmonth'])) {
        $filterQuery .= "&& bill_queue.bill_month in(" . "'" . implode("', '", $filters['bmonth']) . "'" . ")" . " ";
    }

}

## Total number of records without filtering
$sel = mysqli_query($con, "select count(*) as totalcount from bills_paid INNER JOIN bill_queue on bills_paid.BillQueueID=bill_queue.bill_id inner join flats on bills_paid.FlatID=flats.FlatID where flats.BlockNumber='{$_SESSION['blockno']}' and flats.FlatNumber={$_SESSION['flatno']};");

$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['totalcount'];

## Total number of record with filtering
$sel = mysqli_query($con, "select count(*) as totalcountfilters from bills_paid INNER JOIN bill_queue on bills_paid.BillQueueID=bill_queue.bill_id inner join flats on bills_paid.FlatID=flats.FlatID where flats.BlockNumber='{$_SESSION['blockno']}' and flats.FlatNumber={$_SESSION['flatno']} and " . $searchQuery . "&& (" . $filterQuery . ")");

$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['totalcountfilters'];

## Fetch records

$sql = "SELECT bill_queue.bill_id, bill_queue.bill_month, bill_queue.data,bill_queue.filename, bills_paid.BillID,bills_paid.Receipt,bills_paid.ReceiptName,bills_paid.Status,bills_paid.updated_at from bills_paid INNER JOIN bill_queue on bills_paid.BillQueueID=bill_queue.bill_id inner join flats on bills_paid.FlatID=flats.FlatID where flats.FlatNumber='{$_SESSION['flatno']}' and flats.BlockNumber='{$_SESSION['blockno']}' and "
    . $searchQuery . "&& (" . $filterQuery . ")" . $orderQuery . " limit " . $row . "," . $rowperpage;

$chargeRecords = mysqli_query($con, $sql);
$data = array();
$count = 0;
while ($row = mysqli_fetch_assoc($chargeRecords)) {

    $data[] = array(
        // "select-cbox"=>'<input type="checkbox">',
        "bill_month" => $row['bill_month'],
        "Bill" => '<a target="_blank" href="viewbillpdf.php?id=' . $row['bill_id'] . '">' . $row['filename'] . '</a>',
        "Receipt" => $row['Receipt'] == '' ? 'No receipt' : '<a target="_blank" href="viewreceiptpdf.php?id=' . $row['BillID'] . '">' . $row['ReceiptName'] . '</a>',
        "Status" => $row['Status'] == '0' ? 'Not Paid' : 'Paid',
        "updated_at" => $row['updated_at'],
        "Action" => '<!-- Button trigger modal -->
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