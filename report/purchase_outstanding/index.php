<?php Include("../../includes/connection.php");
date_default_timezone_set("Asia/kolkata");

error_reporting(0);
$page = isset($_GET['page_no']) ? $_GET['page_no'] : 1;
$supplier_name = isset($_GET['supplier_name']) ? $_GET['supplier_name'] : '';
$branch_name = isset($_GET['branch_name']) ? $_GET['branch_name'] : '';

if ($page == '') {
    $page = 1;
}

$start = ($page - 1) * 10;

$supplier_nameSql = $supplier_name != "" ? " AND supplier_name LIKE '%" . $supplier_name . "%'" : "";
$branch_nameSql = $branch_name != "" ? " AND branch_name LIKE '%" . $branch_name . "%'" : "";


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Purchase Outstanding Report</title>

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
    $header_name = "Purchase Outstanding Report";
    include('../../includes/header.php');
    ?>

    <div class="content-body">
        <div class="page-titles" style="margin-left: 21px;">
            <ol class="breadcrumb">
            </ol>
        </div>

        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Purchase Outstanding List</h4>
                    <div style="display: flex; justify-content: flex-end;">
                        <form class="form-inline">
                        </form>
<!--                        <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#invoice_filter" style="margin-left: 20px;">FILTER</button>-->
                        <button type="button" class="excel_download btn btn-rounded btn-success" style="margin-left: 20px;">
                            <span class="btn-icon-left text-success"><i class="fa fa-download color-success"></i></span> Excel Download
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-responsive-md" style="text-align: center;">
                            <thead>
                            <tr>
                                <th class="width80"><strong>#</strong></th>
                                <th><strong>Supplier Name</strong></th>
                                <th><strong>Balance Amount</strong></th>
                            </tr>
                            </thead>
                            <?php
                            $sql = "SELECT p.purchase_id, p.grand_total, s.supplier_name, (p.grand_total - COALESCE(SUM(pp.pay_made), 0)) AS balance_amount 
        FROM purchase p 
        LEFT JOIN purchase_payment pp ON p.purchase_id = pp.purchase_id
        LEFT JOIN supplier s ON p.supplier = s.supplier_id
        GROUP BY p.purchase_id, s.supplier_name
        ORDER BY p.purchase_id DESC LIMIT $start, 10";

                            $result = mysqli_query($conn, $sql);

                            $overallTotalAmount = 0;
                            if (mysqli_num_rows($result) > 0) {
                                $sNo = $start;
//                                $overallTotalAmount = 0;
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $sNo++;
                                    $supplier_name = $row['supplier_name'];
                                    $balance_amount = $row['balance_amount'];
                                    $overallTotalAmount += $balance_amount;
                                    ?>
                                    <tbody>
                                    <tr>
                                        <td><strong><?php echo $sNo; ?></strong></td>
                                        <td><?php echo $supplier_name; ?></td>
                                        <td><?php echo $balance_amount; ?></td>
                                    </tr>
                                    </tbody>
                                <?php } ?>
                                <tfoot>
                                <tr>
                                    <td colspan="2"><strong>Overall Total</strong></td>
                                    <td><strong><?php echo $overallTotalAmount; ?></strong></td>
                                </tr>
                                </tfoot>
                            <?php } ?>
                        </table>
                        <div class="col-12 pl-3" style="display: flex; justify-content: center;">
                            <nav>
                                <ul class="pagination pagination-gutter pagination-primary pagination-sm no-bg">
                                    <?php
                                    $prevPage = abs($page - 1);
                                    if ($prevPage == 0) {
                                        ?>
                                        <li class="page-item page-indicator"><a class="page-link" href="javascript:void(0);"><i class="fa-solid fa-less-than"></i></a></li>
                                        <?php
                                    } else {
                                        ?>
                                        <li class="page-item page-indicator"><a class="page-link" href="?page_no=<?php echo $prevPage; ?>&supplier_name=<?php echo $supplier_name; ?>"><i class="fa-solid fa-less-than"></i></a></li>
                                        <?php
                                    }
                                    $countSql = "SELECT COUNT(DISTINCT p.purchase_id) as count 
                                                 FROM purchase p 
                                                 LEFT JOIN supplier s ON p.supplier = s.supplier_id";
                                    $countResult = mysqli_query($conn, $countSql);
                                    if (mysqli_num_rows($countResult) > 0) {
                                        $countRow = mysqli_fetch_assoc($countResult);
                                        $count = $countRow['count'];
                                        $show = 10;
                                        $get = $count / $show;
                                        $pageFooter = floor($get);
                                        if ($get > $pageFooter) {
                                            $pageFooter++;
                                        }
                                        for ($i = 1; $i <= $pageFooter; $i++) {
                                            $active = ($i == $page) ? "active" : "";
                                            if ($i <= ($pageSql + 10) && $i > $pageSql || $pageFooter <= 10) {
                                                ?>
                                                <li class="page-item <?php echo $active; ?>"><a class="page-link" href="?page_no=<?php echo $i; ?>&supplier_name=<?php echo $supplier_name; ?>"><?php echo $i; ?></a></li>
                                                <?php
                                            }
                                        }
                                        $nextPage = $page + 1;
                                        if ($nextPage > $pageFooter) {
                                            ?>
                                            <li class="page-item page-indicator"><a class="page-link" href="javascript:void(0);"><i class="fa-solid fa-greater-than"></i></a></li>
                                            <?php
                                        } else {
                                            ?>
                                            <li class="page-item page-indicator"><a class="page-link" href="?page_no=<?php echo $nextPage; ?>&supplier_name=<?php echo $supplier_name; ?>"><i class="fa-solid fa-greater-than"></i></a></li>
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
        <?php Include ('../../includes/footer.php'); ?>
        <div class="modal fade" id="filter_modal" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="basic-form" style="color: black;">
                            <form id="filter_form" autocomplete="off">
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label>Supplier Name</label>
                                        <input type="text" class="form-control" placeholder="Supplier Name" id="supplier_name" name="supplier_name" style="border-color: #181f5a; color: black">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>Branch Name</label>
                                        <input type="text" class="form-control" placeholder="Branch Name" id="branch_name" name="branch_name" style="border-color: #181f5a; color: black">
                                    </div>
                                    <button type="submit" class="btn btn-primary mb-2">Search</button>
                                </div>
                            </form>
                        </div>
                    </div>
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
