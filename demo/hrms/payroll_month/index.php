<?php Include("../../includes/connection.php");

error_reporting(0);
$page= $_GET['page_no'];
$search= $_GET['search'];
if($page=='') {
    $page=1;
}


$pageSql= $page-1;
$start=$pageSql*10;
$end = $start;

if($pageSql == 0) {
    $end = 10;
}

$search = $_GET['search'];
$fdate= $_GET['from'];
$ldate= $_GET['to'];
if (empty($fdate)) {
//    $fdate = date('Y-m-01');
    $fdate = date('01-m-Y');
}

if (empty($ldate)) {
    $ldate = date('d-m-Y');
}

$from = date('Y-m-d', strtotime($fdate));
$to = date('Y-m-d', strtotime($ldate));
$currentDate = date('Y-m-d');
$yesterday = date('Y-m-d', strtotime('-1 day'));

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Payroll Month</title>
    <link rel="icon" type="image/png" sizes="16x16" href="https://jbcargo.in/includes/365-logo.png">
    <link href="https://jbcargo.in/vendor/jqvmap/css/jqvmap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://jbcargo.in/vendor/chartist/css/chartist.min.css">

    <link href="https://jbcargo.in/vendor/jqvmap/css/jqvmap.min.css" rel="stylesheet">
    <link href="https://jbcargo.in/vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
    <link href="https://jbcargo.in/css/style.css" rel="stylesheet">
    <link href="https://jbcargo.in/vendor/owl-carousel/owl.carousel.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"  />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://jbcargo.in/vendor/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

    <link href="https://jbcargo.in/vendor/clockpicker/css/bootstrap-clockpicker.min.css" rel="stylesheet">



    <link href="https://jbcargo.in/vendor/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet">

    <link rel="stylesheet" href="https://jbcargo.in/vendor/pickadate/themes/default.css">
    <link rel="stylesheet" href="https://jbcargo.in/vendor/pickadate/themes/default.date.css">
    <link href="https://jbcargo.in/vendor/summernote/summernote.css" rel="stylesheet">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css">

    <style>
        label{
            color: black;!important;
        }
    </style>
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

    $header_name ="Payroll Month";
    Include ('../../includes/header.php') ?>



    <div class="content-body">
        <div class="page-titles" style="margin-left: 21px;">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Table</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Payroll Month</a></li>


            </ol>

        </div>


        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Payroll Month List</h4>
                    <div style="display: flex;justify-content: flex-end;">
                        <button type="button" class="btn btn-primary mb-2"  style="margin-left: 20px;" data-bs-toggle="modal" data-bs-target="#device" onclick="adddevice()">ADD</button>

                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">


                        <table class="table table-responsive-md" style="text-align: center;">
                            <thead>
                            <tr>
                                <th class="width80"><strong>#</strong></th>
                                <th><strong>Month</strong></th>
                                <th><strong>No Of Days</strong></th>
                                <th><strong>Action</strong></th>

                                <!--                                <th><strong>Type</strong></th>-->


                            </tr>
                            </thead>
                            <?php

                                $sql = "SELECT * FROM payroll_month ORDER BY id DESC LIMIT $start, 10";

                            $result = mysqli_query($conn, $sql);
                            if (mysqli_num_rows($result)>0) {
                            $sNo = $start;
                            while($row = mysqli_fetch_assoc($result)) {
                            $pay_month = $row['payroll_month'];
                            $pay_months = '';
                            switch ($pay_month) {
                                case '01':
                                    $pay_months = 'January';
                                    break;
                                case '02':
                                    $pay_months = 'February';
                                    break;
                                case '03':
                                    $pay_months = 'March';
                                    break;
                                case '04':
                                    $pay_months = 'April';
                                    break;
                                case '05':
                                    $pay_months = 'May';
                                    break;
                                case '06':
                                    $pay_months = 'June';
                                    break;
                                case '07':
                                    $pay_months = 'July';
                                    break;
                                case '08':
                                    $pay_months = 'August';
                                    break;
                                case '09':
                                    $pay_months = 'September';
                                    break;
                                case '10':
                                    $pay_months = 'October';
                                    break;
                                case '11':
                                    $pay_months = 'November';
                                    break;
                                case '12':
                                    $pay_months = 'December';
                                    break;
                                default:
                                    $pay_months = ''; // Handle other cases as needed
                            }

                            $sNo++;



                            ?>
                            <tbody>
                            <!-- <tr>
                                <td><strong><?php //echo $sNo;?></strong></td>
                                <td><?php //echo $row['staff_id']?></td>

                                   <td> <?php //echo $row['staff_name']?> </td>
                                   <td> <?php //echo $row['branch_id']?> </td>
                                   <td> <?php //echo $row['role']?> </td>
                                   <td> <?php //echo $row['mobile']?> </td>
                                   <td> <?php //echo $row['email']?> </td>
                                   <td><?php //echo $row['password']?></td>
                                <td> <span class="badge badge-pill badge-<?php //echo $statColor?>"><?php //echo $statCont?></span><td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn btn-success light sharp" data-toggle="dropdown">
                                            <svg width="20px" height="20px" viewbox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><circle fill="#000000" cx="5" cy="12" r="2"></circle><circle fill="#000000" cx="12" cy="12" r="2"></circle><circle fill="#000000" cx="19" cy="12" r="2"></circle></g></svg>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" data-toggle="modal" data-target="#career_list" style="cursor: pointer" onclick="editTitle('<?php echo $row['staff_id'];?>')">Edit</a>
                                            <a class="dropdown-item" style="cursor: pointer" onclick="delete_model('<?php //echo $row['staff_id'];?>')">Delete</a>
                                        </div>
                                    </div>
                                </td>

                            </tr> -->
                            <tr>
                                <td><strong><?php echo $sNo;?></strong></td>
                                <td> <?php echo $pay_months?> </td>
                                <td> <?php echo $row['payroll_days']?> </td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn btn-success light sharp" data-toggle="dropdown">
                                            <svg width="20px" height="20px" viewbox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><circle fill="#000000" cx="5" cy="12" r="2"></circle><circle fill="#000000" cx="12" cy="12" r="2"></circle><circle fill="#000000" cx="19" cy="12" r="2"></circle></g></svg>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item"  onclick="viewDevice('<?php echo $row['payroll_id']; ?>')">Edit</a>
                                            <a class="dropdown-item"  onclick="deleteDevice('<?php echo $row['payroll_id']; ?>')">Delete</a>
                                            <!-- <a class="dropdown-item" style="cursor: pointer" onclick="delete_model('<?php //echo $row['staff_id'];?>')">Delete</a> -->
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
                                        <li class="page-item page-indicator"><a class="page-link" href="?page_no=<?php echo $prevPage?>"><i class="fa-solid fa-less-than"></i></a></li>
                                        <?php
                                    }



                                        $sql = "SELECT COUNT(id) as count FROM payroll_month";


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
                                                                                               href="?page_no=<?php echo $i ?>"><?php echo $i ?></a>
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
                                            <li class="page-item page-indicator"><a class="page-link" href="?page_no=<?php echo $nextPage ?>"><i class="fa-solid fa-greater-than"></i></a></li>
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


        <div class="modal custom-modal fade" data-backdrop="static" data-keyboard="false" id="device" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="header">Device</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="deviceForm">
<!--                            <div class="input-block mb-3">-->
<!--                                <label class="col-form-label">Month <span class="text-danger">*</span></label>-->
<!--                                <input class="form-control" type="text" name="payroll_month" id="payroll_month" style="color: black">-->
<!--                                <input class="form-control" type="hidden" name="id" id="id">-->
<!--                                <input class="form-control" type="hidden" name="url" id="url">-->
<!--                            </div>-->
                            <div class="input-block mb-3">
                                <label class="col-form-label">Month <span class="text-danger">*</span></label>
                                <input class="form-control" type="hidden" name="payroll_id" id="payroll_id">
                                <input class="form-control" type="hidden" name="url" id="url">
                                <select class="form-control" name="payroll_month" id="payroll_month" style="border-color: #181f5a;color: black">
                                    <option value="">Select Month</option>
                                    <option value="01">January</option>
                                    <option value="02">February</option>
                                    <option value="03">March</option>
                                    <option value="04">April</option>
                                    <option value="05">May</option>
                                    <option value="06">June</option>
                                    <option value="07">July</option>
                                    <option value="08">August</option>
                                    <option value="09">September</option>
                                    <option value="10">October</option>
                                    <option value="11">November</option>
                                    <option value="12">December</option>
                                </select>
                            </div>

                            <div class="input-block mb-3">
                                <label class="col-form-label">No of Days <span class="text-danger">*</span></label>
                                <input class="form-control" type="number" name="no_days" id="no_days" style="border-color: #181f5a;color: black">
                            </div>


                            <div class="submit-section">
                                <button class="btn btn-primary" type="button" id="add">Add Month</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>




    </div>

    <?php Include ('../../includes/footer.php') ?>

</div>


<script src="https://jbcargo.in/vendor/global/global.min.js"></script>
<script src="https://jbcargo.in/vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
<script src="https://jbcargo.in/vendor/chart.js/Chart.bundle.min.js"></script>
<script src="../../js/custom.min.js"></script>
<script src="../../js/dlabnav-init.js"></script>
<script src="https://jbcargo.in/vendor/owl-carousel/owl.carousel.js"></script>
<script src="https://jbcargo.in/vendor/peity/jquery.peity.min.js"></script>
<!--<script src="../vendor/apexchart/apexchart.js"></script>-->
<script src="../../js/dashboard/dashboard-1.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://jbcargo.in/vendor/jquery-validation/jquery.validate.min.js"></script>
<script src="../../js/plugins-init/jquery.validate-init.js"></script>
<script src="https://jbcargo.in/vendor/moment/moment.min.js"></script>
<script src="https://jbcargo.in/vendor/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="https://jbcargo.in/vendor/summernote/js/summernote.min.js"></script>
<script src="../../js/plugins-init/summernote-init.js"></script>


<script>






    $(document).ready(function() {
        $("#deviceForm").validate({
            ignore: '.ignore',
            rules: {
                no_days: {
                    required: true,
                },
                payroll_month: {
                    required: true
                },
            },
            messages: {
                no_days: "Please select Month.",
                payroll_month: "Please enter Days.",
            }
        });
    });










    $(document).ready(function() {
        $("#add").click(function() {
            $("#deviceForm").valid();

            if ($("#deviceForm").valid() == true) {

                document.getElementById('add').disabled = true;
                $("#add").html('<i class="fa-solid fa-spinner fa-spin"></i>'); // Make sure the spinner HTML is correct.

                var formElem = $("#deviceForm");
                var formdata = new FormData(formElem[0]);

                var link=document.getElementById('url').value;

                $.ajax({
                    type: "POST",
                    url: link,
                    data: formdata,
                    processData: false,
                    contentType: false,
                    dataType:"json",

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

                        }

                        else if(res.status=="failure"){
                            Swal.fire(
                                {
                                    title: "failure",
                                    text: res.msg,
                                    icon: "failure",
                                    button: "OK",
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    closeOnClickOutside: false,
                                }
                            )
                                .then((value) => {
                                    document.getElementById('add').disabled = false;
                                });
                        }

                    },
                });
            }
        });
    });





    function deleteDevice(id) {


        Swal.fire({
            title: "Delete",
            text: "Are you sure you want to delete the Device?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            allowOutsideClick: false,
            allowEscapeKey: false,
            closeOnClickOutside: false,
            showCancelButton: true,
        })
            .then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "delete.php",
                        data: 'payroll_id=' + id,
                        dataType: "json",
                        success: function(res) {
                            if (res.status == 'success') {
                                Swal.fire({
                                    title: "Success",
                                    text: res.msg,
                                    icon: "success",
                                    button: "OK",
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    closeOnClickOutside: false,
                                })
                                    .then(() => {
                                        window.location.reload();
                                    });
                            }
                        },
                    });
                }
            });
    }




    function viewDevice(id) {
        $('#deviceForm')[0].reset();
        document.getElementById('url').value = 'edit.php';
        document.getElementById('add').innerText = 'Update';
        $.ajax({

            type: "POST",
            url: "view.php",
            data: 'payroll_id=' + id,
            dataType: "json",
            success: function (res) {
                if (res.status == 'success') {

                    $("#payroll_id").val(res.payroll_id);
                    $("#no_days").val(res.payroll_days);
                    $("#payroll_month").val(res.payroll_month);


                }
            }
        });

        $('#device').modal('show');
    }


    function adddevice() {
        $('#deviceForm')[0].reset();
        document.getElementById('url').value = 'add.php';
        document.getElementById('add').innerText = 'Add';
        $('#device').modal('show');
    }
</script>







</body>
</html>
