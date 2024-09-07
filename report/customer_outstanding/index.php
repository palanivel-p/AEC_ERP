<?php Include("../../includes/connection.php");
date_default_timezone_set("Asia/kolkata");

error_reporting(0);
$page= $_GET['page_no'];

if($page=='') {
    $page=1;
}
$pageSql= $page-1;
$start=$pageSql*10;
$end = $start;

if($pageSql == 0) {
    $end = 10;
}
$p_name= $_GET['p_name'];
$p_code= $_GET['p_code'];
$s_category= $_GET['s_category'];
$p_category= $_GET['p_category'];
$brand= $_GET['brand'];
$customer= $_GET['customer'];

if($p_name != ""){
    $pNameSql= " AND product_name = '".$p_name."'";

}
else{
    $pNameSql ="";
}

if($p_code != ""){
    $pCodeSql= " AND product_code = '".$p_code."'";

}
else{
    $pCodeSql ="";
}

if($s_category != ""){
    $categorySql= " AND sub_category = '".$s_category."'";

}
else{
    $categorySql ="";
}
if($p_category != ""){
    $pcategorySql= " AND primary_category = '".$p_category."'";

}
else{
    $pcategorySql ="";
}

if($brand != ""){
    $brandSql= "AND brand_type = '".$brand."'";

}
else {
    $brandSql = "";
}
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
$currentDate = date('Y-m-d'); // Current date
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Customer Outstanding-Report</title>

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

    $header_name ="Customer Outstanding-Report";
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
                    <h4 class="card-title">Customer Outstanding List</h4>
                    <div style="display: flex;justify-content: flex-end;">
                        <!--                        <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#invoice_filter" style="justify-content: end">FILTER</button>-->

                        <form class="form-inline">

                            <!--                            <div class="form-group mx-sm-3 mb-2">-->
                            <!---->
                            <!--                                <input type="text" class="form-control" placeholder="Search By Name" name="search" id="search" style="border-radius:20px;color:black;" >-->
                            <!--                            </div>-->
                            <!--                            <button type="submit" class="btn btn-primary mb-2">Search</button>-->
                        </form>
<!--                        <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#invoice_filter" style="margin-left: 20px;">FILTER</button>-->
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
                                <th><strong>Bill No</strong></th>
                                <th><strong>Customer Name</strong></th>
                                <th><strong>Total Amount</strong></th>
                                <th><strong>30 to 45 days</strong></th>
                                <th><strong>45 to 60 days</strong></th>
                                <th><strong>60 to 90 days</strong></th>
                                <th><strong>90 to 120 days</strong></th>
                                <th><strong>(>120 days)</strong></th>
                                <th><strong>Remarks</strong></th>
                            </tr>
                            </thead>
                            <?php
//                            $i = 0;

//                            if($customer == "allname"){
                                $sqlcus = "SELECT * FROM customer ORDER BY id DESC LIMIT $start,10";
//                            }else{
//                                $sqlcus = "SELECT * FROM customer Where customer_id='$customer'";
//                            }

                            $resultcus = mysqli_query($conn, $sqlcus);
                            if (mysqli_num_rows($resultcus) > 0) {
                            $sNo = $start;
                                $overallTotal = 0;
                                $overall30to45 = 0;
                                $overall45to60 = 0;
                                $overall60to90 = 0;
                                $overall90to120 = 0;
                                $overallGreaterThan120 = 0;
                                while ($rowcus = mysqli_fetch_assoc($resultcus)) {
                            $sNo++;
                                    $cus_id=$rowcus['customer_id'];

                                    $sql = "SELECT * FROM sale WHERE customer='$cus_id'";
                                    $result = mysqli_query($conn, $sql);
                                    if (mysqli_num_rows($result) > 0) {
                                        // Initialize variables for overall totals
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $sale_id = $row['sale_id'];
                                            $customer_id = $row['customer'];
                                            $invoice_no = $row['invoice_no'];
                                            $remark = $row['notes'];
                                            $date = $row['sale_date'];
                                            $due_date = $row['due_date'];
                                            $sale_date = date('d-m-Y', strtotime($date));
                                            $due_date1 = date('d-m-Y', strtotime($due_date));

                                            if($remark == ''){
                                                $notes = 'NA';
                                            }else{
                                                $notes = $remark;
                                            }
                                            // Calculate the difference in days
                                            $diffDays = (strtotime($currentDate) - strtotime($date)) / (60 * 60 * 24);

                                            // Fetch balance_amount
                                            $sqlamount = "SELECT SUM(pay_made) AS pay_made FROM sale_payment WHERE sale_id='$sale_id'";
                                            $resamount = mysqli_query($conn, $sqlamount);
                                            if (mysqli_num_rows($resamount) > 0) {
                                                $arrayamount = mysqli_fetch_array($resamount);
                                                $totalAmount = $arrayamount['pay_made'];
                                            }
                                            $grand_total = $row['grand_total'];
                                            $balance_amount = $grand_total - $totalAmount;

                                            // Assign remarks based on the difference in days
                                            if ($diffDays >= 30 && $diffDays <= 45) {
                                                $thirty = $balance_amount;
                                            } elseif ($diffDays > 45 && $diffDays <= 60) {
                                                $fourty = $balance_amount;
                                            } elseif ($diffDays > 60 && $diffDays <= 90) {
                                                $sixty = $balance_amount;
                                            } elseif ($diffDays > 90 && $diffDays <= 120) {
                                                $ninty = $balance_amount;
                                            } elseif ($diffDays > 120) {
                                                $onetwenty = $balance_amount;
                                            } else {
                                                // Default column if the condition doesn't match
                                                $column = '';
                                            }
                                            if($thirty ==''){
                                                $thirty = 'NA';
                                            }
                                            if($fourty ==''){
                                                $fourty = 'NA';
                                            }
                                            if($sixty ==''){
                                                $sixty = 'NA';
                                            }
                                            if($ninty ==''){
                                                $ninty = 'NA';
                                            }
                                            if($onetwenty ==''){
                                                $onetwenty = 'NA';
                                            }
                                            $sqlcustomer = "SELECT * FROM `customer` WHERE `customer_id`='$customer_id'";
                                            $rescustomer = mysqli_query($conn, $sqlcustomer);
                                            $rowcustomer = mysqli_fetch_assoc($rescustomer);
                                            $customer_name =  $rowcustomer['customer_name'];
                                            // Increment counter
                                            $i++;

                                            // Update overall totals
                                            $overallTotal += $grand_total;
                                            if ($diffDays >= 30 && $diffDays <= 45) {
                                                $overall30to45 += $balance_amount;
                                            } elseif ($diffDays > 45 && $diffDays <= 60) {
                                                $overall45to60 += $balance_amount;
                                            } elseif ($diffDays > 60 && $diffDays <= 90) {
                                                $overall60to90 += $balance_amount;
                                            } elseif ($diffDays > 90 && $diffDays <= 120) {
                                                $overall90to120 += $balance_amount;
                                            } elseif ($diffDays > 120) {
                                                $overallGreaterThan120 += $balance_amount;
                                            }
                                        }
                                    }
                            ?>
                            <tbody>
                            <tr>
                                <td><strong><?php echo $sNo;?></strong></td>
                                <td> <?php echo $due_date1?> </td>
                                <td> <?php echo $invoice_no?> </td>
                                <td> <?php echo $customer_name?> </td>
                                <td> <?php echo $grand_total?> </td>
                                <td> <?php echo $thirty?> </td>
                                <td> <?php echo $fourty?> </td>
                                <td> <?php echo $sixty?> </td>
                                <td> <?php echo $ninty?> </td>
                                <td> <?php echo $onetwenty?> </td>
                                <td> <?php echo $notes?> </td>
                            </tr>

                            <?php } }
                            ?>
                            </tbody>
                        </table>
                        <div class="col-12 pl-3" style="display: flex;justify-content: center;">
                            <nav>
                                <ul class="pagination pagination-gutter pagination-primary pagination-sm no-bg">
                                    <?php
                                    $prevPage=abs($page-1);
                                    if($prevPage==0)
                                    {
                                        ?>
                                        <li class="page-item page-indicator"><a class="page-link" href="javascript:void(0);"><i class="fa-solid fa-less-than"></i></a></li>
                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <li class="page-item page-indicator"><a class="page-link" href="?page_no=<?php echo $prevPage?>&user_name=<?php echo $user_name?>"><i class="fa-solid fa-less-than"></i></a></li>
                                        <?php
                                    }
