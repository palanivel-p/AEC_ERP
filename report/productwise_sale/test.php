<?php Include("../../includes/connection.php");
date_default_timezone_set("Asia/kolkata");

error_reporting(0);
$page= $_GET['page_no'];
$fdate1 = isset($_GET['fdate']) ? $_GET['fdate'] : date('Y-m-01');
$ldate1 = isset($_GET['ldate']) ? $_GET['ldate'] : date('Y-m-d');

// Convert dates to DateTime objects
$fdate_obj = new DateTime($fdate1);
$ldate_obj = new DateTime($ldate1);

// Calculate the difference in months
$diff = $ldate_obj->diff($fdate_obj);
$diff_years_in_months = $diff->y * 12;
$total_diff_months = $diff_years_in_months + $diff->m;
if ($diff->d > 0) {
    $total_diff_months++;
}

// Set the current date for iteration
$currentDate = clone $fdate_obj;

// Handle pagination
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$pageSql = $page - 1;
$start = $pageSql * 10;
$end = ($pageSql == 0) ? 10 : $start + 10;

// Handle role-based search filters
$cookieStaffId = $_COOKIE['staff_id'];
$cookieBranch_Id = $_COOKIE['branch_id'];
$addedBranchSerach = '';
if ($_COOKIE['role'] == 'Super Admin') {
    $addedBranchSerach = '';
} else if ($_COOKIE['role'] == 'Admin') {
    $addedBranchSerach = "AND branch_name='$cookieBranch_Id'";
    // Uncomment if needed:
    // $addedBranchSerach = "AND added_by='$cookieStaffId' AND branch_name='$cookieBranch_Id'";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>ProductWise Sale Report</title>

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
    $header_name ="ProductWise Sale Report";
    Include ('../../includes/header.php') ?>

    <div class="content-body">
        <div class="page-titles" style="margin-left: 21px;">
            <ol class="breadcrumb">
                <!-- <li class="breadcrumb-item"><a href="javascript:void(0)">Table</a></li>-->
                <!--  <li class="breadcrumb-item active"><a href="javascript:void(0)">Purchase</a></li>-->
            </ol>
        </div>


        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <form>
                        <div class="container">
                            <div class="row">
                                <div class="col-4" style="margin-top: -28px;">
                                    <label>From date</label>
                                    <input type="date" class="form-control" placeholder="Start Date" name="fdate" value="<?php echo htmlspecialchars($fdate1); ?>" min="1900-01-01" max="<?php echo date("Y-m-d"); ?>" id="fdate" style="border-color:black;color:black;">
                                </div>
                                <div class="col-4" style="margin-top: -28px;">
                                    <label>To date</label>
                                    <input type="date" class="form-control" placeholder="End Date" name="ldate" value="<?php echo htmlspecialchars($ldate1); ?>" min="1900-01-01" max="<?php echo date("Y-m-d"); ?>" id="ldate" style="border-color:black;color:black;">
                                </div>
                                <div class="col-4">
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
                        <?php
//                           $sql1='select p.primary_category,ct.sub_category,p.product_name ,c.customer_id,p.product_id,c.customer_name,sd.sale_date from product p inner join sale_details sd on p.product_id=sd.product_id inner join sale s on s.sale_id=sd.sale_id inner join customer c on c.customer_id=s.customer inner join category ct on ct.category_id=p.sub_category';
                        ////                           $result1 = mysqli_query($conn, $sql1);
                        ////                        if (mysqli_num_rows($result1)>0) {
                        ////                            while($row1 = mysqli_fetch_assoc($result1)) {
                        ////
                        ////                                $sql='select DATE_FORMAT(sale_date,"%M %Y") sale_date from sale_details where sale_date between (select min(sale_date) from sale_details) and (select max(sale_date) from sale_details) group by DATE_FORMAT(sale_date,"%M %Y") order by sale_date asc';
                        ////                                $result = mysqli_query($conn, $sql);
                        ////                                if (mysqli_num_rows($result)>0) {
                        ////                                    while($row = mysqli_fetch_assoc($result)) {
                        ////                                        $monthhead.='<th rowspan="1" colspan="3">'.$row['sale_date'].'</th>';
                        ////
                        ////                                    }
                        ////                                }
                        ////
                        ////                            }
                        ////                        }



                        $monthhead='';
                        $monthsubhead='';
                        $bobycontent='';
                        $grandtotal=0;
                        $sql='select DATE_FORMAT(sale_date,"%M %Y") sale_date from sale_details where sale_date between (select min(sale_date) from sale_details) and (select max(sale_date) from sale_details) group by DATE_FORMAT(sale_date,"%M %Y") order by date(sale_date) asc';
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result)>0)
                        {
                            while($row = mysqli_fetch_assoc($result)) {
                                $monthhead.='<th rowspan="1" colspan="3">'.$row['sale_date'].'</th>';
                                $monthsubhead.='<th rowspan="1" colspan="1">Qty</th>
			                        <th rowspan="1" colspan="1">Rate</th>
			                        <th rowspan="1" colspan="1">Amount</th>';
                            }
                        }
                        $output='<table border="2">
	<thead>
		<tr>
			<th rowspan="2">S.No.</th>
			<th rowspan="2">Category</th>
			<th rowspan="2">sub Category</th>
			<th rowspan="2">Product</th>
			<th rowspan="2">Customer</th>';
                        $output.=$monthhead;
                        $output.='<th rowspan="2">Grand Total</th>
	</tr><tr>';
                        $output.=$monthsubhead;
                        $output.='</tr></thead>
