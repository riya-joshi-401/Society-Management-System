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
    $orderQuery = ' order by allotments.BlockNumber asc ';
}
$searchValue = $_POST['search']['value']; // Search value

## Search
$searchQuery = "1";
if ($searchValue != '') {
    $searchQuery = "(allotments.BlockNumber like '%" . $searchValue . "%' or
    allotments.FlatNumber like '%" . $searchValue . "%' or
    bill_queue.bill_month like '%" . $searchValue . "%' or bills_paid.Status like '%" . $searchValue . "%'
        or bills_paid.updated_at like '%." . $searchValue . ".%') ";
}

$filterQuery = "1 ";
#filters
if (isset($_POST['filters'])) {
    $filters = $_POST['filters'];

    if (isset($filters['block'])) {
        $filterQuery .= "&& allotments.BlockNumber in(" . "'" . implode("', '", $filters['block']) . "'" . ")" . " ";
    }

    if (isset($filters['fno'])) {
        $filterQuery .= "&& allotments.FlatNumber in(" . "'" . implode("', '", $filters['fno']) . "'" . ")" . " ";
    }

    if (isset($filters['bmonth'])) {
        $filterQuery .= "&& bill_queue.bill_month in(" . "'" . implode("', '", $filters['bmonth']) . "'" . ")" . " ";
    }

}

## Total number of records without filtering
$sel = mysqli_query($con, "select count(*) as totalcount from bills_paid where 1");

$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['totalcount'];

## Total number of record with filtering
$sel = mysqli_query($con, "select count(*) as totalcountfilters from bills_paid inner join bill_queue on bills_paid.BillQueueID=bill_queue.bill_id inner join allotments on bill_queue.FlatID=allotments.FlatID WHERE 1 and " . $searchQuery . "&& (" . $filterQuery . ")");

$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['totalcountfilters'];

## Fetch records

$sql = "select allotments.BlockNumber,allotments.FlatNumber,bill_queue.bill_id, bill_queue.filename,
        bill_queue.bill_month, bills_paid.Receipt,bills_paid.ReceiptName, bills_paid.Status, bills_paid.BillID,
        bills_paid.updated_at from bills_paid inner join bill_queue on bills_paid.BillQueueID = bill_queue.bill_id
        inner join allotments on bill_queue.FlatID = allotments.FlatID WHERE 1
        and " . $searchQuery . "&& (" . $filterQuery . ")" . $orderQuery . " limit " . $row . "," . $rowperpage;
//select allotments.BlockNumber, allotments.FlatNumber,bill_queue.bill_month,bill_queue.data ,bills_paid.Receipt,bills_paid.Status,bills_paid.updated_at from bills_paid inner join bill_queue on bills_paid.BillQueueID=bill_queue.bill_id inner join allotments on bill_queue.FlatID=allotments.FlatID

// echo $sql;

$billRecords = mysqli_query($con, $sql);
$data = array();
$count = 0;
$fullname = "";
while ($row = mysqli_fetch_assoc($billRecords)) {

    $data[] = array(

        // "select-cbox"=>'<input type="checkbox">',
        // "select-cbox" => '<div class="custom-control custom-checkbox">
        //                 <input type="checkbox" class="custom-control-input selectrow" id="selectrow' . $count . '">
        //                 <label class="custom-control-label" for="selectrow' . $count . '"></label>
        //              </div>',
        "BlockNumber" => $row['BlockNumber'],
        "FlatNumber" => $row['FlatNumber'],
        "bill_month" => $row['bill_month'],
        "Bill" => '<a target="_blank" href="viewbillpdf.php?id=' . $row['bill_id'] . '">' . $row['filename'] . '</a>',
        "Receipt" => $row['Receipt'] == '' ? 'No receipt' : '<a target="_blank" href="viewreceiptpdf.php?id=' . $row['BillID'] . '">' . $row['ReceiptName'] . '</a>',
        "Status" => $row['Status'] == '0' ? 'Not Paid' : 'Paid',
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

// select allotments.BlockNumber,allotments.FlatNumber,bill_queue.bill_id, bill_queue.filename,bill_queue.bill_month, bills_paid.Receipt,bills_paid.ReceiptName, bills_paid.Status, bills_paid.BillID, bills_paid.updated_at from bills_paid inner join bill_queue on bills_paid.BillQueueID = bill_queue.bill_id inner join allotments on bill_queue.FlatID = allotments.FlatID WHERE 1 and 1 && (1 && allotments.BlockNumber in ('A') && allotments.FlatNumber in (801) && bill_queue.bill_month in ('Mar 2021') ) order by allotments.BlockNumber asc;