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
    <h3 class="my-4">Allotments</h3>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card mt-2">
            <div class="card shadow pt-1 pb-5">
                <div class="card-body">
                    <h4 class="card-title text-info mb-5">Add Allotments</h4>
                    <div class="col text-center">
                        <button type="button" class="btn btn-themeblack" name="addallotment" data-toggle="modal"
                            data-target="#uploadallotments">
                            Upload excel&nbsp;&nbsp;<i class="fas fa-upload"></i>
                        </button>
                    </div>
                    <!-- Modal for importing -->
                    <div class="modal fade" id="uploadallotments" tabindex="-1" role="dialog"
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
                                        <form method="POST" enctype="multipart/form-data" id="bulkUploadAllotments">
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
                                                    <br>
                                                    <label for=""><small><b>Note:</b> Put "Yes" or "No" for isRent
                                                            column<br>Put - in Rentee columns if flat not on
                                                            rent</small>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="form-row mt-4">
                                                <div class="form-group col-md-6">
                                                    <label for="flat"><b>Flat Number</b></label>
                                                    <input type="text" class="form-control" id="flat"
                                                        placeholder="Column name of Flat" name="flat" value="FlatNumber"
                                                        required readonly>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="block"><b>Block</b></label>
                                                    <input type="text" class="form-control" id="block"
                                                        placeholder="Column name of Block" name="block"
                                                        value="BlockNumber" required readonly>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="oname"><b>Owner Name</b></label>
                                                    <input type="text" class="form-control" id="oname"
                                                        placeholder="Column name of Owner name" name="oname"
                                                        value="OwnerName" required readonly>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="oemail"><b>Owner Email</b></label>
                                                    <input type="text" class="form-control" id="oemail"
                                                        placeholder="Column name of Owner email" name="oemail"
                                                        value="OwnerEmail" required readonly>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="ocno" style="margin-bottom: 2.05rem;"><b>Owner Contact
                                                            Number</b></label>

                                                    <input type="text" class="form-control" id="ocno"
                                                        placeholder="Column name of Owner contact number" name="ocno"
                                                        value="OwnerContactNumber" required readonly>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="oacno"><b>Owner Alternate Contact Number</b></label>
                                                    <input type="text" class="form-control" id="oacno"
                                                        placeholder="Column name of Owner alt contact num" name="oacno"
                                                        value="OwnerAlternateContactNumber" required readonly>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="omem"><b>Owner Member count</b></label>
                                                    <input type="text" class="form-control" id="omem"
                                                        placeholder="Column name of Owner Member count" name="omem"
                                                        value="OwnerMemberCount" required readonly>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="isRent"><b>Flat on Rent?</b></label>
                                                    <input type="text" class="form-control" id="isRent"
                                                        placeholder="Column name of on rent?" name="isRent"
                                                        value="isRent" required readonly>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="rname"><b>Rentee Name</b></label>
                                                    <input type="text" class="form-control" id="rname"
                                                        placeholder="Column name of Rentee name" name="rname"
                                                        value="RenteeName" required readonly>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="remail"><b>Rentee Email</b></label>
                                                    <input type="text" class="form-control" id="remail"
                                                        placeholder="Column name of Rentee email" name="remail"
                                                        value="RenteeEmail" required readonly>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="rcno" style="margin-bottom: 2.05rem;"><b>Rentee Contact
                                                            Number</b></label>

                                                    <input type="text" class="form-control" id="rcno"
                                                        placeholder="Column name of Rentee contact number" name="rcno"
                                                        value="RenteeContactNumber" required readonly>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="racno"><b>Rentee Alternate Contact Number</b></label>
                                                    <input type="text" class="form-control" id="racno"
                                                        placeholder="Column name of Rentee alt contact num" name="racno"
                                                        value="RenteeAlternateContactNumber" required readonly>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="rmem"><b>Rentee Member count</b></label>
                                                    <input type="text" class="form-control" id="rmem"
                                                        placeholder="Column name of Rentee Member count" name="rmem"
                                                        value="RenteeMemberCount" required readonly>
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
                                                    id="upload_allotments">Upload</button>
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
                    <form action="./includes/queries/allotments.php" autocomplete="off" method='POST'>
                        <div class="form-group">
                            <label for="block">Block:</label>
                            <select class="form-control" id="blocks" name="block" required>
                                <option value="" selected> Select a Block</option>
                                <?php

$sql = "SELECT distinct(BlockNumber) from flats";
$res = mysqli_query($con, $sql);