//                                    if($user_name == "" ) {
//                                        $sql = "SELECT COUNT(id) as count FROM customer ORDER BY id DESC";
//                                    }
//                                    else {
                                        $sql = "SELECT COUNT(id) as count FROM customer ORDER BY id DESC ";
//                                    }

                                    $result = mysqli_query($conn, $sql);

                                    if (mysqli_num_rows($result)) {

                                        $row = mysqli_fetch_assoc($result);
                                        $count = $row['count'];
                                        $show = 10;

                                        $get = $count / $show;

                                        $pageFooter = floor($get);

                                        if ($get > $pageFooter) {
                                            $pageFooter++;
                                        }

                                        for ($i = 1; $i <= $pageFooter; $i++) {
                                            if($i==$page) {
                                                $active = "active";
                                            }
                                            else {
                                                $active = "";
                                            }
                                            if($i<=($pageSql+10) && $i>$pageSql || $pageFooter<=10) {
                                                ?>
                                                <li class="page-item <?php echo $active ?>"><a class="page-link"
                                                                                               href="?page_no=<?php echo $i ?>&user_name=<?php echo $user_name?>"><?php echo $i ?></a>
                                                </li>
                                                <?php
                                            }
                                        }

                                        $nextPage=$page+1;

                                        if($nextPage>$pageFooter)
                                        {
                                            ?>
                                            <li class="page-item page-indicator"><a class="page-link" href="javascript:void(0);"><i class="fa-solid fa-greater-than"></i></a></li>
                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <li class="page-item page-indicator"><a class="page-link" href="?page_no=<?php echo $nextPage ?>&role=<?php echo $role ?>&user_name=<?php echo $user_name?>"><i class="fa-solid fa-greater-than"></i></a></li>
                                            <?php
                                        }
                                    }
                                    ?>
                                </ul>
                            </nav>
                        </div>
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
                                        <label>Role</label>
                                        <input type="text"  class="form-control" placeholder="Role" id="user_role" name="user_role" style="border-color: #181f5a;color: black">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>User Name </label>
                                        <input type="text"  class="form-control" placeholder="User Name" id="u_name" name="u_name" style="border-color: #181f5a;color: black">
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

        //$( document ).ready(function() {
        //    $('#search').val('<?php //echo $search;?>//');
        //    $('#branch_nameS').val('<?php //echo $branch_nameS;?>//');
        //
        //});
        //$(document).on("click", ".excel_download", function () {
        //    window.location.href = "excel_download.php?&p_id=<?php //echo $p_id?>//&s_id=<?php //echo $s_id?>//";
        //});
        $(document).on("click", ".excel_download", function () {
            window.location.href = "excel_download.php?&role=<?php echo $role ?>&user_name=<?php echo $user_name?>";
        });

        function pdf(purchase_id) {
            window.location.href= '<?php echo $website; ?>/purchase/invoice.php?purchase_id='+purchase_id;
        }
    </script>

</body>
</html>
