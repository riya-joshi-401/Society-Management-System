<?php
include_once '../../../config.php';
// echo 'Hi';
$allowed_roles = array("admin");
// if (isset($_SESSION['username']) && in_array($_SESSION['role'], $allowed_roles)) {
// echo 'Hi';

$data = json_decode(file_get_contents("php://input"), true);
$block = mysqli_escape_string($con, $data['BlockNumber']);
$fseries = mysqli_escape_string($con, $data['FlatSeries']);
$ftype = mysqli_escape_string($con, $data['FlatType']);
$result = mysqli_query($con, "select FlatAreaID,BlockNumber,FlatSeries,FlatType,FlatArea,Ratepsq from flatarea WHERE BlockNumber='$block' and FlatSeries='$fseries' and FlatType='$ftype'");
$row = mysqli_fetch_assoc($result);
$farea = $row['FlatArea'];
$rate = $row['Ratepsq'];
$recordID = $row['FlatAreaID'];
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
                                <form id="delete_flatarea">
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1"><i class="text-danger">*This will delete all the information related to the flat area</i>
                                            <br>Are you sure you want to delete the record of <br> Block <i><small><b>' . $block . '</b></small></i>
                                            ,Series <i><small><b>' . $fseries . '</small></b></i> ,flat area <i><small><b>' . $farea . ' sq.ft.</b></small></i>
                                            ,maintanence rate <i><small><b> Rs.' . $rate . '/sqft.</b></small></i> ?
                                        </label>
                                        <br>
                                        <input type="hidden" name="record_id" value="' . $recordID . '">
                                        <div class="row">
                                            <div class="col-md-6 text-left">
                                                <button type="submit" class="btn btn-primary" id="delete_flatarea_btn" name="delete_flatarea">Yes</button>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal" name="no">No</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!--end Deletion-->


                            <!--Update-->
                            <div class="tab-pane fade" id="nav-update" role="tabpanel" aria-labelledby="nav-update-tab">
                                <form method="POST" id="update_flatarea">
                                    <div class="form-row mt-4">
                                        <div class="form-group col-md-6">
                                            <label for="block"><b>Block Number</b></label>
                                            <input type="text" class="form-control"  placeholder="Block Number" name="blockno_new" value="' . $block . '">
                                            <input type="hidden" name="blockno_old" value="' . $block . '">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="seri"><b>Flat Series</b></label>
                                            <input type="text" class="form-control"  placeholder="Flat Series" name="series_new" value="' . $fseries . '">
                                            <input type="hidden" name="series_old" value="' . $fseries . '">
                                        </div>
                                        <div class="col-12" id="error_record">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="areaf"><b>Flat Area</b></label>
                                            <input type="text" class="form-control"  placeholder="Flat Area" name="area_new" value="' . $farea . '">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="frate"><b>Maintenance Rate</b></label>
                                            <input type="text" class="form-control" required="required" placeholder="New Rate" name="rate_new" id="rate_new" value="' . $rate . '">
                                            <input type="hidden" class="form-control"  name="recordID" id="recordID" value="' . $recordID . '">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="ftyp"><b>Flat Type</b></label>
                                            <select class="form-control" id="flattype_new" name="flattype_new">
                                                <option value="1BHK" ';
$ftype == '1BHK' ? print("selected") : "";
echo ' > 1BHK</option>
                                                <option value="2BHK" ';
$ftype == '2BHK' ? print("selected") : "";
echo ' > 2BHK </option>
                                                <option value="3BHK" ';
$ftype == '3BHK' ? print("selected") : "";
echo ' > 3BHK </option>
                                                <option value="4BHK" ';
$ftype == '4BHK' ? print("selected") : "";
echo ' > 4BHK </option>
                                                <option value="other" ';
$ftype == 'other' ? print("selected") : "";
echo ' > other </option>
                                            </select>
                                        </div>
                                        <input type="hidden" name="timestamp" value="' . $date . '">
                                    </div>


                                    <div class="form-row">
                                        <div class="form-group col-md-6 text-center">
                                            <button type="submit" class="btn btn-primary" id="update_flatarea_btn" name="update_flatarea">Update</button>
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