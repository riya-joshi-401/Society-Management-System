<?php
include_once '../../../config.php';
// echo 'Hi';
$allowed_roles = array("admin");
// if (isset($_SESSION['username']) && in_array($_SESSION['role'], $allowed_roles)) {
// echo 'Hi';

$data = json_decode(file_get_contents("php://input"), true);
$block = mysqli_escape_string($con, $data['BlockNumber']);
$fno = mysqli_escape_string($con, $data['FlatNumber']);
//$ftype = mysqli_escape_string($con, $data['FlatType']);
$floor = mysqli_escape_string($con, $data['Floor']);
$result = mysqli_query($con, "select FlatID,FlatNumber,BlockNumber,Floor,FlatAreaID from flats WHERE BlockNumber='$block' and FlatNumber='$fno'");
$row = mysqli_fetch_assoc($result);
$recordID = $row['FlatID'];
$flatareaID = $row['FlatAreaID'];
echo "<script>console.log($recordID)</script>";
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
                                <form id="delete_flats">
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1"><i class="text-danger">*This will delete all the information related to the Flat</i>
                                            <br>Are you sure you want to delete the record of <br> Block <i><small><b>' . $block . '</b></small></i>
                                            ,Flat Number <i><small><b>' . $fno . '</small></b></i> ,Floor <i><small><b>' . $floor . '</b></small></i>
                                            ?
                                        </label>
                                        <br>
                                        <input type="hidden" name="record_id" value="' . $recordID . '">
                                        <div class="row">
                                            <div class="col-md-6 text-left">
                                                <button type="submit" class="btn btn-primary" id="delete_flats_btn" name="delete_flats">Yes</button>
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
                                <form method="POST" id="update_flats">
                                    <div class="form-row mt-4">
                                        <div class="form-group col-md-6">
                                            <label for="block"><b>Block Number</b></label>
                                            <input type="text" class="form-control"  placeholder="Block Number" name="blockno_new" value="' . $block . '">
                                            <input type="hidden" class="form-control"  name="blockno_old" id="blockno_old" value="' . $block . '">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="seri"><b>Flat Number</b></label>
                                            <input type="number" class="form-control"  placeholder="Flat Number" name="number_new" value="' . $fno . '">
                                            <input type="hidden" class="form-control"  name="number_old" id="number_old" value="' . $fno . '">
                                        </div>
                                        <div class="col-12" id="error_record" class="text-danger">

                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="areaf"><b>Floor</b></label>
                                            <input type="number" class="form-control"  placeholder="Floor" name="floor_new" value="' . $floor . '">
                                            <input type="hidden" class="form-control" name="floor_old" value="' . $floor . '">
                                            <input type="hidden" class="form-control"  name="recordID" id="recordID" value="' . $recordID . '">
                                            <input type="hidden" class="form-control"  name="flatareaID" id="flatareaID" value="' . $flatareaID . '">

                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-6 text-center">
                                            <button type="submit" class="btn btn-primary" id="update_flats_btn" name="update_flats">Update</button>
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