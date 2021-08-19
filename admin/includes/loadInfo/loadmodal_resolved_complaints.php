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
                                            <label><i class="text-danger mx-auto">*The admin can only view resolved complaints.</i></label>
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
                                                        <tr>
                                                            <th scope="col"> Admin Remark: </th>
                                                            <td> ' . $adminRemark . ' </td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="col"> Resolved On: </th>
                                                            <td> ' . $resolveddate . ' </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6 text-center">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal" name="close">Okay</button>
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