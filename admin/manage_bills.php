<?php
include './includes/shared/header.php';
?>

<?php include './includes/shared/sidebar.php';?>

<?php include './includes/shared/topbar.php';?>

<!-- Begin Page Content -->
<div class="container-fluid">
    <h3 class="my-4">Bills</h3>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card mt-2">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <div class="row align-items-center">
                        <div class="col-12 mb-3">
                            <h4 class="m-0 font-weight-bold text-primary">Bill Records</h4>
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

                                <form class="forms-sample" id="filter_bill_form" method="POST" action="">
                                    <div class="form-check">
                                        <label for="">Block</label>
                                        <br>
                                        <?php

$block_numbers = array();
// $user = $_SESSION['username'];

$query = "SELECT distinct(BlockNumber) FROM allotments";
if ($result = mysqli_query($con, $query)) {
    $rowcount = mysqli_num_rows($result);
    while ($row = mysqli_fetch_array($result)) {
        $block_numbers = $row['BlockNumber'];
        echo '<div class="custom-control custom-checkbox custom-control-inline">
                                                            <input type="checkbox" checked name="filter_block[]" class="custom-control-input" value="' . $block_numbers . '" id="filter_block_' . $block_numbers . '">
                                                            <label class="custom-control-label" for="filter_block_' . $block_numbers . '">' . $block_numbers . '</label>
                                                        </div>';
    }
}
?>
                                    </div>
                                    <br />

                                    <div class="form-check">
                                        <label for="">Flat Number</label>
                                        <br>
                                        <?php
$fno = array();
$query = "SELECT distinct(FlatNumber) FROM allotments";
if ($result = mysqli_query($con, $query)) {
    $rowcount = mysqli_num_rows($result);
    while ($row = mysqli_fetch_array($result)) {
        $fno = $row['FlatNumber'];
        echo '<div class="custom-control custom-checkbox custom-control-inline">
                                                            <input checked type="checkbox" name="filter_fno[]" class="custom-control-input" value="' . $fno . '" id="filter_fno_' . $fno . '">
                                                            <label class="custom-control-label" for="filter_fno_' . $fno . '">' . $fno . '</label>
                                                        </div>';
    }
}
?>
                                    </div>
                                    <br />
                                    <div class="form-check">
                                        <label for="">Bill month</label>
                                        <br>
                                        <?php
$bmonth = array();
$query = "SELECT distinct(bill_month) FROM bill_queue;";
if ($result = mysqli_query($con, $query)) {
    $rowcount = mysqli_num_rows($result);
    while ($row = mysqli_fetch_array($result)) {
        $bmonth = $row['bill_month'];
        echo '<div class="custom-control custom-checkbox custom-control-inline">
                                                            <input checked type="checkbox" name="filter_bmonth[]" class="custom-control-input" value="' . $bmonth . '" id="filter_bmonth_' . $bmonth . '">
                                                            <label class="custom-control-label" for="filter_bmonth_' . $bmonth . '">' . $bmonth . '</label>
                                                        </div>';
    }
}
?>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-primary" id="clear-filters"
                                            name="clear">clear filters</button>
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
                    <table class="table table-bordered table-responsive" id="dataTable-managebills" width="100%"
                        cellspacing="0">
                        <thead>
                            <tr>
                                <th>Block Number</th>
                                <th>Flat Number</th>
                                <th>Bill month</th>
                                <th>Bill</th>
                                <th>Bill Receipt</th>
                                <th>Payment Status</th>
                                <th>Last Updated At</th>
                                <th>Action </th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Block Number</th>
                                <th>Flat Number</th>
                                <th>Bill month</th>
                                <th>Bill</th>
                                <th>Bill Receipt</th>
                                <th>Payment Status</th>
                                <th>Last Updated At</th>
                                <th>Action </th>
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
    const filters = $("#filter_bill_form").serializeArray();
    let normalizedFilters = {};
    for (filter of filters) {
        switch (filter.name) {

            case "filter_block[]":
                if (!normalizedFilters.block) {
                    normalizedFilters.block = []
                }
                normalizedFilters.block.push(filter.value)
                break;
            case "filter_fno[]":
                if (!normalizedFilters.fno) {
                    normalizedFilters.fno = []
                }
                normalizedFilters.fno.push(filter.value)
                break;
            case "filter_bmonth[]":
                if (!normalizedFilters.bmonth) {
                    normalizedFilters.bmonth = []
                }
                normalizedFilters.bmonth.push(filter.value)
                break;
        }
    }
    console.log("Normalized Filters: " + normalizedFilters);
    return normalizedFilters
}

