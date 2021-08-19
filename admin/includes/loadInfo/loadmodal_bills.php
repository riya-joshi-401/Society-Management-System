<?php
include_once '../../../config.php';
// echo 'Hi';
$allowed_roles = array("admin");
// if (isset($_SESSION['username']) && in_array($_SESSION['role'], $allowed_roles)) {
// echo 'Hi';

$data = json_decode(file_get_contents("php://input"), true);
$block = mysqli_escape_string($con, $data['BlockNumber']);
$flat = mysqli_escape_string($con, $data['FlatNumber']);
$bmonth = mysqli_escape_string($con, $data['bill_month']);
$receipt_table = mysqli_escape_string($con, $data['Receipt']);
$status = mysqli_escape_string($con, $data['Status']);

$result = mysqli_query($con, "SELECT * FROM `bills_paid` inner join bill_queue on bill_queue.bill_id=bills_paid.BillQueueID inner join flats on bills_paid.FlatID = flats.FlatID where flats.BlockNumber='$block' and flats.FlatNumber='$flat' and bill_queue.bill_month='$bmonth';");
$row = mysqli_fetch_assoc($result);

$receipt = $row['Receipt'];
$receipt_name = $row['ReceiptName'];
$recordID = $row['BillID']; //in bills_paid
$flatid = $row['FlatID'];
$date = date("Y-m-d H:i:s");

echo '<div class="modal fade mymodal" id="update-del-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalCenterTitle1">Action</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                    <div class="modal-body">
                            <!--Update-->

                                <form method="POST" id="update_bill">
                                    <div class="form-row mt-4">
                                        <div class="form-group col-md-6">
                                            <label for="block"><b>Block Number</b></label>
                                            <input type="text" class="form-control"  placeholder="Block Number" name="blockno" value="' . $block . '" readonly>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="flat"><b>Flat Number</b></label>
                                            <input type="text" class="form-control"  placeholder="Flat Number" name="flatno" value="' . $flat . '" readonly>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="bmonth"><b>Bill month</b></label>
                                            <input type="text" class="form-control"  placeholder="bill month" name="bmonth" value="' . $bmonth . '" readonly>
                                        </div>
                                        <div class="col-12" id="error_record">
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="receipt"><b>View Receipt:</b></label>';
if ($receipt_table != 'No receipt') {
    echo '<a target="_blank" href="viewreceiptpdf.php?id=' . $row['BillID'] . '">' . $row['ReceiptName'] . '</a>';
} else {
    echo '<div>No receipt</div>';
}
echo '</div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="ftyp"><b>Change Status</b></label>
                                            <select class="form-control" id="status" name="status_new">

                                                <option value="0" ';
$status == 'Not Paid' ? print("selected") : "";
echo '> Not paid</option>
                                                <option value="1" ';
$status == 'Paid' ? print("selected") : "";
$receipt_table == 'No receipt' ? print("disabled") : "";
echo '> Paid </option>
                                            </select>
                                        </div>
                                        <input type="hidden" name="flatid" value="' . $flatid . '">
                                        <input type="hidden" name="recordid" value="' . $recordID . '">
                                        <input type="hidden" name="timestamp" value="' . $date . '">
                                    </div>


                                    <div class="form-row">
                                        <div class="form-group col-md-6 text-center">
                                            <button type="submit" class="btn btn-primary" id="update_bill_btn" name="update_bill">Update</button>
                                        </div>
                                        <div class="form-group col-md-6 text-center">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal" name="close">Close</button>
                                        </div>
                                    </div>
                                </form>
                                <br>

                            <!--end Update-->

                        </div>
                    </div>
                    </div>
                </div>
            </div>';
// echo 'Hi';

// }