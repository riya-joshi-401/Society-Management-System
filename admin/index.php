<?php
include './includes/shared/header.php';
?>

<?php include './includes/shared/sidebar.php';?>

<?php include './includes/shared/topbar.php';?>

<?php

$allot_sql = mysqli_query($con, "SELECT * from allotments");
$allot = mysqli_num_rows($allot_sql);

$complaint_sql = mysqli_query($con, "SELECT * from complaints");
$complaint = mysqli_num_rows($complaint_sql);

$visit_sql = mysqli_query($con, "SELECT * from visitors");
$visit = mysqli_num_rows($visit_sql);

$bill_sql = mysqli_query($con, "SELECT * from bill_queue");
$bill = mysqli_num_rows($bill_sql);

$security_sql = mysqli_query($con, "SELECT * from security");
$security = mysqli_num_rows($security_sql);

// Count of all types of complaints
$comp_count_sql = mysqli_query($con, "SELECT COUNT(*) as count, status from complaints group by STATUS");
$comp_count_rows = mysqli_fetch_all($comp_count_sql);
$comp_count_count = mysqli_num_rows($comp_count_sql);
// print_r($comp_count_row);
$ccount_0 = $ccount_1 = $ccount_2 = 0;
foreach ($comp_count_rows as $arr) {
    // print_r($arr);
    if ($arr[1] == '0') {
        $ccount_0 = $arr[0];
    }

    if ($arr[1] == '1') {
        $ccount_1 = $arr[0];
    }

    if ($arr[1] == '2') {
        $ccount_2 = $arr[0];
    }
}
// echo $ccount_2;

$comp_date_sql = mysqli_query($con, "SELECT DATE(RaisedDate), COUNT(*) AS count FROM complaints GROUP BY DATE(RaisedDate) ORDER BY RaisedDate LIMIT 7");
$comp_date_rows = mysqli_fetch_all($comp_date_sql);
$comp_date_count = mysqli_num_rows($comp_date_sql);
// print_r($comp_date_rows[0][0]);

?>

<style>
.card1,
.card2,
.card3,
.card4,
.card5,
.card6 {
    transition: all 0.3s ease-out;
    overflow: hidden;
}

.card1:hover,
.card2:hover,
.card3:hover,
.card4:hover,
.card5:hover,
.card6:hover {
    transform: translateY(-5px) scale(1.005) translateZ(0);
}

.card1:hover {
    box-shadow: 0 24px 36px rgba(0, 0, 0, 0.11),
        0 24px 46px rgba(255, 215, 97, 0.48) !important;
}

.card2:hover {
    box-shadow: 0 24px 36px rgba(0, 0, 0, 0.11),
        0 24px 46px rgba(184, 249, 211, 0.48) !important;
}

.card3:hover {
    box-shadow: 0 24px 36px rgba(0, 0, 0, 0.11),
        0 24px 46px rgba(206, 178, 252, 0.48) !important;
}

.card4:hover {
    box-shadow: 0 24px 36px rgba(0, 0, 0, 0.11),
        0 24px 46px rgba(252, 178, 178, 0.48) !important;
}

.card5:hover {
    box-shadow: 0 24px 36px rgba(0, 0, 0, 0.11),
        0 24px 46px rgba(178, 189, 252, 0.48) !important;
}

.card6:hover {
    box-shadow: 0 24px 36px rgba(0, 0, 0, 0.11),
        0 24px 46px rgba(178, 249, 252, 0.48) !important;
}

.card1:hover .overlay,
.card2:hover .overlay,
.card3:hover .overlay,
.card4:hover .overlay,
.card5:hover .overlay,
.card6:hover .overlay {
    transform: scale(9) translateZ(0);
}

.card1:hover .circle {
    border-color: #ffeeba;
    background: #ffd861;
}

.card2:hover .circle {
    border-color: #e2fced;
    background: #b8f9d3;
}

.card3:hover .circle {
    border-color: #f0e7ff;
    background: #ceb2fc;
}

.card4:hover .circle {
    border-color: #ffe7e7;
    background: #fcb2b2;
}

