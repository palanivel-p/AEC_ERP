<?php Include("../../includes/connection.php");
date_default_timezone_set("Asia/kolkata");

error_reporting(0);
$page= $_GET['page_no'];
$a_id= $_GET['a_id'];

$fdate1 = $_GET['fdate'];
$ldate1 = $_GET['ldate'];
$customer = $_GET['customer'];

if($customer==''){
    $customer='allname';
}


$fdate = date('Y-m-01');
$ldate = date('Y-m-d');


if($fdate1 == ''){
    $fdate1 = date('Y-m-01');
}
if($ldate1 == ''){
    $ldate1 = date('Y-m-d');
}


if($page=='') {
    $page=1;
}

$pageSql= $page-1;
$start=$pageSql*10;
$end = $start;

if($pageSql == 0) {
    $end = 10;
}
$cookieStaffId = $_COOKIE['staff_id'];
$cookieBranch_Id = $_COOKIE['branch_id'];
$currentDate = date('Y-m-d');

// Query for customer data
$currentDate = date('Y-m-d');

// Query for customer data
if($customer == "allname"){
    $sqlcus = "SELECT * FROM customer";
} else {
    $sqlcus = "SELECT * FROM customer WHERE customer_id='$customer'";
}

$resultcus = mysqli_query($conn, $sqlcus);
if (mysqli_num_rows($resultcus) > 0) {
    $i = 0;
    $htmlTableRows = '';
    while ($rowcus = mysqli_fetch_assoc($resultcus)) {
        $cus_id = $rowcus['customer_id'];

        // Query for sale data
        $sql = "SELECT * FROM sale WHERE customer='$cus_id'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $sale_id = $row['sale_id'];
                $customer_id = $row['customer'];
                $invoice_no = $row['invoice_no'];
                $remark = $row['notes'];
                $date = $row['sale_date'];
                $due_date = $row['due_date'];
                $sale_date = date('d-m-Y', strtotime($date));
                $due_date1 = date('d-m-Y', strtotime($due_date));

                // Calculate the difference in days
                $diffDays = (strtotime($currentDate) - strtotime($date)) / (60 * 60 * 24);

                // Fetch balance amount
                $sqlamount = "SELECT SUM(pay_made) AS pay_made FROM sale_payment WHERE sale_id='$sale_id'";
                $resamount = mysqli_query($conn, $sqlamount);
                if (mysqli_num_rows($resamount) > 0) {
                    $arrayamount = mysqli_fetch_array($resamount);
                    $totalAmount = $arrayamount['pay_made'];
                } else {
                    $totalAmount = 0;
                }
                $grand_total = $row['grand_total'];
                $balance_amount = $grand_total - $totalAmount;

                // Fetch customer name
                $sqlcustomer = "SELECT * FROM customer WHERE customer_id='$customer_id'";
                $rescustomer = mysqli_query($conn, $sqlcustomer);
                $rowcustomer = mysqli_fetch_assoc($rescustomer);
                $customer_name = $rowcustomer['customer_name'];

                // Initialize ageing columns
                $ageing30to45 = $ageing45to60 = $ageing60to90 = $ageing90to120 = $ageingGreaterThan120 = 'NA';

                // Determine the column based on days difference
                if ($diffDays >= 30 && $diffDays <= 45) {
                    $ageing30to45 = $balance_amount;
                } elseif ($diffDays > 45 && $diffDays <= 60) {
                    $ageing45to60 = $balance_amount;
                } elseif ($diffDays > 60 && $diffDays <= 90) {
                    $ageing60to90 = $balance_amount;
                } elseif ($diffDays > 90 && $diffDays <= 120) {
                    $ageing90to120 = $balance_amount;
                } elseif ($diffDays > 120) {
                    $ageingGreaterThan120 = $balance_amount;
                }

                // Increment counter
                $i++;

                // Generate table rows
                $htmlTableRows .= '<tr>';
                $htmlTableRows .= '<td>' . ($sale_date ? $sale_date : 'NA') . '</td>';
                $htmlTableRows .= '<td>' . ($invoice_no ? $invoice_no : 'NA') . '</td>';
                $htmlTableRows .= '<td>' . ($customer_name ? $customer_name : 'NA') . '</td>';
                $htmlTableRows .= '<td>' . ($grand_total ? $grand_total : 'NA') . '</td>';
                $htmlTableRows .= '<td>' . ($ageing30to45 !== 'NA' ? $ageing30to45 : 'NA') . '</td>';
                $htmlTableRows .= '<td>' . ($ageing45to60 !== 'NA' ? $ageing45to60 : 'NA') . '</td>';
                $htmlTableRows .= '<td>' . ($ageing60to90 !== 'NA' ? $ageing60to90 : 'NA') . '</td>';
                $htmlTableRows .= '<td>' . ($ageing90to120 !== 'NA' ? $ageing90to120 : 'NA') . '</td>';
                $htmlTableRows .= '<td>' . ($ageingGreaterThan120 !== 'NA' ? $ageingGreaterThan120 : 'NA') . '</td>';
                $htmlTableRows .= '<td>' . (!empty($remark) ? $remark : 'NA') . '</td>';
                $htmlTableRows .= '</tr>';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Customer Outstanding Report</title>

    <link rel="icon" type="image/png" sizes="16x16" href="../../images/favicon_New.png">
    <link href="../../vendor/jqvmap/css/jqvmap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../vendor/chartist/css/chartist.min.css">
    <link rel="stylesheet" href="../../vendor/select2/css/select2.min.css">

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

    $header_name ="Customer Outstanding Report";
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
                    <form>
                        <div class="container">
                            <div class="row">
                                <div class="col-9" style="margin-top: -28px;width: 238px;">
                                    <label>Select Customer Name</label>
                                    <select data-search="true" class="form-control js-example-disabled-results tail-select w-full" id="customer" name="customer" style="border-color: black;color: black">
                                        <option value="allname"> All Customer</option>
                                        <?php
                                        $sqlSupplier = "SELECT * FROM `customer`";
                                        $resultSupplier = mysqli_query($conn, $sqlSupplier);
                                        if (mysqli_num_rows($resultSupplier) > 0) {
                                            while ($rowSupplier = mysqli_fetch_array($resultSupplier)) {
                                                ?>
                                                <option
                                                    value='<?php echo $rowSupplier['customer_id']; ?>'><?php echo strtoupper($rowSupplier['customer_name']); ?></option>
                                                <?php
                                            }
                                        }
                                        ?>

                                    </select>
                                </div>
<!--                                <div class="col-4" style="margin-top: -28px;">-->
<!--                                    <label>Due date</label>-->
<!--                                    <select class="form-control" name="ddate" id="ddate" style="border-color:black;color:black;">-->
<!--                                        <option value="">-->
<!--                                            Due date-->
<!--                                        </option>-->
<!--                                    </select>-->
<!--                                </div>-->
                                <div class="col-3">
                                    <button type="submit" class="btn btn-primary mb-1">Search</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div style="display: flex;justify-content: flex-end;">

                        <!--                        <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#invoice_filter" style="margin-left: 20px;">FILTER</button>-->
                        <!--                        <button type="button" class="pdf_download btn btn-primary mb-2" id="pdf" style="margin-left: 20px;">PDF</button>-->
                        <!--                        <button class="pdf_download btn btn-success" type="button" id="pdf">PDF</button>-->
                        <button type="button" class="excel_download btn btn-rounded btn-success" style="margin-left: 20px;"><span class="btn-icon-left text-success"><i class="fa fa-download color-success"></i>
            </span>Excel Download</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>Bill No</th>
                                <th>Customer Name</th>
                                <th>Total Amount</th>
                                <th>30 to 45 days</th>
                                <th>45 to 60 days</th>
                                <th>60 to 90 days</th>
                                <th>90 to 120 days</th>
                                <th>(>120 days)</th>
                                <th>Remarks</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php echo $htmlTableRows; ?>
                            </tbody>
                        </table>
                        <div class="col-12 pl-3" style="display: flex;justify-content: center;">
                            <nav>
                                <ul class="pagination pagination-gutter pagination-primary pagination-sm no-bg">
                                    <?php
                                    // Pagination links
                                    if ($page > 1) {
                                        echo '<li class="page-item"><a class="page-link" href="?page_no=1">First</a></li>';
                                    }
                                    for ($i = 1; $i <= $totalPages; $i++) {
                                        $activeClass = ($i == $page) ? 'active' : '';
                                        echo '<li class="page-item ' . $activeClass . '"><a class="page-link" href="?page_no=' . $i . '">' . $i . '</a></li>';
                                    }
                                    if ($page < $totalPages) {
                                        echo '<li class="page-item"><a class="page-link" href="?page_no=' . $totalPages . '">Last</a></li>';
                                    }
                                    ?>
                                </ul>
                            </nav>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>



    </div>
    <?php Include ('../../includes/footer.php') ?>

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

<script src="../../vendor/select2/js/select2.full.min.js"></script>
<script src="../../js/plugins-init/select2-init.js"></script>
<script>
//
//    $( document ).ready(function() {
//        $('#search').val('<?php //echo $search;?>//');
//        $('#branch_nameS').val('<?php //echo $branch_nameS;?>//');
//
//    });

    $(document).on("click", ".excel_download", function () {
        window.location.href = "excel_download.php?&customer=<?php echo $customer?>";
    });


    var $disabledResults = $(".js-example-disabled-results");
    $disabledResults.select2();
</script>

</body>
</html>
