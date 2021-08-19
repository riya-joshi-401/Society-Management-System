<?php
include './includes/shared/header.php';
?>

<?php include './includes/shared/sidebar.php';?>

<?php include './includes/shared/topbar.php';?>

<!-- Begin Page Content -->
<div class="container-fluid">
    <h3 class="my-4">Flat Charges</h3>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card mt-2">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <div class="row align-items-center">
                        <div class="col-12 mb-3">
                            <h4 class="m-0 font-weight-bold text-primary">Additional Flat Charges</h4>
                        </div>
                        <div class="col-6 offset-md-8 col-md-1 text-center">
                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                data-target="#exampleModalCenter1">
                                <i class="fas fa-filter"></i>
                            </button>
                        </div>
                        <div class="col-6 col-md-3 text-center" id="delete_selected_response_div">
                            <button type="button" class="btn btn-danger" id="delete_selected_response_btn"
                                name="delete_selected_current">
                                <i class="fas fa-trash-alt">&nbsp;</i>Selected Records
                            </button>
                        </div>
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
                                        <label for="">Block</label>
                                        <br>
                                        <?php

$block_numbers = array();
// $user = $_SESSION['username'];

$query = "SELECT distinct(flats.BlockNumber) FROM `additional_charges` inner join flats on additional_charges.FlatID = flats.FlatID";
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
                                        <label for="">Flat</label>
                                        <br>
                                        <?php
$flat = array();
$query = "SELECT distinct(flats.FlatNumber) FROM `additional_charges` inner join flats on additional_charges.FlatID = flats.FlatID";
if ($result = mysqli_query($con, $query)) {
    $rowcount = mysqli_num_rows($result);
    while ($row = mysqli_fetch_array($result)) {
        $flat = $row['FlatNumber'];
        echo '<div class="custom-control custom-checkbox custom-control-inline">
                                                            <input checked type="checkbox" name="filter_flats[]" class="custom-control-input" value="' . $flat . '" id="filter_flats_' . $flat . '">
                                                            <label class="custom-control-label" for="filter_flats_' . $flat . '">' . $flat . '</label>
                                                        </div>';
    }
}
?>
                                    </div>
                                    <br />
                                    <div class="form-check">
                                        <label for="">Flat Type</label>
                                        <br>
                                        <?php
