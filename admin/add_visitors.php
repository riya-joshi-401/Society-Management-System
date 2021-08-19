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

    <!-- Begin Page Content -->
    <h3 class="my-4">Visitors</h3>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card mt-2">
            <div class="card shadow pt-1 pb-5">
                <div class="card-body">
                    <div class="col-12 mb-3">
                        <h4 class="font-weight-bold text-primary">Add Visitors</h4>
                    </div>
                    <div class="col text-center">
                        <button type="button" class="btn btn-themeblack" name="addvisitors" data-toggle="modal"
                            data-target="#uploadvisitor">
                            Upload excel&nbsp;&nbsp;<i class="fas fa-upload"></i>
                        </button>
                    </div>
                    <!-- Modal for importing -->
                    <div class="modal fade" id="uploadvisitor" tabindex="-1" role="dialog"
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
                                        <form method="POST" enctype="multipart/form-data" id="bulkUploadVisitor">
                                            <label for="">
                                                <h6>Information for mapping Data from excel sheet columns to
                                                    database
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
                                                    <label for="block">Block:</label>
                                                    <input type="text" class="form-control" id="block" name="block"
                                                        value="BlockNumber" placeholder="Column name of Block"
                                                        readonly>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="fno">Flat no:</label>
                                                    <input type="text" class="form-control" id="flatno"
                                                        name="flatno" value="FlatNumber"
                                                        placeholder="Column name of Flat number" readonly>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-12">
                                                    <label for="name">Visitor Name:</label>
                                                    <input type="text" class="form-control" id="vname" name="vname"
                                                        value="VisitorName"
                                                        placeholder="Column name of Visitor Name" readonly>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="contact col-md-6">Visitor Contact No.:</label>
                                                    <input type="text" class="form-control" id="contact"
                                                        name="contact" value="VisitorContactNo"
                                                        placeholder="Column name of Contact no" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label for="contact1">Alternate Visitor Contact No.:</label>
                                                    <input type="text" class="form-control" id="contact1"
                                                        name="contact1" value="AlternateVisitorContactNo"
                                                        placeholder="Column name of alternate contact no" readonly>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="people">Number of People:</label>
                                                    <input type="text" class="form-control" id="people"
                                                        name="people" placeholder="Column name of number of people"
                                                        value="NoOfPeople" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label for="whomToMeet">Whom to Meet:</label>
                                                    <input type="text" class="form-control" id="whomToMeet"
                                                        name="whomToMeet" value="WhomToMeet"
                                                        placeholder="Column name of whom to meet" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="reasonToMeet">Reason to Meet:</label>
                                                <input type="text" class="form-control" id="reasonToMeet"
                                                    name="reasonToMeet" value="ReasonToMeet"
                                                    placeholder="Column name of whom to meet" rows="3" readonly>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="startdate">Start Date:</label>
                                                    <input type="text" class="form-control" id="startdate"
                                                        name="startdate" placeholder="Column name of start date"
                                                        value="StartDate" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label for="duration">Duration:</label>
                                                    <input type="text" class="form-control" id="duration"
                                                        name="duration" value="Duration"
                                                        placeholder="Column name of duration in days" readonly>
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
                                                    id="upload_visitors">Upload</button>
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
                <!--Main Form section starts-->
                <form action="includes/queries/visitors.php" method="POST" autocomplete="">
                    <div class="form-group">
                        <label for="block">Block:</label>
                        <!-- <input type="text" class="form-control" id="block" name="block" aria-describedby="blockHelp"
                            required> -->
                        <select class="form-control" id="block_select" name="block" required>
                            <option value="" selected> Select a Block</option>
                            <?php 
                            
                            $sql = "SELECT distinct(BlockNumber) from allotments";
                            $res = mysqli_query($con,$sql);

                            while($row= mysqli_fetch_assoc($res)){
                                echo '
                                <option value="'. $row["BlockNumber"].'">' .$row["BlockNumber"]. ' </option>';
                            }
                            ?>
                        </select>
                        <small id="blockHelp" class="form-text text-muted">Select the block name</small>
                    </div>
                    <div class="form-group">
                        <label for="fno">Flat no:</label>
                        <select class="form-control" id="flat_select" name="flat" required>
                            <option value="" selected> Select a Flat</option>
                        </select>
                        <small id="fnoHelp" class="form-text text-muted">Select the Flat number</small>
                    </div>

                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" class="form-control" id="name" name="name"
                                aria-describedby="nameHelp" required>
                            <small id="nameHelp" class="form-text text-muted">Enter the visitor's name</small>
                        </div>
                        <div class="form-group">
                            <label for="contact">Contact No.:</label>
                            <input type="text" class="form-control" id="contact" name="contact"
                                aria-describedby="contactHelp" required>
                            <small id="contactHelp" class="form-text text-muted">Enter the visitor's contact
                                number</small>
                        </div>
                        <div class="form-group">
                            <label for="contact1">Alternate Contact No.:</label>
                            <input type="text" class="form-control" id="contact1" name="contact1"
                                aria-describedby="contact1Help" required>
                            <small id="contact1Help" class="form-text text-muted">Enter the visitor's alternate
                                contact number</small>
                        </div>
                        <div class="form-group">
                            <label for="people">Number of People:</label>
                            <input type="number" class="form-control" id="people" name="people"
                                aria-describedby="peopleHelp">
                            <small id="peopleHelp" class="form-text text-muted">Enter the number of people</small>
                        </div>
                        <div class="form-group">
                            <label for="whomToMeet">Whom to Meet:</label>
                            <input type="text" class="form-control" id="whomToMeet" name="whomToMeet"
                                aria-describedby="whomToMeetHelp">
                            <small id="whomToMeetHelp" class="form-text text-muted">Enter the whom to meet(flat
                                owner's name)</small>
                        </div>
                        <div class="form-group">
                            <label for="reasonToMeet">Reason to Meet:</label>
                            <textarea class="form-control" id="reasonToMeet" name="reasonToMeet"
                                aria-describedby="reasonToMeetHelp" rows="3"></textarea>
                            <small id="reasonToMeetHelp" class="form-text text-muted">Enter the reason to
                                meet</small>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="startDate">Start Date:</label>
                                <input type="date" class="form-control" id="startDate" name="startDate"
                                    aria-describedby="startDateHelp">
                                <small id="startDateHelp" class="form-text text-muted">Enter the start date to
                                    visit</small>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="duration">Duration:</label>
                                <input type="number" class="form-control" id="duration" name="duration"
                                    aria-describedby="durationHelp">
                                <small id="durationHelp" class="form-text text-muted">Enter the duration in days</small>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-themeblack" name='addvisitors-btn'>Add</button>
                        <button type="reset" class="btn btn-themeblack">Clear</button>
                    </form>
                    <!--Main Form section ends-->
                </div>
            </div>
        </div>
    </div>
</div>


<!-- /container-fluid -->
<script>
$("#bulkUploadVisitor").submit(function(e) {
    e.preventDefault();
    form = this;
    //console.log(this.fno);
    var formData = new FormData(this);
    // $("#upload_visitors").attr("disabled", true);
    // $("#upload_visitors").text("Uploading...")
    $.ajax({
        url: "includes/bulkUpload/add_visitors.php",
        type: 'POST',
        data: formData,
        success: function(data) {
            console.log("data");
            console.log(data);
            let [status, response] = $.trim(data).split("+");
            console.log(status);
            if (status == "Successful") {
                let resData = JSON.parse(response);
                console.log(resData)
                $("#upload_visitors").text("Upload Successfull!");
                $("#upload_visitors").removeClass("btn-primary");
                $("#upload_visitors").addClass("btn-success");
                alert("Status:" + status + "\nInserted : " + resData.insertedRecords +
                    "\nUpdated : " + resData.updatedRecords + "\nNo Operation : " + (resData
                        .totalRecords - (resData.updatedRecords + resData.insertedRecords)))
            } else {
                $("#upload_visitors").text("Upload Failed");
                $("#upload_visitors").addClass("btn-danger");
                alert(data);
            }
            // form.reset();
        },
        cache: false,
        contentType: false,
        processData: false
    });
})

$("#block_select").change(function() {
    getflats();
});

function getflats() {
    var data = $("#block_select").val();
    console.log("Block selected: ", data);
    $.ajax({
        type: "POST",
        data: {
            block: data
        },
        url: "includes/handlers/add_visitor_flats.php",
        success: function(res) {
            // alert(res);
            // console.log(res);
            $("#flat_select").html(res);
        }
    });

}
</script>
<!-- <script type="text/javascript" src="../js/date_validation.js"></script> -->



    <?php

include './includes/shared/footer.php';
include './includes/shared/scripts.php';

?>