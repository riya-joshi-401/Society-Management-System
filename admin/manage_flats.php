<?php include './includes/shared/header.php';?>
<?php include './includes/shared/sidebar.php';?>
<?php include './includes/shared/topbar.php';?>

<!-- Begin Page Content -->
<div class="container-fluid">
    <h3 class="my-4">Flats</h3>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card mt-2">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <div class="row align-items-center">
                        <div class="col-12 mb-3">
                            <h4 class="m-0 font-weight-bold text-primary">Flat List</h4>
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

                                <form class="forms-sample" id="filter_flats_form" method="POST" action="">
                                    <div class="form-check">
                                        <label for="">Block</label>
                                        <br>
                                        <?php
$block_numbers = array();
//$user = $_SESSION['username'];
$query = "SELECT distinct(BlockNumber) FROM flats";
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
$flatnumber = array();
$query = "SELECT distinct(FlatNumber) FROM flats";
if ($result = mysqli_query($con, $query)) {
    $rowcount = mysqli_num_rows($result);
    while ($row = mysqli_fetch_array($result)) {
        $flatnumber = $row['FlatNumber'];
        echo '<div class="custom-control custom-checkbox custom-control-inline">
                                                            <input checked type="checkbox" name="filter_flatnumber[]" class="custom-control-input" value="' . $flatnumber . '" id="filter_series_' . $flatnumber . '">
                                                            <label class="custom-control-label" for="filter_series_' . $flatnumber . '">' . $flatnumber . '</label>
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
$ftypes = array();
$query = "SELECT distinct(FlatType) FROM flatarea where BlockNumber in (Select BlockNumber from flats)";
if ($result = mysqli_query($con, $query)) {
    $rowcount = mysqli_num_rows($result);
    while ($row = mysqli_fetch_array($result)) {
        $ftypes = $row['FlatType'];
        echo '<div class="custom-control custom-checkbox custom-control-inline">
                                                            <input checked type="checkbox" name="filter_ftypes[]" class="custom-control-input" value="' . $ftypes . '" id="filter_ftypes_' . $ftypes . '">
                                                            <label class="custom-control-label" for="filter_ftypes_' . $ftypes . '">' . $ftypes . '</label>
                                                        </div>';
    }
}
?>
                                    </div>

                                    <br />
                                    <div class="form-check">
                                        <label for="">Floor</label>
                                        <br>
                                        <?php
$ftypes = array();
$query = "SELECT distinct(Floor) FROM flats";
if ($result = mysqli_query($con, $query)) {
    $rowcount = mysqli_num_rows($result);
    while ($row = mysqli_fetch_array($result)) {
        $ftypes = $row['Floor'];
        echo '<div class="custom-control custom-checkbox custom-control-inline">
                                                            <input checked type="checkbox" name="filter_ftypes[]" class="custom-control-input" value="' . $ftypes . '" id="filter_ftypes_' . $ftypes . '">
                                                            <label class="custom-control-label" for="filter_ftypes_' . $ftypes . '">' . $ftypes . '</label>
                                                        </div>';
    }
}
?>
                                    </div>

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
                <div class="card-body ">
                    <table class="table table-bordered table-responsive" id="dataTable-flats" width="100%"
                        cellspacing="0">
                        <thead>
                            <tr>
                                <th>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="select_all">
                                        <label class="custom-control-label" for="select_all"></label>
                                    </div>
                                </th>
                                <th>Flat Number</th>
                                <th>Block Number</th>
                                <th>Flat Type</th>
                                <th>Floor</th>
                                <th>Maintenance</th>
                                <th>Action </th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th>Flat Number</th>
                                <th>Block Number</th>
                                <th>Flat Type</th>
                                <th>Floor</th>
                                <th>Maintenance</th>
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
    const filters = $("#filter_flats_form").serializeArray();
    let normalizedFilters = {};
    for (filter of filters) {
        switch (filter.name) {

            case "filter_block[]":
                if (!normalizedFilters.block) {
                    normalizedFilters.block = []
                }
                normalizedFilters.block.push(filter.value)
                break;
            case "filter_ftypes[]":
                if (!normalizedFilters.ftypes) {
                    normalizedFilters.ftypes = []
                }
                normalizedFilters.ftypes.push(filter.value)
                break;
            case "filter_flatnumber[]":
                if (!normalizedFilters.flatnumber) {
                    normalizedFilters.flatnumber = []
                }
                normalizedFilters.flatnumber.push(filter.value)
                break;

            case "filter_floor[]":
                if (!normalizedFilters.floor) {
                    normalizedFilters.floor = []
                }
                normalizedFilters.floor.push(filter.value)
                break;
        }
    }
    // console.log("Normalized Filters: "+normalizedFilters);
    return normalizedFilters
}

//DATATABLE CREATE
function loadCurrent() {
    var table = $('#dataTable-flats').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        autoWidth: false,
        responsive: true,
        serverMethod: 'post',
        aaSorting: [],
        dom: '<"d-flex justify-content-between table-buttons-addflats"fBl>tip',
        buttons: [{
            extend: 'excel',
            title: "flats-data",
            text: '<span> <i class="fas fa-download "></i> EXCEL</span>',
            className: "btn btn-outline-primary  ",
            action: newExportAction,
            exportOptions: {
                columns: [1, 2, 3, 4, 5]
            }
        }, {
            extend: "pdfHtml5",
            title: "flats-data",
            text: '<span> <i class="fas fa-download "></i> PDF</span>',
            className: "btn btn-outline-primary  mx-2",
            action: newExportAction,
            exportOptions: {
                columns: [1, 2, 3, 4, 5]
            },
        }, ],
        ajax: {
            'url': 'includes/loadInfo/manage_flats.php',
            "data": function(d) {
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
                //console.log(checkbox);
                checkbox.attr("checked", !checkbox.attr("checked"));
                row.toggleClass('selected table-secondary')
                if ($("#dataTable-flats tbody tr.selected").length != $(
                        "#dataTable-flats tbody tr").length) {
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
                data: 'FlatNumber'
            },
            {
                data: 'BlockNumber'
            },
            {
                data: 'FlatType'
            },
            {
                data: 'Floor'
            },
            {
                data: 'Maintenance'
            },
            {
                data: 'action'
            },
        ],
        columnDefs: [{
                targets: [0, 3, 5, 6], // column index (start from 0)
                orderable: false, // set orderable false for selected columns
            },
            {
                className: "selectbox",
                targets: [0]
            },
            {
                className: "BlockNumber",
                "targets": [1]
            },
            {
                width: "5%",
                targets: [6]
            }
        ],
    });
    table.columns.adjust()
}
//SELECT CHECKALL
$("#select_all").click(function(e) {
    // console.log("Hi")
    //   var row=$(this).closest('tr')
    if ($(this).is(":checked")) {
        $("#dataTable-flats tbody tr").addClass("selected table-secondary");
        $(".selectrow").attr("checked", true);
    } else {
        $(".selectrow").attr("checked", false);
        $("#dataTable-flats tbody tr").removeClass("selected table-secondary");
    }
    //   row.toggleClass('selected table-secondary')
})
//action modal part
function loadModalCurrent() {
    var target_row = $(this).closest("tr"); // this line did the trick
    // console.log(target_row)
    // var btn=$(this);
    var aPos = $("#dataTable-flats").dataTable().fnGetPosition(target_row.get(0));
    var areaData = $('#dataTable-flats').DataTable().row(aPos).data()
    // console.log("AreaData"+areaData);
    var json_areaData = JSON.stringify(areaData)
    // console.log("Json Area data modal: "+json_areaData)
    $.ajax({
        type: "POST",
        url: "includes/loadInfo/loadmodal_flats.php",
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
            $('#delete_flats').submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var form_serialize = form.serializeArray(); // serializes the form's elements.
                form_serialize.push({
                    name: $("#delete_flats_btn").attr('name'),
                    value: $("#delete_flats_btn").attr('value')
                });
                // alert('hi');
                //console.log(form_serialize);
                $("#delete_flats_btn").text("Deleting...");
                $("#delete_flats_btn").attr("disabled", true);
                $.ajax({
                    type: "POST",
                    url: "includes/queries/flats.php",
                    data: form_serialize,
                    success: function(data) {
                        //    alert(data); // show response from the php script.
                        $("#delete_flats_btn").text("Deleted Successfully");
                        var row = $("#update-del-modal").closest('tr');
                        var aPos = $("#dataTable-flats").dataTable().fnGetPosition(
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
            $('#update_flats').submit(function(e) {
                update_flats(e);
                // $('#update-del-modal').modal('hide');
            });
        }
    });
}

$("#filter_flats_form").submit(function(e) {
    e.preventDefault();
    //console.log("hi");
    $('#dataTable-flats').DataTable().ajax.reload();
    $("#exampleModalCenter1").modal("hide")
})

function update_flats(e) {
    e.preventDefault();
    var form = $('#update_flats');
    var form_serialize = form.serializeArray(); // serializes the form's elements.
    // console.log(form_serialize)
    form_serialize.push({
        name: $("#update_flats_btn").attr('name'),
        value: $("#update_flats_btn").attr('value')
    });
    $("#update_flats_btn").text("Updating...");
    $("#update_flats_btn").attr("disabled", true);
    $.ajax({
        type: "POST",
        url: "includes/queries/flats.php",
        data: form_serialize,
        success: function(data) {
            // alert(data); // show response from the php script.
            console.log(data);
            if (data === "Exists_record") {
                $('#error_record').text(
                    '*This data already exists! Please change the Block or flat value');
                $('#error_record').addClass("text-danger");
                $("#update_flats_btn").text("Update");
                $("#update_flats_btn").attr("disabled", false);
            } else if (data == 'Block_no_exist') {
                $('#error_record').text(
                    '*Block Number does not exist!');
                $('#error_record').addClass("text-danger");
                $("#update_flats_btn").text("Update");
                $("#update_flats_btn").attr("disabled", false);
            } else {
                $("#update_flats_btn").text("Updated Successfully");
                $("#update_flats_btn").removeClass("btn-primary");
                $("#update_flats_btn").addClass("btn-success");
                var row = $("#update-del-modal").closest('tr');
                var aPos = $("#dataTable-flats").dataTable().fnGetPosition(row.get(0));
                var temp = $("#dataTable-flats").DataTable().row(aPos).data();
                // console.log(temp)
                console.log("Hi ", form_serialize)
                temp['BlockNumber'] = form_serialize[0].value; //new values
                //temp['']
                temp['FlatNumber'] = form_serialize[2].value; //new values
                //temp['FlatType'] = form_serialize[3].value;
                temp['Floor'] = form_serialize[4].value;
                //temp['updated_at'] = date("Y-m-d H:i:s");
                // temp['Updatedby'] = $_SESSION['username'];
                $('#dataTable-flats').dataTable().fnUpdate(temp, aPos, undefined, false);
                $('.action-btn').off('click')
                $('.action-btn').on('click', loadModalCurrent)
                // $("#dataTable-flats").DataTable().row(aPos).draw(false);
                $('#error_record').remove();
            }
        }
    });
}


$("#delete_selected_response_btn").click(function(e) {
    alert("You have selected " + $("#dataTable-flats tbody tr.selected").length + " record(s) for deletion");
    var delete_rows = $("#dataTable-flats").DataTable().rows('.selected').data()
    var delete_data = {}
    for (var i = 0; i < delete_rows.length; i++) {
        // console.log("delete:"+delete_rows[i].FlatNumber)
        baseData = {}
        baseData['block'] = delete_rows[i].BlockNumber
        baseData['flatnumber'] = delete_rows[i].FlatNumber
        delete_data[i] = baseData
        // console.log("Base Data:"+baseData);
    }
    var actual_data = {}
    actual_data['type'] = 'current'
    actual_data['delete_data'] = delete_data
    actual_delete_data_json = JSON.stringify(actual_data)
    // console.log("Actual Data:"+actual_delete_data_json)
    $.ajax({
        type: "POST",
        url: "includes/queries/delete_multiple_flats.php",
        data: actual_delete_data_json,
        success: function(data) {
            // console.log("Returned data: "+data)
            $("#dataTable-flats").DataTable().draw(false);
        }
    })
})

$("#clear-filters").click(function(e) {
    $('#filter_flats_form').trigger('reset');
    $('#dataTable-flats').DataTable().ajax.reload(false);
});
</script>


<?php

include './includes/shared/footer.php';
include './includes/shared/scripts.php';

?>