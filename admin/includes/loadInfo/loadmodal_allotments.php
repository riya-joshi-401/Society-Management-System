<?php
// echo 'Hi';
$allowed_roles = array("admin");
// if (isset($_SESSION['username']) && in_array($_SESSION['role'], $allowed_roles)) {
// echo 'Hi';
include_once '../../../config.php';

$data = json_decode(file_get_contents("php://input"), true);
$block = mysqli_escape_string($con, $data['BlockNumber']);
$fno = mysqli_escape_string($con, $data['FlatNumber']);
$isRent = mysqli_escape_string($con, $data['isRent']);
$rname = $remail = $rcontact = $racontact = $rmembers = '';
$timestamp = date("Y-m-d H:i:s");
$updatedby = $_SESSION['username'];
// $updatedby = 'Admin1';
$result = mysqli_query($con, "select AllotmentID, FlatNumber, BlockNumber, OwnerName, OwnerEmail, OwnerContactNumber, OwnerAlternateContactNumber, OwnerMemberCount,isRent, RenteeName, RenteeEmail, RenteeContactNumber, RenteeAlternateContactNumber, RenteeMemberCount, updated_by, updated_at from allotments WHERE BlockNumber='$block' and FlatNumber='$fno' ");
//isRent, RenteeName, RenteeEmail, RenteeContactNumber, RenteeAlternateContactNumber, RenteeMemberCount,
$row = mysqli_fetch_assoc($result);

$oname = $row['OwnerName'];
$ocontact = $row['OwnerContactNumber'];
$oacontact = $row['OwnerAlternateContactNumber'];
$oemail = $row['OwnerEmail'];
$omembers = $row['OwnerMemberCount'];
$recordID = $row['AllotmentID'];
if ($isRent != "No") {
    $rname = $row['RenteeName'];
    $remail = $row['RenteeEmail'];
    $rcontact = $row['RenteeContactNumber'];
    $racontact = $row['RenteeAlternateContactNumber'];
    $rmembers = $row['RenteeMemberCount'];
}

$date = date("Y-m-d H:i:s");
//, Rentee name <i><small><b> ' . $isRent == 1 ? $rname : "-" . '</b></small></i>
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
                                <form id="delete_allotments">
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1"><i class="text-danger">*This will delete all the information related to the flat area</i>
                                            <br>Are you sure you want to delete the record of <br> Block <i><small><b>' . $block . '</b></small></i>
                                            ,Flat Number <i><small><b>' . $fno . '</small></b></i> , Rented Flat? <i><small><b>' . $isRent . ' </b></small></i>
                                            ,Owner name <i><small><b> ' . $oname . '.</b></small></i>

                                        </label>
                                        <br>
                                        <input type="hidden" name="record_id" value="' . $recordID . '">
                                        <div class="row">
                                            <div class="col-md-6 text-left">
                                                <button type="submit" class="btn btn-primary" id="delete_allotments_btn" name="delete_allotments">Yes</button>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal" name="no">No</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!--end Deletion-->


                            <!--Update-->
                            <div class="tab-pane fade" id="nav-update" role="tabpanel" aria-labelledby="nav-update-tab">
                                <form method="POST" id="update_allotments">
                                    <div class="form-row mt-4">
                                        <div class="col-12" id="allotment_error_record"></div>
                                        <div class="col-12" id="other_error_record"></div>
                                        <div class="form-group col-md-6">
                                            <label for="block"><b>Block Number</b></label>
                                            <input type="text" class="form-control"  placeholder="Block Number" name="blockno_new" value="' . $block . '">
                                            <input type="hidden" name="blockno_old" value="' . $block . '">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="fno"><b>Flat Number</b></label>
                                            <input type="text" class="form-control" id="fno" placeholder="Flat Number" name="fno_new" value="' . $fno . '">
                                            <input type="hidden" name="fno_old" value="' . $fno . '">
                                        </div>
                                        <div class="col-12" id="flat_error_record"></div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="block"><b>Owner Name</b></label>
                                            <input type="text" class="form-control"  placeholder="Owner Name" name="oname_new" value="' . $oname . '">
                                            <input type="hidden" name="oname_old" value="' . $oname . '">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="fno"><b>Owner Email</b></label>
                                            <input type="email" class="form-control" placeholder="Owner Email" name="oemail_new" value="' . $oemail . '">
                                            <input type="hidden" name="oemail_old" value="' . $oemail . '">
                                        </div>
                                       </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="block"><b>Owner Contact Number</b></label>
                                            <input type="number" class="form-control"  placeholder="Contact Number" name="ocontact_new" value="' . $ocontact . '">
                                            <input type="hidden" name="ocontact_old" value="' . $ocontact . '">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="fno"><b>Alternate Contact Number</b></label>
                                            <input type="number" class="form-control" id="oacontact" placeholder="Alternate Contact Number" name="oacontact_new" value="' . $oacontact . '">
                                            <input type="hidden" name="oacontact_old" value="' . $oacontact . '">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="fno"><b>Member Count</b></label>
                                            <input type="text" class="form-control" placeholder="Member Count" name="omembers_new" value="' . $omembers . '">
                                            <input type="hidden" name="omembers_old" value="' . $omembers . '">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="isRent"><b>Flat on rent?</b></label>
                                            <select class="form-control" id="isRent" name="isRent">
                                                <option value="1" ';
