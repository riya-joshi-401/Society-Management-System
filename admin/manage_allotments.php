<?php
//include '../config.php';
include 'includes/shared/header.php';
include 'includes/shared/sidebar.php';
include 'includes/shared/topbar.php';
?>
<div class='container-fluid'>
    <h3 class="my-4">Allotments</h3>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card mt-2">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <div class="row align-items-center">
                        <div class="col-12 mb-3">
                            <h4 class="m-0 font-weight-bold text-primary">Allotment Records</h4>
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
                                <form class="forms-sample" id="filter_allotments_form" method="POST" action="">
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
                                        <label for="">Flat Numbers</label>
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
                                        <label for="">Is Flat on Rent</label>
                                        <br>
                                        <?php
                                        $isRent = array();
                                        $query = "SELECT distinct(isRent) FROM allotments";
                                        if ($result = mysqli_query($con, $query)) {
                                            $rowcount = mysqli_num_rows($result);
                                            while ($row = mysqli_fetch_array($result)) {
                                                if ($row['isRent'] == 0) {
                                                    $isRentp = 'No';
                                                } else {
                                                    $isRentp = 'Yes';
                                                }
                                                $isRent = $row['isRent'];
                                                echo '<div class="custom-control custom-checkbox custom-control-inline">
                                                            <input checked type="checkbox" name="filter_isRent[]" class="custom-control-input" value="' . $isRent . '" id="filter_isRent_' . $isRent . '">
                                                            <label class="custom-control-label" for="filter_isRent_' . $isRent . '">' . $isRentp . '</label>
                                                        </div>';
                                            }
                                        }
                                        ?>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-primary" id="clear-filters"
                                            name="clear">clear
                                            filters</button>
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
                    <table class="table table-bordered table-responsive" id="dataTable-allotments" width="100%"
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
                                <th>Owner Name</th>
                                <th>Owner Email</th>
                                <th>Owner Contact Number</th>
                                <th>Owner Alternate Contact Number</th>
                                <th>Owner Member Count </th>
                                <th>onRent</th>
                                <th>Rentee Name</th>
                                <th>Rentee Email</th>
                                <th>Rentee Contact Number</th>
                                <th>Rentee Alternate Contact Number</th>
                                <th>Rentee Member Count </th>
                                <th>Updated By</th>
                                <th>Updated At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th>Flat Number</th>
                                <th>Block Number</th>
                                <th>Owner Name</th>
                                <th>Owner Email</th>
                                <th>Owner Contact Number</th>
                                <th>Owner Alternate Contact Number</th>
                                <th>Owner Member Count </th>
                                <th>onRent</th>
                                <th>Rentee Name</th>
                                <th>Rentee Email</th>
                                <th>Rentee Contact Number</th>
                                <th>Rentee Alternate Contact Number</th>
                                <th>Rentee Member Count </th>
                                <th>Updated By</th>
                                <th>Updated At</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    loadCurrent();
});

function getFilters() {
    const filters = $("#filter_allotments_form").serializeArray();
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
            case "filter_isRent[]":
                if (!normalizedFilters.isRent) {
                    normalizedFilters.isRent = []
                }
                normalizedFilters.isRent.push(filter.value)
                break;

        }
    }
    // console.log("Normalized Filters: "+normalizedFilters);
    return normalizedFilters
};