.card5:hover .circle {
    border-color: #e7ebff;
    background: #b2bffc;
}

.card6:hover .circle {
    border-color: #e7fdff;
    background: #b2f6fc;
}

.card1:hover .circle:after {
    background: #ffeeba;
}

.card2:hover .circle:after {
    background: #e2fced;
}

.card3:hover .circle:after {
    background: #f0e7ff;
}

.card4:hover .circle:after {
    background: #ffe7e7;
}

.card5:hover .circle:after {
    background: #e7edff;
}

.card6:hover .circle:after {
    background: #e7fcff;
}

.card1:active {
    transform: scale(1) translateZ(0);
    box-shadow: 0 15px 24px rgba(0, 0, 0, 0.11),
        0 15px 24px rgba(255, 215, 97, 0.48);
}

.card2:active {
    transform: scale(1) translateZ(0);
    box-shadow: 0 15px 24px rgba(0, 0, 0, 0.11),
        0 15px 24px rgba(184, 249, 211, 0.48);
}

.card3:active {
    transform: scale(1) translateZ(0);
    box-shadow: 0 15px 24px rgba(0, 0, 0, 0.11),
        0 15px 24px rgba(206, 178, 252, 0.48);
}

.card4:active {
    transform: scale(1) translateZ(0);
    box-shadow: 0 15px 24px rgba(0, 0, 0, 0.11),
        0 15px 24px rgba(252, 178, 178, 0.48);
}

.card5:active {
    transform: scale(1) translateZ(0);
    box-shadow: 0 15px 24px rgba(0, 0, 0, 0.11),
        0 15px 24px rgba(178, 185, 252, 0.48);
}

.card6:active {
    transform: scale(1) translateZ(0);
    box-shadow: 0 15px 24px rgba(0, 0, 0, 0.11),
        0 15px 24px rgba(178, 252, 248, 0.48);
}

.circle {
    width: 105px;
    height: 105px;
    border-radius: 50%;
    background: #fff;
    display: flex;
    justify-content: center;
    align-items: center;
    position: relative;
    z-index: 1;
    transition: all 0.3s ease-out;
    margin: auto;
}

.card1 {
    border: 0.5px solid #ffd861;
}

.card1 .circle {
    border: 2px solid #ffd861;
}

.card2 {
    border: 0.5px solid #b8f9d3;
}

.card2 .circle {
    border: 2px solid #b8f9d3;
}

.card3 {
    border: 0.5px solid #ceb2fc;
}

.card3 .circle {
    border: 2px solid #ceb2fc;
}

.card4 {
    border: 0.5px solid #fcb2b2;
}

.card4 .circle {
    border: 2px solid #fcb2b2;
}

.card5 {
    border: 0.5px solid #b2b9fc;
}

.card5 .circle {
    border: 2px solid #b2b9fc;
}

.card6 {
    border: 0.5px solid #b2f9fc;
}

.card6 .circle {
    border: 2px solid #b2f9fc;
}

.circle:after {
    content: "";
    width: 88px;
    height: 88px;
    display: block;
    position: absolute;
    border-radius: 50%;
    top: 7px;
    left: 7px;
    transition: opacity 0.3s ease-out;
}

.card1 .circle:after {
    background: #ffd861;
}

.card2 .circle:after {
    background: #b8f9d3;
}

.card3 .circle:after {
    background: #ceb2fc;
}

.card4 .circle:after {
    background: #fcb2b2;
}

.card5 .circle:after {
    background: #b2bffc;
}

.card6 .circle:after {
    background: #b2fcfc;
}

.circle i {
    z-index: 10000;
    font-size: 40px;
    transform: translateZ(0);
}

.overlay {
    width: 88px;
    position: absolute;
    height: 118px;
    border-radius: 50%;
    top: 25px;
    left: 110px;
    z-index: -1;
    transition: transform 0.3s ease-out;
}

.card1 .overlay {
    background: #ffd861;
}

.card2 .overlay {
    background: #b8f9d3;
}

.card3 .overlay {
    background: #ceb2fc;
}

.card4 .overlay {
    background: #fcb2b2;
}

.card5 .overlay {
    background: #b2bdfc;
}

