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
    $orderQuery = ' order by flats.BlockNumber asc ';
}
$searchValue = $_POST['search']['value']; // Search value

## Search
$searchQuery = "1";
if ($searchValue != '') {
    $searchQuery = "(flats.BlockNumber like '%" . $searchValue . "%' or flats.FlatNumber like '%" . $searchValue . "%' or
    flatarea.FlatType like '%" . $searchValue . "%' or
    additional_charges.Amount like '%" . $searchValue . "%' or additional_charges.Reason like '%" . $searchValue . "%' or additional_charges.Bill_month like '%" . $searchValue . "%'
    or additional_charges.Updated_by like '%." . $searchValue . ".%' or additional_charges.Updated_at like '%" . $searchValue . "%') ";
}

$filterQuery = "1 ";
#filters
if (isset($_POST['filters'])) {
    $filters = $_POST['filters'];

    if (isset($filters['block'])) {
        $filterQuery .= "&& flats.BlockNumber in(" . "'" . implode("', '", $filters['block']) . "'" . ")" . " ";
    }

    if (isset($filters['flats'])) {
        $filterQuery .= "&& flats.FlatNumber in(" . "'" . implode("', '", $filters['flats']) . "'" . ")" . " ";
    }

    if (isset($filters['ftype'])) {
        $filterQuery .= "&& flatarea.FlatType in(" . "'" . implode("', '", $filters['ftype']) . "'" . ")" . " ";
    }

    if (isset($filters['bmonth'])) {
        $filterQuery .= "&& additional_charges.Bill_month in(" . "'" . implode("', '", $filters['bmonth']) . "'" . ")" . " ";
    }

    if (isset($filters['reason'])) {
        $filterQuery .= "&& additional_charges.Reason in(" . "'" . implode("', '", $filters['reason']) . "'" . ")" . " ";
    }

}

## Total number of records without filtering
$sel = mysqli_query($con, "select count(*) as totalcount from additional_charges where 1");

$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['totalcount'];

## Total number of record with filtering
$sel = mysqli_query($con, "select count(*) as totalcountfilters from additional_charges inner join flats on additional_charges.FlatID = flats.FlatID inner join flatarea on flatarea.FlatAreaID= flats.FlatAreaID WHERE 1 and " . $searchQuery . "&& (" . $filterQuery . ")");

$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['totalcountfilters'];

## Fetch records

$sql = "select flats.BlockNumber, flats.FlatNumber, flatarea.FlatType, additional_charges.Amount, additional_charges.Reason, additional_charges.Bill_month, additional_charges.Updated_by, additional_charges.Updated_at from additional_charges inner join flats on additional_charges.FlatID = flats.FlatID inner join flatarea on flatarea.FlatAreaID= flats.FlatAreaID WHERE 1 and "
    . $searchQuery . "&& (" . $filterQuery . ")" . $orderQuery . " limit " . $row . "," . $rowperpage;
$chargeRecords = mysqli_query($con, $sql);
$data = array();
$count = 0;
$fullname = "";
while ($row = mysqli_fetch_assoc($chargeRecords)) {

    $data[] = array(

        // "select-cbox"=>'<input type="checkbox">',
        "select-cbox" => '<div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input selectrow" id="selectrow' . $count . '">
                        <label class="custom-control-label" for="selectrow' . $count . '"></label>
                     </div>',
        "BlockNumber" => $row['BlockNumber'],
        "FlatNumber" => $row['FlatNumber'],
        "FlatType" => $row['FlatType'],
        "Amount" => $row['Amount'],
        "Reason" => $row['Reason'],
        "Bill_month" => $row['Bill_month'],
        "Updated_by" => $row['Updated_by'],
        "Updated_at" => $row['Updated_at'],
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