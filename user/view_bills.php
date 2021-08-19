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
                            <h4 class="m-0 font-weight-bold text-primary">View Bills</h4>
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

                                <form class="forms-sample" id="filter_bills_form" method="POST" action="">
                                    <div class="form-check">
                                        <label for="">Status</label>
                                        <br>
                                        <?php

$status = array();
$statustype = array("0" => "Not Paid", "1" => "Paid");
$query = "SELECT DISTINCT(bills_paid.Status) FROM `bills_paid` inner join flats on bills_paid.FlatID=flats.FlatID where flats.FlatNumber='{$_SESSION['flatno']}' and flats.BlockNumber='{$_SESSION['blockno']}';";
if ($result = mysqli_query($con, $query)) {
    $rowcount = mysqli_num_rows($result);
    while ($row = mysqli_fetch_array($result)) {
        $status = $statustype[$row['Status']];
        echo '<div class="custom-control custom-checkbox custom-control-inline">
                                                            <input type="checkbox" checked name="filter_status[]" class="custom-control-input" value="' . $row['Status'] . '" id="filter_status_' . $status . '">
                                                            <label class="custom-control-label" for="filter_status_' . $status . '">' . $status . '</label>
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
$query = "SELECT DISTINCT(bill_queue.bill_month) FROM `bill_queue` inner join bills_paid on bill_queue.bill_id=bills_paid.BillQueueID inner join flats on bills_paid.FlatID=flats.FlatID where flats.FlatNumber='{$_SESSION['flatno']}' and flats.BlockNumber='{$_SESSION['blockno']}';";
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
                    <table class="table table-bordered table-responsive" id="dataTable-bills" width="100%"
                        cellspacing="0">
                        <thead>
                            <tr>
                                <th>Bill Month</th>
                                <th>Bill</th>
                                <th>Receipt</th>
                                <th>Status</th>
                                <th>Updated At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Bill Month</th>
                                <th>Bill</th>
                                <th>Receipt</th>
                                <th>Status</th>
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
    const filters = $("#filter_bills_form").serializeArray();
    let normalizedFilters = {};
    for (filter of filters) {
        switch (filter.name) {

            case "filter_status[]":
                if (!normalizedFilters.status) {
                    normalizedFilters.status = []
                }
                normalizedFilters.status.push(filter.value)
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
    var table = $('#dataTable-bills').DataTable({
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
            'url': 'includes/loadInfo/view_bills.php',
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
                if ($("#dataTable-bills tbody tr.selected").length != $(
                        "#dataTable-bills tbody tr").length) {
                    $("#select_all").prop("checked", true)
                    $("#select_all").prop("checked", false)
                } else {
                    $("#select_all").prop("checked", false)
                    $("#select_all").prop("checked", true)
                }
            })
        },
        columns: [{
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
                data: 'Action'
            },
        ],
        columnDefs: [{
                targets: [0, 5], // column index (start from 0)
                orderable: false, // set orderable false for selected columns
            },
            {
                className: "bill_month",
                "targets": [0],
            },
            {
                width: "5%",
                targets: [5]
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
    var aPos = $("#dataTable-bills").dataTable().fnGetPosition(target_row.get(0));
    var billData = $('#dataTable-bills').DataTable().row(aPos).data()
    // console.log("AreaData"+billData);
    var json_billData = JSON.stringify(billData)
    console.log("Json Area data modal: " + json_billData)
    $.ajax({
        type: "POST",
        url: "includes/loadInfo/loadmodal_bills.php",
        // data: form_serialize,
        // dataType: "json",
        data: json_billData,
        success: function(output) {
            target_row.append(output);
            $('#update-del-modal').modal('show')
            $(document).on('hidden.bs.modal', '#update-del-modal', function() {
                $("#update-del-modal").remove();
            });
            //update form submission
            $('#update_bills').submit(function(e) {
                // update_bills(e);
                e.preventDefault();
                form = this;
                var formData = new FormData(this);
                console.log(formData);

                $.ajax({
                    url: "includes/queries/upload_receipt.php",
                    type: 'POST',
                    data: formData,
                    success: function(status) {
                        // console.log(data);
                        // let [status, response] = $.trim(data).split("+");
                        console.log(status);
                        if (status == "Successful") {
                            // const resData = JSON.parse(response);
                            // console.log(resData)
                            $("#update_bills_btn").text("Upload Successfull!");
                            $("#update_bills_btn").removeClass("btn-primary");
                            $("#update_bills_btn").addClass("btn-success");
                            window.location.reload();
                        } else {
                            $("#update_bills_btn").text("Upload Failed");
                            $("#update_bills_btn").addClass("btn-danger");
                            alert(data);
                        }
                        // form.reset();
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            });
        }
    });
}

$("#filter_bills_form").submit(function(e) {
    e.preventDefault();
    // console.log("hi");
    $('#dataTable-bills').DataTable().ajax.reload();
    $("#exampleModalCenter1").modal("hide")
})

function update_bills(e) {
    e.preventDefault();
    var form = $('#update_bills');
    var formData = new FormData(document.getElementById("update_bills"));
    console.log(formData);
    // var fileSelect = document.getElementById('Uploadfile');
    // // alert(fileSelect);
    // var files = fileSelect.files;
    // var file = files[0];
    // alert(file.name);
    var form_serialize = form.serializeArray();
    // serializes the form's elements.
    console.log("formser:", form_serialize);
    // form_serialize.push({
    //     name: 'file',
    //     value: file
    // });
    // form_serialize.push({
    //     name: 'filename',
    //     value: file.name
    // });
    form_serialize.push({
        name: $("#update_bills_btn").attr('name'),
        value: $("#update_bills_btn").attr('value')
    });
    $("#update_bills_btn").text("Updating...");
    $("#update_bills_btn").attr("disabled", true);
    $.ajax({
        type: "POST",
        url: "includes/queries/upload_receipt.php",
        data: form_serialize,
        success: function(data) {
            alert(data); // show response from the php script.
            console.log(data);

            $("#update_bills_btn").text("Updated Successfully");
            $("#update_bills_btn").removeClass("btn-primary");
            $("#update_bills_btn").addClass("btn-success");
            var row = $("#update-del-modal").closest('tr');
            var aPos = $("#dataTable-bills").dataTable().fnGetPosition(row.get(0));
            var temp = $("#dataTable-bills").DataTable().row(aPos).data();
            // console.log(temp)
            // console.log("Hi", form_serialize)

            temp['updated_at'] = form_serialize[4].value;
            $('#dataTable-bills').dataTable().fnUpdate(temp, aPos, undefined, false);
            $('.action-btn').off('click')
            $('.action-btn').on('click', loadModalCurrent)
            $('#error_record').remove();

        }
    });
}

$("#clear-filters").click(function(e) {
    $('#filter_bills_form').trigger('reset');
    $('#dataTable-bills').DataTable().ajax.reload(false);
});
</script>


<?php

include './includes/shared/footer.php';
include './includes/shared/scripts.php';

?>