$isRent == 'Yes' ? print("selected") : "";
echo ' > Yes</option>
                                                <option value="0" ';
$isRent == 'No' ? print("selected") : "";
echo ' > No </option>
                                            </select>
                                            <input type="hidden" class="form-control"  name="recordID" id="recordID" value="' . $recordID . '">
                                        </div>
                                    </div>
                                    <section id="rentee-section">
                                        <div class="form-row justify-content-center my-4 text-center text-success font-weight-bold">-----&nbsp;&nbsp;Rentee Details&nbsp;&nbsp;-----</div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="block"><b>Rentee Name</b></label>
                                                <input type="text" class="form-control"  placeholder="Rentee Name" name="rname_new" value="' . $rname . '">
                                                <input type="hidden" name="rname_old" value="' . $rname . '">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="fno"><b>Rentee Email</b></label>
                                                <input type="email" class="form-control" placeholder="Rentee Email" name="remail_new" value="' . $remail . '">
                                                <input type="hidden" name="remail_old" value="' . $remail . '">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="block"><b>Rentee Contact Number</b></label>
                                                <input type="number" class="form-control"  placeholder="Rentee Contact Number" name="rcontact_new" value="' . $rcontact . '">
                                                <input type="hidden" name="rcontact_old" value="' . $rcontact . '">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="fno"><b>Alternate Contact Number</b></label>
                                                <input type="number" class="form-control" placeholder="Alternate Contact Number" name="racontact_new" value="' . $racontact . '">
                                                <input type="hidden" name="racontact_old" value="' . $racontact . '">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="block"><b>Total Members</b></label>
                                                <input type="number" class="form-control"  placeholder="Rentee Members" name="rmembers_new" value="' . $rmembers . '">
                                            </div>
                                        </div>
                                    </section>
                                    <input type="hidden" name="timestamp" value="' . $timestamp . '">
                                    <input type="hidden" name="updated_by" value="' . $updatedby . '">
                                    <div class="form-row mt-4">
                                        <div class="form-group col-md-6 text-center">
                                            <button type="submit" class="btn btn-primary" id="update_allotments_btn" name="update_allotments">Update</button>
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
            </div>

            <script>

                $(document).ready(function() {
                    renteeFields();
                });

                $("#isRent").change(function() {
                    renteeFields();
                });

                function renteeFields(){
                    // console.log("hi");
                    var isRent = $("#isRent").val();
                    if(isRent=="0"){
                    $("#rentee-section").addClass("d-none");
                    }
                    else{
                    $("#rentee-section").removeClass("d-none");
                    }
            }
            </script>';
// echo 'Hi';

// }