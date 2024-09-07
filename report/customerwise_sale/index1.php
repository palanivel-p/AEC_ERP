<?php
include("../../includes/connection.php");
date_default_timezone_set("Asia/Kolkata");
error_reporting(E_ALL);
$page= $_GET['page_no'];
$a_id= $_GET['a_id'];
$fdate1 = $_GET['fdate'];
$ldate1 = $_GET['ldate'];

if($fdate1 == ''){
    $fdate1 = date('Y-m-01');
}
if($ldate1 == ''){
    $ldate1 = date('Y-m-d');
}


//$fdate = date('Y-m-01');
//$ldate = date('Y-m-d');



if($page=='') {
    $page=1;
}

$pageSql= $page-1;
$start=$pageSql*10;
$end = $start;

if($pageSql == 0) {
    $end = 10;
}
echo $query = "SELECT * FROM sale WHERE id > 0  $dateSql ORDER BY id DESC LIMIT $start, $end";
$result = mysqli_query($conn, $query);

$sumQty = 0;
$sumAmount = 0;
$totalRate = 0;
$numRows = 0;

if (mysqli_num_rows($result) > 0) {
    $sNo = $start;
    while ($row = mysqli_fetch_assoc($result)) {
        $customer_id =$row['customer'];
        $sale_id =$row['sale_id'];

        $sNo++;
        echo '<tr>';
        echo '<td>' . $sNo . '</td>';
        echo '<td>' . $row['customer'] . '</td>';
        echo '<td>' . $row['product'] . '</td>';
        echo '<td>' . $row['qty'] . '</td>';
        echo '<td>' . $row['rate'] . '</td>';
        echo '<td>' . $row['amount'] . '</td>';
        $sumQty += $row['qty'];
        $sumAmount += $row['amount'];
        $totalRate += $row['rate'];
        $numRows++;
        echo '</tr>';
    }
    $avgRate = $totalRate / $numRows;
} else {
    echo '<tr><td colspan="9">No records found for the selected period.</td></tr>';
}

// Pagination links
echo '<nav><ul class="pagination pagination-gutter pagination-primary pagination-sm no-bg">';
$prevPage = abs($page - 1);
$prevDisabled = $prevPage == 0 ? 'disabled' : '';
echo "<li class='page-item page-indicator $prevDisabled'><a class='page-link' href='?page_no=$prevPage&start_date=$fdate1&end_date=$ldate1'><i class='fa-solid fa-less-than'></i></a></li>";

