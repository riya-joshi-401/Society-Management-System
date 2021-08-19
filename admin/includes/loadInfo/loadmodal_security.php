<?php
// echo 'Hi';
include_once '../../../config.php';
$allowed_roles = array("admin");
// if (isset($_SESSION['username']) && in_array($_SESSION['role'], $allowed_roles)) {
// echo 'Hi';

$data = json_decode(file_get_contents("php://input"), true);
$securityid = mysqli_escape_string($con, $data['SecurityID']);
$name = mysqli_escape_string($con, $data['Name']);
$contactnumber = mysqli_escape_string($con, $data['ContactNumber']);
$shift = mysqli_escape_string($con, $data['Shift']);
$result = mysqli_query($con, "select SecurityID,Name,ContactNumber,Shift from security WHERE SecurityID='$securityid' and Name='$name' and ContactNumber='$contactnumber' and Shift='$shift'");
$row = mysqli_fetch_assoc($result);
$date = date("Y-m-d H:i:s");
//echo "<script>console.log('in loadmodal')</script>";

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
                                <form id="delete_security">
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1"><i class="text-danger">*This will delete all the information related to the security guard</i>
                                            <br>Are you sure you want to delete the record of <br> SecurityID <i><small><b>' . $securityid . '</b></small></i>
                                            ,Name <i><small><b>' . $name . '</small></b></i> ,ContactNumber <i><small><b>' . $contactnumber . '</b></small></i>
                                            ,Shift <i><small><b>' . $shift . '</b></small></i> ?
                                        </label>
                                        <br>
                                        <input type="hidden" name="security_id" value="' . $securityid . '">
                                        <div class="row">
                                            <div class="col-md-6 text-left">
                                                <button type="submit" class="btn btn-primary" id="delete_security_btn" name="delete_security">Yes</button>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal" name="no">No</button>
                                            </div>
                                            <div class="col-md-6 text-right">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal" name="close">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!--end Deletion-->


                            <!--Update-->
                            <div class="tab-pane fade" id="nav-update" role="tabpanel" aria-labelledby="nav-update-tab">
                                <form method="POST" id="update_security">
                                    <div class="form-row mt-4">
                                        <div class="form-group col-md-6">
                                            <label for="name"><b>Name</b></label>
                                            <input type="text" class="form-control"  placeholder="Name" name="name_new" value="' . $name . '">
                                            <input type="hidden" class="form-control"  name="name_old" value="' . $name . '">
                                        </div>
                                        <div class="col-12" id="error_record" class="text-danger">

                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="contactnumber"><b>Contact Number</b></label>
                                            <input type="text" class="form-control"  placeholder="Contact Number" name="contactnumber_new" value="' . $contactnumber . '">
                                            <input type="hidden" name="contactnumber_old" value="' . $contactnumber . '">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="shift"><b>Shift</b></label>
                                            <input type="text" class="form-control" required="required" placeholder="Shift" name="shift_new" value="' . $shift . '">
                                            <input type="hidden" class="form-control"  name="shift_old" value="' . $shift . '">
                                        </div>
                                    </div>
                                    <input type="hidden" name="security_id" value="' . $securityid . '">
                                    <div class="form-row">
                                        <div class="form-group col-md-6 text-center">
                                            <button type="submit" class="btn btn-primary" id="update_security_btn" name="update_security">Update</button>
                                        </div>
                                        <div class="form-group col-md-6 text-center">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal" name="close">Close</button>
                                        </div>
                                    </div>
                                </form>
                                <br>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>';
// echo 'Hi';

// }