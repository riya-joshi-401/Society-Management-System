<?php include './includes/shared/header.php'; ?>
<?php //include './includes/shared/sidebar.php';?>
<?php include './includes/shared/topbar.php';?>

<!-- Begin Page Content -->
<div class="container-fluid">
    <h3 class="my-4">Security Dashboard</h3>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card mt-2">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <div class="row align-items-center">
                        <div class="col-12 mb-3">
                            <h4 class="m-0 font-weight-bold text-primary">Visitors</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-responsive" id="dataTable-visitors" width="100%"
                        cellspacing="0">
                        <thead>
                            <tr>
                                <th>Block Number</th>
                                <th>Flat Number</th>
                                <th>Name</th>
                                <th>Contact No</th>
                                <th>Alternate Contact No</th>
                                <th>Number of People</th>
                                <th>Date</th>
                                <th>OTP</th>
                                <!-- <th>Verify</th> -->
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Block Number</th>
                                <th>Flat Number</th>
                                <th>Name</th>
                                <th>Contact No</th>
                                <th>Alternate Contact No</th>
                                <th>Number of People</th>
                                <th>Date</th>
                                <th>OTP</th>
                                <!-- <th>Verify</th> -->
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
        ajax: {
            'url': 'includes/loadInfo/manage_visitors.php',
            "data": function(d) {
                //console.log(d);
                //d.filters = getFilters();
                //d.sort("Date");
                return d
            },
        },
        columns: [{
                data: 'BlockNumber'
            },
            {
                data: 'FlatNumber'
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
                data: 'StartDate'
            },
            {
                data: 'OTP'
            },
            /* {
                data: 'action'
            }, */
        ],
        columnDefs: [{
                targets: [0, 7], // column index (start from 0)
                orderable: false, // set orderable false for selected columns
            },
            {
                className: "BlockNumber",
                "targets": [0],
            },
            {
                width: "3%",
                targets: [7]
            },

        ],
    });
    table.columns.adjust()

}
</script>


<?php
include './includes/shared/footer.php';
include './includes/shared/scripts.php';
?>