$countQuery = "SELECT COUNT(id) as count FROM sale WHERE id > 0  $dateSql";
$countResult = mysqli_query($conn, $countQuery);
if (mysqli_num_rows($countResult)) {
    $row = mysqli_fetch_assoc($countResult);
    $count = $row['count'];
    $show = 10;
    $pageFooter = ceil($count / $show);

    for ($i = 1; $i <= $pageFooter; $i++) {
        $active = $i == $page ? 'active' : '';
        echo "<li class='page-item $active'><a class='page-link' href='?page_no=$i&start_date=$fdate1&end_date=$ldate1'>$i</a></li>";
    }

    $nextPage = $page + 1;
    $nextDisabled = $nextPage > $pageFooter ? 'disabled' : '';
    echo "<li class='page-item page-indicator $nextDisabled'><a class='page-link' href='?page_no=$nextPage&start_date=$fdate1&end_date=$ldate1'><i class='fa-solid fa-greater-than'></i></a></li>";
}
echo '</ul></nav>';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Customer Wise Sales Report</title>
    <link rel="icon" type="image/png" sizes="16x16" href="../../images/favicon_New.png">
    <link href="../../vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
    <link href="../../css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css">
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
    <?php include ('../../includes/header.php'); ?>
    <div class="content-body">
        <div class="page-titles" style="margin-left: 21px;">
            <ol class="breadcrumb"></ol>
        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <form>
                        <div class="container">
                            <div class="row">
                                <div class="col-4" style="margin-top: -28px;">
                                    <label>From date</label>
                                    <input type="date" class="form-control" name="start_date" value="<?php echo $fdate1;?>" id="start_date" style="border-color:black;color:black;">
                                </div>
                                <div class="col-4" style="margin-top: -28px;">
                                    <label>To date</label>
                                    <input type="date" class="form-control" name="end_date" value="<?php echo $ldate1;?>" id="end_date" style="border-color:black;color:black;">
                                </div>
                                <!--                                <div class="col-4" style="margin-top: -28px;">-->
                                <!--                                    <label>Customer Name</label>-->
                                <!--                                    <input type="text" class="form-control" name="customer_name" value="--><?php //echo $customer_name;?><!--" id="customer_name" style="border-color:black;color:black;">-->
                                <!--                                </div>-->
                                <div class="col-4">
                                    <button type="submit" class="btn btn-primary mb-1">Search</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div style="display: flex;justify-content: flex-end;">
                        <button type="button" class="excel_download btn btn-rounded btn-success" style="margin-left: 20px;"><span class="btn-icon-left text-success"><i class="fa fa-download color-success"></i></span>Excel Download</button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-responsive-md" style="text-align: center;">
                        <thead>
                        <tr>
                            <th><strong>S.No</strong></th>
                            <th><strong>Customer</strong></th>
                            <th><strong>Product</strong></th>
                            <th><strong>Qty</strong></th>
                            <th><strong>Rate</strong></th>
                            <th><strong>Amount</strong></th>
                            <th><strong>Sum Of Qty</strong></th>
                            <th><strong>Average Of Rate</strong></th>
                            <th><strong>Sum Of Amount</strong></th>
                        </tr>
                        </thead>
                        <?php
                        //    $sql = "SELECT * FROM expense ORDER BY id  LIMIT $start,10";
                           echo $sql = "SELECT * FROM sale WHERE sale_date BETWEEN $fdate1 AND $ldate1 ORDER BY id DESC LIMIT $start, 10";

                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result)>0) {
                        $sNo = $start;
                        while($row = mysqli_fetch_assoc($result)) {

                        $sNo++;
                        $customer_id=$row['customer'];
                        $sale_id = $row['sale_id'];

                        $sqlCustomer = "SELECT * FROM `customer` WHERE `customer_id`='$customer_id'";
                        $resCustomer = mysqli_query($conn, $sqlCustomer);
                        $rowCustomer = mysqli_fetch_assoc($resCustomer);
                        $customer_names =  $rowCustomer['customer_name'];

                        $sqlSale = "SELECT * FROM `sale_details` WHERE `sale_id`='$sale_id'";
                        $resSale = mysqli_query($conn, $sqlSale);
                        $rowSale = mysqli_fetch_assoc($resSale);
                        $product_name =  $rowSale['product_name'];

                        $added_date = $row['added_date'];
                        $added_dates = date('d-m-Y', strtotime($added_date));
                        $user_activity = $row['activity'];

                        ?>
                        <tbody>
                        <tr>
                            <td><strong><?php echo $sNo;?></strong></td>
                            <td> <?php echo $customer_names?> </td>
                            <td> <?php echo $product_name?> </td>
                            <td> <?php echo $added_dates?> </td>
                            <td> <?php echo $user_activity?> </td>
                        </tr>

                        <?php } }
                        ?>
                        </tbody>
                        <tbody>
                        <?php
                        echo '<tr>
                            <td colspan="6"><strong>Records from ' . date('M Y', strtotime($fdate1)) . '</strong></td>
                            <td><strong>' . $sumQty . '</strong></td>
                            <td><strong>' . number_format($avgRate, 2) . '</strong></td>
                            <td><strong>' . $sumAmount . '</strong></td>
                        </tr>';
                        ?>
                        </tbody>
                    </table>
                    <div class="col-12 pl-3" style="display: flex;justify-content: center;">
                        <nav>
                            <ul class="pagination pagination-gutter pagination-primary pagination-sm no-bg">
                                <?php
                                echo "<li class='page-item page-indicator $prevDisabled'><a class='page-link' href='?page_no=$prevPage&customer_name=$customer_name&start_date=$fdate1&end_date=$ldate1'><i class='fa-solid fa-less-than'></i></a></li>";

                                for ($i = 1; $i <= $pageFooter; $i++) {
                                    $active = $i == $page ? 'active' : '';
                                    echo "<li class='page-item $active'><a class='page-link' href='?page_no=$i&customer_name=$customer_name&start_date=$fdate1&end_date=$ldate1'>$i</a></li>";
                                }

                                echo "<li class='page-item page-indicator $nextDisabled'><a class='page-link' href='?page_no=$nextPage&customer_name=$customer_name&start_date=$fdate1&end_date=$ldate1'><i class='fa-solid fa-greater-than'></i></a></li>";
                                ?>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include ('../../includes/footer.php'); ?>
</div>

<script src="../../vendor/global/global.min.js"></script>
<script src="../../vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
<script src="../../vendor/chart.js/Chart.bundle.min.js"></script>
<script src="../../js/custom.min.js"></script>
<script src="../../js/dlabnav-init.js"></script>
<script src="../../vendor/owl-carousel/owl.carousel.js"></script>
<script src="../../vendor/peity/jquery.peity.min.js"></script>
<script src="../../js/dashboard/dashboard-1.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../../vendor/jquery-validation/jquery.validate.min.js"></script>
<script src="../../js/plugins-init/jquery.validate-init.js"></script>
<script src="../../vendor/moment/moment.min.js"></script>
<script src="../../vendor/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="../../vendor/summernote/js/summernote.min.js"></script>
<script src="../../js/plugins-init/summernote-init.js"></script>
<script>
    $(document).ready(function() {
        $('#start_date').val('<?php echo $start_date;?>');
        $('#end_date').val('<?php echo $end_date;?>');
    });
    $(document).on("click", ".excel_download", function () {
        window.location.href = "demo.php?fdate=<?php echo $start_date?>&ldate=<?php echo $end_date?>";
    });
</script>
</body>
</html>
