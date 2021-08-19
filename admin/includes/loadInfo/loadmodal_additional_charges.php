<?php
include_once '../../../config.php';

$allowed_roles = array("admin");
// if (isset($_SESSION['username']) && in_array($_SESSION['role'], $allowed_roles)) {
// echo 'Hi';

$data = json_decode(file_get_contents("php://input"), true);
$block = mysqli_escape_string($con, $data['BlockNumber']);
$flat = mysqli_escape_string($con, $data['FlatNumber']);
$ftype = mysqli_escape_string($con, $data['FlatType']);
$amount = mysqli_escape_string($con, $data['Amount']);
$reason = mysqli_escape_string($con, $data['Reason']);
$bmonth = mysqli_escape_string($con, $data['Bill_month']);
$updatedby = mysqli_escape_string($con, $data['Updated_by']);
$updatedat = mysqli_escape_string($con, $data['Updated_at']);
$flatid_sql = mysqli_query($con, "SELECT FlatID from flats where FlatNumber='$flat' and BlockNumber='$block'");
$flatid_row = mysqli_fetch_assoc($flatid_sql);
$flatid = $flatid_row['FlatID'];
$result = mysqli_query($con, "SELECT ChargeID from additional_charges where FlatID='$flatid' and Amount='$amount' and Bill_month='$bmonth' and Updated_at='$updatedat' and Updated_by='$updatedby'");
$row = mysqli_fetch_assoc($result);
$recordID = $row['ChargeID'];
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
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link active" id="nav-delete-tab" data-toggle="tab" href="#nav-delete" role="tab" aria-controls="nav-delete" aria-selected="true">Deletion</a>
                                <a class="nav-item nav-link" id="nav-update-tab" data-toggle="tab" href="#nav-update" role="tab" aria-controls="nav-update" aria-selected="false">Update</a>
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <!--Deletion-->
                            <div class="tab-pane fade show active" id="nav-delete" role="tabpanel" aria-labelledby="nav-delete-tab">
                                <form id="delete_additional_charges">
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1"><i class="text-danger">*This will delete all the information related to the flat area</i>
                                            <br>Are you sure you want to delete the record of <br> Flat <i><small><b>' . $block . '-' . $flat . '</b></small></i>
                                            ,Additonal Charges Rs.<i><small><b>' . $amount . '</b></small></i> for the Reason <i><small><b>' . $reason . '</b></small></i>
                                            ,Bill Month<i><small><b>' . $bmonth . '</b></small></i> ?
                                        </label>
                                        <br>
                                        <input type="hidden" name="record_id" value="' . $recordID . '">
                                        <div class="row">
                                            <div class="col-md-6 text-left">
                                                <button type="submit" class="btn btn-primary" id="delete_charges_btn" name="delete_charges">Yes</button>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal" name="no">No</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!--end Deletion-->

                            <!--Update-->
                            <div class="tab-pane fade" id="nav-update" role="tabpanel" aria-labelledby="nav-update-tab">
                                <form method="POST" id="update_charges">
                                    <div class="col-12 pt-2" id="error_record">
                                    </div>
                                    <div class="form-row mt-4">
                                        <div class="form-group col-md-6">
                                            <label for="block"><b>Block Number</b></label>
                                            <input type="text" class="form-control"  placeholder="Block Number" name="blockno_new" value="' . $block . '" required>
                                            <input type="hidden" name="blockno_old" value="' . $block . '">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="seri"><b>Flat Number</b></label>
                                            <input type="text" class="form-control"  placeholder="Flat Number" name="flatno_new" value="' . $flat . '" required>
                                            <input type="hidden" name="flatno_old" value="' . $flat . '">
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="areaf"><b>Additional Charges</b></label>
                                            <input type="text" class="form-control"  placeholder="Additional Charges" name="charges_new" value="' . $amount . '" required>
                                            <input type="hidden" name="charges_old" value="' . $amount . '">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="frate"><b>Reason</b></label>
                                            <input type="text" class="form-control" required="required" placeholder="Reason" name="reason_new" id="reason_new" value="' . $reason . '">
                                            <input type="hidden" name="reason_old" value="' . $reason . '">

                                            <input type="hidden"  name="recordID" id="recordID" value="' . $recordID . '">
                                            <input type="hidden"  name="timestamp" value="' . $date . '">
                                            <input type="hidden"  name="updatedby" value="' . $_SESSION['username'] . '">
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-6 text-center">
                                            <button type="submit" class="btn btn-primary" id="update_charges_btn" name="update_charges">Update</button>
                                        </div>
                                        <div class="form-group col-md-6 text-center">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal" name="close">Close</button>
                                        </div>
                                    </div>
                                </form>
                                <br>
                            </div>
                            <!--end Update-->

                        </div>
                    </div>
                    </div>
                </div>
            </div>';
// echo 'Hi';

// }