//DATATABLE CREATE
function loadCurrent() {
    var table = $('#dataTable-managebills').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        autoWidth: true,
        responsive: true,
        serverMethod: 'post',
        aaSorting: [],
        dom: '<"d-flex justify-content-between table-buttons-bills"fBl>tip',
        buttons: [{
            extend: 'excel',
            title: "bills-data",
            text: '<span> <i class="fas fa-download "></i> EXCEL</span>',
            className: "btn btn-outline-primary  ",
            action: newExportAction,
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6]
            }
        }, {
            extend: "pdfHtml5",
            title: "bills-data",
            text: '<span> <i class="fas fa-download "></i> PDF</span>',
            className: "btn btn-outline-primary  mx-2",
            action: newExportAction,
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6]
            },
        }, ],
        ajax: {
            'url': 'includes/loadInfo/manage_bills.php',
            "data": function(d) {
                console.log(d);
                d.filters = getFilters();
                return d
            }
        },
        fnDrawCallback: function() {
            $(".action-btn").on('click', loadModalCurrent)
            $(".selectrow").attr("disabled", true);
            $("th").removeClass('selectbox');
            $(".selectbox").click(function(e) {
                var row = $(this).closest('tr')
                var checkbox = $(this).find('input');
                console.log(checkbox);
                checkbox.attr("checked", !checkbox.attr("checked"));
                row.toggleClass('selected table-secondary')
                if ($("#dataTable-managebills tbody tr.selected").length != $(
                        "#dataTable-managebills tbody tr").length) {
                    $("#select_all").prop("checked", true)
                    $("#select_all").prop("checked", false)
                } else {
                    $("#select_all").prop("checked", false)
                    $("#select_all").prop("checked", true)
                }
            })
        },
        columns: [{
                data: 'BlockNumber'
            },
            {
                data: 'FlatNumber'
            },
            {
                data: 'bill_month'
            },
            {
                data: 'Bill'
            },
            {
                data: 'Receipt'
            },
            {
                data: 'Status'
            },
            {
                data: 'updated_at'
            },
            {
                data: 'action'
            },
        ],
        columnDefs: [{
                targets: [3, 4, 7], // column index (start from 0)
                orderable: false, // set orderable false for selected columns
            },
            {
                className: "BlockNumber",
                "targets": [0],
            },
            {
                width: "5%",
                targets: [7]
            },

        ],
    });
    table.columns.adjust()
}

//action modal part
function loadModalCurrent() {
    var target_row = $(this).closest("tr"); // this line did the trick
    // console.log(target_row)
    // var btn=$(this);
    var aPos = $("#dataTable-managebills").dataTable().fnGetPosition(target_row.get(0));
    var areaData = $('#dataTable-managebills').DataTable().row(aPos).data()
    // console.log("AreaData"+areaData);
    var json_areaData = JSON.stringify(areaData)
    console.log("Json Area data modal: " + json_areaData)
    $.ajax({
        type: "POST",
        url: "includes/loadInfo/loadmodal_bills.php",
        // data: form_serialize,
        // dataType: "json",
        data: json_areaData,
        success: function(output) {
            target_row.append(output);
            $('#update-del-modal').modal('show')
            $(document).on('hidden.bs.modal', '#update-del-modal', function() {
                $("#update-del-modal").remove();
            });
            $('#update_bill').submit(function(e) {
                update_bills(e);
                // $('#update-del-modal').modal('hide');
            });
        }
    });
}

$("#filter_bill_form").submit(function(e) {
    e.preventDefault();
    console.log("hi");
    $('#dataTable-managebills').DataTable().ajax.reload();
    $("#exampleModalCenter1").modal("hide")
})

function update_bills(e) {
    e.preventDefault();
    var form = $('#update_bill');
    var form_serialize = form.serializeArray(); // serializes the form's elements.
    console.log(form_serialize)
    form_serialize.push({
        name: $("#update_bill_btn").attr('name'),
        value: $("#update_bill_btn").attr('value')
    });
    $("#update_bill_btn").text("Updating...");
    $("#update_bill_btn").attr("disabled", true);
    $.ajax({
        type: "POST",
        url: "includes/queries/manage_bills.php",
        data: form_serialize,
        success: function(data) {
            // alert(data); // show response from the php script.

            $("#update_bill_btn").text("Updated Successfully");
            $("#update_bill_btn").removeClass("btn-primary");
            $("#update_bill_btn").addClass("btn-success");
            var row = $("#update-del-modal").closest('tr');
            var aPos = $("#dataTable-managebills").dataTable().fnGetPosition(row.get(0));
            var temp = $("#dataTable-managebills").DataTable().row(aPos).data();
            // console.log(temp)
            // console.log("Hi", form_serialize)
            temp['Status'] = form_serialize[3].value == '0' ? "Not Paid" : "Paid"; //new values
            temp['updated_at'] = form_serialize[6].value; //new values
            $('#dataTable-managebills').dataTable().fnUpdate(temp, aPos, undefined, false);
            $('.action-btn').off('click')
            $('.action-btn').on('click', loadModalCurrent)
            // $("#dataTable-managebills").DataTable().row(aPos).draw(false);
            $('#error_record').remove();
        }

    });
}

$("#clear-filters").click(function(e) {
    $('#filter_bill_form').trigger('reset');
    $('#dataTable-managebills').DataTable().ajax.reload(false);
});
</script>


<?php

include './includes/shared/footer.php';
include './includes/shared/scripts.php';

?>