function loadCurrent() {
    var table = $("#dataTable-allotments").DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        autoWidth: true,
        responsive: true,
        serverMethod: 'post',
        aaSorting: [],
        dom: '<"d-flex justify-content-between table-buttons-allotments"fBl>tip',
        buttons: [{
                extend: 'excel',
                title: "allotments-data",
                text: '<span> <i class="fas fa-download "></i> EXCEL</span>',
                className: "btn btn-outline-primary  ",
                action: newExportAction,
                exportOptions: {
                    columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13]
                }
            }, {
                extend: "pdfHtml5",
                title: "allotments-data-owner",
                text: '<span> <i class="fas fa-download "></i> PDF (owner)</span>',
                className: "btn btn-outline-primary  mx-2",
                action: newExportAction,
                exportOptions: {
                    columns: [1, 2, 3, 4, 5, 6, 7, 8]
                },
            },
            {
                extend: "pdfHtml5",
                title: "allotments-data-rentee",
                text: '<span> <i class="fas fa-download "></i> PDF (rentee)</span>',
                className: "btn btn-outline-primary  mx-2",
                action: newExportAction,
                exportOptions: {
                    columns: [1, 2, 3, 8, 9, 10, 11, 12, 13]
                },
            },
        ],
        ajax: {
            'url': 'includes/loadInfo/manage_allotments.php',
            "data": function(d) {
                console.log(d);
                d.filters = getFilters();
                return d
            }
        },
        fnDrawCallback: function() {
            $(".action-btn").on('click', loadModalCurrent);
            $(".selectrow").attr("disabled", true);
            $("th").removeClass('selectbox');
            $(".selectbox").click(function(e) {
                var row = $(this).closest('tr')
                var checkbox = $(this).find('input');
                console.log(checkbox);
                checkbox.attr("checked", !checkbox.attr("checked"));
                row.toggleClass('selected table-secondary')
                if ($("#dataTable-allotments tbody tr.selected").length != $(
                        "#dataTable-allotments tbody tr").length) {
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
                data: 'OwnerName'
            },
            {
                data: 'OwnerEmail'
            },
            {
                data: 'OwnerContactNumber'
            },
            {
                data: 'OwnerAlternateContactNumber'
            },
            {
                data: 'OwnerMemberCount'
            },
            {
                data: 'isRent'
            },
            {
                data: 'RenteeName'
            },
            {
                data: 'RenteeEmail'
            },
            {
                data: 'RenteeContactNumber'
            },
            {
                data: 'RenteeAlternateContactNumber'
            },
            {
                data: 'RenteeMemberCount'
            },
            {
                data: 'updated_by'
            },
            {
                data: 'updated_at'
            },
            {
                data: 'action'
            },
        ],
        columnDefs: [{
                targets: [0, 16], // column index (start from 0)
                orderable: false, // set orderable false for selected columns
            },
            {
                className: "selectbox",
                targets: [0],
            },
            {
                className: "BlockNumber",
                targets: [2],
            },
            {
                width: "5%",
                targets: [16]
            },

        ],
    });
    table.columns.adjust();
};


$("#select_all").click(function(e) {
    // console.log("Hi")
    //   var row=$(this).closest('tr')
    if ($(this).is(":checked")) {
        $("#dataTable-allotments tbody tr").addClass("selected table-secondary");
        $(".selectrow").attr("checked", true);
    } else {
        $(".selectrow").attr("checked", false);
        $("#dataTable-allotments tbody tr").removeClass("selected table-secondary");
    }
    //   row.toggleClass('selected table-secondary')
});

