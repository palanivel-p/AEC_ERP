<?php Include("../includes/connection.php");

error_reporting(0);
$page= $_GET['page_no'];
//$service_id= $_GET['service_id'];
//$e_category= $_GET['e_category'];
//$s_name= $_GET['s_name'];

$product_id= $_GET['cus_id'];
$f_date = $_GET['f_date'];
$t_date = $_GET['t_date'];
$user_doc = $_GET['userid'];
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


if($product_id != ""){
//    $product_idSql= " AND customer_name LIKE '%".$product_id."%'";
    $product_idSql= " AND customer_name = '".$product_id."'";
}
else{
    $product_idSql ="";
}

if($e_category != ""){
    $e_categorySql= " AND expense_type = '".$e_category."'";

}
else{
    $e_categorySql ="";
}

if($s_name != ""){
    $s_nameSql= " AND supplier = '".$s_name."'";

}
else{
    $s_nameSql ="";
}

if($pay_mode != ""){
    $pay_modeSql= "AND payment_mode	 = '".$pay_mode."'";

}
else {
    $pay_modeSql = "";
}
if($ref_no != ""){
    $ref_noSql= "AND reference_no = '".$ref_no."'";

}
else {
    $ref_noSql = "";
}
$added_by = $_COOKIE['user_id'];
if($_COOKIE['role'] == 'Super Admin' || $_COOKIE['role'] == 'Admin'){
    $addedBy = "";
}
else{
    $addedBy = " AND added_by='$added_by'";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Service Report</title>
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo $website; ?>/includes/AEC.png">
    <link href="../vendor/jqvmap/css/jqvmap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../vendor/chartist/css/chartist.min.css">
    <link href="../vendor/jqvmap/css/jqvmap.min.css" rel="stylesheet">
    <link href="../vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <link href="../vendor/owl-carousel/owl.carousel.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="../vendor/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <link href="../vendor/clockpicker/css/bootstrap-clockpicker.min.css" rel="stylesheet">
    <link href="../vendor/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet">
    <link rel="stylesheet" href="../vendor/pickadate/themes/default.css">
    <link rel="stylesheet" href="../vendor/pickadate/themes/default.date.css">
    <link href="../vendor/summernote/summernote.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" href="../vendor/select2/css/select2.min.css">
</head>
<style>
    .error {
        color:red;
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
    $header_name ="Service Report";
    Include ('../includes/header.php') ?>

    <div class="content-body">
        <div class="page-titles" style="margin-left: 21px;">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Table</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Service Report</a></li>
            </ol>
        </div>

        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Services Report</h4>
                    <div style="display: flex;justify-content: flex-end;">
                        <form class="form-inline">
                            <!--                        <div class="form-group mx-sm-3 mb-2">-->
                            <!--                                <label>Children Type</label>-->
                            <!--                                <select data-search="true" class="form-control tail-select w-full" id="child_type" name="child_type" style="border-radius:20px;color:black;border:1px solid black;">-->
                            <!--                                    <option value='all'>All</option>-->
                            <!--                                    <option value='current project'>current project</option>-->
                            <!--                                    <option value='completed project'>completed project</option>-->
                            <!--                                </select>-->
                            <!--                            </div>-->
                            <!--                            <div class="form-group mx-sm-3 mb-2">-->
                            <!--                                <input type="text" class="form-control" placeholder="Search By Name" name="search" id="search" style="border-radius:20px;color:black;" >-->
                            <!--                            </div>-->
                            <!--                            <button type="submit" class="btn btn-primary mb-2">Search</button>-->
                        </form>
                        <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#career_list" onclick="addTitle()">ADD</button>
                        <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#invoice_filter" style="margin-left: 20px;">FILTER</button>
                        <button type="button" class="pdf_download btn btn-primary mb-2" id="pdf" style="margin-left: 20px;">PDF</button>
                        <!-- <button class="pdf_download btn btn-success" type="button" id="pdf">PDF</button>-->
                        <button type="button" class="excel_download btn btn-rounded btn-success" style="margin-left: 20px;"><span class="btn-icon-left text-success"><i class="fa fa-download color-success"></i>
                           </span>Excel</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-responsive-md" style="text-align: center;">
                            <thead>
                            <tr>
                                <th class="width80"><strong>#</strong></th>
                                <th><strong>Visit Date</strong></th>
                                <th><strong>Customer Name</strong></th>
                                <th><strong>Meet whom</strong></th>
                                <th><strong>Image</strong></th>
                                <th><strong>Service Type</strong></th>
                                <th><strong>View</strong></th>
                                <th><strong>Edit</strong></th>
                                <th><strong>Service View</strong></th>
                                <th><strong>Action</strong></th>

                            </tr>
                            </thead>
                            <?php
                            //                             $sql = "SELECT * FROM service ORDER BY id  LIMIT $start,10";

                            if($product_id == "") {
                                $sql = "SELECT * FROM service WHERE visit_date  BETWEEN '$from_date' AND '$to_date' $addedBy ORDER BY id  LIMIT $start,10";
                            }
                            {
                                $sql = "SELECT * FROM service WHERE visit_date  BETWEEN '$from_date' AND '$to_date' $product_idSql $addedBy ORDER BY id  LIMIT $start,10";
                            }
                            $result = mysqli_query($conn, $sql);
                            if (mysqli_num_rows($result)>0) {
                            $sNo = $start;
                            while($row = mysqli_fetch_assoc($result)) {

                            $sNo++;
                            $v_date = $row['visit_date'];
                            $visite_date = date('d-m-Y', strtotime($v_date));

                            $customer_id=$row['customer_name'];

                            //                               $sqlExpenseType = "SELECT * FROM `expense_category` WHERE `category_id`='$service_id'";
                            //                            $resExpenseType = mysqli_query($conn, $sqlExpenseType);
                            //                            $rowExpenseType = mysqli_fetch_assoc($resExpenseType);
                            //                            $ExpenseType =  $rowExpenseType['category_type'];
                            //
                            $sqlCustomer = "SELECT * FROM `customer` WHERE `customer_id`='$customer_id'";
                            $resCustomer = mysqli_query($conn, $sqlCustomer);
                            $rowCustomer = mysqli_fetch_assoc($resCustomer);
                            $customer_name =  $rowCustomer['customer_name'];

                            if($row['payment_status'] == 'paid'){
                                $statColor = 'success';
                                $statCont = 'Paid';
                            }
                            else {
                                $statColor = 'danger';
                                $statCont = 'UnPaid';
                            }
                            ?>
                            <tbody>
                            <tr>
                                <td><strong><?php echo $sNo;?></strong></td>
                                <td><?php echo $visite_date?></td>
                                <td> <?php echo $customer_id?> </td>
                                <td> <?php echo $row['meet_whom']?> </td>
                                <td>  <a href="<?php echo $website ?>/service/?userid=<?php echo $row['service_id']; ?>" class="btn btn-success" style="padding: 6px">Image</a></td>
                                    <!--                                <td> --><?php //echo $row['service_type']?><!-- </td>-->
                                <td> <a href="service.php?service_id=<?php echo $row['service_id'] ?>&service_type=<?php echo $row['service_type'] ?>"><span class="badge badge-pill badge-primary"><?php echo $row['service_type']?></span></a></td>
                                <td> <a href="service_view.php?service_id=<?php echo $row['service_id'] ?>&service_type=<?php echo $row['service_type'] ?>"><span class="badge badge-pill badge-success">View</span></a></td>
                                <td> <a href="service.php?service_id=<?php echo $row['service_id'] ?>&service_type=<?php echo $row['service_type'] ?>"><span class="badge badge-pill badge-success">Edit</span></a></td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <a href="<?php echo $website?>/service/show_file.php?service_id=<?php echo $row['service_id']?>"
                                           class="btn btn-primary shadow btn-xs sharp me-1"><i class="fa fa-eye"></i></a>
                                    </div>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn btn-success light sharp" data-toggle="dropdown">
                                            <svg width="20px" height="20px" viewbox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><circle fill="#000000" cx="5" cy="12" r="2"></circle><circle fill="#000000" cx="12" cy="12" r="2"></circle><circle fill="#000000" cx="19" cy="12" r="2"></circle></g></svg>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" data-toggle="modal" data-target="#career_list" style="cursor: pointer" onclick="editTitle('<?php echo $row['service_id'];?>')">Edit</a>
                                            <?php
                                            if($_COOKIE['role'] == 'Super Admin' || $_COOKIE['role'] == 'Service') {
                                            ?>
                                            <a class="dropdown-item" style="cursor: pointer" onclick="delete_model('<?php echo $row['service_id'];?>')">Delete</a>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </td>
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
                                        <li class="page-item page-indicator"><a class="page-link" href="?page_no=<?php echo $prevPage?>&product_id=<?php echo $product_id ?>&f_date=<?php echo $from_date?>&t_date=<?php echo $to_date?>"><i class="fa-solid fa-less-than"></i></a></li>
                                        <?php
                                    }

                                    //                                    $sql = 'SELECT COUNT(id) as count FROM service';
                                    if($product_id == "") {
                                        $sql = "SELECT COUNT(id) as count FROM service WHERE visit_date  BETWEEN '$from_date' AND '$to_date'$addedBy";
                                    }
                                    {
                                        $sql = "SELECT COUNT(id) as count FROM service WHERE visit_date  BETWEEN '$from_date' AND '$to_date' $product_idSql $addedBy";
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
                                                                                               href="?page_no=<?php echo $i ?>&product_id=<?php echo $product_id ?>&f_date=<?php echo $from_date?>&t_date=<?php echo $to_date?>"><?php echo $i ?></a>
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
                                            <li class="page-item page-indicator"><a class="page-link" href="?page_no=<?php echo $nextPage ?>&product_id=<?php echo $product_id ?>&f_date=<?php echo $from_date?>&t_date=<?php echo $to_date?>"><i class="fa-solid fa-greater-than"></i></a></li>
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

        <div class="modal fade" id="document_list" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="window.location.href='<?php echo $website ?>/People/Users'">
                            <span aria-hidden="true" >&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <?php
                            $sqlValidateCookie = "SELECT * FROM `service` WHERE service_id='$user_doc'";
                            $resValidateCookie = mysqli_query($conn, $sqlValidateCookie);
                            if (mysqli_num_rows($resValidateCookie) > 0) {
                                $row = mysqli_fetch_assoc($resValidateCookie);
                                if ($row['img1'] == 1) {
                                    ?>
                                    <div class="form-group col-md-6">
                                        <label>Image 1</label>
                                        <button class="btn btn-primary btn-block"
                                                onclick="window.open('<?php echo $website ?>/service/service_img/<?php echo $user_doc ?>_1.jpg', '_blank')">
                                            Image
                                        </button>
                                    </div>
                                    <?php
                                }
                                if ($row['img2'] == 1) {
                                    ?>
                                    <div class="form-group col-md-6">
                                        <label>Image 2</label>
                                        <button class="btn btn-primary btn-block"
                                                onclick="window.open('<?php echo $website ?>/service/service_img/<?php echo $user_doc ?>_2.jpg', '_blank')">
                                            Image
                                        </button>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                        <div class="row">
                            <?php
                            if ($row['img3'] == 1) {
                                ?>
                                <div class="form-group col-md-6">
                                    <label>Image 3</label>
                                    <button class="btn btn-primary btn-block"
                                            onclick="window.open('<?php echo $website ?>/service/service_img/<?php echo $user_doc ?>_3.jpg', '_blank')">
                                        Image
                                    </button>
                                </div>
                                <?php
                            }
                            if ($row['img4'] == 1) {
                                ?>
                                <div class="form-group col-md-6">
                                    <label>Image 4</label>
                                    <button class="btn btn-primary btn-block"
                                            onclick="window.open('<?php echo $website ?>/service/service_img/<?php echo $user_doc ?>_4.jpg', '_blank')">
                                        Image
                                    </button>
                                </div>
                                <?php
                            }
                            if ($row['img5'] == 1) {
                                ?>
                                <div class="form-group col-md-6">
                                    <label>Image 5</label>
                                    <button class="btn btn-primary btn-block"
                                            onclick="window.open('<?php echo $website ?>/service/service_img/<?php echo $user_doc ?>_5.jpg', '_blank')">
                                        Image
                                    </button>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" onclick="window.location.href='<?php echo $website ?>/service/'">Close</button>
                        <!--                        <button type="button" class="btn btn-primary">Save changes</button>-->
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="career_list"  data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="title">Expense</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="basic-form" style="color: black;">
                            <form id="expense_form" autocomplete="off">
                                <div class="form-row">

                                    <div class="form-group col-md-6" id="ex_date">
                                        <label>Visit Date *</label>
                                        <input type="date" class="form-control" id="visit_date" name="visit_date" style="border-color: #181f5a;color: black">
                                        <input type="hidden" class="form-control"  id="api" name="api">
                                        <input type="hidden" class="form-control"  id="old_pa_id" name="old_pa_id">
                                        <input type="hidden" class="form-control"  id="service_id" name="service_id">
                                    </div>
                                    <div class="form-group col-md-6" id="c_type">
                                        <label>Customer Name *</label>
                                        <input type="text" class="form-control" id="customer_name" name="customer_name" placeholder="Customer Name" style="border-color: #181f5a;color: black">
                                    </div>
<!--                                    <div class="form-group col-md-6" id="c_type">-->
<!--                                        <label>Customer Name *</label>-->
<!--                                        <select  class="form-control js-example-disabled-results tail-select w-full" id="customer_name" name="customer_name" style="border-color: #181f5a;color: black">-->
<!--                                            <option value="">Select Customer</option>-->
<!--                                            --><?php
//                                            $sqlDevice = "SELECT * FROM `customer`";
//                                            $resultDevice = mysqli_query($conn, $sqlDevice);
//                                            if (mysqli_num_rows($resultDevice) > 0) {
//                                                while ($rowDevice = mysqli_fetch_array($resultDevice)) {
//                                                    ?>
<!--                                                    <option-->
<!--                                                            value='--><?php //echo $rowDevice['customer_id']; ?><!--'>--><?php //echo strtoupper($rowDevice['customer_name']); ?><!--</option>-->
<!--                                                    --><?php
//                                                }
//                                            }
//                                            ?>
<!--                                        </select>-->
<!--                                    </div>-->
                                    <div class="form-group col-md-6" id="s_name">
                                        <label>Meet whom *</label>
                                        <input type="text" class="form-control" id="meet" name="meet"  placeholder="Meet whom" style="border-color: #181f5a;color: black">
                                    </div>
                                    <div class="form-group col-md-6" id="s_name">
                                        <label>Mobile *</label>
                                        <input type="number" class="form-control" id="mobile" name="mobile"  placeholder="Mobile" style="border-color: #181f5a;color: black">
                                    </div>
                                    <div class="form-group col-md-6" id="d_date">
                                        <label>Next Follow date *</label>
                                        <input type="date" class="form-control" id="next_follow" name="next_follow" style="border-color: #181f5a;color: black">
                                    </div>
                                    <div class="form-group col-md-6" id="repayment_modes">
                                        <label>Service Type *</label>
                                        <select  class="form-control" id="service_type" name="service_type" style="border-color: #181f5a;color: black;text-transform: uppercase;">
                                            <option value=''>Select Service</option>
                                            <option value='Furnace Lining'>Furnace Lining</option>
                                            <option value='Laddle Wet Lining'>Laddle Wet Lining</option>
                                            <option value='Laddle Dry Lining'>Laddle Dry Lining</option>
                                            <option value='Erosion Analysis'>Erosion Analysis</option>
                                            <option value='Furnace Patch'>Furnace Patch</option>
                                            <option value='Laddle Chipping'>Laddle Chipping</option>
                                            <option value='Laddle Patch'>Laddle Patch</option>
                                            <option value='Steel Shots Analysis'>Steel Shots Analysis</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="upload_image">Image(1)</label>
                                        <input type="file" class="form-control" placeholder="Upload Image" id="upload_img1" name="upload_img1" style="border-color: #181f5a;color: black" accept=".jpg,.jpeg,.png">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="upload_image">Image(2)</label>
                                        <input type="file" class="form-control" placeholder="Upload Image" id="upload_img2" name="upload_img2" style="border-color: #181f5a;color: black" accept=".jpg,.jpeg,.png">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="upload_image">Image(3)</label>
                                        <input type="file" class="form-control" placeholder="Upload Image" id="upload_img3" name="upload_img3" style="border-color: #181f5a;color: black" accept=".jpg,.jpeg,.png">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="upload_image">Image(4)</label>
                                        <input type="file" class="form-control" placeholder="Upload Image" id="upload_img4" name="upload_img4" style="border-color: #181f5a;color: black" accept=".jpg,.jpeg,.png">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="upload_image">Image(5)</label>
                                        <input type="file" class="form-control" placeholder="Upload Image" id="upload_img5" name="upload_img5" style="border-color: #181f5a;color: black" accept=".jpg,.jpeg,.png">
                                    </div>
                                    <div class="form-group col-md-12" id="ref_nos">
                                        <label>Discussed About </label>
                                        <textarea class="form-control" placeholder="Discussed About" id="discuss_about" name="discuss_about" style="border-color: #181f5a;color: black"></textarea>
                                    </div>
                                </div>
                            </form>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger light" data-dismiss="modal" style="background-color: red; color: white;">Close</button>
                        <button type="button" class="btn btn-primary" id="add_btn">ADD</button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <?php Include ('../includes/footer.php') ?>
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
                                    <label> Visit From Date </label>
                                    <input type="date"  class="form-control" id="f_date" name="f_date" style="border-color: #181f5a;color: black">
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Visit To Date </label>
                                    <input type="date"  class="form-control" id="t_date" name="t_date" style="border-color: #181f5a;color: black">
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Customer Name </label>
                                    <select  class="form-control js-example-disabled-results tail-select w-full" id="cus_id" name="cus_id" style="border-color: #181f5a;color: black">
                                        <?php
                                        $sqlDevice = "SELECT * FROM `customer`";
                                        $resultDevice = mysqli_query($conn, $sqlDevice);
                                        if (mysqli_num_rows($resultDevice) > 0) {
                                            while ($rowDevice = mysqli_fetch_array($resultDevice)) {
                                                ?>
                                                <option
                                                        value='<?php echo $rowDevice['customer_id']; ?>'><?php echo strtoupper($rowDevice['customer_name']); ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                    <!--                                    <input type="text"  class="form-control" placeholder="Customer Name" id="cus_id" name="cus_id" style="border-color: #181f5a;color: black">-->
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


<script src="../vendor/global/global.min.js"></script>
<script src="../vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
<script src="../vendor/chart.js/Chart.bundle.min.js"></script>
<script src="../js/custom.min.js"></script>
<script src="../js/dlabnav-init.js"></script>
<script src="../vendor/owl-carousel/owl.carousel.js"></script>
<script src="../vendor/peity/jquery.peity.min.js"></script>
<!--<script src="../vendor/apexchart/apexchart.js"></script>-->
<script src="../js/dashboard/dashboard-1.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../vendor/jquery-validation/jquery.validate.min.js"></script>
<script src="../js/plugins-init/jquery.validate-init.js"></script>
<script src="../vendor/moment/moment.min.js"></script>
<script src="../vendor/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="../vendor/summernote/js/summernote.min.js"></script>
<script src="../js/plugins-init/summernote-init.js"></script>
<script src="../vendor/select2/js/select2.full.min.js"></script>
<script src="../js/plugins-init/select2-init.js"></script>

<script>

    function addTitle() {
        $("#title").html("Add service");
        $('#expense_form')[0].reset();
        $('#api').val("add_api.php")
        // $('#game_id').prop('readonly', false);
    }

    function editTitle(data) {

        $("#title").html("Edit service- "+data);
        $('#expense_form')[0].reset();
        $('#api').val("edit_api.php");

        $.ajax({
            type: "POST",
            url: "view_api.php",
            data: 'service_id='+data,
            dataType: "json",
            success: function(res){
                if(res.status=='success')
                {
                    $("#visit_date").val(res.visit_date);
                    $("#customer_name").val(res.customer_name);
                    $("#meet").val(res.meet);
                    $("#mobile").val(res.mobile);
                    $("#discuss_about").val(res.discuss_about);
                    $("#service_type").val(res.service_type);
                    $('#qty').val(res.qty);
                    $('#progress').val(res.progress);
                    $('#last_follow').val(res.last_follow);
                    $('#next_follow').val(res.next_follow);
                    $("#old_pa_id").val(res.service_id);
                    $("#service_id").val(res.service_id);

                    $("#upload_image").rules( 'remove' );
                    var edit_model_title = "Edit service - "+data;
                    $('#title').html(edit_model_title);
                    $('#add_btn').html("Save");
                    $('#career_list').modal('show');
                }
                else if(res.status=='wrong')
                {
                    swal("Invalid",  res.msg, "warning")
                        .then((value) => {
                            window.window.location.reload();
                        });
                }
                else if(res.status=='failure')
                {
                    swal("Failure",  res.msg, "error")
                        .then((value) => {
                            window.window.location.reload();

                        });
                }
            },
            error: function(){
                swal("Check your network connection");

                window.window.location.reload();
            }
        });

    }


    //to validate form
    $("#expense_form").validate(
        {
            ignore: '.ignore',
            // Specify validation rules
            rules: {
                visit_date: {
                    required: true
                },
                customer_name: {
                    required: true
                },
                meet: {
                    required: true
                },
                service_type: {
                    required: true
                },
                // discuss_about: {
                //     required: true
                // },
                mobile: {
                    required: true
                },
                next_follow: {
                    required: true
                },

            },
            // Specify validation error messages
            messages: {
                visit_date: "*This field is required",
                customer_name: "*This field is required",
                meet: "*This field is required",
                service_type: "*This field is required",
                discuss_about: "*This field is required",
                mobile: "*This field is required",
                qty: "*This field is required",
                progress: "*This field is required",
                last_follow: "*This field is required",
                next_follow: "*This field is required",
            }
            // Make sure the form is submitted to the destination defined
        });

    //add data

    $('#add_btn').click(function () {

        $("#expense_form").valid();

        if($("#expense_form").valid()==true) {

            var api = $('#api').val();
            var form = $("#expense_form");
            var formData = new FormData(form[0]);
            this.disabled = true;
            this.innerHTML = '<i class="fa fa-spinner fa-spin"></i>';
            $.ajax({

                type: "POST",
                url: api,
                data: formData,
                dataType: "json",
                contentType: false,
                cache: false,
                processData: false,
                success: function (res) {
                    if (res.status == 'success') {
                        Swal.fire(
                            {
                                title: "Success",
                                text: res.msg,
                                icon: "success",
                                button: "OK",
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                closeOnClickOutside: false,
                            }
                        )
                            .then((value) => {
                                window.window.location.reload();
                            });
                    } else if (res.status == 'failure') {

                        Swal.fire(
                            {
                                title: "Failure",
                                text: res.msg,
                                icon: "warning",
                                button: "OK",
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                closeOnClickOutside: false,
                            }
                        )
                            .then((value) => {

                                document.getElementById("add_btn").disabled = false;
                                document.getElementById("add_btn").innerHTML = 'Add';
                            });

                    }
                },
                error: function () {

                    Swal.fire('Check Your Network!');
                    document.getElementById("add_btn").disabled = false;
                    document.getElementById("add_btn").innerHTML = 'Add';
                }

            });



        } else {
            document.getElementById("add_btn").disabled = false;
            document.getElementById("add_btn").innerHTML = 'Add';

        }


    });

    //
    //delete model

    function delete_model(data) {

        Swal.fire({
            title: "Delete",
            text: "Are you sure want to delete the record?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            allowOutsideClick: false,
            allowEscapeKey: false,
            closeOnClickOutside: false,
            showCancelButton: true,
            cancelButtonText: 'Cancel'
        })
            .then((value) => {
                if(value.isConfirmed) {

                    $.ajax({

                        type: "POST",
                        url: "delete_api.php",
                        data: 'service_id='+data,
                        dataType: "json",
                        success: function(res){
                            if(res.status=='success')
                            {
                                Swal.fire(
                                    {
                                        title: "Success",
                                        text: res.msg,
                                        icon: "success",
                                        button: "OK",
                                        allowOutsideClick: false,
                                        allowEscapeKey: false,
                                        closeOnClickOutside: false,
                                    }
                                )
                                    .then((value) => {
                                        window.window.location.reload();

                                    });
                            }
                            else if(res.status=='failure')
                            {
                                swal(
                                    {
                                        title: "Failure",
                                        text: res.msg,
                                        icon: "warning",
                                        button: "OK",
                                        allowOutsideClick: false,
                                        allowEscapeKey: false,
                                        closeOnClickOutside: false,
                                    }
                                )
                                    .then((value) => {
                                        window.window.location.reload();                             });

                            }
                        },
                        error: function(){
                            swal("Check your network connection");

                        }

                    });

                }

            });

    }

    $( document ).ready(function() {
        $('#product_id').val('<?php echo $product_id;?>');
        $('#t_date').val('<?php echo $t_date;?>');
        $('#f_date').val('<?php echo $f_date;?>');

    });
    $( document ).ready(function() {
        $('#search').val('<?php echo $search;?>');


        var user = '<?php echo $user_doc; ?>'; // Assuming $user_doc contains the user document information

        if (user !== '') {
            $('#document_list').modal('show');
        }

    });
    $(document).on("click", ".excel_download", function () {
        window.location.href = "excel_download.php?&service_id=<?php echo $service_id?>";
    });
    $(document).on("click", ".pdf_download", function () {
        window.location.href = "pdf_download.php?&service_id=<?php echo $service_id?>";
    });
    //select search
    var $disabledResults = $(".js-example-disabled-results");
    $disabledResults.select2();
</script>


</body>
</html>
