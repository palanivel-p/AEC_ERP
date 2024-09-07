<?php Include("../../includes/connection.php");
date_default_timezone_set("Asia/kolkata");

error_reporting(0);
$page= $_GET['page_no'];
$f_date = $_GET['f_date'];
$t_date = $_GET['t_date'];
if($f_date == ''){
    $f_date = date('Y-m-01');
}
if($t_date == ''){
    $t_date = date('Y-m-d');
}
$from_date = date('Y-m-d 00:00:00',strtotime($f_date));
$to_date = date('Y-m-d 23:59:59',strtotime($t_date));
if($page=='') {
    $page=1;
}

$pageSql= $page-1;
$start=$pageSql*10;
$end = $start;

if($pageSql == 0) {
    $end = 10;
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Profit & Loss-Report</title>

    <link rel="icon" type="image/png" sizes="16x16" href="../../images/favicon_New.png">
    <link href="../../vendor/jqvmap/css/jqvmap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../vendor/chartist/css/chartist.min.css">

    <link href="../../vendor/jqvmap/css/jqvmap.min.css" rel="stylesheet">
    <link href="../../vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
    <link href="../../css/style.css" rel="stylesheet">
    <link href="../../vendor/owl-carousel/owl.carousel.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="../../vendor/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

    <link href="../../vendor/clockpicker/css/bootstrap-clockpicker.min.css" rel="stylesheet">



    <link href="../../vendor/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet">

    <link rel="stylesheet" href="../../vendor/pickadate/themes/default.css">
    <link rel="stylesheet" href="../../vendor/pickadate/themes/default.date.css">
    <link href="../../vendor/summernote/summernote.css" rel="stylesheet">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css">


</head>
<style>
    .error {
        color:red;
    }
    .btn.btn-sm {
        /* Adjust the font size */
        font-size: 12px;
        /* Adjust padding if needed */
        padding: 5px 10px;
    }
</style>
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

    $header_name ="Profit & Loss-Report";
    Include ('../../includes/header.php') ?>



    <div class="content-body">
        <div class="page-titles" style="margin-left: 21px;">
            <ol class="breadcrumb">
                <!--                <li class="breadcrumb-item"><a href="javascript:void(0)">Table</a></li>-->
                <!--                <li class="breadcrumb-item active"><a href="javascript:void(0)">Purchase</a></li>-->


            </ol>

        </div>


        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Profit & Loss-Report List</h4>
                    <div style="display: flex;justify-content: flex-end;">
                        <!--                        <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#invoice_filter" style="justify-content: end">FILTER</button>-->

                        <form class="form-inline">

                            <!--                            <div class="form-group mx-sm-3 mb-2">-->
                            <!---->
                            <!--                                <input type="text" class="form-control" placeholder="Search By Name" name="search" id="search" style="border-radius:20px;color:black;" >-->
                            <!--                            </div>-->
                            <!--                            <button type="submit" class="btn btn-primary mb-2">Search</button>-->
                        </form>
                        <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#invoice_filter" style="margin-left: 20px;">FILTER</button>
                        <!--                        <button type="button" class="pdf_download btn btn-primary mb-2" id="pdf" style="margin-left: 20px;">PDF</button>-->
                        <!--                        <button class="pdf_download btn btn-success" type="button" id="pdf">PDF</button>-->
                        <button type="button" class="excel_download btn btn-rounded btn-success" style="margin-left: 20px;"><span class="btn-icon-left text-success"><i class="fa fa-download color-success"></i>
            </span>Excel Download</button> </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-responsive-md" style="text-align: center;">
                            <thead>
                            <tr>
                                <th class="width80"><strong>#</strong></th>
                                <th><strong>Date</strong></th>
                                <th><strong>Credits</strong></th>
                                <th><strong>Debits</strong></th>
                                <th><strong>Net Income</strong></th>

                            </tr>
                            </thead>
                            <?php
                            if ($f_date == "" && $t_date == "") {
                                $sql = "SELECT SUM(CASE WHEN type = 'credit' THEN amount ELSE 0 END) AS total_credit_amount,
                                         SUM(CASE WHEN type = 'debit' THEN amount ELSE 0 END) AS total_debit_amount FROM bank_details WHERE  payment_date BETWEEN '$from_date' AND '$to_date'";
                            } else {
                                $sql = "SELECT SUM(CASE WHEN type = 'credit' THEN amount ELSE 0 END) AS total_credit_amount,
                                          SUM(CASE WHEN type = 'debit' THEN amount ELSE 0 END) AS total_debit_amount FROM bank_details  WHERE payment_date BETWEEN '$from_date' AND '$to_date'";
                            }

                            $result = mysqli_query($conn, $sql);

                            if ($result) {
                                $row = mysqli_fetch_assoc($result);
                                $total_credit_amount = $row['total_credit_amount'];
                                $total_debit_amount = $row['total_debit_amount'];
                                // Now $total_credit_amount and $total_debit_amount hold the sums of 'amount' for credits and debits respectively
                            } else {
                                // Handle the case when the query fails
                                echo "Query failed: " . mysqli_error($conn);
                            }
                            $net_amount = $total_credit_amount - $total_debit_amount;
                            $start_date = date('d-m-Y', strtotime($from_date));
                            $end_date = date('d-m-Y', strtotime($to_date));
                            ?>

                            <tbody>
                            <?php
                            if($total_credit_amount > 0 || $total_debit_amount > 0) {
                            ?>
                            <tr>
                                <td><strong><?php echo 1;?></strong></td>
                                <td> <?php echo $start_date . " - ".$end_date?> </td>
                                <td> <?php echo $total_credit_amount?> </td>
                                <td> <?php echo $total_debit_amount?> </td>
                                <td> <?php echo $net_amount?> </td>
                            </tr>
                                <?php

                                    } else {
                                        ?>
                            <tr>
                                <td colspan="8" style="text-align: center">No Record Found <span style='font-size:40px;'>&#128533;</span></td>
                            </tr>
                            <?php
                            }

                            ?>
                            </tbody>

                        </table>

                    </div>
                </div>
            </div>
        </div>
        <?php Include ('../../includes/footer.php') ?>
        <div class="modal fade" id="invoice_filter"  data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <!-- <h5 class="modal-title" id="title">pay Details</h5> -->

                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="basic-form" style="color: black;">
                            <form id="filter_form" autocomplete="off">
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label>From Date </label>
                                        <input type="date"  class="form-control" id="f_date" name="f_date" style="border-color: #181f5a;color: black">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>To Date </label>
                                        <input type="date"  class="form-control" id="t_date" name="t_date" style="border-color: #181f5a;color: black">
                                    </div>

                                    <button type="submit" class="btn btn-primary mb-2">Search</button>
                                </div>
                            </form>
                        </div>

                    </div>
                    <!--                <div class="modal-footer">-->
                    <!--                    <button type="button" class="btn btn-danger light" data-dismiss="modal" style="background-color: red; color: white;">Close</button>-->
                    <!--                    <button type="submit" class="btn btn-primary" id="filter">Filter</button>-->
                    <!--                </div>-->
                </div>
            </div>
        </div>
    </div>


    <script src="../../vendor/global/global.min.js"></script>
    <script src="../../vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
    <script src="../../vendor/chart.js/Chart.bundle.min.js"></script>
    <script src="../../js/custom.min.js"></script>
    <script src="../../js/dlabnav-init.js"></script>
    <script src="../../vendor/owl-carousel/owl.carousel.js"></script>
    <script src="../../vendor/peity/jquery.peity.min.js"></script>
    <!--<script src="../../vendor/apexchart/apexchart.js"></script>-->
    <script src="../../js/dashboard/dashboard-1.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../../vendor/jquery-validation/jquery.validate.min.js"></script>
    <script src="../../js/plugins-init/jquery.validate-init.js"></script>
    <script src="../../vendor/moment/moment.min.js"></script>
    <script src="../../vendor/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script src="../../vendor/summernote/js/summernote.min.js"></script>
    <script src="../../js/plugins-init/summernote-init.js"></script>


    <script>
        $(document).on("click", ".excel_download", function () {
            window.location.href = "excel_download.php?&f_date=<?php echo $from_date?>&t_date=<?php echo $to_date?>";
        });
    </script>

</body>
</html>