while ($row = mysqli_fetch_assoc($res)) {
    echo '
                                    <option value="' . $row["BlockNumber"] . '">' . $row["BlockNumber"] . ' </option>';
}
?>
                            </select>
                            <small id="blockHelp" class="form-text text-muted">Select block</small>
                        </div>
                        <div class="form-group">
                            <label for="fno">Flat number:</label>
                            <select class="form-control" id="fnoo" name="fno" required>
                                <option value="" selected> Select a Flat</option>
                            </select>
                            <!-- <input type="number" class="form-control" id="fno" name="fno" aria-describedby="fnoHelp"
                                required> -->
                            <small id="fno" class="form-text text-muted">Select flat number</small>
                        </div>
                        <div class="form-group">
                            <label for="oname">Owner Name:</label>
                            <input type="text" class="form-control" id="oname" name="oname" aria-describedby="onameHelp"
                                required>
                            <small id="onameHelp" class="form-text text-muted">Enter the flat owner's name</small>
                        </div>
                        <div class="form-group">
                            <label for="ocontact">Owner Contact No.:</label>
                            <input type="number" class="form-control" id="ocontact" name="ocontact"
                                aria-describedby="ocontactHelp" required>
                            <small id="ocontactHelp" class="form-text text-muted">Enter the flat owner's contact
                                number</small>
                        </div>
                        <div class="form-group">
                            <label for="oacontact">Owner Alternate Contact No.:</label>
                            <input type="number" class="form-control" id="oacontact" name="oacontact"
                                aria-describedby="oacontactHelp" required>
                            <small id="oacontactHelp" class="form-text text-muted">Enter the flat owner's alternate
                                contact number</small>
                        </div>
                        <div class="form-group">
                            <label for="oemail">Owner Email ID:</label>
                            <input type="email" class="form-control" id="oemail" name="oemail"
                                aria-describedby="oemailHelp" required>
                            <small id="oemailHelp" class="form-text text-muted">Enter the flat owner's email
                                address</small>
                        </div>
                        <div class="form-group">
                            <label for="omembers">Member Count:</label>
                            <input type="number" class="form-control" id="omembers" name="omembers"
                                aria-describedby="omembersHelp" required>
                            <small id="omembersHelp" class="form-text text-muted">Enter the flat owner's total
                                family members</small>
                        </div>
                        <div class=" form-check">
                            <label class="form-check-label" for="isRent">
                                <input class="form-check-input" type="checkbox" id="isRentt" name="isRent"
                                    onclick="myFunction()">
                                Flat on rent?
                            </label>
                            <!--  <script>
                            $('#isRent').onchange(function() {
                                console.log($('#isRent').value)
                            });
                            </script> -->
                        </div>
                        <div class='' style='display:none' id='rentee'>
                            <div class="form-group">
                                <label for="rname">Rentee Name:</label>
                                <input type="text" class="form-control" id="rname" name="rname"
                                    aria-describedby="rnameHelp">
                                <small id="rnameHelp" class="form-text text-muted">Enter the flat rentee's name</small>
                            </div>
                            <div class="form-group">
                                <label for="rcontact">Rentee Contact No.:</label>
                                <input type="number" class="form-control" id="rcontact" name="rcontact"
                                    aria-describedby="rcontactHelp">
                                <small id="rcontactHelp" class="form-text text-muted">Enter the flat rentee's contact
                                    number</small>
                            </div>
                            <div class="form-group">
                                <label for="racontact">Rentee Alternate Contact No.:</label>
                                <input type="number" class="form-control" id="racontact" name="racontact"
                                    aria-describedby="racontactHelp">
                                <small id="racontactHelp" class="form-text text-muted">Enter the flat rentee's alternate
                                    contact number</small>
                            </div>
                            <div class="form-group">
                                <label for="remail">Rentee Email ID:</label>
                                <input type="email" class="form-control" id="remail" name="remail"
                                    aria-describedby="remailHelp">
                                <small id="remailHelp" class="form-text text-muted">Enter the flat rentee's email
                                    address</small>
                            </div>
                            <div class="form-group">
                                <label for="rmembers">Member Count:</label>
                                <input type="number" class="form-control" id="rmembers" name="rmembers"
                                    aria-describedby="rmembersHelp">
                                <small id="rmembersHelp" class="form-text text-muted">Enter the flat rentee's total
                                    family members</small>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-themeblack" name='addallotment-btn'>Add</button>
                        <button type="clear" class="btn btn-themeblack">Clear</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /container-fluid -->
<script>
$("#blocks").change(function() {
    getflats();
});

function getflats() {
    var data = $("#blocks").val();
    //console.log("Block selected: ", data);
    $.ajax({
        type: "POST",
        data: {
            block: data
        },
        url: "includes/handlers/add_allotment.php",
        success: function(res) {
            // alert(res);
            // console.log(res);
            $("#fnoo").html(res);
        }
    });

}

function myFunction() {
    var checkBox = document.getElementById("isRentt");
    // Get the output text
    var text = document.getElementById("rentee");
    // console.log(checkBox);
    //console.log(text);
    // If the checkbox is checked, display the output text
    if (checkBox.checked == true) {
        checkBox.value = 1;
        console.log(checkBox.value);
        text.style.display = "block";
    } else {
        checkBox.value = 0;
        //console.log(checkBox.value);
        text.style.display = "none";
    }
};

$("#bulkUploadAllotments").submit(function(e) {
    e.preventDefault();
    form = this;
    var formData = new FormData(this);
    // $("#upload_allotments").attr("disabled", true);
    // $("#upload_allotments").text("Uploading...")
    $.ajax({
        url: "includes/bulkUpload/add_allotments.php",
        type: 'POST',
        data: formData,
        success: function(data) {
            console.log(data);
            let [status, response] = $.trim(data).split("+");
            console.log(status);
            if (status == "Successful") {
                const resData = JSON.parse(response);
                console.log(resData)
                $("#upload_allotments").text("Upload Successfull!");
                $("#upload_allotments").removeClass("btn-primary");
                $("#upload_allotments").addClass("btn-success");
                alert("Status:" + status + "\nInserted : " + resData.insertedRecords +
                    "\nUpdated : " + resData.updatedRecords + "\nNo Operation : " + (resData
                        .totalRecords - (resData.updatedRecords + resData.insertedRecords)))
            } else {
                $("#upload_allotments").text("Upload Failed");
                $("#upload_allotments").addClass("btn-danger");
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