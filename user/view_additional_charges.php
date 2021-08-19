<?php
include './includes/shared/header.php';
?>

<?php include './includes/shared/sidebar.php';?>

<?php include './includes/shared/topbar.php';?>

<!-- Begin Page Content -->
<div class="container-fluid">
    <h3 class="my-4">Additional Charges</h3>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card mt-2">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <div class="row align-items-center">
                        <div class="col-12 mb-3">
                            <h4 class="m-0 font-weight-bold text-primary">View Additional Charges</h4>
                        </div>
                    </div>
                    <div class="d-flex flex-row-reverse text-center">
                        <button type="button" class="btn btn-primary" data-toggle="modal"
                            data-target="#exampleModalCenter1">
                            <i class="fas fa-filter"></i>
                        </button>
                    </div>

                </div>

                <div class="modal fade" id="exampleModalCenter1" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalCenterTitle1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalCenterTitle1">Filter</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <!-- Table -->

                                <form class="forms-sample" id="filter_charges_form" method="POST" action="">
                                    <div class="form-check">
                                        <label for="">Reason</label>
                                        <br>
                                        <?php

$reason = array();
$query = "SELECT DISTINCT(additional_charges.Reason) FROM `additional_charges` inner join flats on additional_charges.FlatID=flats.FlatID where flats.FlatNumber='{$_SESSION['flatno']}' and flats.BlockNumber='{$_SESSION['blockno']}';";
if ($result = mysqli_query($con, $query)) {
    $rowcount = mysqli_num_rows($result);
    while ($row = mysqli_fetch_array($result)) {
        $reason = $row['Reason'];
        echo '<div class="custom-control custom-checkbox custom-control-inline">
                                                            <input type="checkbox" checked name="filter_reason[]" class="custom-control-input" value="' . $reason . '" id="filter_reason_' . $reason . '">
                                                            <label class="custom-control-label" for="filter_reason_' . $reason . '">' . $reason . '</label>
                                                        </div>';
    }
}
?>
                                    </div>
                                    <br />

                                    <div class="form-check">
                                        <label for="">Bill Month</label>
                                        <br>
                                        <?php
$bmonth = array();
$query = "SELECT DISTINCT(additional_charges.Bill_month) FROM `additional_charges` inner join flats on additional_charges.FlatID=flats.FlatID where flats.FlatNumber='{$_SESSION['flatno']}' and flats.BlockNumber='{$_SESSION['blockno']}';";
if ($result = mysqli_query($con, $query)) {
    $rowcount = mysqli_num_rows($result);
    while ($row = mysqli_fetch_array($result)) {
        $bmonth = $row['Bill_month'];
        echo '<div class="custom-control custom-checkbox custom-control-inline">
                                                            <input checked type="checkbox" name="filter_bmonth[]" class="custom-control-input" value="' . $bmonth . '" id="filter_bmonth_' . $bmonth . '">
                                                            <label class="custom-control-label" for="filter_bmonth_' . $bmonth . '">' . $bmonth . '</label>
                                                        </div>';
    }
}
?>
                                    </div>
                                    <br />

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-primary" id="clear-filters"
                                            name="clear">Clear filters</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                            name="close">Close</button>
                                        <button type="submit" class="btn btn-primary" name="filter">Filter</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-responsive" id="dataTable-additionalcharges" width="100%"
                        cellspacing="0">
                        <thead>
                            <tr>
                                <th>Amount</th>
                                <th>Reason</th>
                                <th>Bill Month</th>
                                <th>Updated By</th>
                                <th>Updated At</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Amount</th>
                                <th>Reason</th>
                                <th>Bill Month</th>
                                <th>Updated By</th>
                                <th>Updated At</th>
                            </tr>
                        </tfoot>
                    </table>
                    <!-- </div> -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

<script type="text/javascript">
$(document).ready(function() {
    loadCurrent();
    // filterTable();
});

function getFilters() {
    const filters = $("#filter_charges_form").serializeArray();
    let normalizedFilters = {};
    for (filter of filters) {
        switch (filter.name) {

            case "filter_reason[]":
                if (!normalizedFilters.reason) {
                    normalizedFilters.reason = []
                }
                normalizedFilters.reason.push(filter.value)
                // console.log(filter.value)
                break;
            case "filter_bmonth[]":
                if (!normalizedFilters.bmonth) {
                    normalizedFilters.bmonth = []
                }
                normalizedFilters.bmonth.push(filter.value)
                // console.log(filter.value)
                break;
        }
    }
    // console.log("Normalized Filters: " + normalizedFilters);
    return normalizedFilters
}

//DATATABLE CREATE
function loadCurrent() {
    var table = $('#dataTable-additionalcharges').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        autoWidth: true,
        responsive: true,
        serverMethod: 'post',
        aaSorting: [],
        dom: '<"d-flex justify-content-between table-buttons-addcharges"fBl>tip',
        buttons: [{
            extend: 'excel',
            title: "additional-charges-data",
            text: '<span> <i class="fas fa-download "></i> EXCEL</span>',
            className: "btn btn-outline-primary  ",
            action: newExportAction,
            exportOptions: {
                columns: [0, 1, 2, 3, 4]
            }
        }, {
            extend: "pdfHtml5",
            title: "additional-charges-data",
            text: '<span> <i class="fas fa-download "></i> PDF</span>',
            className: "btn btn-outline-primary  mx-2",
            action: newExportAction,
            exportOptions: {
                columns: [0, 1, 2, 3, 4]
            },
        }, ],
        ajax: {
            'url': 'includes/loadInfo/view_additional_charges.php',
            "data": function(d) {
                console.log(d);
                d.filters = getFilters();
                return d
            }
        },
        columns: [{
                data: 'Amount'
            },
            {
                data: 'Reason'
            },
            {
                data: 'Bill_month'
            },
            {
                data: 'Updated_by'
            },
            {
                data: 'Updated_at'
            },
        ],
        columnDefs: [{
                targets: [0, 4], // column index (start from 0)
                orderable: false, // set orderable false for selected columns
            },
            {
                className: "Amount",
                "targets": [0],
            },
            {
                width: "5%",
                targets: [4]
            },

        ],
    });
    table.columns.adjust()
}

$("#filter_charges_form").submit(function(e) {
    e.preventDefault();
    console.log("hi");
    $('#dataTable-additionalcharges').DataTable().ajax.reload();
    $("#exampleModalCenter1").modal("hide")
})

$("#clear-filters").click(function(e) {
    $('#filter_charges_form').trigger('reset');
    $('#dataTable-additionalcharges').DataTable().ajax.reload(false);
});
</script>


<?php

include './includes/shared/footer.php';
include './includes/shared/scripts.php';

?>