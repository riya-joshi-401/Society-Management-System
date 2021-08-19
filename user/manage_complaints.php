<?php
include './includes/shared/header.php';
?>

<?php include './includes/shared/sidebar.php';?>

<?php include './includes/shared/topbar.php';?>

<!-- Begin Page Content -->
<div class="container-fluid">
    <h3 class="my-4">Complaints</h3>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card mt-2">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <div class="row align-items-center">
                        <div class="col-12 mb-3">
                            <h4 class="m-0 font-weight-bold text-primary">Manage Complaints</h4>
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

                                <form class="forms-sample" id="filter_complaints_form" method="POST" action="">
                                    <div class="form-check">
                                        <label for="">Complaint Type</label>
                                        <br>
                                        <?php

$complaint_types = array();
$flatno = $_SESSION['flatno'];
$query = "SELECT DISTINCT(complainttypes.complaint_type),complainttypes.complaint_id from complaints INNER JOIN complainttypes ON complainttypes.complaint_id = complaints.ComplaintType where complaints.FlatNumber=" . $flatno . "";
if ($result = mysqli_query($con, $query)) {
    $rowcount = mysqli_num_rows($result);
    while ($row = mysqli_fetch_array($result)) {
        $complaint_types = $row['complaint_type'];
        $complaint_id = $row['complaint_id'];
        echo '<div class="custom-control custom-checkbox custom-control-inline">
                                                            <input type="checkbox" checked name="filter_complaint[]" class="custom-control-input" value="' . $complaint_id . '" id="filter_complaint_' . $complaint_types . '">
                                                            <label class="custom-control-label" for="filter_complaint_' . $complaint_types . '">' . $complaint_types . '</label>
                                                        </div>';
    }
}
?>
                                    </div>
                                    <br />

                                    <div class="form-check">
                                        <label for="">Status</label>
                                        <br>
                                        <?php
$status = array();
$statustype = array("0" => "Unresolved", "1" => "In-progress", "2" => "Resolved");
$query = "SELECT distinct(Status) FROM complaints where FlatNumber=" . $flatno . "";
if ($result = mysqli_query($con, $query)) {
    $rowcount = mysqli_num_rows($result);
    while ($row = mysqli_fetch_array($result)) {
        $status = $statustype[$row['Status']];
        echo '<div class="custom-control custom-checkbox custom-control-inline">
                                                            <input checked type="checkbox" name="filter_status[]" class="custom-control-input" value="' . $row['Status'] . '" id="filter_status_' . $status . '">
                                                            <label class="custom-control-label" for="filter_status_' . $status . '">' . $status . '</label>
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
                    <table class="table table-bordered table-responsive" id="dataTable-complaints" width="100%"
                        cellspacing="0">
                        <thead>
                            <tr>
                                <th>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="select_all">
                                        <label class="custom-control-label" for="select_all"></label>
                                    </div>
                                </th>
                                <th>Complaint ID</th>
                                <th>Complaint Type</th>
                                <th>Complaint Description</th>
                                <th>Raised Date</th>
                                <th>Admin Remark</th>
                                <th>Status</th>
                                <th>Resolved Date</th>
                                <th>Updated At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th>Complaint ID</th>
                                <th>Complaint Type</th>
                                <th>Complaint Description</th>
                                <th>Raised Date</th>
                                <th>Admin Remark</th>
                                <th>Status</th>
                                <th>Resolved Date</th>
                                <th>Updated At</th>
                                <th>Action</th>
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
    const filters = $("#filter_complaints_form").serializeArray();
    let normalizedFilters = {};
    for (filter of filters) {
        switch (filter.name) {

            case "filter_complaint[]":
                if (!normalizedFilters.complaint) {
                    normalizedFilters.complaint = []
                }
                normalizedFilters.complaint.push(filter.value)
                // console.log(filter.value)
                break;
            case "filter_status[]":
                if (!normalizedFilters.status) {
                    normalizedFilters.status = []
                }
                normalizedFilters.status.push(filter.value)
                // console.log(filter.value)
                break;
        }
    }
    // console.log("Normalized Filters: " + normalizedFilters);
    return normalizedFilters
}

//DATATABLE CREATE
function loadCurrent() {
    var table = $('#dataTable-complaints').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        autoWidth: true,
        responsive: true,
        serverMethod: 'post',
        aaSorting: [],
        dom: '<"d-flex justify-content-between table-buttons-addcomplaints"fBl>tip',
        buttons: [{
            extend: 'excel',
            title: "complaints-data",
            text: '<span> <i class="fas fa-download "></i> EXCEL</span>',
            className: "btn btn-outline-primary  ",
            action: newExportAction,
            exportOptions: {
                columns: [1, 2, 3, 4, 5, 6, 7, 8]
            }
        }, {
            extend: "pdfHtml5",
            title: "complaints-data",
            text: '<span> <i class="fas fa-download "></i> PDF</span>',
            className: "btn btn-outline-primary  mx-2",
            action: newExportAction,
            exportOptions: {
                columns: [1, 2, 3, 4, 5, 6, 7, 8]
            },
        }, ],
        ajax: {
            'url': 'includes/loadInfo/manage_complaints.php',
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
                if ($("#dataTable-complaints tbody tr.selected").length != $(
                        "#dataTable-complaints tbody tr").length) {
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
                data: 'RequestID'
            },
            {
                data: 'ComplaintType'
            },
            {
                data: 'Description'
            },
            {
                data: 'RaisedDate'
            },
            {
                data: 'AdminRemark'
            },
            {
                data: 'Status'
            },
            {
                data: 'ResolvedDate'
            },
            {
                data: 'updated_at'
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
                className: "ComplaintType",
                "targets": [1],
            },
            {
                width: "5%",
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
        $("#dataTable-complaints tbody tr").addClass("selected table-secondary");
        $(".selectrow").attr("checked", true);
    } else {
        $(".selectrow").attr("checked", false);
        $("#dataTable-complaints tbody tr").removeClass("selected table-secondary");
    }
    //   row.toggleClass('selected table-secondary')
})

//action modal part
function loadModalCurrent() {
    var target_row = $(this).closest("tr"); // this line did the trick
    // console.log(target_row)
    // var btn=$(this);
    var aPos = $("#dataTable-complaints").dataTable().fnGetPosition(target_row.get(0));
    var areaData = $('#dataTable-complaints').DataTable().row(aPos).data()
    // console.log("AreaData"+areaData);
    var json_areaData = JSON.stringify(areaData)
    console.log("Json Area data modal: " + json_areaData)
    $.ajax({
        type: "POST",
        url: "includes/loadInfo/loadmodal_complaints.php",
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
            $('#delete_complaints').submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var form_serialize = form.serializeArray(); // serializes the form's elements.
                form_serialize.push({
                    name: $("#delete_complaints_btn").attr('name'),
                    value: $("#delete_complaints_btn").attr('value')
                });
                // alert('hi');
                console.log(form_serialize);
                $("#delete_complaints_btn").text("Deleting...");
                $("#delete_complaints_btn").attr("disabled", true);
                $.ajax({
                    type: "POST",
                    url: "includes/queries/raise_complaint.php",
                    data: form_serialize,
                    success: function(data) {
                        // alert(data); // show response from the php script.
                        if (data == "Status_0") {
                            $("#delete_complaints_btn").text("Can not be deleted");
                            $('.modal-backdrop').remove();
                        } else {
                            $("#delete_complaints_btn").text("Deleted Successfully");
                            var row = $("#update-del-modal").closest('tr');
                            var aPos = $("#dataTable-complaints").dataTable()
                                .fnGetPosition(
                                    row.get(0));
                            $('#update-del-modal').modal('hide');
                            $('body').removeClass('modal-open');
                            $('.modal-backdrop').remove();
                        }
                        // row.remove();
                        loadCurrent();

                        // console.log(aPos);
                        // console.log(row)
                    }
                });
            });
            $('#update_complaints').submit(function(e) {
                update_complaints(e);
                // $('#update-del-modal').modal('hide');
            });
        }
    });
}

