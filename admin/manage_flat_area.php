<?php
include './includes/shared/header.php';
?>

<?php include './includes/shared/sidebar.php';?>

<?php include './includes/shared/topbar.php';?>

<!-- Begin Page Content -->
<div class="container-fluid">
    <h3 class="my-4">Flat Area</h3>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card mt-2">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <div class="row align-items-center">
                        <div class="col-12 mb-3">
                            <h4 class="m-0 font-weight-bold text-primary">Flat Area Records</h4>
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

                                <form class="forms-sample" id="filter_farea_form" method="POST" action="">
                                    <div class="form-check">
                                        <label for="">Block</label>
                                        <br>
                                        <?php

$block_numbers = array();
// $user = $_SESSION['username'];

$query = "SELECT distinct(BlockNumber) FROM flatarea";
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
                                        <label for="">Series</label>
                                        <br>
                                        <?php
$series = array();
$query = "SELECT distinct(FlatSeries) FROM flatarea";
if ($result = mysqli_query($con, $query)) {
    $rowcount = mysqli_num_rows($result);
    while ($row = mysqli_fetch_array($result)) {
        $series = $row['FlatSeries'];
        echo '<div class="custom-control custom-checkbox custom-control-inline">
                                                            <input checked type="checkbox" name="filter_series[]" class="custom-control-input" value="' . $series . '" id="filter_series_' . $series . '">
                                                            <label class="custom-control-label" for="filter_series_' . $series . '">' . $series . '</label>
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
$query = "SELECT distinct(FlatType) FROM flatarea";
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
                    <table class="table table-bordered table-responsive" id="dataTable-flatarea" width="100%"
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
                                <th>Flat Series</th>
                                <th>Flat Area</th>
                                <th>Flat Type</th>
                                <th>Ratepsq</th>
                                <th>Last Updated By</th>
                                <th>Last Updated At</th>
                                <th>Action </th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th>Block Number</th>
                                <th>Flat Series</th>
                                <th>Flat Area</th>
                                <th>Flat Type</th>
                                <th>Ratepsq</th>
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
    const filters = $("#filter_farea_form").serializeArray();
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
            case "filter_series[]":
                if (!normalizedFilters.series) {
                    normalizedFilters.series = []
                }
                normalizedFilters.series.push(filter.value)
                break;
        }
    }
    // console.log("Normalized Filters: "+normalizedFilters);
    return normalizedFilters
}

