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
    $orderQuery = ' order by SecurityID asc ';
}
$searchValue = $_POST['search']['value']; // Search value

## Search 
$searchQuery = "1";
if ($searchValue != '') {
    $searchQuery = "(SecurityID like '%" . $searchValue . "%' or 
        Name like '%" . $searchValue . "%' or 
        ContactNumber like '%" . $searchValue . "%' or Shift like '%" . $searchValue . "%') ";
}

$filterQuery = "1 ";
#filters
if (isset($_POST['filters'])) {
    $filters = $_POST['filters'];

    if (isset($filters['SecurityID'])) {
        $filterQuery .= "&& SecurityID in(" . "'" . implode("', '", $filters['SecurityID']) . "'" . ")" . " ";
    }

    if (isset($filters['Name'])) {
        $filterQuery .= "&& Name in(" . "'" . implode("', '", $filters['Name']) . "'" . ")" . " ";
    }

    if (isset($filters['ContactNumber'])) {
        $filterQuery .= "&& ContactNumber in(" . "'" . implode("', '", $filters['ContactNumber']) . "'" . ")" . " ";
    }
    if (isset($filters['Shift'])) {
        $filterQuery .= "&& Shift in(" . "'" . implode("', '", $filters['Shift']) . "'" . ")" . " ";
    }
}

## Total number of records without filtering
$sel = mysqli_query($con, "select count(*) as totalcount from security s where 1");

$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['totalcount'];

## Total number of record with filtering
$sel = mysqli_query($con, "select count(*) as totalcountfilters from security s WHERE 1 and " . $searchQuery . "&& (" . $filterQuery . ")");

$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['totalcountfilters'];

## Fetch records

$sql = "select SecurityID,Name,ContactNumber,Shift,updated_at from security s WHERE 1 and "
    . $searchQuery . "&& (" . $filterQuery . ")" . $orderQuery . " limit " . $row . "," . $rowperpage;
$areaRecords = mysqli_query($con, $sql);
$data = array();
$count = 0;
$fullname = "";
while ($row = mysqli_fetch_assoc($areaRecords)) {

    $data[] = array(

        // "select-cbox"=>'<input type="checkbox">',
        "select-cbox" => '<div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input selectrow" id="selectrow' . $count . '">
                        <label class="custom-control-label" for="selectrow' . $count . '"></label>
                     </div>',
        "SecurityID" => $row['SecurityID'],
        "Name" => $row['Name'],
        "ContactNumber" => $row['ContactNumber'],
        "Shift" => $row['Shift'],
        "updated_at" => $row['updated_at'],
        //"updated_at" => $row['updated_at'],
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
    "aaData" => $data
);

echo json_encode($response);