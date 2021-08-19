<?php include './includes/shared/header.php'; ?>
<?php include './includes/shared/sidebar.php'; ?>
<?php include './includes/shared/topbar.php'; ?>

<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card mt-2">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <div class="row align-items-center">
                        <div class="col-12 mb-3">
                            <h4 class="m-0 font-weight-bold text-primary">Security Guards</h4>
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

                                <form class="forms-sample" id="filter_security_form" method="POST" action="">
                                    <div class="form-check">
                                        <label for="">SecurityID</label>
                                        <br>
                                        <?php
                                        $securityid = array();
                                        //$user = $_SESSION['username'];
                                        $query = "SELECT DISTINCT(SecurityID) FROM security";
                                        if ($result = mysqli_query($con, $query)) {
                                            $rowcount = mysqli_num_rows($result);
                                            while ($row = mysqli_fetch_array($result)) {
                                                $securityid = $row['SecurityID'];
                                                echo '<div class="custom-control custom-checkbox custom-control-inline">
                                                            <input type="checkbox" checked name="filter_security[]" class="custom-control-input" value="' . $securityid . '" id="filter_security_' . $securityid . '">
                                                            <label class="custom-control-label" for="filter_security_' . $securityid . '">' . $securityid . '</label>
                                                        </div>';
                                            }
                                        }
                                        ?>
                                    </div>
                                    <br />

                                    <div class="form-check">
                                        <label for="">Name</label>
                                        <br>
                                        <?php
                                        $name = array();
                                        $query = "SELECT DISTINCT(Name) FROM security";
                                        if ($result = mysqli_query($con, $query)) {
                                            $rowcount = mysqli_num_rows($result);
                                            while ($row = mysqli_fetch_array($result)) {
                                                $name = $row['Name'];
                                                echo '<div class="custom-control custom-checkbox custom-control-inline">
                                                            <input checked type="checkbox" name="filter_name[]" class="custom-control-input" value="' . $name . '" id="filter_name_' . $name . '">
                                                            <label class="custom-control-label" for="filter_name_' . $name . '">' . $name . '</label>
                                                        </div>';
                                            }
                                        }
                                        ?>
                                    </div>
                                    <br />
                                    <div class="form-check">
                                        <label for="">ContactNumber</label>
                                        <br>
                                        <?php
                                        $contactnumber = array();
                                        $query = "SELECT DISTINCT(ContactNumber) FROM security";
                                        if ($result = mysqli_query($con, $query)) {
                                            $rowcount = mysqli_num_rows($result);
                                            while ($row = mysqli_fetch_array($result)) {
                                                $contactnumber = $row['ContactNumber'];
                                                echo '<div class="custom-control custom-checkbox custom-control-inline">
                                                            <input checked type="checkbox" name="filter_contactnumber[]" class="custom-control-input" value="' . $contactnumber . '" id="filter_contactnumber_' . $contactnumber . '">
                                                            <label class="custom-control-label" for="filter_contactnumber_' . $contactnumber . '">' . $contactnumber . '</label>
                                                        </div>';
                                            }
                                        }
                                        ?>
                                    </div>
                                    <br />
                                    <div class="form-check">
                                        <label for="">Shift</label>
                                        <br>
                                        <?php
                                        $shift = array();
                                        $query = "SELECT DISTINCT(Shift) FROM security";
                                        if ($result = mysqli_query($con, $query)) {
                                            $rowcount = mysqli_num_rows($result);
                                            while ($row = mysqli_fetch_array($result)) {
                                                $shift = $row['Shift'];
                                                echo '<div class="custom-control custom-checkbox custom-control-inline">
                                                            <input checked type="checkbox" name="filter_shift[]" class="custom-control-input" value="' . $shift . '" id="filter_shift_' . $shift . '">
                                                            <label class="custom-control-label" for="filter_shift_' . $shift . '">' . $shift . '</label>
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
                <div class="card-body ">
                    <table class="table table-bordered table-responsive" id="dataTable-security" width="100%"
                        cellspacing="0">
                        <thead>
                            <tr>
                                <th>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="select_all">
                                        <label class="custom-control-label" for="select_all"></label>
                                    </div>
                                </th>
                                <th>SecurityID</th>
                                <th>Name</th>
                                <th>ContactNumber</th>
                                <th>Shift</th>
                                <th>Last Updated At</th>
                                <th>Action </th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th>SecurityID</th>
                                <th>Name</th>
                                <th>ContactNumber</th>
                                <th>Shift</th>
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
    const filters = $("#filter_security_form").serializeArray();
    let normalizedFilters = {};
    for (filter of filters) {
        switch (filter.name) {

            case "filter_security[]":
                if (!normalizedFilters.security) {
                    normalizedFilters.security = []
                }
                normalizedFilters.security.push(filter.value)
                break;
            case "filter_name[]":
                if (!normalizedFilters.name) {
                    normalizedFilters.name = []
                }
                normalizedFilters.name.push(filter.value)
                break;
            case "filter_contactnumber[]":
                if (!normalizedFilters.contactnumber) {
                    normalizedFilters.contactnumber = []
                }
                normalizedFilters.contactnumber.push(filter.value)
                break;
            case "filter_shift[]":
                if (!normalizedFilters.shift) {
                    normalizedFilters.shift = []
                }
                normalizedFilters.shift.push(filter.value)
                break;
        }
    }
    // console.log("Normalized Filters: "+normalizedFilters);
    return normalizedFilters
}

//DATATABLE CREATE
function loadCurrent() {
    var table = $('#dataTable-security').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        autoWidth: false,
        responsive: true,
        serverMethod: 'post',
        aaSorting: [],
        dom: '<"d-flex justify-content-between table-buttons-addsecurity"fBl>tip',
        buttons: [{
            extend: 'excel',
            title: "security-data",
            text: '<span> <i class="fas fa-download "></i> EXCEL</span>',
            className: "btn btn-outline-primary  ",
            action: newExportAction,
            exportOptions: {
                columns: [1, 2, 3, 4]
            }
        }, {
            extend: "pdfHtml5",
            title: "security-data",
            text: '<span> <i class="fas fa-download "></i> PDF</span>',
            className: "btn btn-outline-primary  mx-2",
            action: newExportAction,
            exportOptions: {
                columns: [1, 2, 3, 4]
            },
        }, ],
        ajax: {
            'url': 'includes/loadInfo/manage_security.php',
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
                console.log(checkbox);
                checkbox.attr("checked", !checkbox.attr("checked"));
                row.toggleClass('selected table-secondary')
                if ($("#dataTable-security tbody tr.selected").length != $(
                        "#dataTable-security tbody tr").length) {
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
                data: 'SecurityID'
            },
            {
                data: 'Name'
            },
            {
                data: 'ContactNumber'
            },
            {
                data: 'Shift'
            },
            {
                data: 'updated_at'
            },
            {
                data: 'action'
            },
        ],
        columnDefs: [{
                targets: [0, 6], // column index (start from 0)
                orderable: false, // set orderable false for selected columns
            },
            {
                className: "selectbox",
                targets: [0]
            },
            {
                className: "SecurityID",
                "targets": [1]
            },
            {
                width: "3%",
                targets: [0, 1, 6]
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
        $("#dataTable-security tbody tr").addClass("selected table-secondary");
        $(".selectrow").attr("checked", true);
    } else {
        $(".selectrow").attr("checked", false);
        $("#dataTable-security tbody tr").removeClass("selected table-secondary");
    }
    //   row.toggleClass('selected table-secondary')
})
//action modal part
function loadModalCurrent() {
    var target_row = $(this).closest("tr"); // this line did the trick
    //console.log(target_row)
    // var btn=$(this);
    var aPos = $("#dataTable-security").dataTable().fnGetPosition(target_row.get(0));
    var areaData = $('#dataTable-security').DataTable().row(aPos).data()
    //console.log("AreaData"+areaData);
    var json_areaData = JSON.stringify(areaData)
    //console.log("Json Area data modal: "+json_areaData)
    $.ajax({
        type: "POST",
        url: "includes/loadInfo/loadmodal_security.php",
        //console.log('yo yo');
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
            $('#delete_security').submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var form_serialize = form.serializeArray(); // serializes the form's elements.
                form_serialize.push({
                    name: $("#delete_security_btn").attr('name'),
                    value: $("#delete_security_btn").attr('value')
                });
                //console.log('yo yo');
                //alert('hi');
                //console.log('Form Serialize');
                //console.log(form_serialize);
                $("#delete_security_btn").text("Deleting...");
                $("#delete_security_btn").attr("disabled", true);
                $.ajax({
                    type: "POST",
                    url: "includes/queries/security.php",
                    data: form_serialize,
                    success: function(data) {
                        //alert(data); // show response from the php script.
                        $("#delete_security_btn").text("Deleted Successfully");
                        var row = $("#update-del-modal").closest('tr');
                        var aPos = $("#dataTable-security").dataTable().fnGetPosition(
                            row.get(0));
                        $('#update-del-modal').modal('hide');
                        $('body').removeClass('modal-open');
                        $('.modal-backdrop').remove();
                        // row.remove();
                        loadCurrent();

                        //console.log(aPos);
                        //console.log(row)
                    }
                });
            });
            $('#update_security').submit(function(e) {
                update_security(e);
                // $('#update-del-modal').modal('hide');
            });
        }
    });
}