.card6 .overlay {
    background: #b2fcf8;
}

.card p {
    z-index: 1000;
    transition: color 0.3s ease-out;
}

.card1 i {
    color: #d98a19;
}

.card2 i {
    color: #5bd6a2;
}

.card3 i {
    color: #8b6fc0;
}

.card4 i {
    color: #c06f6f;
}

.card5 i {
    color: #6f7bc0;
}

.card6 i {
    color: #6fc0c0;
}

.line-chart {
    height: 350px !important;
    width: 100% !important;
}

.mixed-chart {
    height: 350px !important;
}

.pie-chart-container {
    height: 60% !important;
    width: 60% !important;
}
</style>


<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card mt-2">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title font-weight-bold text-info">Dashboard: <?php echo $_SESSION['username']; ?>
                    </h4>
                    <div class="mt-5">
                        <div class="card-deck mx-2">
                            <div class="card card5 shadow justify-content-center">
                                <div class="card-body row justify-content-center align-items-center text-center">
                                    <div class="col-lg-6">
                                        <div class="overlay"></div>
                                        <div class="circle">
                                            <i class="fas fa-home"></i>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="card-heading align-self-center font-weight-bold"
                                            style="font-size:1.5rem;color: #4C5656;">
                                            <span class="counter" data-target='<?php echo $allot; ?>'>0</span> <br>
                                            Allotments
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card card2 shadow justify-content-center">
                                <div class="card-body row justify-content-center align-items-center text-center">
                                    <div class="col-lg-6">
                                        <div class="overlay"></div>
                                        <div class="circle">
                                            <i class="fas fa-file-text"></i>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="card-heading align-self-center font-weight-bold"
                                            style="font-size:1.5rem;color: #4C5656;">
                                            <span class="counter" data-target='<?php echo $complaint; ?>'>0</span> <br>
                                            Complaints
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card card3 shadow justify-content-center">
                                <div class="card-body row justify-content-center align-items-center text-center">
                                    <div class="col-lg-6">
                                        <div class="overlay"></div>
                                        <div class="circle">
                                            <i class="fas fa-user-friends"></i>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="card-heading align-self-center font-weight-bold"
                                            style="font-size:1.5rem;color: #4C5656;">
                                            <span class="counter" data-target='<?php echo $visit; ?>'>0</span> <br>
                                            Visitors
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="container my-5">
                            <!-- <h4 class="col-12 text-center font-weight-bold pb-4">Visitors Distribution
                            </h4>
                            <div class="mixed-chart-container">
                                <canvas class="mixed-chart" id="mixed" width="100px" height="300px">
                                </canvas>
                            </div> -->
                            <div class="row justify-content-center align-items-center my-5">
                                <h4 class="col-12 text-center font-weight-bold py-4">Complaints Distribution
                                </h4>
                                <div class="col-md-6">
                                    <div class="line-chart-container">
                                        <?php

if ($comp_count_count > 0) {
    echo '<canvas class="line-chart" id="line">
                                            </canvas>';
} else {
    echo 'No data available';
}
?>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="pie-chart-container mx-auto">
                                        <?php