$ftype = array();
$query = "SELECT distinct(flatarea.FlatType) FROM `additional_charges` inner join flats on additional_charges.FlatID = flats.FlatID inner join flatarea on flatarea.FlatAreaID = flats.FlatAreaID";
if ($result = mysqli_query($con, $query)) {
    $rowcount = mysqli_num_rows($result);
    while ($row = mysqli_fetch_array($result)) {
        $ftype = $row['FlatType'];
        echo '<div class="custom-control custom-checkbox custom-control-inline">
                                                            <input checked type="checkbox" name="filter_ftype[]" class="custom-control-input" value="' . $ftype . '" id="filter_ftype_' . $ftype . '">
                                                            <label class="custom-control-label" for="filter_ftype_' . $ftype . '">' . $ftype . '</label>
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
$query = "SELECT distinct(Bill_month) FROM additional_charges";
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
                                    <div class="form-check">
                                        <label for="">Reason</label>
                                        <br>
                                        <?php
$reason = array();
$query = "SELECT distinct(Reason) FROM additional_charges";
if ($result = mysqli_query($con, $query)) {
    $rowcount = mysqli_num_rows($result);
    while ($row = mysqli_fetch_array($result)) {
        $reason = $row['Reason'];
        echo '<div class="custom-control custom-checkbox custom-control-inline">
                                                            <input checked type="checkbox" name="filter_reason[]" class="custom-control-input" value="' . $reason . '" id="filter_reason_' . $reason . '">
                                                            <label class="custom-control-label" for="filter_reason_' . $reason . '">' . $reason . '</label>
                                                        </div>';
    }
}
?>
                                    </div>
                                    <br />

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
                    <table class="table table-bordered table-responsive" id="dataTable-charges" width="100%"
                        cellspacing="0">
                        <thead>
                            <tr>
                                <th>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="select_all">
                                        <label class="custom-control-label" for="select_all"></label>
                                    </div>
                                </th>
                                <th>Block Number</th>
                                <th>Flat Number</th>
                                <th>Flat Type</th>
                                <th>Amount</th>
                                <th>Reason</th>
                                <th>Bill Month</th>
                                <th>Last Updated By</th>
                                <th>Last Updated At</th>
                                <th>Action </th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th>Block Number</th>
                                <th>Flat Number</th>
                                <th>Flat Type</th>
                                <th>Amount</th>
                                <th>Reason</th>
                                <th>Bill Month</th>
                                <th>Last Updated By</th>
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
    const filters = $("#filter_charges_form").serializeArray();
    let normalizedFilters = {};
    for (filter of filters) {
        switch (filter.name) {

            case "filter_block[]":
                if (!normalizedFilters.block) {
                    normalizedFilters.block = []
                }
                normalizedFilters.block.push(filter.value)
                break;
            case "filter_flats[]":
                if (!normalizedFilters.flats) {
                    normalizedFilters.flats = []
                }
                normalizedFilters.flats.push(filter.value)
                break;

            case "filter_ftype[]":
                if (!normalizedFilters.ftype) {
                    normalizedFilters.ftype = []
                }
                normalizedFilters.ftype.push(filter.value)
                break;

            case "filter_bmonth[]":
                if (!normalizedFilters.bmonth) {
                    normalizedFilters.bmonth = []
                }
                normalizedFilters.bmonth.push(filter.value)
                break;

            case "filter_reason[]":
                if (!normalizedFilters.reason) {
                    normalizedFilters.reason = []
                }
                normalizedFilters.reason.push(filter.value)
                break;
        }
    }
    // console.log("Normalized Filters: " + normalizedFilters);
    return normalizedFilters
}

//DATATABLE CREATE
function loadCurrent() {
    var table = $('#dataTable-charges').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        autoWidth: true,
        responsive: true,
        serverMethod: 'post',
        aaSorting: [],
        dom: '<"d-flex justify-content-between table-buttons-addfarea"fBl>tip',
        buttons: [{
            extend: 'excel',
            title: "flat-charges-data",
            text: '<span> <i class="fas fa-download "></i> EXCEL</span>',
            className: "btn btn-outline-primary  ",
            action: newExportAction,
            exportOptions: {
                columns: [1, 2, 3, 4, 5, 6, 7, 8]
            }
        }, {
            extend: "pdfHtml5",
            title: "flat-charges-data",
            text: '<span> <i class="fas fa-download "></i> PDF</span>',
            className: "btn btn-outline-primary  mx-2",
            action: newExportAction,
            exportOptions: {
                columns: [1, 2, 3, 4, 5, 6, 7, 8]
            },
        }, ],
        ajax: {
            'url': 'includes/loadInfo/manage_flat_charges.php',
            "data": function(d) {
                // console.log(d);
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
                if ($("#dataTable-charges tbody tr.selected").length != $(
                        "#dataTable-charges tbody tr").length) {
                    $("#select_all").prop("checked", true)
                    $("#select_all").prop("checked", false)
                } else {
                    $("#select_all").prop("checked", false)
                    $("#select_all").prop("checked", true)
                }
            })
        },
        columns: [{
                data: 'select-cbox'
            },
            {
                data: 'BlockNumber'
            },
            {
                data: 'FlatNumber'
            },
            {
                data: 'FlatType'
            },
            {
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
            {
                data: 'action'
            },
        ],
        columnDefs: [{
                targets: [0, 9], // column index (start from 0)
                orderable: false, // set orderable false for selected columns
            },
            {
                className: "selectbox",
                targets: [0],
            },
            {
                className: "BlockNumber",
                "targets": [1],
            },
            {
                width: "2%",
                targets: [9]
            },

        ],
    });
    table.columns.adjust()
}
//SELECT CHECKALL
$("#select_all").click(function(e) {
    // console.log("Hi")
    //   var row=$(this).closest('tr')
    if ($(this).is(":checked")) {
        $("#dataTable-charges tbody tr").addClass("selected table-secondary");
        $(".selectrow").attr("checked", true);
    } else {
        $(".selectrow").attr("checked", false);
        $("#dataTable-charges tbody tr").removeClass("selected table-secondary");
    }
    //   row.toggleClass('selected table-secondary')
})
//action modal part
function loadModalCurrent() {
    var target_row = $(this).closest("tr"); // this line did the trick
    // console.log(target_row)
    // var btn=$(this);
    var aPos = $("#dataTable-charges").dataTable().fnGetPosition(target_row.get(0));
    var areaData = $('#dataTable-charges').DataTable().row(aPos).data()
    // console.log("AreaData"+areaData);
    var json_areaData = JSON.stringify(areaData)
    // console.log("Json Area data modal: " + json_areaData)
    $.ajax({
        type: "POST",
        url: "includes/loadInfo/loadmodal_additional_charges.php",
        // data: form_serialize,
        // dataType: "json",
        data: json_areaData,
        success: function(output) {
            // $("#"+x).text("Deleted Successfully");
            target_row.append(output);
            $('#update-del-modal').modal('show')
            $(document).on('hidden.bs.modal', '#update-del-modal', function() {
                $("#update-del-modal").remove();
            });
            $('#delete_additional_charges').submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var form_serialize = form.serializeArray(); // serializes the form's elements.
                form_serialize.push({
                    name: $("#delete_charges_btn").attr('name'),
                    value: $("#delete_charges_btn").attr('value')
                });
                // alert('hi');
                console.log(form_serialize);
                $("#delete_charges_btn").text("Deleting...");
                $("#delete_charges_btn").attr("disabled", true);
                $.ajax({
                    type: "POST",
                    url: "includes/queries/add_additional_charges_bills.php",
                    data: form_serialize,
                    success: function(data) {
                        //    alert(data); // show response from the php script.
                        $("#delete_charges_btn").text("Deleted Successfully");
                        var row = $("#update-del-modal").closest('tr');
                        var aPos = $("#dataTable-charges").dataTable().fnGetPosition(
                            row.get(0));
                        $('#update-del-modal').modal('hide');
                        $('body').removeClass('modal-open');
                        $('.modal-backdrop').remove();
                        // row.remove();
                        loadCurrent();

                        // console.log(aPos);
                        // console.log(row)
                    }
                });
            });
            $('#update_charges').submit(function(e) {
                update_charges(e);
                // $('#update-del-modal').modal('hide');
            });
        }
    });
}

