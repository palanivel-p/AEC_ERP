
<?php

$cookieStaffId = $_COOKIE['staff_id'];
$cookieBranch_Id = $_COOKIE['branch_id'];
if($_COOKIE['role'] == 'Super Admin'){
    $addedBranchSerach = '';
}
else {
    if ($_COOKIE['role'] == 'Admin'){
        $addedBranchSerach = "AND branch_name='$cookieBranch_Id'";
    }
    else{
        $addedBranchSerach = "AND added_by='$cookieStaffId' AND branch_name='$cookieBranch_Id'";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Dashboard</title>

    <link rel="icon" type="image/png" sizes="16x16" href="../images/favicon_New.png">
    <link href="../vendor/jqvmap/css/jqvmap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../vendor/chartist/css/chartist.min.css">

    <link href="../vendor/jqvmap/css/jqvmap.min.css" rel="stylesheet">
    <link href="../vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <link href="../vendor/owl-carousel/owl.carousel.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <style>
        .outer {
            width: 1px;
            height: 100%;
            margin: auto;
            position: relative;
            overflow: hidden;
        }
        .inner {
            position: absolute;
            width:100%;
            height: 40%;
            background: grey;
            top: 30%;
            box-shadow: 0px 0px 30px 20px grey;
        }
    </style>
</head>

<body>


<div id="preloader">
    <div class="sk-three-bounce">
        <div class="sk-child sk-bounce1"></div>
        <div class="sk-child sk-bounce2"></div>
        <div class="sk-child sk-bounce3"></div>
    </div>
</div>




<div id="main-wrapper">


    <?php
    $header_name='Dashboard';
    Include ('../includes/header.php');
    Include ('../includes/connection.php');

    /*************** statistics ************/


    /******* Transaction Data*****/

    date_default_timezone_set("Asia/Kolkata");
    $date = date('Y-m-d');
    if($_COOKIE['role'] != "Admin") {

        $sqlSale= "SELECT COUNT(id) as count FROM sale";
        $resultSale = mysqli_query($conn, $sqlSale);
        $rowSale = mysqli_fetch_assoc($resultSale);
        $totalSale = $rowSale['count'];

        $sqlPurchase= "SELECT COUNT(id) as count FROM purchase";
        $resultPurchase = mysqli_query($conn, $sqlPurchase);
        $rowPurchase = mysqli_fetch_assoc($resultPurchase);
        $totalPurchase = $rowPurchase['count'];

        $sqlSaleReturn= "SELECT COUNT(id) as count FROM sale_return";
        $resultSaleReturn = mysqli_query($conn, $sqlSaleReturn);
        $rowSaleReturn = mysqli_fetch_assoc($resultSaleReturn);
        $totalSaleReturn = $rowSaleReturn['count'];

        $sqlPurchaseReturn= "SELECT COUNT(id) as count FROM purchase_return";
        $resultPurchaseReturn = mysqli_query($conn, $sqlPurchaseReturn);
        $rowPurchaseReturn = mysqli_fetch_assoc($resultPurchaseReturn);
        $totalPurchaseReturn = $rowPurchaseReturn['count'];
    }
    if ($_COOKIE['role'] != "Staff") {

//        $branchId = $addedBranchSerach;
//        $sqlbranchName="SELECT * FROM `branch_profile` WHERE branch_id='$branchId'";
//        $resultBranchName=mysqli_query($conn,$sqlbranchName);
//        if(mysqli_num_rows($resultBranchName) > 0) {
//            $rowBranchName = mysqli_fetch_assoc($resultBranchName);
//
//            $branchName = $rowBranchName['branch_name'];
//
//        }



        $sqlstaff = "SELECT COUNT(id) as count FROM staff_profile WHERE id>0 $addedBranchSerach";
        $resultstaff = mysqli_query($conn, $sqlstaff);
        $rowstaff = mysqli_fetch_assoc($resultstaff);
        $totalstaff = $rowstaff['count'];

    }


    $sqldoner = "SELECT COUNT(DISTINCT doner_id) as count FROM transaction WHERE verify=1 $addedBranchSerach";
    $resultdoner = mysqli_query($conn, $sqldoner);
    $rowdoner = mysqli_fetch_assoc($resultdoner);
    $totaldoner = $rowdoner['count'];



    $sqlonline = "SELECT SUM(amount) AS collection FROM transaction WHERE verify=1 AND pay_mode = 'online'$addedBranchSerach";
    $resultonline = mysqli_query($conn, $sqlonline);
    $rowonline = mysqli_fetch_assoc($resultonline);
    $totalonline = $rowonline['collection'];

    $sqloffline = "SELECT SUM(amount) AS collections FROM transaction WHERE verify=1 AND pay_mode = 'offline'$addedBranchSerach";
    $resultoffline = mysqli_query($conn, $sqloffline);
    $rowoffline = mysqli_fetch_assoc($resultoffline);
    $totaloffline = $rowoffline['collections'];

    $startMonth =date('Y-m-01 H:i:s',strtotime("00:00:00"));
    $endMonth =date('Y-m-30 H:i:s',strtotime("23:59:59"));

    //$sqloffline = "SELECT SUM(amount) AS collections FROM transaction WHERE verify=1 AND pay_mode = 'offline'";
    //	 $sqloffline = "select SUM(amount) AS damount from transaction WHERE  verify=1 AND date between CONCAT_WS('-', YEAR(NOW()), MONTH( NOW() ), '01') and DATE( NOW() )";
    $sqloffline = "select SUM(amount) AS damount from transaction WHERE  verify=1 AND date between '$startMonth' AND '$endMonth'$addedBranchSerach";
    $resultoffline = mysqli_query($conn, $sqloffline);
    $rowoffline = mysqli_fetch_assoc($resultoffline);
    $totaloffline = $rowoffline['damount'];


    $startDay =date('Y-m-d H:i:s',strtotime("00:00:00"));
    $endDay =date('Y-m-d H:i:s',strtotime("23:59:59"));

    $sqldamount = "SELECT SUM(amount) AS damount FROM transaction WHERE verify=1 AND date between '$startDay' AND '$endDay'$addedBranchSerach";
    $resultdamount = mysqli_query($conn, $sqldamount);
    $rowdamount = mysqli_fetch_assoc($resultdamount);
    $totaldamount = $rowdamount['damount'];



    //    $sqlD="SELECT * FROM `transaction` WHERE date='$date' $addBranchSerach";
    //    $resultD=mysqli_query($conn,$sqlD);
    //
    //        $rowD = mysqli_fetch_array($resultD);


    //    $mobiles = $rowD['mobile'];
    //    $desktops = $rowD['desktop'];
    //
    //    $num_mobile = (int)$mobiles;
    //    $num_desktop = (int)$desktops;
    //
    //    $today_vist = $num_mobile + $num_desktop;



    /*************** Graph Data ************/


    $yearArrayData =  date("Y");;
    $date = $yearArrayData - 1;

    $fromDate1 = $date .'-12-01';
    $end_date1 = $yearArrayData.'-11-30';

    $monthly_mobile_vist='[';
    $monthly_desktop_vist='[';
    $monthly_offline='[';
    $monthly_online='[';

    while (strtotime($fromDate1) < strtotime($end_date1))
    {

        $fromDate1 = date ("Y-m-d 00:00:00", strtotime("+1 month", strtotime($fromDate1)));
        $toDate=date ("Y-m-d 00:00:00", strtotime("+1 month", strtotime($fromDate1)));

        $toDate=date ("Y-m-d 23:59:59", strtotime("-1 day", strtotime($toDate)));




        // mobile


        $sqlmobileChart="SELECT COUNT(DISTINCT doner_id) as count FROM transaction WHERE verify=1 AND date BETWEEN '$fromDate1' AND '$toDate'$addedBranchSerach";
        $resMobileChart=mysqli_query($conn,$sqlmobileChart);
        $arrayMobileChart=mysqli_fetch_array($resMobileChart);
        $mobileChartCount=$arrayMobileChart['count'];
        if($mobileChartCount == "") {
            $mobileChartCount= 0;
        }

        $monthly_mobile_vist.=$mobileChartCount.',';


        $sqlmobileChartoff="SELECT COUNT(id) as count FROM purchase WHERE purchase_date BETWEEN '$fromDate1' AND '$toDate'";
        $resMobileChartoff=mysqli_query($conn,$sqlmobileChartoff);
        $arrayMobileChartoff=mysqli_fetch_array($resMobileChartoff);
        $mobileChartCountoff=$arrayMobileChartoff['count'];
        if($mobileChartCountoff == "") {
            $mobileChartCountoff= 0;
        }
        $monthly_offline.=$mobileChartCountoff.',';

        $sqlmobileCharton="SELECT COUNT(id) as count FROM sale WHERE sale_date BETWEEN '$fromDate1' AND '$toDate'";
        $resMobileCharton=mysqli_query($conn,$sqlmobileCharton);
        $arrayMobileCharton=mysqli_fetch_array($resMobileCharton);
        $mobileChartCounton=$arrayMobileCharton['count'];
        if($mobileChartCounton == "") {
            $mobileChartCounton= 0;
        }
        $monthly_online.=$mobileChartCounton.',';

        // desktop

//        $sqldesktopChart="SELECT SUM(desktop) AS desktop  FROM dashboard_data WHERE date BETWEEN '$fromDate1' AND '$toDate'";
//        $resdesktopChart=mysqli_query($conn,$sqldesktopChart);
//        $arraydesktopChart=mysqli_fetch_array($resdesktopChart);
//        $desktopChartCount=$arraydesktopChart['desktop'];
//
//
//        if($desktopChartCount == "") {
//            $desktopChartCount = 0;
//        }
//        $monthly_desktop_vist.=$desktopChartCount.',';




    }

    $monthly_mobile_vist.=']';
    $monthly_desktop_vist.=']';
    $monthly_offline.=']';
    $monthly_online.=']';
    print_r($monthly_offline);




    ?>
    <div class="content-body">

        <div class="container-fluid">

            <div class="row">
                <div class="col-xl-12">
                    <div class="row">
                        <?php

                        $total_visits = 0;
                        $total_mobiles = 0;
                        $total_desktops = 0;


                        $sqlVist="SELECT * FROM `dashboard_data`";

                        $resultVist = mysqli_query($conn, $sqlVist);
                        if (mysqli_num_rows($resultVist)>0) {
                            while($row = mysqli_fetch_assoc($resultVist)) {


                                $total_mobile = $row['mobile'];
                                $total_desktop = $row['desktop'];

                                $num_mobiles = (int)$total_mobile;
                                $num_desktops = (int)$total_desktop;


                                $total_mobiles+= $num_mobiles;
                                $total_desktops+= $num_desktops;

                                $total_visits += $num_mobiles + $num_desktops;
                            }
                        }

                        ?>
                        <?php
                        if($_COOKIE['role'] != "") {
                            if($_COOKIE['role'] != "") {


                                ?>

                                <div class="col-xl-3 col-lg-6 col-sm-6">
                                    <div class="widget-stat card bg-danger">
                                        <div class="card-body  p-4">
                                            <div class="media">
                                                <div class="media-body text-white">
                                                    <p class="mb-1" style="text-align: center;">Total Purchase</p>
                                                    <!-- <h3 class="text-white"><?php //echo $total_visits; ?></h3> -->
                                                    <h3 class="text-white" style="margin-top: 30px; text-align: center;"><?php echo $totalPurchase; ?></h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php

                            }
                            ?>
                            <div class="col-xl-3 col-lg-6 col-sm-6">
                                <div class="widget-stat card bg-success">
                                    <div class="card-body p-4">
                                        <div class="media">
                                            <div class="media-body text-white">
                                                <p class="mb-1" style="text-align: center;">Total Sale</p>
                                                <!-- <h3 class="text-white"><?php //echo $total_desktops; ?></h3> -->
                                                <h3 class="text-white" style="margin-top: 30px; text-align: center;"><?php echo $totalSale; ?></h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                        <div class="col-xl-3 col-lg-6 col-sm-6">
                            <div class="widget-stat card bg-info">
                                <div class="card-body p-4">
                                    <div class="media">
                                        <div class="media-body text-white">
                                            <p class="mb-1" style="text-align: center;">Purchase Return</p>
                                            <!-- <h3 class="text-white"><?php //echo $total_mobiles; ?></h3> -->
                                            <h3 class="text-white"style="margin-top: 30px; text-align: center;"><?php echo $totalPurchaseReturn == ''?0:$totalPurchaseReturn; ?></h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        //                            }
                        //                        }
                        ?>
                        <div class="col-xl-3 col-lg-6 col-sm-6">
                            <div class="widget-stat card bg-primary">
                                <div class="card-body p-4">
                                    <div class="media">
                                        <div class="media-body text-white">
                                            <p class="mb-1" style="text-align: center;">Sales Return</p>
                                            <h3 class="text-white" style="margin-top: 30px; text-align: center;"><?php echo $totalSaleReturn == ''?0:$totalSaleReturn; ?></h3>
<!--                                            <hr>-->
<!--                                            <p class="mb-1" style="text-align: center;">Monthly Collection</p>-->
<!--                                            <h3 class="text-white" style="margin-top: 30px; text-align: center;">--><?php //echo $totaloffline == ''?0:$totaloffline; ?><!--</h3>-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
<!--                <div class="col-xl-12">-->
<!--                    <div class="row">-->
<!--                        <div class="col-xl-12 col-lg-12 col-xxl-12 col-sm-12">-->
<!--                            <div class="card">-->
<!--                                <div class="card-header">-->
<!--                                    <h4 class="card-title">Total Doner for Month - --><?php //echo date('Y'); ?><!--</h4>-->
<!--                                </div>-->
<!--                                <div class="card-body">-->
<!--                                    <div id="currYearGraph" style="width: 100%; height: auto;"></div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
                <div class="col-xl-12">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-xxl-12 col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                   <h4 class="card-title">Total Sales And Purchase - <?php echo date('Y'); ?></h4>
                                </div>
                                <div class="card-body">
                                    <div id="currMonthGraph" style="width: 100%; height: auto;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>


    <?php Include ('../includes/footer.php') ?>



</div>



<script src="../vendor/global/global.min.js"></script>
<script src="../vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
<script src="../vendor/chart.js/Chart.bundle.min.js"></script>
<script src="../js/custom.min.js"></script>
<script src="../js/dlabnav-init.js"></script>
<script src="../vendor/owl-carousel/owl.carousel.js"></script>

<script src="../vendor/peity/jquery.peity.min.js"></script>

<!--<script src="../vendor/apexchart/apexchart.js"></script>-->

<!--<script src="../js/dashboard/dashboard-1.js"></script>-->
<script src="../js/highCharts.js"></script>


<script>
    $( document ).ready(function() {

        Highcharts.chart('currYearGraph', {

            chart: {

                type: 'column'

            },

            title: {

                text: '<?php echo date("Y"); ?> Monthly Chart'

            },


            xAxis: {

                categories: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec']

            },


            yAxis: {

                allowDecimals: false,

                min: 0,

                title: {

                    text: 'No of Doners'

                }

            },

            tooltip: {

                formatter: function () {

                    return '<b>' + this.x + '</b><br/>' +

                        this.series.name + ': ' + this.y + '<br/>'

                }

            },

            plotOptions: {

                column: {

                    stacking: 'normal'

                }

            },

            series: [

                {

                    name: 'Doners',

                    data: <?php echo $monthly_mobile_vist; ?>,

                    //stack: 'Offline',

                    color: '#2bc155'

                }
            ]

        });
    });


</script>
<script>
    $( document ).ready(function() {

        Highcharts.chart('currMonthGraph', {

            chart: {

                type: 'column'

            },

            title: {

                text: '<?php echo date("Y"); ?> Monthly Sales And Purchase Chart'

            },


            xAxis: {

                categories: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec']

            },


            yAxis: {

                allowDecimals: false,

                min: 0,

                title: {

                    text: 'No of Orders'

                }

            },

            tooltip: {

                formatter: function () {

                    return '<b>' + this.x + '</b><br/>' +

                        this.series.name + ': ' + this.y + '<br/>'

                }

            },

            plotOptions: {

                column: {

                    stacking: 'normal'

                }

            },

            series: [{

                name: 'Sales',

                data: <?php echo $monthly_online; ?>,

                stack: 'Sales',

                color: '#2db3ff'

            },{

                name: 'Purchase',

                data: <?php echo $monthly_offline ?>,

                stack: 'Purchase',

                color: '#2bc155'

            }]

        });
    });


</script>
</body>
</html>