function loadModalCurrent() {
    var target_row = $(this).closest("tr"); // this line did the trick
    // console.log(target_row)
    // var btn=$(this);
    var aPos = $("#dataTable-allotments").dataTable().fnGetPosition(target_row.get(0));
    var areaData = $('#dataTable-allotments').DataTable().row(aPos).data()
    // console.log("AreaData"+areaData);
    var json_areaData = JSON.stringify(areaData)
    // console.log("Json Area data modal: "+json_areaData)
    $.ajax({
        type: "POST",
        url: "includes/loadInfo/loadmodal_allotments.php",
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
            $('#delete_allotments').submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var form_serialize = form.serializeArray(); // serializes the form's elements.
                form_serialize.push({
                    name: $("#delete_allotments_btn").attr('name'),
                    value: $("#delete_allotments_btn").attr('value')
                });
                // alert('hi');
                // console.log(form_serialize);
                $("#delete_allotments_btn").text("Deleting...");
                $("#delete_allotments_btn").attr("disabled", true);
                $.ajax({
                    type: "POST",
                    url: "includes/queries/allotments.php",
                    data: form_serialize,
                    success: function(data) {
                        // alert(data); // show response from the php script.
                        $("#delete_allotments_btn").text("Deleted Successfully");
                        var row = $("#update-del-modal").closest('tr');
                        var aPos = $("#dataTable-allotments").dataTable().fnGetPosition(
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
            $('#update_allotments').submit(function(e) {
                update_allotments(e);
                // $('#update-del-modal').modal('hide');
            });
        }
    });
};

function update_allotments(e) {
    e.preventDefault();
    var form = $('#update_allotments');
    var form_serialize = form.serializeArray(); // serializes the form's elements.
    console.log(form_serialize)
    form_serialize.push({
        name: $("#update_allotments_btn").attr('name'),
        value: $("#update_allotments_btn").attr('value')
    });
    $("#update_allotments_btn").text("Updating...");
    $("#update_allotments_btn").attr("disabled", true);
    $.ajax({
        type: "POST",
        url: "includes/queries/allotments.php",
        data: form_serialize,
        success: function(data) {
            // alert(data); // show response from the php script.
            // alert(jQuery.type(data)); //check dtype
            // console.log(data);
            // data2 = data.split("#");
            // alert(data2);
            if (data === "Allotment_0") { //if allotment already exists
                $('#allotment_error_record').text(
                    '*Allotment for this flat already exists!');
                $('#allotment_error_record').addClass('text-danger');
                $("#update_allotments_btn").text("Update");
                $("#update_allotments_btn").attr("disabled", false);
                $('#flat_error_record').text('');
                $('#other_error_record').text('');
            } else if (data === "Flat_0") { // if flat does not exist
                $('#flat_error_record').text(
                    '*This flat doesn\'t exist! Please add the flat in the Add flats section');
                $('#allotment_error_record').text('');
                $('#other_error_record').text('');
                $('#flat_error_record').addClass('text-danger');
                $("#update_allotments_btn").text(
                    "Update");
                $("#update_allotments_btn").attr("disabled", false);
            } else if (data.includes("#")) { //if fields are empty or with invalid values
                data2 = data.split("#");
                // alert(data2);
                $('#other_error_record').text(data2.slice(1, data2.length));
                $('#other_error_record').addClass('text-danger');
                $("#update_allotments_btn").text("Update");
                $("#update_allotments_btn").attr("disabled", false);
                $('#flat_error_record').text('');
                $('#allotment_error_record').text('');
            } else { //updated the record successfully
                $("#update_allotments_btn").text("Updated Successfully");
                $("#update_allotments_btn").removeClass("btn-primary");
                $("#update_allotments_btn").addClass("btn-success");
                var row = $("#update-del-modal").closest('tr');
                var aPos = $("#dataTable-allotments").dataTable().fnGetPosition(row.get(0));
                var temp = $("#dataTable-allotments").DataTable().row(aPos).data();
                // console.log(temp)
                // console.log("Hi", form_serialize)
                temp['BlockNumber'] = form_serialize[0].value; //new values
                temp['FlatNumber'] = form_serialize[2].value; //new values
                temp['OwnerName'] = form_serialize[4].value;
                temp['OwnerEmail'] = form_serialize[6].value;
                temp['OwnerContactNumber'] = form_serialize[8].value;
                temp['OwnerAlternateContactNumber'] = form_serialize[10].value;
                temp['OwnerMemberCount'] = form_serialize[12].value;
                temp['isRent'] = form_serialize[14].value === '1' ? 'Yes' : 'No';
                if (form_serialize[14].value === '1') {
                    temp['RenteeName'] = form_serialize[16].value;
                    temp['RenteeEmail'] = form_serialize[18].value;
                    temp['RenteeContactNumber'] = form_serialize[20].value;
                    temp['RenteeAlternateContactNumber'] = form_serialize[22].value;
                    temp['RenteeMemberCount'] = form_serialize[24].value;
                } else {
                    temp['RenteeName'] = temp['RenteeEmail'] = temp['RenteeContactNumber'] = temp[
                        'RenteeAlternateContactNumber'] = temp['RenteeMemberCount'] = '-';
                }
                temp['updated_at'] = form_serialize[25].value;
                temp['updated_by'] = form_serialize[26].value;

                $('#dataTable-allotments').dataTable().fnUpdate(temp, aPos, undefined, false);
                $('.action-btn').off('click')
                $('.action-btn').on('click', loadModalCurrent)
                $('#flat_error_record').remove();
                $('#allotment_error_record').remove();
            }
        }
    });
}

$("#filter_allotments_form").submit(function(e) {
    e.preventDefault();
    console.log("hi");
    $('#dataTable-allotments').DataTable().ajax.reload();
    $("#exampleModalCenter1").modal("hide")
});

$("#delete_selected_response_btn").click(function(e) {
    alert("You have selected " + $("#dataTable-allotments tbody tr.selected").length +
        " record(s) for deletion");
    var delete_rows = $("#dataTable-allotments").DataTable().rows('.selected').data()
    var delete_data = {}
    for (var i = 0; i < delete_rows.length; i++) {
        // console.log("delete:"+delete_rows[i].FlatSeries)
        baseData = {}
        baseData['block'] = delete_rows[i].BlockNumber
        baseData['oname'] = delete_rows[i].OwnerName
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
        url: "includes/queries/delete_multiple_allotments.php",
        data: actual_delete_data_json,
        success: function(data) {
            //console.log("Returned data: " + data)
            $("#dataTable-allotments").DataTable().draw(false);
        }
    })
});


$("#clear-filters").click(function(e) {
    $('#filter_allotments_form').trigger('reset');
    $('#dataTable-allotments').DataTable().ajax.reload(false);
});
</script>
<?php
include './includes/shared/footer.php';
include './includes/shared/scripts.php';
?>