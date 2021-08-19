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
                            <h4 class="m-0 font-weight-bold text-primary">Unresolved Complaints</h4>
                        </div>
                        <div class="col-6 offset-md-11 col-md-1 text-center">
                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                data-target="#exampleModalCenter1">
                                <i class="fas fa-filter"></i> Filter
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
$query = "SELECT DISTINCT(complainttypes.complaint_type),complainttypes.complaint_id from complaints INNER JOIN complainttypes ON complainttypes.complaint_id = complaints.ComplaintType where complaints.Status='0'";
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
                                        <label for="">Block Number</label>
                                        <br>
                                        <?php
$query = "SELECT distinct(BlockNumber) FROM complaints";
if ($result = mysqli_query($con, $query)) {
    $rowcount = mysqli_num_rows($result);
    while ($row = mysqli_fetch_array($result)) {
       
        echo '<div class="custom-control custom-checkbox custom-control-inline">
                                                            <input checked type="checkbox" name="filter_block[]" class="custom-control-input" value="' . $row['BlockNumber'] . '" id="filter_block_' . $row['BlockNumber'] . '">
                                                            <label class="custom-control-label" for="filter_block_' .  $row['BlockNumber'] . '">' . $row['BlockNumber'] . '</label>
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
$query = "SELECT distinct(FlatNumber) FROM complaints where Status='0'";
if ($result = mysqli_query($con, $query)) {
    $rowcount = mysqli_num_rows($result);
    while ($row = mysqli_fetch_array($result)) {
       
        echo '<div class="custom-control custom-checkbox custom-control-inline">
                                                            <input checked type="checkbox" name="filter_flat[]" class="custom-control-input" value="' . $row['FlatNumber'] . '" id="filter_flat_' . $row['FlatNumber'] . '">
                                                            <label class="custom-control-label" for="filter_flat_' .  $row['FlatNumber'] . '">' . $row['FlatNumber'] . '</label>
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
                                <th>Complaint ID</th>
                                <th>Block Number </th>
                                <th>Flat Number </th>
                                <th>Complaint Type</th>
                                <th>Complaint Description</th>
                                <th>Raised Date</th>
                                <th>Admin Remark</th>
                                <th>Status</th>
                                <th>Resolved Date</th>
                                <th>Updated At</th>
                                <th>View</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Complaint ID</th>
                                <th>Block Number </th>
                                <th>Flat Number </th>
                                <th>Complaint Type</th>
                                <th>Complaint Description</th>
                                <th>Raised Date</th>
                                <th>Admin Remark</th>
                                <th>Status</th>
                                <th>Resolved Date</th>
                                <th>Updated At</th>
                                <th>View</th>
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
            case "filter_block[]":
                if (!normalizedFilters.block) {
                    normalizedFilters.block = []
                }
                normalizedFilters.block.push(filter.value)
                // console.log(filter.value)
                break;
            case "filter_flat[]":
                if (!normalizedFilters.flat) {
                    normalizedFilters.flat = []
                }
                normalizedFilters.flat.push(filter.value)
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
            title: "unresolved-complaints-data",
            text: '<span> <i class="fas fa-download "></i> EXCEL</span>',
            className: "btn btn-outline-primary  ",
            action: newExportAction,
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
            }
        }, {
            extend: "pdfHtml5",
            title: "unresolved-complaints-data",
            text: '<span> <i class="fas fa-download "></i> PDF</span>',
            className: "btn btn-outline-primary  mx-2",
            action: newExportAction,
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
            },
        }, ],
        ajax: {
            'url': 'includes/loadInfo/unresolved_complaints.php',
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
                data: 'RequestID'
            },
            {
                data: 'BlockNumber'
            },
            {
                data: 'FlatNumber'
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
                orderable: true, // set orderable false for selected columns
            },
            {
                targets: [10],
                orderable: false,
            },
            {
                className: "selectbox",
                targets: [0],
            },
            {
                className: "RequestID",
                "targets": [0],
            },
            {
                width: "5%",
                targets: [10]
            },

        ],
    });
    table.columns.adjust()
}



//action modal part
function loadModalCurrent() {
    var target_row = $(this).closest("tr"); // this line did the trick
    // console.log(target_row);
    // var btn=$(this);
    var aPos = $("#dataTable-complaints").dataTable().fnGetPosition(target_row.get(0));
    var complaintData = $('#dataTable-complaints').DataTable().row(aPos).data();
    // console.log("complaintData"+complaintData);
    var json_complaintData = JSON.stringify(complaintData);
    console.log("Json complaint data modal: " + json_complaintData);
    $.ajax({
        type: "POST",
        url: "includes/loadInfo/loadmodal_unresolved_complaints.php",
        // data: form_serialize,
        // dataType: "json",
        data: json_complaintData,
        success: function(output) {
            // $("#"+x).text("Deleted Successfully");
            target_row.append(output);
            $('#update-del-modal').modal('show');
            $(document).on('hidden.bs.modal', '#update-del-modal', function() {
                $("#update-del-modal").remove();
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
    $("#exampleModalCenter1").modal("hide");
})

function update_complaints(e) {
    e.preventDefault();
    var form = $('#update_complaints');
    var form_serialize = form.serializeArray(); // serializes the form's elements.
    console.log("formser:", form_serialize)
    form_serialize.push({
        name: $("#update_unresolved_complaints").attr('name'),
        value: $("#update_unresolved_complaints").attr('value')
    });
    $("#update_unresolved_complaints").text("Updating...");
    $("#update_unresolved_complaints").attr("disabled", true);
    $.ajax({
        type: "POST",
        url: "includes/queries/complaints.php",
        data: form_serialize,
        success: function(data) {
            // alert(data); // show response from the php script.
            // console.log(data);
            $("#update_unresolved_complaints").text("Updated Successfully");
            $("#update_unresolved_complaints").removeClass("btn-primary");
            $("#update_unresolved_complaints").addClass("btn-success");
            var row = $("#update-del-modal").closest('tr');
            var aPos = $("#dataTable-complaints").dataTable().fnGetPosition(row.get(0));
            // var temp = $("#dataTable-complaints").DataTable().row(aPos).data(); //no need to get data from the row
            // console.log(temp)
            // console.log("Hi", form_serialize)
            if (data === '1') {
                alert('The complaint has been shifted to the In-progress section!');
            }
            if (data === '2') {
                alert('The complaint has been shifted to the Resolved section!');
            }
            $("#dataTable-complaints").DataTable().row(aPos).remove();
            $("#dataTable-complaints").DataTable().draw(false);
            $("div").removeClass("modal-backdrop"); //remove backdrop of modal as it gets dismissed 
            $('.action-btn').off('click');
            $('.action-btn').on('click', loadModalCurrent);
            $('#error_record').remove();
        }
    });
}


$("#clear-filters").click(function(e) {
    $('#filter_complaints_form').trigger('reset');
    $('#dataTable-complaints').DataTable().ajax.reload(false);
});
</script>


<?php

include './includes/shared/footer.php';
include './includes/shared/scripts.php';

?>