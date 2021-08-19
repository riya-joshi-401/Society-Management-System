<?php

include 'includes/shared/header.php';
include 'includes/shared/sidebar.php';
include 'includes/shared/topbar.php';

?>

<!-- Begin Page Content -->
<div class="container-fluid">
    <?php
if (isset($_SESSION['success_message']) && !empty($_SESSION['success_message'])) {
    ?>

    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php echo $_SESSION['success_message']; ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <?php
unset($_SESSION['success_message']);
}
?>

    <?php
if (isset($_SESSION['error_message']) && !empty($_SESSION['error_message'])) {
    ?>

    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?php echo $_SESSION['error_message']; ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <?php
unset($_SESSION['error_message']);
}
?>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card mt-2">
            <div class="card shadow pt-1 pb-5">
                <div class="card-body">
                    <div class="col-12 mb-3">
                        <h4 class="font-weight-bold text-primary">Add Security Guard</h4>
                    </div>
                    <div class="col text-center">
                        <button type="button" class="btn btn-themeblack" name="addsecurity" data-toggle="modal"
                            data-target="#uploadsecurity">
                            Upload excel&nbsp;&nbsp;<i class="fas fa-upload"></i>
                        </button>
                    </div>
                    <!-- Modal for importing -->
                    <div class="modal fade" id="uploadsecurity" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalCenterTitle0" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalCenterTitle0">Upload Your File </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="container">
                                        <form method="POST" enctype="multipart/form-data" id="bulkUploadSecurity">
                                            <label for="">
                                                <h6>Information for mapping Data from excel sheet columns to database
                                                    columns </h6>
                                            </label>
                                            <label for=""><small><b>Note:</b> The following fields should be column
                                                    names in excel sheet</small>
                                            </label>
                                            <div class="form-row">
                                                <div class="form-group col-md-12">
                                                    <label for="rno"><b>Upload Constraint</b></label>
                                                    <select class="form-control" id="upload_constraint"
                                                        name="upload_constraint" required>
                                                        <option value="0">Only insert new Records</option>
                                                        <option value="1">Insert and update Existing</option>
                                                        <option value="2">Only Update existing records</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-row mt-4">
                                                <div class="form-group col-md-6">
                                                    <label for="securityid"><b>SecurityID</b></label>
                                                    <input type="text" class="form-control" id="securityid"
                                                        placeholder="Column name of SecurityID" name="securityid"
                                                        value="SecurityID" required>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="name"><b>Name</b></label>
                                                    <input type="text" class="form-control" id="name"
                                                        placeholder="Column name of Name" name="name" value="Name"
                                                        required>
                                                </div>
                                            </div>
                                            <div class="form-row">

                                                <div class="form-group col-md-6">
                                                    <label for="contactnumber"><b>Contact Number</b></label>
                                                    <input type="text" class="form-control" id="contactnumber"
                                                        placeholder="Column name of Contact Number" name="contactnumber"
                                                        value="ContactNumber" required>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="shift"><b>Shift</b></label>
                                                    <input type="text" class="form-control" id="shift"
                                                        placeholder="Column name of Shift" name="shift" value="Shift"
                                                        required>
                                                </div>
                                            </div>


                                            <br>
                                            <div class="form-group files color">
                                                <!-- <input type="file" class="form-control" accept=".xls,.xlsx"> -->
                                                <script type="text/javascript" language="javascript">
                                                function checkfile(sender) {
                                                    var validExts = new Array(".xlsx", ".xls");
                                                    var fileExt = sender.value;
                                                    fileExt = fileExt.substring(fileExt.lastIndexOf('.'));
                                                    if (validExts.indexOf(fileExt) < 0) {
                                                        alert("Invalid file selected, valid files are of " +
                                                            validExts.toString() + " types.");
                                                        return false;
                                                    } else return true;
                                                }
                                                </script>
                                                <input type="file" name="Uploadfile" class="form-control"
                                                    onchange="checkfile(this);"
                                                    accept="application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                                                    required />
                                                <label for=""><b>Accepted formats .xls,.xlsx only.</b></label>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                                    name="close">Close</button>
                                                <button type="submit" class="btn btn-primary" name="save_changes"
                                                    id="upload_security">Upload</button>
                                            </div>
                                        </form>
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
                                    background-image: url('https://image.flaticon.com/icons/png/128/109/109612.png');
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
                                </style>
                            </div>
                        </div>
                    </div>
                    <!-- Close upload modal -->
                    <form action="includes/queries/add_security.php" method="POST" autocomplete="off">

                        <div class="form-group">
                            <label for="securityid">SecurityID:</label>
                            <input type="text" class="form-control" id="securityid" name="securityid"
                                aria-describedby="securityid" required>
                            <small id="securityid" class="form-text text-muted">Enter the SecurityID</small>
                        </div>
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" class="form-control" id="name" name="name" aria-describedby="name"
                                required>
                            <small id="name" class="form-text text-muted">Enter the name</small>
                        </div>
                        <div class="form-group">
                            <label for="contactnumber">Contact Number:</label>
                            <input type="number" class="form-control" id="contactnumber" name="contactnumber"
                                aria-describedby="contactnumber" required>
                            <small id="contactnumber" class="form-text text-muted">Enter the contact number</small>
                        </div>
                        <div class="form-group">
                            <label for="shift">Shift:</label>
                            <select class="form-control" name="shift" required>
                                <option selected value='Morning'>Morning</option>
                                <option value='Afternoon'>Afternoon</option>
                                <option value='Evening'>Evening</option>
                                <option value='Night'>Night</option>
                            </select>
                            <small id="shift" class="form-text text-muted">Enter the shift</small>
                        </div>


                        <button type="submit" class="btn btn-themeblack" name='addsecurity-btn'>Add</button>
                        <button type="reset" class="btn btn-themeblack">Clear</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /container-fluid -->

<script>
$("#bulkUploadSecurity").submit(function(e) {
    e.preventDefault();
    form = this;
    var formData = new FormData(this);
    // $("#upload_farea").attr("disabled", true);
    // $("#upload_farea").text("Uploading...")
    $.ajax({
        url: "includes/bulkUpload/add_security.php",
        type: 'POST',
        data: formData,
        success: function(data) {
            console.log(data);
            let [status, response] = $.trim(data).split("+");
            console.log(status);
            if (status == "Successful") {
                const resData = JSON.parse(response);
                console.log(resData)
                $("#upload_security").text("Upload Successfull!");
                $("#upload_security").removeClass("btn-primary");
                $("#upload_security").addClass("btn-success");
                alert("Status:" + status + "\nInserted : " + resData.insertedRecords +
                    "\nUpdated : " + resData.updatedRecords + "\nNo Operation : " + (resData
                        .totalRecords - (resData.updatedRecords + resData.insertedRecords)))
            } else {
                $("#upload_security").text("Upload Failed");
                $("#upload_security").addClass("btn-danger");
                alert(data);
            }
            // form.reset();
        },
        cache: false,
        contentType: false,
        processData: false
    });
})
</script>


<?php

include './includes/shared/footer.php';
include './includes/shared/scripts.php';

?>