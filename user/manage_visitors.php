<?php include './includes/shared/header.php';?>
<?php include './includes/shared/sidebar.php';?>
<?php include './includes/shared/topbar.php';?>

<!-- Begin Page Content -->
<div class="container-fluid">
    <h3 class="my-4">Visitors</h3>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card mt-2">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <div class="row align-items-center">
                        <div class="col-12 mb-3">
                            <h4 class="m-0 font-weight-bold text-primary">Visitors Records</h4>
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

                                <form class="forms-sample" id="filter_visitor_form" method="POST" action="">
                                    <div class="form-check">
                                        <label for="">Name</label>
                                        <br>
                                        <?php
$block = $_SESSION['blockno'];
$flatno = $_SESSION['flatno'];

// $block = 'A' ;//remove it later
// $flatno = '101';//remove it later

$vname = array();
$query = "SELECT distinct(VisitorName) FROM visitors WHERE BlockNumber='" . $block ."' AND  FlatNumber=" . $flatno . ";";
if ($result = mysqli_query($con, $query)) {
    $rowcount = mysqli_num_rows($result);
    while ($row = mysqli_fetch_array($result)) {
        $vname = $row['VisitorName'];
        echo '<div class="custom-control custom-checkbox custom-control-inline">
                                                            <input checked type="checkbox" name="filter_vname[]" class="custom-control-input" value="' . $vname . '" id="filter_vname_' . $vname . '">
                                                            <label class="custom-control-label" for="filter_vname_' . $vname . '">' . $vname . '</label>
                                                        </div>';
    }
}
?>
                                    </div>
                                    <br />
                                    <div class="form-check">
                                        <label for="">Number of People</label>
                                        <br>
                                        <?php

$people = array();


$query = "SELECT DISTINCT(NoOfPeople) FROM visitors WHERE BlockNumber='" . $block ."' AND  FlatNumber=" . $flatno . ";"; 

if ($result = mysqli_query($con, $query)) {
    $rowcount = mysqli_num_rows($result);
    while ($row = mysqli_fetch_array($result)) {
        $people = $row['NoOfPeople'];

        echo '<div class="custom-control custom-checkbox custom-control-inline">
                                                            <input type="checkbox" checked name="filter_people[]" class="custom-control-input" value="' . $people . '" id="filter_people_' . $people . '">
                                                            <label class="custom-control-label" for="filter_people_' . $people . '">' . $people . '</label>
                                                        </div>';
    }
}
?>
                                    </div>
                                    <br />
                                    <div class="form-check">
                                        <label for="">Duration</label>
                                        <br>
                                        <?php
