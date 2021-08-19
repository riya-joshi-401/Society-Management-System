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
    <h3 class="my-4">Flats</h3>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card mt-2">
            <div class="card shadow pt-1 pb-5">
                <div class="card-body">
                    <div class="col-12 mb-3">
                        <h4 class="font-weight-bold text-primary">Add Flats</h4>
                    </div>
                    <div class="col text-center">
                        <button type="button" class="btn btn-themeblack" name="addflats" data-toggle="modal"
                            data-target="#uploadflat">
                            Upload excel&nbsp;&nbsp;<i class="fas fa-upload"></i>
                        </button>
                    </div>
                    <!-- Modal for importing -->
                    <div class="modal fade" id="uploadflat" tabindex="-1" role="dialog"
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
                                        <form method="POST" enctype="multipart/form-data" id="bulkUploadFlats">
                                            <label for="">
                                                <h6>Information for mapping Data from excel sheet columns to database
                                                    columns</h6>
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
                                                        <!-- <option value="1">Insert and update Existing</option>
                                                        <option value="2">Only Update existing records</option> -->
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-row mt-4">
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label for="fno"><b>Flat Number</b></label>
                                                        <input type="text" class="form-control" id="fno"
                                                            placeholder="Column name of Flat Number" name="fno"
                                                            value="FlatNumber" required readonly>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="floor"><b>Floor</b></label>
                                                        <input type="text" class="form-control" id="floor"
                                                            placeholder="Column name of Floor" name="floor"
                                                            value="Floor" required readonly>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-8">
                                                        <label for="block"><b>Block</b></label>
                                                        <input type="text" class="form-control" id="block"
                                                            placeholder="Column name of Block" name="block"
                                                            value="BlockNumber" required readonly>
                                                    </div>
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
                                                    id="upload_flats">Upload</button>
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
                    <form action="./includes/queries/flats.php" autocomplete="off" method="POST" name="addflat">
                        <div class="form-group">
                            <label for="fno">Flat number:</label>
                            <input type="text" class="form-control" id="fnoo" name="fno" aria-describedby="fnoHelp"
                                required>
                            <small id="fnoHelp" class="form-text text-muted">Enter the Flat number</small>
                        </div>

                        <!-- <div class="form-group">
                            <label for="flattype">Flat Type:</label>
                            <select class="form-control" id="flattype" name="flattype">
                                <option value="1 BHK">1BHK</option>
                                <option value="2 BHK">2BHK</option>
                                <option value="3 BHK">3BHK</option>
                                <option value="4 BHK">4BHK</option>
                            </select>
                        </div> -->
                        <div class="form-group">
                            <label for="floorno">Floor:</label>
                            <input type="text" class="form-control" id="floorno" name="floorno"
                                aria-describedby="floornoHelp" required>
                            <small id="floornoHelp" class="form-text text-muted">Enter the floor number</small>
                        </div>
                        <div class="form-group">
                            <label for="block">Block:</label>
                            <select class="form-control" id="blocks" name="block" required>
                                <!-- <option value="" selected> Select Block</option> -->
                            </select>
                        </div>
                        <button type="submit" class="btn btn-themeblack" name="flat">Add</button>
                        <button type="clear" class="btn btn-themeblack">Clear</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /container-fluid -->
<script>
$("#floorno").change(function() {
    getblocks();
});

$("#fnoo").change(function() {
    getblocks();
});

function getblocks() {
    //var data = $("#series").val();
    var data = $('#fnoo').val() - (100 * $('#floorno').val());
    console.log("Series selected: ", data);
    $.ajax({
        type: "POST",
        data: {
            block: data
        },
        url: "includes/handlers/add_flat.php",
        success: function(res) {
            //alert(res);
            //console.log(res);
            $("#blocks").html(res);
        }
    });

}

$("#bulkUploadFlats").submit(function(e) {
    e.preventDefault();
    form = this;
    //console.log(this.fno);
    var formData = new FormData(this);
    // $("#upload_flats").attr("disabled", true);
    // $("#upload_flats").text("Uploading...")
    $.ajax({
        url: "includes/bulkUpload/add_flats.php",
        type: 'POST',
        data: formData,
        success: function(data) {
            console.log(data);
            let [status, response] = $.trim(data).split("+");
            console.log(status);
            if (status == "Successful") {
                const resData = JSON.parse(response);
                console.log(resData)
                $("#upload_flats").text("Upload Successfull!");
                $("#upload_flats").removeClass("btn-primary");
                $("#upload_flats").addClass("btn-success");
                alert("Status:" + status + "\nInserted : " + resData.insertedRecords +
                    "\nUpdated : " + resData.updatedRecords + "\nNo Operation : " + (resData
                        .totalRecords - (resData.updatedRecords + resData.insertedRecords)))
            } else {
                $("#upload_flats").text("Upload Failed");
                $("#upload_flats").addClass("btn-danger");
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