<?php

include 'includes/shared/header.php';
include 'includes/shared/sidebar.php';
include 'includes/shared/topbar.php';

$tgl = date("d F Y ");
$prevmonth = date("M Y", mktime(0, 0, 0, date("m", strtotime($tgl)) - 1, 1, date("Y", strtotime($tgl))));

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

    <h3 class="my-4">Bills</h3>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card mt-2">
            <div class="card shadow pt-1 pb-3">
                <div class="card-body">
                    <div class="col-12 mb-3">
                        <h4 class="font-weight-bold text-primary">Add Additional Charges For All the Flats
                        </h4>
                    </div>

                    <form action="includes/queries/add_additional_charges_bills.php" method="POST" autocomplete="off"
                        id="add_charges_all">
                        <div class="form-group">
                            <label for="billmonth">Bill month:</label>
                            <input type="text" class="form-control" name="bill_month" value="<?php echo $prevmonth;?>"
                                readonly>
                        </div>
                        <div class="form-group">
                            <label for="charges">Additional Charges:</label>
                            <input type="number" class="form-control" name="additional_charges" required>
                            <small id="chargesHelp" class="form-text text-muted">Add the charges for all the flats at
                                once </small>
                        </div>
                        <div class="form-group">
                            <label for="reason">Charges Reason:</label>
                            <input type="text" class="form-control" name="charges_reason" required>
                        </div>
                        <button type="submit" class="btn btn-themeblack" id="addchargesall-btn"
                            name='addchargesall-btn'>Add</button>
                        <button type="reset" class="btn btn-themeblack">Reset</button>
                    </form>
                </div>
            </div>
            <div class="card shadow mt-3 pt-1 pb-3">
                <div class="card-body">
                    <div class="col-12 mb-3">
                        <h4 class="font-weight-bold text-primary">Add Additional Charges For a Particular Flat</h4>
                    </div>

                    <form action="add_charges_flats.php" method="POST" autocomplete="off" id="search_allotment_form">
                        <div class="form-group">
                            <label for="billmonth">Bill month:</label>
                            <input type="text" class="form-control" name="bill_month" value="<?php echo $prevmonth;?>"
                                readonly>
                        </div>
                        <div class="form-group">
                            <label for="block">Block:</label>
                            <select class="form-control" id="block_select" name="block_select" required>
                                <option value="" selected> Select a Block</option>
                                <?php

                                    $sql = "SELECT distinct(BlockNumber) from allotments";
                                    $res = mysqli_query($con, $sql);

                                    while ($row = mysqli_fetch_assoc($res)) {
                                        echo '
                                                <option value="' . $row["BlockNumber"] . '">' . $row["BlockNumber"] . ' </option>';
                                    }
?>
                            </select>
                            <small id="blockHelp" class="form-text text-muted">Select the block name </small>
                        </div>
                        <div class="form-group">
                            <label for="flatno">Flat Number:</label>
                            <select class="form-control" id="flat_select" name="flat_select" required>
                                <option value="" selected> Select a Flat</option>
                            </select>
                            <small id="flatnoHelp" class="form-text text-muted">Select the flat Number</small>
                        </div>
                        <button type="submit" class="btn btn-themeblack" id="searchallotment-btn"
                            name='searchallotment-btn'>Search</button>
                        <button type="reset" class="btn btn-themeblack">Reset</button>
                    </form>
                </div>
            </div>
            <div class="card shadow mt-3 pt-1">
                <div class="card-body">
                    <div class="col-12 mb-3">
                        <h4 class="font-weight-bold text-primary">Generate Bills for all the Flats</h4>
                        <div class="text-danger py-2">
                            <strong>Note:</strong> Bill once generated cannot be modified!
                            <div>Add additional charges prior to bill generation if required</div>
                        </div>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#billmodal">
                            Generate Bill
                        </button>
                        <!-- Modal -->
                        <div class="modal fade" id="billmodal" tabindex="-1" role="dialog" aria-labelledby="billmodal"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title font-weight-bold" id="billmodal">Generate Bill</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body font-weight-bold">
                                        Are you sure to generate bill for the month <span class="text-danger">
                                            <?php echo $prevmonth; ?> </span>?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                                        <form method="POST" action="includes/queries/generatebill.php">
                                            <button type="submit" name="genbill-btn"
                                                class="btn btn-primary">Yes</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end modal -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /container-fluid -->
<script>
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
        url: "includes/handlers/add_bill_flat.php", //searching for all the flats in that block using ajax
        success: function(res) {
            // alert(res);
            // console.log(res);
            $("#flat_select").html(res);
        }
    });

}

// $('#search_allotment_form').submit(function(e) {
//     e.preventDefault();
//     var form = $(this);
//     var form_serialize = form.serializeArray(); //get the data
//     form_serialize.push({
//         name: $("#searchallotment-btn").attr('name'),
//         value: $("#searchallotment-btn").attr('value')
//     });
//     console.log(form_serialize)
//     $("#searchallotment-btn").text("Searching...");
// });
</script>


<?php

include './includes/shared/footer.php';
include './includes/shared/scripts.php';

?>