$duration= array();
$query = "SELECT distinct(Duration) FROM visitors WHERE BlockNumber='" . $block ."' AND  FlatNumber=" . $flatno . ";";
if ($result = mysqli_query($con, $query)) {
    $rowcount = mysqli_num_rows($result);
    while ($row = mysqli_fetch_array($result)) {
        $duration= $row['Duration'];
        echo '<div class="custom-control custom-checkbox custom-control-inline">
                                                            <input checked type="checkbox" name="filter_duration[]" class="custom-control-input" value="' . $duration. '" id="filter_duration_' . $duration. '">
                                                            <label class="custom-control-label" for="filter_duration_' . $duration. '">' . $duration. '</label>
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
                    <table class="table table-bordered table-responsive" id="dataTable-visitors" width="100%"
                        cellspacing="0">
                        <thead>
                            <tr>
                                <th>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="select_all">
                                        <label class="custom-control-label" for="select_all"></label>
                                    </div>
                                </th>
                                <th>Visitor Name</th>
                                <th>Visitor Contact No</th>
                                <th>Visitor Alternate Contact No</th>
                                <th>Number of People</th>
                                <th>Reason to Meet</th>
                                <th>Start Date</th>
                                <th>Duration</th>
                                <th>Last Updated At</th>
                                <th>Action </th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th>Visitor Name</th>
                                <th>Visitor Contact No</th>
                                <th>Visitor Alternate Contact No</th>
                                <th>Number of People</th>
                                <th>Reason to Meet</th>
                                <th>Start Date</th>
                                <th>Duration</th>
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
    const filters = $("#filter_visitor_form").serializeArray();
    let normalizedFilters = {};
    for (filter of filters) {
        switch (filter.name) {

            case "filter_vname[]":
                if (!normalizedFilters.vname) {
                    normalizedFilters.vname = []
                }
                normalizedFilters.vname.push(filter.value)
                // console.log(normalizedFilters.vname);
                break;
            case "filter_people[]":
                if (!normalizedFilters.people) {
                    normalizedFilters.people = []
                    
                }
                normalizedFilters.people.push(filter.value)
                // console.log(normalizedFilters.block);
                break;
            case "filter_duration[]":
                if (!normalizedFilters.duration) {
                    normalizedFilters.duration = []
                }
                normalizedFilters.duration.push(filter.value)
                // console.log(normalizedFilters.flatno);
                break;
        }
    }
    // console.log("Normalized Filters: ");
    // console.log(normalizedFilters);
    return normalizedFilters
}

//DATATABLE CREATE
function loadCurrent() {
    var table = $('#dataTable-visitors').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        autoWidth: true,
        responsive: true,
        serverMethod: 'post',
        aaSorting: [],
        dom: '<"d-flex justify-content-between table-buttons-addvisitors"fBl>tip',
        buttons: [
            // {
        //     extend: 'excel',
        //     title: "visitors-data",
        //     text: '<span> <i class="fas fa-download "></i> EXCEL</span>',
        //     className: "btn btn-outline-primary  ",
        //     action: newExportAction,
        //     exportOptions: {
        //         columns: [1, 2, 3, 4, 5, 6, 7, 8, 9] 
        //     }
        // },
        {
            extend: "pdfHtml5",
            title: "visitors-data",
            text: '<span> <i class="fas fa-download "></i> PDF</span>',
            className: "btn btn-outline-primary  mx-2",
            action: newExportAction,
            exportOptions: {
                columns: [1, 2, 3, 4, 5, 6, 7, 8]
            },
        }, ],
        ajax: {
            'url': 'includes/loadInfo/manage_visitors.php',
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
                // console.log('Checkbox')
                // console.log(checkbox);
                checkbox.attr("checked", !checkbox.attr("checked"));
                row.toggleClass('selected table-secondary')
                if ($("#dataTable-visitors tbody tr.selected").length != $(
                        "#dataTable-visitors tbody tr").length) {
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
                data: 'VisitorName'
            },
            {
                data: 'VisitorContactNo'
            },
            {
                data: 'AlternateVisitorContactNo'
            },
            {
                data: 'NoOfPeople'
            },
            {
                data: 'ReasonToMeet'
            },
            {
                data: 'StartDate'
            },
            {
                data: 'Duration'
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
                className: "VisitorName", 
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
        $("#dataTable-visitors tbody tr").addClass("selected table-secondary");
        $(".selectrow").attr("checked", true);
    } else {
        $(".selectrow").attr("checked", false);
        $("#dataTable-visitors tbody tr").removeClass("selected table-secondary");
    }
    //   row.toggleClass('selected table-secondary')
})
//action modal part
function loadModalCurrent() {
    var target_row = $(this).closest("tr"); // this line did the trick
    // console.log('target_row : '+target_row)
    var btn=$(this);
    var aPos = $("#dataTable-visitors").dataTable().fnGetPosition(target_row.get(0));
    var areaData = $('#dataTable-visitors').DataTable().row(aPos).data()
    // console.log("AreaData"+areaData);

    var json_areaData = JSON.stringify(areaData)
    // console.log("Json Area data modal: "+json_areaData)
    
    $.ajax({
        type: "POST",
        url: "includes/loadInfo/loadmodal_visitors.php",
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
            $('#delete_visitors').submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var form_serialize = form.serializeArray(); // serializes the form's elements.
                form_serialize.push({
                    name: $("#delete_visitors_btn").attr('name'),
                    value: $("#delete_visitors_btn").attr('value')
                });
                // alert('hi');
                // console.log(form_serialize);
                $("#delete_visitors_btn").text("Deleting...");
                $("#delete_visitors_btn").attr("disabled", true);
                $.ajax({
                    type: "POST",
                    url: "includes/queries/visitors.php",
                    data: form_serialize,
                    success: function(data) {
                        alert(data); // show response from the php script.
                        $("#delete_visitors_btn").text("Deleted Successfully");
                        var row = $("#update-del-modal").closest('tr');
                        var aPos = $("#dataTable-visitors").dataTable().fnGetPosition(
                            row.get(0));
                        $('#update-del-modal').modal('hide');
                        $('body').removeClass('modal-open');
                        $('.modal-backdrop').remove();
                        // row.remove();
                        loadCurrent();

                        console.log(aPos);
                        console.log(row)
                    }
                });
            });
            $('#update_visitors').submit(function(e) {
                update_visitors(e);
                // $('#update-del-modal').modal('hide');
            });
        }
    });
}