<tbody>';$totalamount=0;
                       $sql2='select qty,unit_cost,p.primary_category,ct.sub_category,p.product_name,p.product_id ,c.customer_id,c.customer_name,DATE_FORMAT(sd.sale_date,"%M %Y") sale_date,sd.qtydata from product p inner join (select sale_id,product_id,unit_cost,qty,(qty*unit_cost) qtydata,sale_date from sale_details) sd on p.product_id=sd.product_id inner join sale s on s.sale_id=sd.sale_id inner join customer c on c.customer_id=s.customer inner join category ct on ct.category_id=p.sub_category';
                        $result2 = mysqli_query($conn, $sql2);
                        if (mysqli_num_rows($result2)>0)
                        {
                            $sn=1;
                            while($row2= mysqli_fetch_assoc($result2)) {
                                $bobycontent='';
                                $totalamount=0;
                                $output.='<tr>
                                <td>'.$sn.'</td>
                                <td>'.$row2['primary_category'].'</td>
                                <td>'.$row2['sub_category'].'</td>
                                <td>'.$row2['product_name'].'</td>
                                <td>'.$row2['customer_name'].'</td>';
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result)>0)
                        {
                            while($row= mysqli_fetch_assoc($result))
                                {
                                if($row2['sale_date']==$row['sale_date']){
                                $bobycontent.='<td>'.$row2['qty'].'</td>
                                <td>'.$row2['unit_cost'].'</td>
                                <td>'.$row2['qtydata'].'</td>';
                                    $totalamount+=$row2['qtydata'];
                                }
                                else
                                {
                                    $bobycontent.='<td>0</td>
                                <td>0</td>
                                <td>0</td>';
                                    $totalamount+=0;
                                }
                            }
                        }
                                $output.=$bobycontent;
                                // $output.=\'\';
                                $output.='<td>'.$totalamount.'</td>
	</tr>';
                                $sn++;
                            }
                        }



$output.='</tbody>';


//                        for($i=1;$i<=4;$i++)
//                        {
//
//                            $bobycontent.='<td>55</td>
//<td>130</td>
//<td>7150</td>';
//                            $grandtotal+=1;
//                        }
//                        $output='<table border="2">
//	<thead>
//		<tr>
//			<th rowspan="2">S.No.</th>
//			<th rowspan="2">Category</th>
//			<th rowspan="2">sub Category</th>
//			<th rowspan="2">Product</th>
//			<th rowspan="2">Customer</th>';
//                        $output.=$monthhead;
//                        $output.='<th rowspan="2">Grandtotal</th>
//	</tr>
//		<tr>';
//                        $output.=$monthsubhead;
//                        $output.='</tr>
//	</thead>
//	<tbody>
//	<tr>
//		<td>1</td>
//		<td>distributor</td>
//		<td>distributor</td>
//		<td>whytheat-A</td>
//		<td>palani</td>';
//                        $output.=$bobycontent;
//                        // $output.='';
//                        $output.='<td>'.$grandtotal.'</td>
//	</tr>
//	</tbody>
//</table>';
                        echo $output;



                        ?>
<!--                        <h1>hi</h1>-->
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


<script>

    $( document ).ready(function() {
        $('#fdate').val('<?php echo $fdate1;?>');
        $('#ldate').val('<?php echo $ldate1;?>');

    });


    $(document).on("click", ".excel_download", function () {
        window.location.href = "excel_download.php?fdate=<?php echo $fdate1?>&ldate=<?php echo $ldate1?>";
    });


</script>


</body>
</html>
