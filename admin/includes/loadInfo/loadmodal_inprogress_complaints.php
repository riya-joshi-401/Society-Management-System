<?php
include_once '../../../config.php';

// echo 'Hi';
$allowed_roles = array("admin");
// if (isset($_SESSION['username']) && in_array($_SESSION['role'], $allowed_roles)) {
// echo 'Hi';

$data = json_decode(file_get_contents("php://input"), true);
$ctype = mysqli_escape_string($con, $data['ComplaintType']);
$cdesc = mysqli_escape_string($con, $data['Description']);
$raiseddate = mysqli_escape_string($con, $data['RaisedDate']);
$adminRemark = mysqli_escape_string($con, $data['AdminRemark']);
$status = mysqli_escape_string($con, $data['Status']);
$resolveddate = mysqli_escape_string($con, $data['ResolvedDate']);
$requestID = mysqli_escape_string($con, $data['RequestID']);

$result = mysqli_query($con, "select FlatNumber,BlockNumber,complaint_type,ComplaintType,Description,RaisedDate,AdminRemark,Status,ResolvedDate,updated_at FROM complaints inner join complainttypes on complainttypes.complaint_id = complaints.ComplaintType WHERE RequestID=" . $requestID . "");
$row = mysqli_fetch_assoc($result);
$cid = $row['ComplaintType'];
$date = date("Y-m-d H:i:s");
$block = $row['BlockNumber'];
$flat = $row['FlatNumber'];

$statusarray = array("1" => "In-progress", "2" => "Resolved");

echo '<div class="modal fade mymodal" id="update-del-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle1" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalCenterTitle1">Action</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                            <!--Update-->
                        <div class="modal-body">
                                <form method="POST" id="update_complaints">
                                    <div class="form-row mt-4">
                                        <div class="form-group col-md-12">
                                            <label><i class="text-danger mx-auto">*The admin shall select the status and provide his remark.</i></label>
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <tbody>
                                                        <tr>
                                                            <th scope="col"> RequestID: </th>
                                                            <td> ' . $requestID . ' </td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="col"> Complaint Type: </th>
                                                            <td> ' . $ctype . ' </td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="col"> Complaint Raised on: </th>
                                                            <td> ' . $raiseddate . ' </td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="col"> Complaint Raised by: </th>
                                                            <td> ' . $block . '-' . $flat . ' </td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="col"> Complaint Description: </th>
                                                            <td> ' . $cdesc . ' </td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="col"> Complaint Status: </th>
                                                            <td> ' . $status . ' </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>

                                            <label for="block"><b>Change Status:</b></label>
                                            <select class="form-control" name="status_new" required>';
foreach ($statusarray as $i => $value) {
    if ($i == '1') {
        echo "<option value= '" . $i . "' selected>" . $value . "</option>";
    } else {
        echo "<option value= '" . $i . "'>" . $value . "</option>";
    }
}
echo '  </select>
                                    <input type="hidden" name="status_old" value="' . $status . '">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="cdesc_new"><b>Admin Remark</b></label>
                                        <textarea class="form-control" id="admin_remark" name="remark_new"
                                        placeholder="Enter admin remark...." rows="5" required></textarea>
                                        <input type="hidden" name="remark_old" value="' . $adminRemark . '">
                                        <input type="hidden" class="form-control" name="recordID" id="recordID" value="' . $requestID . '">
                                        <input type="hidden" class="form-control" name="blockno" id="blockno" value="' . $block . '">
                                        <input type="hidden" class="form-control" name="flatno" id="flatno" value="' . $flat . '">
                                        <input type="hidden" name="timestamp" value="' . $date . '">

                                    </div>
                                    <div class="col-12" id="error_record">
                                    </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6 text-center">
                                            <button type="submit" class="btn btn-primary" id="update_inprogress_complaints" name="update_inprogress_complaints">Update</button>
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