$("#filter_visitor_form").submit(function(e) {
    e.preventDefault();
    // console.log("hi");
    $('#dataTable-visitors').DataTable().ajax.reload();
    $("#exampleModalCenter1").modal("hide")
})

function update_visitors(e) {
    e.preventDefault();
    var form = $('#update_visitors');
    var form_serialize = form.serializeArray(); // serializes the form's elements.
    console.log(form_serialize)
    form_serialize.push({
        name: $("#update_visitors_btn").attr('name'),
        value: $("#update_visitors_btn").attr('value')
    });
    $("#update_visitors_btn").text("Updating...");
    $("#update_visitors_btn").attr("disabled", true);
    $.ajax({
        type: "POST",
        url: "includes/queries/visitors.php",
        data: form_serialize,
        success: function(data) {
            // alert(data); // show response from the php script.
            // console.log(data);
            if (data === "Exists_record") {
                $('#error_record').text(
                    '*This data already exists! Please change the Visitor Name'); 
                $('#error_record').addClass('text-danger');
                $("#update_visitors_btn").text("Update");
                $("#update_visitors_btn").attr("disabled", false);
            } else {
                $("#update_visitors_btn").text("Updated Successfully");
                $("#update_visitors_btn").removeClass("btn-primary");
                $("#update_visitors_btn").addClass("btn-success");
                var row = $("#update-del-modal").closest('tr');
                var aPos = $("#dataTable-visitors").dataTable().fnGetPosition(row.get(0));
                var temp = $("#dataTable-visitors").DataTable().row(aPos).data();
                
                // console.log('form_serialize: ');
                // console.log(form_serialize);
                
                temp['VisitorName'] = form_serialize[0].value; //new values
                temp['VisitorContactNo'] = form_serialize[2].value; //new values
                temp['AlternateVisitorContactNo'] = form_serialize[4].value; //new values
                temp['ReasonToMeet'] = form_serialize[6].value;
                temp['NoOfPeople'] = form_serialize[8].value;
                temp['StartDate'] = form_serialize[10].value;
                temp['Duration'] = form_serialize[12].value;
                
                // temp['updated_at'] = form_serialize[8].value;
                // temp['Updatedby'] = $_SESSION['username'];
                
                $('#dataTable-visitors').dataTable().fnUpdate(temp, aPos, undefined, false);
                $('.action-btn').off('click')
                $('.action-btn').on('click', loadModalCurrent)
                // $("#dataTable-visitors").DataTable().row(aPos).draw(false);
                $('#error_record').remove();
            }
        }
    });
}

$("#delete_selected_response_btn").click(function(e) {
    // console.log('Entered delete section')
    alert("You have selected " + $("#dataTable-visitors tbody tr.selected").length + " record(s) for deletion");
    var delete_rows = $("#dataTable-visitors").DataTable().rows('.selected').data()
    var delete_data = {}
    for (var i = 0; i < delete_rows.length; i++) {
        // console.log('Delete Rows : ');
        // console.log(delete_rows[i]);
        baseData = {}
        // baseData['block'] = delete_rows[i].BlockNumber
        // baseData['flatno'] = delete_rows[i].FlatNumber
        
        baseData['vname'] = delete_rows[i].VisitorName
        delete_data[i] = baseData
        console.log("Base Data:"+baseData);

    }
    var actual_data = {}
    actual_data['type'] = 'current'
    actual_data['delete_data'] = delete_data
    actual_delete_data_json = JSON.stringify(actual_data)
    // console.log("Actual Data:"+actual_delete_data_json)

    $.ajax({
        type: "POST",
        url: "includes/queries/delete_multiple_visitors.php",
        data: actual_delete_data_json,
        success: function(data) {
            // console.log("Returned data: "+data)
            $("#dataTable-visitors").DataTable().draw(false);
        }
    })
})

$("#clear-filters").click(function(e) {
    $('#filter_visitor_form').trigger('reset');
    $('#dataTable-visitors').DataTable().ajax.reload(false);
});
</script>


<?php

include './includes/shared/footer.php';
include './includes/shared/scripts.php';

?>