$("#filter_security_form").submit(function(e) {
    e.preventDefault();
    console.log("hi");
    $('#dataTable-security').DataTable().ajax.reload();
    $("#exampleModalCenter1").modal("hide")
})

function update_security(e) {
    e.preventDefault();
    var form = $('#update_security');
    var form_serialize = form.serializeArray(); // serializes the form's elements.
    // console.log(form_serialize)
    form_serialize.push({
        name: $("#update_security_btn").attr('name'),
        value: $("#update_security_btn").attr('value')
    });
    $("#update_security_btn").text("Updating...");
    $("#update_security_btn").attr("disabled", true);
    $.ajax({
        type: "POST",
        url: "includes/queries/security.php",
        data: form_serialize,
        success: function(data) {
            // alert(data); // show response from the php script.
            // console.log(data);
            if (data === "Exists_record") {
                $('#error_record').text(
                    '*This data already exists!');
                $('#error_record').addClass("text-danger");
                $("#update_security_btn").text("Update");
                $("#update_security_btn").attr("disabled", false);
            } else {
                $("#update_security_btn").text("Updated Successfully");
                $("#update_security_btn").removeClass("btn-primary");
                $("#update_security_btn").addClass("btn-success");
                var row = $("#update-del-modal").closest('tr');
                var aPos = $("#dataTable-security").dataTable().fnGetPosition(row.get(0));
                var temp = $("#dataTable-security").DataTable().row(aPos).data();
                console.log('temp');
                console.log(temp)
                console.log('form serilize');
                console.log(form_serialize);
                console.log("Hi ", form_serialize)

                temp['SecurityID'] = form_serialize[6].value; //new values
                temp['Name'] = form_serialize[0].value; //new values
                temp['ContactNumber'] = form_serialize[2].value;
                temp['Shift'] = form_serialize[4].value;
                // temp['updated_at'] = date("Y-m-d H:i:s");
                // temp['Updatedby'] = $_SESSION['username'];
                $('#dataTable-security').dataTable().fnUpdate(temp, aPos, undefined, false);
                $('.action-btn').off('click')
                $('.action-btn').on('click', loadModalCurrent)
                // $("#dataTable-flats").DataTable().row(aPos).draw(false);
                $('#error_record').remove();
            }
        }
    });
}


