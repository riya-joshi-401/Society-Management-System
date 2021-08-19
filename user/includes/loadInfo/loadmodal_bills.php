<?php
include_once '../../../config.php';
// echo 'Hi';
$allowed_roles = array("admin");
// if (isset($_SESSION['username']) && in_array($_SESSION['login_role'], $allowed_roles)) {
// echo 'Hi';

$data = json_decode(file_get_contents("php://input"), true);
$bmonth = mysqli_escape_string($con, $data['bill_month']);
$receipt_table = mysqli_escape_string($con, $data['Receipt']);
$status = mysqli_escape_string($con, $data['Status']);

$result = mysqli_query($con, "SELECT * FROM `bills_paid` inner join bill_queue on bill_queue.bill_id=bills_paid.BillQueueID inner join flats on bills_paid.FlatID = flats.FlatID where flats.FlatNumber='{$_SESSION['flatno']}' and flats.BlockNumber='{$_SESSION['blockno']}';");
$row = mysqli_fetch_assoc($result);

$receipt = $row['Receipt']; //the pdf blob
$receipt_name = $row['ReceiptName']; //name of the file
$recordID = $row['BillID']; //in bills_paid
$flatid = $row['FlatID']; //in flats
$date = date("Y-m-d H:i:s"); //timestamp
$temp = "input[type='file']";

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

                                <form method="POST" enctype="multipart/form-data" id="update_bills">
                                    <div class="form-row mt-4">
                                        <div class="form-group col-md-12">
                                            <label for="bmonth"><b>Bill month</b></label>
                                            <input type="text" class="form-control"  placeholder="bill month" name="bmonth" value="' . $bmonth . '" readonly>
                                        </div>
                                        <div class="col-12" id="error_record">
                                        </div>';

if ($receipt_table != 'No receipt') {
    echo '<label for="receipt"> <b>Previous Receipt: </b></label><br>
                                                                                    <a target="_blank" href="viewreceiptpdf.php?id=' . $row['BillID'] . '">' . $row['ReceiptName'] . '</a>';
}
echo '<br>
                                            <div class="form-group col-12 files color">
                                            <label for="receipt"><b>Upload Receipt:</b></label>
                                                <!-- <input type="file" class="form-control" accept=".pdf,.pdf"> -->
                                                <script type="text/javascript" language="javascript">
                                                function checkfile(sender) {
                                                    var validExts = new Array(".pdf");
                                                    var fileExt = sender.value;
                                                    fileExt = fileExt.substring(fileExt.lastIndexOf("."));
                                                    console.log(fileExt);
                                                    if (validExts.indexOf(fileExt) < 0) {
                                                        alert("Invalid file selected, valid files are of " +
                                                            validExts.toString() + " types.");
                                                        return false;
                                                    } else return true;
                                                }
                                                </script>
                                                <input type="file" id="Uploadfile" name="Uploadfile" class="form-control"
                                                    onchange="checkfile(this);"
                                                    accept="application/pdf"
                                                    required >
                                                <label for=""><b>Accepted format .pdf only.</b></label>
                                            </div>';

echo '
                                    </div>
                                    <div class="form-row">
                                        <input type="hidden" name="receiptname" value="' . $_SESSION['blockno'] . '-' . $_SESSION['flatno'] . '-' . $bmonth . '-Receipt">
                                        <input type="hidden" name="flatid" value="' . $flatid . '">
                                        <input type="hidden" name="bmonth" value="' . $bmonth . '">
                                        <input type="hidden" name="recordid" value="' . $recordID . '">
                                        <input type="hidden" name="timestamp" value="' . $date . '">
                                    </div>
                                    <h4></h4>

                                    <div class="form-row">
                                        <div class="form-group col-md-6 text-center">
                                            <button type="submit" class="btn btn-primary" id="update_bills_btn" name="update_bills_btn">Update</button>
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
            </div>
            <style type="text/css">
                                .files input {
                                    outline: 2px dashed #92b0b3;
                                    outline-offset: -10px;
                                    -webkit-transition: outline-offset .15s ease-in-out, background-color .15s linear;
                                    transition: outline-offset .15s ease-in-out, background-color .15s linear;
                                    padding: 120px 0px 85px 35%;
                                    text-align: center !important;
                                    margin: 0;
                                    width: 100% !important;
                                }

                                .files input:focus {
                                    outline: 2px dashed #92b0b3;
                                    outline-offset: -10px;
                                    -webkit-transition: outline-offset .15s ease-in-out, background-color .15s linear;
                                    transition: outline-offset .15s ease-in-out, background-color .15s linear;
                                    border: 1px solid #92b0b3;
                                }

                                .files {
                                    position: relative
                                }

                                .files:after {
                                    pointer-events: none;
                                    position: absolute;
                                    top: 60px;
                                    left: 0;
                                    width: 50px;
                                    right: 0;
                                    height: 56px;
                                    content: "";
                                    background-image: url("https://image.flaticon.com/icons/png/128/109/109612.png");
                                    display: block;
                                    margin: 0 auto;
                                    background-size: 100%;
                                    background-repeat: no-repeat;
                                }

                                .color input {
                                    background-color: #f1f1f1;
                                }

                                .files:before {
                                    position: absolute;
                                    bottom: 10px;
                                    left: 0;
                                    pointer-events: none;
                                    width: 100%;
                                    right: 0;
                                    height: 57px;
                                    display: block;
                                    margin: 0 auto;
                                    color: #2ea591;
                                    font-weight: 600;
                                    text-transform: capitalize;
                                    text-align: center;
                                }
                                </style>';

// }

// <script>
//                                 // $("' . $temp . '").change(function(e) {
//                                 //     var geekss = e.target.files[0].name;
//                                 //     $("h4").text(geekss + " is the selected file.");
//                                 // });
//                                 </script>