if ($comp_count_count > 0) {
    echo '<canvas class="pie-chart" id="pie">
                                            </canvas>';
} else {
    echo 'No data available';
}
?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-deck mx-2">
                            <div class="card card4 shadow justify-content-center">
                                <div class="card-body row justify-content-center align-items-center text-center">
                                    <div class="col-lg-6">
                                        <div class="overlay"></div>
                                        <div class="circle">
                                            <i class="fas fa-money-bill"></i>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="card-heading align-self-center font-weight-bold"
                                            style="font-size:1.5rem;color: #4C5656;">
                                            <span class="counter" data-target='<?php echo $bill; ?>'>0</span> <br> Bills
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card card1 shadow justify-content-center">
                                <div class="card-body row justify-content-center align-items-center text-center">
                                    <div class="col-lg-6">
                                        <div class="overlay"></div>
                                        <div class="circle">
                                            <i class="fas fa-shield-alt"></i>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="card-heading align-self-center font-weight-bold"
                                            style="font-size:1.5rem;color: #4C5656;">
                                            <span class="counter" data-target='<?php echo $security; ?>'>0</span> <br>
                                            Security
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card card6 shadow justify-content-center">
                                <div class="card-body row justify-content-center align-items-center text-center">
                                    <div class="col-lg-6">
                                        <div class="overlay"></div>
                                        <div class="circle">
                                            <i class="fas fa-microphone"></i>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="card-heading align-self-center font-weight-bold"
                                            style="font-size:1.5rem;color: #4C5656;">
                                            <span class="counter" data-target='20'>0</span> <br> Annoucements
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
    <script>
    //mixed chart
    var mixed = document.getElementById('mixed');
    var mixedConfig = new Chart(mixed, {
        type: 'bar',
        data: {
            labels: ['data-1', 'data-2', 'data-3', 'data-4', 'data-5', 'data-6', 'data-7'],
            datasets: [{
                label: '# of data',
                data: [18, 12, 9, 11, 8, 4, 2],
                backgroundColor: ['rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)', 'rgba(75, 192, 192, 1)', 'rgba(153, 102, 255, 1)',
                    'rgba(225, 50, 64, 1)', 'rgba(64, 159, 64, 1)'
                ],
                borderWidth: 1
            }, {
                label: '# of data', // Name the series
                data: [20, 19, 18, 14, 12, 15, 10],
                type: 'line', // Specify the data values array
                fill: false,
                borderColor: '#2196f3', // Add custom color border (Line)
                backgroundColor: '#2196f3', // Add custom color background (Points and Fill)
                borderWidth: 1,
                order: 2
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            },
            responsive: true, // Instruct chart js to respond nicely.
            maintainAspectRatio: false, // Add to prevent default behaviour of full-width/height
        }
    })
    </script>
    <script>
    //line chart
    var line = document.getElementById('line');
    line.height = 200
    var lineConfig = new Chart(line, {
        type: 'line',
        data: {
            labels: [<?php
foreach ($comp_date_rows as $val) {
    echo '"' . $val[0] . '"' . ',';
}
?>],
            datasets: [{
                label: 'No. of complaints', // Name the series
                data: [
                    <?php
foreach ($comp_date_rows as $val) {
    echo $val[1] . ',';
}
?>
                ], // Specify the data values array
                fill: false,
                borderColor: '#2196f3', // Add custom color border (Line)
                backgroundColor: '#2196f3', // Add custom color background (Points and Fill)
                borderWidth: 1 // Specify bar border width
            }]
        },
        options: {
            responsive: true, // Instruct chart js to respond nicely.
            maintainAspectRatio: false, // Add to prevent default behaviour of full-width/height
        }
    })
    </script>
    <script>
    //pie chart
    var pie = document.getElementById('pie');
    var pieConfig = new Chart(pie, {
        type: 'pie',
        data: {
            labels: ['Un-resolved', 'In-progress', 'Resolved'],
            datasets: [{
                label: '# of data',
                data: [<?php echo $ccount_0; ?>, <?php echo $ccount_1; ?>, <?php echo $ccount_2; ?>],
                backgroundColor: ['rgba(246, 26, 104,1)', ' rgba(103, 216, 239, 1)',
                    'rgba(64, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true, // Instruct chart js to respond nicely.
            maintainAspectRatio: true, // Add to prevent default behaviour of full-width/height
        }
    });
    </script>
    <!-- COUNTER SCRIPT-->
    <script>
    const counters = document.querySelectorAll('.counter');
    const speed = 100000000;
    counters.forEach(counter => {
        const updateCount = () => {
            const target = +counter.getAttribute(
                'data-target'); //Adding the + sign converts type string to numbers
            // console.log(typeof target);
            const count = +counter.innerText;
            const inc = target / speed;

            if (count < target) {
                counter.innerText = Math.ceil(count + inc);
                setTimeout(updateCount, 50);
                // console.log( count + inc);
            } else {
                counter.innerText = target;
            }
        }
        updateCount();
    })
    </script>
    <?php

include './includes/shared/footer.php';
include './includes/shared/scripts.php';

?>