$("#delete_selected_response_btn").click(function(e) {
    alert("You have selected " + $("#dataTable-security tbody tr.selected").length + " record(s) for deletion");
    var delete_rows = $("#dataTable-security").DataTable().rows('.selected').data()
    var delete_data = {}
    for (var i = 0; i < delete_rows.length; i++) {
        console.log('Delete Rows : ');
        console.log(delete_rows[i]);
        // console.log("delete:"+delete_rows[i].FlatNumber)
        baseData = {}
        baseData['SecurityID'] = delete_rows[i].SecurityID
        baseData['Name'] = delete_rows[i].Name
        delete_data[i] = baseData
        console.log('')
        console.log(baseData);
        // console.log("Base Data:"+baseData);
    }
    var actual_data = {}
    actual_data['type'] = 'current'
    actual_data['delete_data'] = delete_data
    actual_delete_data_json = JSON.stringify(actual_data)
    // console.log("Actual Data:"+actual_delete_data_json)
    console.log('Actual Data');
    console.log(actual_data);
    $.ajax({
        type: "POST",
        url: "includes/queries/delete_multiple_security.php",
        data: actual_delete_data_json,
        success: function(data) {
            // console.log("Returned data: "+data)
            console.log('Returned data');
            console.log(data);
            $("#dataTable-security").DataTable().draw(false);
        }
    })
})

$("#clear-filters").click(function(e) {
    $('#filter_security_form').trigger('reset');
    $('#dataTable-security').DataTable().ajax.reload(false);
});
</script>


<?php

include './includes/shared/footer.php';
include './includes/shared/scripts.php';

?>