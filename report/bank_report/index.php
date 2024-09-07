<?php Include("../../includes/connection.php");
date_default_timezone_set("Asia/kolkata");

error_reporting(0);
$page= $_GET['page_no'];
$bank_name= $_GET['bank_name'];
$role= $_GET['user_role'];
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
if($bank_name != ""){
//    $pNameSql= " AND product_name = '".$p_name."'";
    $bank_nameSql = " AND bank_name LIKE '%" . $bank_name . "%'";

}
else{
    $bank_nameSql ="";
}

if($role != ""){
//    $pCodeSql= " AND product_code = '".$p_code."'";
    $roleSql = " AND role LIKE '%" . $role . "%'";
}
else{
    $roleSql ="";
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Bank-Report</title>

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

    $header_name ="Bank-Report";
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
                    <h4 class="card-title">Bank-Report List</h4>
                    <div style="display: flex;justify-content: flex-end;">
                        <!--                        <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#invoice_filter" style="justify-content: end">FILTER</button>-->

                        <form class="form-inline">

<!--                        <div class="form-group mx-sm-3 mb-2">-->
<!---->
<!--                            <input type="text" class="form-control" placeholder="Search Bank Name" name="bank_name" id="bank_name" style="border-radius:20px;color:black;" >-->
<!--                        </div>-->
<!--                                                        <button type="submit" class="btn btn-primary mb-2">Search</button>-->
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
                                <th><strong>Bank Name</strong></th>
                                <th><strong>Particulars</strong></th>
                                <th><strong>Payment Type</strong></th>
                                <th><strong>Reference No</strong></th>
                                <th><strong>Debit</strong></th>
                                <th><strong>Credit</strong></th>
                            </tr>
                            </thead>
                            <?php
                            if($bank_name == "" && $f_date =="" && $t_date =="") {
                                $sql = "SELECT * FROM bank_details WHERE  payment_date  BETWEEN '$from_date' AND '$to_date' $bank_nameSql ORDER BY id DESC LIMIT $start,10";
                            }
                            else {
                                $sql = "SELECT * FROM bank_details WHERE  payment_date  BETWEEN '$from_date' AND '$to_date' $bank_nameSql ORDER BY id DESC LIMIT $start,10";
                            }
//                            $sql =  "SELECT e.date, e.bank_name, e.supplier, e.amount, e.expense_date, pp.repayment_date, pp.pay_made
//                                         FROM expense e LEFT JOIN purchase_payment pp ON e.bank_name = pp.bank_name AND e.supplier = pp.supplier  ORDER BY e.id DESC LIMIT $start, 10";

                            $result = mysqli_query($conn, $sql);
                            if (mysqli_num_rows($result)>0) {
                            $sNo = $start;
                            while($row = mysqli_fetch_assoc($result)) {

                            $sNo++;
                            $bank_name=$row['bank_name'];
                            $particular = $row['pay_from'];
                            $payment_date = $row['payment_date'];
                            $added_dates = date('d-m-Y', strtotime($payment_date));
                            $pay_mode = $row['pay_mode'];
                            $amount = $row['amount'];
                            $ref_no = $row['ref_no'];
                            $type = $row['type'];
                            if (empty($type)) {
                                $Credit = 'NA';
                                $Debit = 'NA';
                            } else {
                                if ($type == 'Credit') {
                                    $Credit = $amount;
                                    $Debit = 'NA'; // Optionally, you can set Debit to 'NA' if type is 'Credit'
                                } elseif ($type == 'Debit') {
                                    $Debit = $amount;
                                    $Credit = 'NA'; // Optionally, you can set Credit to 'NA' if type is 'Debit'
                                } else {
                                    $Credit = 'NA';
                                    $Debit = 'NA';
                                }
                            }
                            ?>
                            <tbody>
                            <tr>
                                <td><strong><?php echo $sNo;?></strong></td>
                                <td> <?php echo $added_dates?> </td>
                                <td> <?php echo $bank_name?> </td>
                                <td> <?php echo $particular?> </td>
                                <td> <?php echo $pay_mode?> </td>
                                <td> <?php echo $ref_no?> </td>
                                <td> <?php echo $Debit?> </td>
                                <td> <?php echo $Credit?> </td>

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
                                        <li class="page-item page-indicator"><a class="page-link" href="?page_no=<?php echo $prevPage?>&bank_name=<?php echo $bank_name ?>&f_date=<?php echo $from_date?>&t_date=<?php echo $to_date?>"><i class="fa-solid fa-less-than"></i></a></li>
                                        <?php
                                    }
                                    if($bank_name == "" && $f_date =="" && $t_date =="") {
                                        $sql = "SELECT COUNT(id) as count FROM bank_details WHERE  payment_date  BETWEEN '$from_date' AND '$to_date' $bank_nameSql";
                                    }
                                    else {
                                        $sql = "SELECT COUNT(id) as count FROM bank_details WHERE  payment_date  BETWEEN '$from_date' AND '$to_date' $bank_nameSql";
                                    }
                                    
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
                                                                                               href="?page_no=<?php echo $i ?>&bank_name=<?php echo $bank_name ?>&f_date=<?php echo $from_date?>&t_date=<?php echo $to_date?>"><?php echo $i ?></a>
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
                                            <li class="page-item page-indicator"><a class="page-link" href="?page_no=<?php echo $nextPage ?>&bank_name=<?php echo $bank_name ?>&f_date=<?php echo $from_date?>&t_date=<?php echo $to_date?>"><i class="fa-solid fa-greater-than"></i></a></li>
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
                                        <label>From Date </label>
                                        <input type="date"  class="form-control" id="f_date" name="f_date" style="border-color: #181f5a;color: black">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>To Date </label>
                                        <input type="date"  class="form-control" id="t_date" name="t_date" style="border-color: #181f5a;color: black">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>Bank Name </label>
                                        <input type="text"  class="form-control" placeholder="Bank Name" id="bank_name" name="bank_name" style="border-color: #181f5a;color: black">
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
            window.location.href = "excel_download.php?&bank_name=<?php echo $bank_name ?>&f_date=<?php echo $from_date?>&t_date=<?php echo $to_date?>";
        });

        function pdf(purchase_id) {
            window.location.href= '<?php echo $website; ?>/purchase/invoice.php?purchase_id='+purchase_id;
        }
    </script>

</body>
</html>