$("#filter_charges_form").submit(function(e) {
    e.preventDefault();
    console.log("hi");
    $('#dataTable-charges').DataTable().ajax.reload();
    $("#exampleModalCenter1").modal("hide")
})

function update_charges(e) {
    e.preventDefault();
    var form = $('#update_charges');
    var form_serialize = form.serializeArray(); // serializes the form's elements.
    console.log("Form ser:", form_serialize);
    form_serialize.push({
        name: $("#update_charges_btn").attr('name'),
        value: $("#update_charges_btn").attr('value')
    });
    $("#update_charges_btn").text("Updating...");
    $("#update_charges_btn").attr("disabled", true);
    $.ajax({
        type: "POST",
        url: "includes/queries/add_additional_charges_bills.php",
        data: form_serialize,
        success: function(data) {
            // alert(data); // show response from the php script.
            // console.log(data);
            if (data === "FlatExists_0") {
                $('#error_record').text(
                    '*Flat does not exist. Please change the flat or block value');
                $('#error_record').addClass('text-danger');
                $("#update_charges_btn").text("Update");
                $("#update_charges_btn").attr("disabled", false);
            } else if (data === "fieldsRequired_0") {
                $('#error_record').text(
                    '*All the fields are required');
                $('#error_record').addClass('text-danger');
                $("#update_charges_btn").text("Update");
                $("#update_charges_btn").attr("disabled", false);
            } else {
                $("#update_charges_btn").text("Updated Successfully");
                $("#update_charges_btn").removeClass("btn-primary");
                $("#update_charges_btn").addClass("btn-success");
                var row = $("#update-del-modal").closest('tr');
                var aPos = $("#dataTable-charges").dataTable().fnGetPosition(row.get(0));
                var temp = $("#dataTable-charges").DataTable().row(aPos).data();
                // console.log(temp)
                // console.log("Hi", form_serialize)
                temp['BlockNumber'] = form_serialize[0].value; //new values
                temp['FlatNumber'] = form_serialize[2].value; //new values
                temp['Amount'] = form_serialize[4].value; //new values
                // temp['FlatType'] = form_serialize[6].value;
                temp['Reason'] = form_serialize[6].value;
                temp['UpdatedAt'] = form_serialize[9].value;
                // temp['Updatedby'] = $_SESSION['username'];
                temp['Updatedby'] = "<?php echo $_SESSION['username']; ?>";
                $('#dataTable-charges').dataTable().fnUpdate(temp, aPos, undefined, false);
                $('.action-btn').off('click')
                $('.action-btn').on('click', loadModalCurrent)
                // $("#dataTable-charges").DataTable().row(aPos).draw(false);
                $('#error_record').remove();
            }
        }
    });
}


$("#delete_selected_response_btn").click(function(e) {
    alert("You have selected " + $("#dataTable-charges tbody tr.selected").length + " record(s) for deletion");
    var delete_rows = $("#dataTable-charges").DataTable().rows('.selected').data()
    var delete_data = {}
    for (var i = 0; i < delete_rows.length; i++) {
        // console.log("delete:"+delete_rows[i].FlatSeries)
        baseData = {}
        baseData['block'] = delete_rows[i].BlockNumber
        baseData['flat'] = delete_rows[i].FlatNumber
        baseData['amount'] = delete_rows[i].Amount
        baseData['reason'] = delete_rows[i].Reason
        baseData['bmonth'] = delete_rows[i].Bill_month
        baseData['updatedby'] = delete_rows[i].Updated_by
        // console.log(baseData['updatedby'])
        baseData['updatedat'] = delete_rows[i].Updated_at
        delete_data[i] = baseData
        // console.log("Base Data:" + baseData);
    }
    var actual_data = {}
    actual_data['type'] = 'current'
    actual_data['delete_data'] = delete_data
    actual_delete_data_json = JSON.stringify(actual_data)
    // console.log("Actual Data:"+actual_delete_data_json)
    $.ajax({
        type: "POST",
        url: "includes/queries/delete_multiple_charges.php",
        data: actual_delete_data_json,
        success: function(data) {
            // console.log("Returned data: " + data)
            $("#dataTable-charges").DataTable().draw(false);
        }
    })
})

$("#clear-filters").click(function(e) {
    $('#filter_charges_form').trigger('reset');
    $('#dataTable-charges').DataTable().ajax.reload(false);
});
</script>


<?php

include './includes/shared/footer.php';
include './includes/shared/scripts.php';

?>