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
    $orderQuery = ' order by BlockNumber asc, FlatNumber asc ';
}
$searchValue = $_POST['search']['value']; // Search value

## Search
$searchQuery = "1";
if ($searchValue != '') {
    $searchQuery = "(FlatNumber like '%" . $searchValue . "%' or BlockNumber like '%" . $searchValue . "%' or
        OwnerName like '%" . $searchValue . "%' or OwnerEmail like '%" . $searchValue . "%'
        or OwnerContactNumber like '%" . $searchValue . "%' or OwnerAlternateContactNumber like '%" . $searchValue . "%' or 
        isRent like '%" . $searchValue . "%' or RenteeName like '%" . $searchValue . "%' or RenteeEmail like '%" . $searchValue . "%'
        or RenteeContactNumber like '%" . $searchValue . "%' or RenteeAlternateContactNumber like '%" . $searchValue . "%'
        or updated_by like '%" . $searchValue . "%' or updated_at like '%" . $searchValue . "%') ";
}
//echo $searchQuery;
$filterQuery = "1";
#filters
if (isset($_POST['filters'])) {
    $filters = $_POST['filters'];
    if (isset($filters['block'])) {
        $filterQuery .= "&& BlockNumber in(" . "'" . implode("', '", $filters['block']) . "'" . ")" . " ";
    }
    if (isset($filters['fno'])) {
        $filterQuery .= "&& FlatNumber in(" . "'" . implode("', '", $filters['fno']) . "'" . ")" . " ";
    }
    if (isset($filters['isRent'])) {
        $filterQuery .= "&& isRent in(" . "'" . implode("', '", $filters['isRent']) . "'" . ")" . " ";
    }
}

## Total number of records without filtering
$sel = mysqli_query($con, "select count(*) as totalcount from allotments f where 1");

$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['totalcount'];

## Total number of record with filtering
$sel = mysqli_query($con, "select count(*) as totalcountfilters from allotments f WHERE 1 and " . $searchQuery . "&& (" . $filterQuery . ")");

$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['totalcountfilters'];

## Fetch records

$sql = "select FlatNumber, BlockNumber, OwnerName, OwnerEmail, OwnerContactNumber, OwnerAlternateContactNumber, OwnerMemberCount, isRent, RenteeName, RenteeEmail, RenteeContactNumber, RenteeAlternateContactNumber, RenteeMemberCount, updated_by, updated_at from allotments f WHERE 1 and "
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
        "FlatNumber" => $row['FlatNumber'],
        "BlockNumber" => $row['BlockNumber'],
        "OwnerName" => $row['OwnerName'],
        "OwnerEmail" => $row['OwnerEmail'],
        "OwnerContactNumber" => $row['OwnerContactNumber'],
        "OwnerAlternateContactNumber" => $row['OwnerAlternateContactNumber'],
        "OwnerMemberCount" => $row["OwnerMemberCount"],
        "isRent" => $row['isRent'] == 0 ? 'No' : "Yes",
        "RenteeName" => $row['isRent'] == 0 ? '-' : $row['RenteeName'],
        "RenteeEmail" => $row['isRent'] == 0 ? '-' : $row['RenteeEmail'],
        "RenteeContactNumber" => $row['isRent'] == 0 ? '-' : $row['RenteeContactNumber'],
        "RenteeAlternateContactNumber" => $row['isRent'] == 0 ? '-' : $row['RenteeAlternateContactNumber'],
        "RenteeMemberCount" => $row['isRent'] == 0 ? '-' : $row['RenteeMemberCount'],
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