//DATATABLE CREATE
function loadCurrent() {
    var table = $('#dataTable-flatarea').DataTable({
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
            title: "flat-area-data",
            text: '<span> <i class="fas fa-download "></i> EXCEL</span>',
            className: "btn btn-outline-primary  ",
            action: newExportAction,
            exportOptions: {
                columns: [1, 2, 3, 4, 5, 6, 7]
            }
        }, {
            extend: "pdfHtml5",
            title: "flat-area-data",
            text: '<span> <i class="fas fa-download "></i> PDF</span>',
            className: "btn btn-outline-primary  mx-2",
            action: newExportAction,
            exportOptions: {
                columns: [1, 2, 3, 4, 5, 6, 7]
            },
        }, ],
        ajax: {
            'url': 'includes/loadInfo/manage_flat_area.php',
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
                if ($("#dataTable-flatarea tbody tr.selected").length != $(
                        "#dataTable-flatarea tbody tr").length) {
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
                data: 'FlatSeries'
            },
            {
                data: 'FlatArea'
            },
            {
                data: 'FlatType'
            },
            {
                data: 'Ratepsq'
            },
            {
                data: 'Updatedby'
            },
            {
                data: 'UpdatedAt'
            },
            {
                data: 'action'
            },
        ],
        columnDefs: [{
                targets: [0, 8], // column index (start from 0)
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
                width: "5%",
                targets: [8]
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
        $("#dataTable-flatarea tbody tr").addClass("selected table-secondary");
        $(".selectrow").attr("checked", true);
    } else {
        $(".selectrow").attr("checked", false);
        $("#dataTable-flatarea tbody tr").removeClass("selected table-secondary");
    }
    //   row.toggleClass('selected table-secondary')
})
//action modal part
function loadModalCurrent() {
    var target_row = $(this).closest("tr"); // this line did the trick
    // console.log(target_row)
    // var btn=$(this);
    var aPos = $("#dataTable-flatarea").dataTable().fnGetPosition(target_row.get(0));
    var areaData = $('#dataTable-flatarea').DataTable().row(aPos).data()
    // console.log("AreaData"+areaData);
    var json_areaData = JSON.stringify(areaData)
    // console.log("Json Area data modal: "+json_areaData)
    $.ajax({
        type: "POST",
        url: "includes/loadInfo/loadmodal_flatarea.php",
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
            $('#delete_flatarea').submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var form_serialize = form.serializeArray(); // serializes the form's elements.
                form_serialize.push({
                    name: $("#delete_flatarea_btn").attr('name'),
                    value: $("#delete_flatarea_btn").attr('value')
                });
                // alert('hi');
                console.log(form_serialize);
                $("#delete_flatarea_btn").text("Deleting...");
                $("#delete_flatarea_btn").attr("disabled", true);
                $.ajax({
                    type: "POST",
                    url: "includes/queries/flatarea.php",
                    data: form_serialize,
                    success: function(data) {
                        //    alert(data); // show response from the php script.
                        $("#delete_flatarea_btn").text("Deleted Successfully");
                        var row = $("#update-del-modal").closest('tr');
                        var aPos = $("#dataTable-flatarea").dataTable().fnGetPosition(
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
            $('#update_flatarea').submit(function(e) {
                update_flatarea(e);
                // $('#update-del-modal').modal('hide');
            });
        }
    });
}

$("#filter_farea_form").submit(function(e) {
    e.preventDefault();
    console.log("hi");
    $('#dataTable-flatarea').DataTable().ajax.reload();
    $("#exampleModalCenter1").modal("hide")
})

function update_flatarea(e) {
    e.preventDefault();
    var form = $('#update_flatarea');
    var form_serialize = form.serializeArray(); // serializes the form's elements.
    // console.log(form_serialize)
    form_serialize.push({
        name: $("#update_flatarea_btn").attr('name'),
        value: $("#update_flatarea_btn").attr('value')
    });
    $("#update_flatarea_btn").text("Updating...");
    $("#update_flatarea_btn").attr("disabled", true);
    $.ajax({
        type: "POST",
        url: "includes/queries/flatarea.php",
        data: form_serialize,
        success: function(data) {
            // alert(data); // show response from the php script.
            // console.log(data);
            if (data === "Exists_record") {
                $('#error_record').text(
                    '*This data already exists! Please change the Block or series value');
                $('#error_record').addClass('text-danger');
                $("#update_flatarea_btn").text("Update");
                $("#update_flatarea_btn").attr("disabled", false);
            } else {
                $("#update_flatarea_btn").text("Updated Successfully");
                $("#update_flatarea_btn").removeClass("btn-primary");
                $("#update_flatarea_btn").addClass("btn-success");
                var row = $("#update-del-modal").closest('tr');
                var aPos = $("#dataTable-flatarea").dataTable().fnGetPosition(row.get(0));
                var temp = $("#dataTable-flatarea").DataTable().row(aPos).data();
                // console.log(temp)
                // console.log("Hi", form_serialize)
                temp['BlockNumber'] = form_serialize[0].value; //new values
                temp['FlatArea'] = form_serialize[4].value; //new values
                temp['FlatSeries'] = form_serialize[2].value; //new values
                temp['FlatType'] = form_serialize[7].value;
                temp['Ratepsq'] = form_serialize[5].value;
                temp['UpdatedAt'] = form_serialize[8].value;
                temp['Updatedby'] = '<?php echo $_SESSION['username']; ?>'

                // temp['Updatedby'] = 'Admin1';
                $('#dataTable-flatarea').dataTable().fnUpdate(temp, aPos, undefined, false);
                $('.action-btn').off('click')
                $('.action-btn').on('click', loadModalCurrent)
                // $("#dataTable-flatarea").DataTable().row(aPos).draw(false);
                $('#error_record').remove();
            }
        }
    });
}


$("#delete_selected_response_btn").click(function(e) {
    alert("You have selected " + $("#dataTable-flatarea tbody tr.selected").length + " record(s) for deletion");
    var delete_rows = $("#dataTable-flatarea").DataTable().rows('.selected').data()
    var delete_data = {}
    for (var i = 0; i < delete_rows.length; i++) {
        // console.log("delete:"+delete_rows[i].FlatSeries)
        baseData = {}
        baseData['block'] = delete_rows[i].BlockNumber
        baseData['series'] = delete_rows[i].FlatSeries
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
        url: "includes/queries/delete_multiple_flatarea.php",
        data: actual_delete_data_json,
        success: function(data) {
            // console.log("Returned data: "+data)
            $("#dataTable-flatarea").DataTable().draw(false);
        }
    })
})

$("#clear-filters").click(function(e) {
    $('#filter_farea_form').trigger('reset');
    $('#dataTable-flatarea').DataTable().ajax.reload(false);
});
</script>


<?php

include './includes/shared/footer.php';
include './includes/shared/scripts.php';

?>