<?php
// echo 'Hi';
$allowed_roles = array("admin");
// if (isset($_SESSION['username']) && in_array($_SESSION['login_role'], $allowed_roles)) {
// echo 'Hi';
include_once '../../../config.php';

$data = json_decode(file_get_contents("php://input"), true);
$ctype = mysqli_escape_string($con, $data['ComplaintType']);
$cdesc = mysqli_escape_string($con, $data['Description']);
$raiseddate = mysqli_escape_string($con, $data['RaisedDate']);
$adminRemark = mysqli_escape_string($con, $data['AdminRemark']);
$status = mysqli_escape_string($con, $data['Status']);
$resolveddate = mysqli_escape_string($con, $data['ResolvedDate']);
$requestID = mysqli_escape_string($con, $data['RequestID']);
$flatno = $_SESSION['flatno'];
// $contactno = $_SESSION['contactno'];
// $contactno = '9029996333';
// $flatno = '802';

$result = mysqli_query($con, "select complaint_type,ComplaintType,Description,RaisedDate,AdminRemark,Status,ResolvedDate,updated_at FROM complaints inner join complainttypes on complainttypes.complaint_id = complaints.ComplaintType WHERE FlatNumber=" . $flatno . " and RequestID=" . $requestID . "");
$row = mysqli_fetch_assoc($result);
$cid = $row['ComplaintType'];
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
                                <form id="delete_complaints">
                                    <div class="form-group">
                                        <label>
                                            <i class="text-danger">*You can only delete the complaints that are not resolved.</i>
                                        </label>
                                        <label for="exampleFormControlSelect1"><i class="text-danger">*This will delete all the information related to the complaint</i>
                                            <br>Are you sure you want to delete your complaint of <br><i><small><b>' . $ctype . '</b></small></i>
                                            ,Raised On <i><small><b>' . $raiseddate . '</small></b></i> ,with the staus <i><small><b>' . $status . '</b></small></i>?
                                        </label>
                                        <br>
                                        <input type="hidden" name="record_id" value="' . $requestID . '">
                                        <input type="hidden" name="status" value="' . $status . '">
                                        <div class="row">
                                            <div class="col-md-6 text-left">
                                                <button type="submit" class="btn btn-primary" id="delete_complaints_btn" name="delete_complaints">Yes</button>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal" name="no">No</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!--end Deletion-->

                            <!--Update-->
                            <div class="tab-pane fade" id="nav-update" role="tabpanel" aria-labelledby="nav-update-tab">
                                <form method="POST" id="update_complaints">
                                    <div class="form-row mt-4">
                                        <div class="form-group col-md-12">
                                            <label><i class="text-danger mx-auto">*You can only change the complaint type and discription if the complaint is unresolved</i></label>
                                            <label for="block"><b>Complaint Type</b></label>
                                            <select class="form-control" name="ctype_new" aria-describedby="typeHelp" required>';

$sql = "SELECT * from complainttypes";
$res = mysqli_query($con, $sql);
while ($row = mysqli_fetch_array($res)) {
    if ($cid == $row['complaint_id']) {
        echo "<option value= '" . $row['complaint_type'] . "' selected>" . $row['complaint_type'] . "</option>";
    } else {
        echo "<option value= '" . $row['complaint_type'] . "'";
        if ($status != "Unresolved") {
            echo "disabled";
        }
        echo " >" . $row['complaint_type'] . "</option>";
    }

}

echo '  </select>
                                    <input type="hidden" name="ctype_old" value="' . $ctype . '">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="cdesc_new"><b>Complaint Description</b></label>
                                        <textarea class="form-control" id="complaint_desc" name="cdesc_new"
                                        placeholder="Enter complaint description...." rows="5" required';

if ($status != "Unresolved") {
    echo "disabled";
}

echo '
                                        >' . $cdesc . '</textarea>
                                        <input type="hidden" name="cdesc_old" value="' . $cdesc . '">
                                        <input type="hidden" class="form-control" name="recordID" id="recordID" value="' . $requestID . '">
                                        <input type="hidden" name="timestamp" value="' . $date . '">
                                    </div>
                                    <div class="col-12" id="error_record">
                                    </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6 text-center">
                                            <button type="submit" class="btn btn-primary" id="update_complaints_btn" name="update_complaints">Update</button>
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

// }