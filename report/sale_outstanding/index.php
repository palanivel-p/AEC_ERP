<?php Include("../../includes/connection.php");
date_default_timezone_set("Asia/kolkata");

error_reporting(0);
$page= $_GET['page_no'];
$a_id= $_GET['a_id'];
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

if($a_id != ""){
    $a_idSql= " AND adjustment_id = '".$a_id."'";

}
else{
    $a_idSql ="";
}

if($s_id != ""){
    $s_idSql= " AND supplier = '".$s_id."'";

}
else{
    $s_idSql ="";
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
if($_COOKIE['role'] == 'Super Admin'){
    $addedBranchSerach = '';
}
else {
    if ($_COOKIE['role'] == 'Admin'){
        $addedBranchSerach = "AND branch_name='$cookieBranch_Id'";

    }
//    else{
//        $addedBranchSerach = "AND added_by='$cookieStaffId' AND branch_name='$cookieBranch_Id'";
//
//    }

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Sale Outstanding Report</title>

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
    $header_name ="Sale Outstanding Report";
    Include ('../../includes/header.php');
    ?>

    <div class="content-body">
        <div class="page-titles" style="margin-left: 21px;">
            <ol class="breadcrumb"></ol>
        </div>

        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Sale Outstanding Report List</h4>
                    <div style="display: flex; justify-content: flex-end;">
<!--                        <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#invoice_filter" style="margin-left: 20px;">FILTER</button>-->
                        <button type="button" class="excel_download btn btn-rounded btn-success" style="margin-left: 20px;">
                            <span class="btn-icon-left text-success"><i class="fa fa-download color-success"></i></span>Excel Download
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-responsive-md" style="text-align: center;">
                            <thead>
                            <tr>
                                <th class="width80"><strong>#</strong></th>
                                <th><strong>Customer</strong></th>
                                <th><strong>Balance Amount</strong></th>
                            </tr>
                            </thead>
                            <?php
                            $sql = "SELECT * FROM sale ORDER BY sale_id DESC LIMIT $start,10";
                            $result = mysqli_query($conn, $sql);
                            if (mysqli_num_rows($result) > 0) {
                            $sNo = $start;
                            $overallTotalAmount = 0;

                            while ($row = mysqli_fetch_assoc($result)) {
                            $sNo++;
                            $sale_id = $row['sale_id'];
                            $customer_id = $row['customer'];

                            $sqlamount = "SELECT SUM(pay_made) AS pay_made FROM sale_payment WHERE sale_id='$sale_id'";
                            $resamount = mysqli_query($conn, $sqlamount);

                            if (mysqli_num_rows($resamount) > 0) {
                                $arrayamount = mysqli_fetch_array($resamount);
                                $totalAmount = $arrayamount['pay_made'];
                            }
                            $grand_total = $row['grand_total'];
                            $balance_amount = $grand_total - $totalAmount;

                            $overallTotalAmount += $balance_amount;

                            $sqlcustomer = "SELECT * FROM `customer` WHERE `customer_id`='$customer_id'";
                            $rescustomer = mysqli_query($conn, $sqlcustomer);
                            $rowcustomer = mysqli_fetch_assoc($rescustomer);
                            $customer_name = $rowcustomer['customer_name'];
                            ?>
                            <tbody>
                            <tr>
                                <td><strong><?php echo $sNo; ?></strong></td>
                                <td><?php echo $customer_name; ?></td>
                                <td><?php echo $balance_amount; ?></td>
                            </tr>
                            <?php } ?>
                            <tr>
                                <td colspan="2"><strong>Overall Total</strong></td>
                                <td><?php echo $overallTotalAmount; ?></td>
                            </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                        <div class="col-12 pl-3" style="display: flex; justify-content: center;">
                            <nav>
                                <ul class="pagination pagination-gutter pagination-primary pagination-sm no-bg">
                                    <?php
                                    $prevPage = abs($page-1);
                                    if ($prevPage == 0) {
                                        echo '<li class="page-item page-indicator"><a class="page-link" href="javascript:void(0);"><i class="fa-solid fa-less-than"></i></a></li>';
                                    } else {
                                        echo '<li class="page-item page-indicator"><a class="page-link" href="?page_no=' . $prevPage . '"><i class="fa-solid fa-less-than"></i></a></li>';
                                    }

                                    $sql = "SELECT COUNT(sale_id) as count FROM sale";
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
                                            $active = ($i == $page) ? "active" : "";
                                            if ($i <= ($pageSql + 10) && $i > $pageSql || $pageFooter <= 10) {
                                                echo '<li class="page-item ' . $active . '"><a class="page-link" href="?page_no=' . $i . '">' . $i . '</a></li>';
                                            }
                                        }

                                        $nextPage = $page + 1;
                                        if ($nextPage > $pageFooter) {
                                            echo '<li class="page-item page-indicator"><a class="page-link" href="javascript:void(0);"><i class="fa-solid fa-greater-than"></i></a></li>';
                                        } else {
                                            echo '<li class="page-item page-indicator"><a class="page-link" href="?page_no=' . $nextPage . '"><i class="fa-solid fa-greater-than"></i></a></li>';
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
    </div>

    <script src="../../vendor/global/global.min.js"></script>
    <script src="../../vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
    <script src="../../vendor/chart.js/Chart.bundle.min.js"></script>
    <script src="../../js/custom.min.js"></script>
    <script src="../../js/dlabnav-init.js"></script>
    <script src="../../js/demo.js"></script>
    <script src="../../js/styleSwitcher.js"></script>
    <script src="../../vendor/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script src="../../vendor/clockpicker/js/bootstrap-clockpicker.min.js"></script>
    <script src="../../vendor/jquery-asColor/jquery-asColor.min.js"></script>
    <script src="../../vendor/jquery-asGradient/jquery-asGradient.min.js"></script>
    <script src="../../vendor/jquery-asColorPicker/js/jquery-asColorPicker.min.js"></script>
    <script src="../../vendor/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
    <script src="../../vendor/pickadate/picker.js"></script>
    <script src="../../vendor/pickadate/picker.time.js"></script>
    <script src="../../vendor/pickadate/picker.date.js"></script>
    <script src="../../vendor/summernote/js/summernote.min.js"></script>
    <script src="../../js/plugins-init/bs-daterange-picker-init.js"></script>
    <script src="../../js/plugins-init/clock-picker-init.js"></script>
    <script src="../../js/plugins-init/jquery-asColorPicker.init.js"></script>
    <script src="../../js/plugins-init/material-date-picker-init.js"></script>
    <script src="../../js/plugins-init/pickadate-init.js"></script>
    <script src="../../js/plugins-init/summernote-init.js"></script>


<script>

    $( document ).ready(function() {
        $('#search').val('<?php echo $search;?>');

    });
    $(document).on("click", ".excel_download", function () {
        window.location.href = "excel_download.php?&p_id=<?php echo $p_id?>&s_id=<?php echo $s_id?>";
    });
    $(document).on("click", ".pdf_download", function () {
        window.location.href = "pdf_download.php?&p_id=<?php echo $p_id?>&s_id=<?php echo $s_id?>";
    });

    function pdf(purchase_id) {
        window.location.href= '<?php echo $website; ?>/purchase/invoice.php?purchase_id='+purchase_id;
    }
</script>

</body>
</html>