$("#filter_complaints_form").submit(function(e) {
    e.preventDefault();
    console.log("hi");
    $('#dataTable-complaints').DataTable().ajax.reload();
    $("#exampleModalCenter1").modal("hide")
})

function update_complaints(e) {
    e.preventDefault();
    var form = $('#update_complaints');
    var form_serialize = form.serializeArray(); // serializes the form's elements.
    console.log("formser:", form_serialize)
    form_serialize.push({
        name: $("#update_complaints_btn").attr('name'),
        value: $("#update_complaints_btn").attr('value')
    });
    $("#update_complaints_btn").text("Updating...");
    $("#update_complaints_btn").attr("disabled", true);
    $.ajax({
        type: "POST",
        url: "includes/queries/raise_complaint.php",
        data: form_serialize,
        success: function(data) {
            // alert(data); // show response from the php script.
            // console.log(data);

            $("#update_complaints_btn").text("Updated Successfully");
            $("#update_complaints_btn").removeClass("btn-primary");
            $("#update_complaints_btn").addClass("btn-success");
            var row = $("#update-del-modal").closest('tr');
            var aPos = $("#dataTable-complaints").dataTable().fnGetPosition(row.get(0));
            var temp = $("#dataTable-complaints").DataTable().row(aPos).data();
            // console.log(temp)
            // console.log("Hi", form_serialize)
            temp['ComplaintType'] = form_serialize[0].value; //new values
            temp['Description'] = form_serialize[2].value; //new values
            temp['updated_at'] = form_serialize[5].value;
            $('#dataTable-complaints').dataTable().fnUpdate(temp, aPos, undefined, false);
            $('.action-btn').off('click')
            $('.action-btn').on('click', loadModalCurrent)
            // $("#dataTable-complaints").DataTable().row(aPos).draw(false);
            $('#error_record').remove();

        }
    });
}


$("#delete_selected_response_btn").click(function(e) {
    alert("You have selected " + $("#dataTable-complaints tbody tr.selected").length +
        " record(s) for deletion");
    var delete_rows = $("#dataTable-complaints").DataTable().rows('.selected').data()
    var delete_data = {}
    for (var i = 0; i < delete_rows.length; i++) {
        // console.log("delete:" + delete_rows[i].Status)
        baseData = {}
        baseData['record_id'] = delete_rows[i].RequestID
        baseData['status'] = delete_rows[i].Status
        delete_data[i] = baseData
        // console.log("Base Data:"+baseData);
    }
    var actual_data = {}
    actual_data['type'] = 'current'
    actual_data['delete_data'] = delete_data
    actual_delete_data_json = JSON.stringify(actual_data)
    // console.log("Actual Data:" + actual_delete_data_json)
    $.ajax({
        type: "POST",
        url: "includes/queries/delete_multiple_complaints.php",
        data: actual_delete_data_json,
        success: function(data) {
            // console.log("Returned data: " + data)
            alert(data + " record(s) have been deleted. ");
            $("#dataTable-complaints").DataTable().draw(false);
        }
    })
})

$("#clear-filters").click(function(e) {
    $('#filter_complaints_form').trigger('reset');
    $('#dataTable-complaints').DataTable().ajax.reload(false);
});
</script>


<?php

include './includes/shared/footer.php';
include './includes/shared/scripts.php';

?>