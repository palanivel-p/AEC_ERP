<?php Include("../../includes/connection.php");

error_reporting(0);
$page= $_GET['page_no'];
$search= $_GET['search'];

if($page=='') {
    $page=1;
}

$currentYear = date('Y');
$currentmonth = date('m');
$lastYear = date('Y', strtotime('-1 year'));
$pageSql= $page-1;
$start=$pageSql*10;
$end = $start;

if($pageSql == 0) {
    $end = 10;
}

$month = $_GET['month'];
$year = $_GET['year'];

if (empty($month)) {
    $month=$currentmonth;
}
if (empty($year)) {
    $year=$currentYear;
}
$daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

$fdate = '01-' . $month . '-' . $year;
$ldate = '31-' . $month . '-' . $year;



//$fdate= $_GET['from'];
//$ldate= $_GET['to'];
if (empty($fdate)) {
//    $fdate = date('Y-m-01');
    $fdate = date('01-m-Y');
}

if (empty($ldate)) {
    $ldate = date('d-m-Y');
}

$from = date('Y-m-d', strtotime($fdate));
$to = date('Y-m-d', strtotime($ldate));



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Staff Payroll</title>

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

    $header_name ="Payroll";
    Include ('../../includes/header.php') ?>



    <div class="content-body">
        <div class="page-titles" style="margin-left: 21px;">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Table</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Payroll</a></li>


            </ol>

        </div>


        <div class="col-lg-12">
            <div class="card">
                <div class="card-header" style="zoom: 90%">
                    <h4 class="card-title">Payroll List</h4>
                    <div style="display: flex;justify-content: flex-end;">
                        <form class="form-inline">

                            <div class="form-group mx-sm-3 mb-2">
                                <select data-search="true" class="form-control tail-select w-full" id="year" name="year" style="border-radius:20px;color:black;">
                                    <option value="">Select Year</option>
                                    <option value="<?php echo $currentYear?>"><?php echo $currentYear?></option>
                                    <option value="<?php echo $lastYear?>"><?php echo $lastYear?></option>

                                </select>
                            </div>
                            <div class="form-group mx-sm-3 mb-2">
                                <select data-search="true" class="form-control tail-select w-full" id="month" name="month" style="border-radius:20px;color:black;">
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
                            <div class="form-group mx-sm-3 mb-2">

                                <input type="text" class="form-control" placeholder="Search By Name" name="search" id="search" style="border-radius:20px;color:black;" >
                            </div>
                            <div class="form-group mx-sm-3 mb-2">
                                <button type="button" class="excel_download btn btn-success" >
            <span class="text-white">
                <i class="fa fa-download"></i>
            </span>
                                    Payroll
                                </button>
                            </div>
                            <button type="submit" class="btn btn-primary mb-2">Search</button>
                        </form>
<!--                        <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#career_list" style="margin-left: 20px;" onclick="addTitle()">ADD</button>-->
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">


                        <table class="table table-responsive-md" style="text-align: center;">
                            <thead>
                            <tr>
                                <th class="width80"><strong>#</strong></th>
                                <th><strong>Staff</strong></th>
<!--                                <th><strong>Staff Name</strong></th>-->
<!--                                <th><strong>Branch Name</strong></th>-->
                                <th><strong>Gross Salary</strong></th>
                                <th><strong>Net Salary</strong></th>
                                <th><strong>Total Days</strong></th>
                                <th><strong>Present Days</strong></th>
                                <th><strong>Absent Days</strong></th>
                                <th><strong>Holidays</strong></th>
                                <th><strong>Eligible Leave</strong></th>
                                <th><strong>LOP Days</strong></th>
                                <th><strong>NET Pay</strong></th>

                            </tr>
                            </thead>
                            <?php
                            if($search == "") {
                                    $sql = "SELECT * FROM `user` ORDER BY user_id ASC LIMIT $start,10";
                            }
                            else {
                                $sql = "SELECT * FROM `user` WHERE f_name LIKE '%$search%' ORDER BY id DESC LIMIT $start,10";
                            }

                            $result = mysqli_query($conn, $sql);
                            if (mysqli_num_rows($result)>0) {
                            $sNo = $start;
                            while($row = mysqli_fetch_assoc($result)) {

                            $sNo++;

                            $branch_id = $row['branch_id'];
                            $staff_id = $row['staff_id'];
                            $eligible_leave = $row['eligible_leave'];
                            $net_salary = $row['net_salary'];
//                            $sqlBranch = "SELECT * FROM `branch` WHERE `branch_id`='$branch_id'";
//                            $resBranch = mysqli_query($conn, $sqlBranch);
//                            $rowBranch = mysqli_fetch_assoc($resBranch);
//                            $branch_name =  $rowBranch['branch_name'];

                            $sqlTotal = "SELECT * FROM `attendance` WHERE `emp_id`='$staff_id' AND `date_time` BETWEEN '$from' AND '$to'";
                            $resTotal = mysqli_query($conn, $sqlTotal);
                            $totalDays = mysqli_num_rows($resTotal);

                              $sqlPresent = "SELECT * FROM `attendance` WHERE `emp_id`='$staff_id' AND `date_time` BETWEEN '$from' AND '$to' AND `present_status`='P'";
                            $resPresent = mysqli_query($conn, $sqlPresent);
                            $totalPresent = mysqli_num_rows($resPresent);

                              $sqlAbsent = "SELECT * FROM `attendance` WHERE `emp_id`='$staff_id' AND `date_time` BETWEEN '$from' AND '$to' AND `present_status`='A'";
                            $resAbsent = mysqli_query($conn, $sqlAbsent);
                            $totalAbsent = mysqli_num_rows($resAbsent);

                              $sqlHoliday = "SELECT * FROM `attendance` WHERE `emp_id`='$staff_id' AND `date_time` BETWEEN '$from' AND '$to' AND `present_status`='H'";
                            $resHoliday = mysqli_query($conn, $sqlHoliday);
                            $totalHoliday = mysqli_num_rows($resHoliday);

                            if($totalAbsent<=$eligible_leave){
                                $lop='0';
                            }else{
                                $lop=$totalAbsent-$eligible_leave;
                                if($lop<0){
                                    $lop='0';
                                }
                            }

                              $pay_days=($totalPresent + $totalHoliday) -$lop;

//                              $pay_perday=$net_salary/$totalDays;
                              $daysInMonth;
                            $sqlMonth = "SELECT * FROM `payroll_month` WHERE `payroll_month`='$month'";
                            $resMonth = mysqli_query($conn, $sqlMonth);
                            $rowMonth = mysqli_fetch_assoc($resMonth);
                            $no_of_days =  $rowMonth['payroll_days'];

//                             $pay_perday=$net_salary/$daysInMonth;
                             $pay_perday=$net_salary/$no_of_days;

                             $total_netpay=round($pay_days * $pay_perday);

                             if($total_netpay<0){
                                 $total_netpay=0;
                             }


                            ?>
                            <tbody>

                            <tr>
                                <td><strong><?php echo $sNo;?></strong></td>
                                <td><?php echo $row['staff_id']?><br><?php echo $row['f_name']?></td>
<!--                                <td> --><?php //echo $branch_name?><!-- </td>-->
                                <td> <?php echo $row['gross_salary']?> </td>
                                <td> <?php echo $row['net_salary']?> </td>
                                <td><?php echo $no_of_days ?></td>
                                <td><?php echo $totalPresent?></td>
                                <td><?php echo $totalAbsent?></td>
                                <td><?php echo $totalHoliday?></td>
                                <td> <?php echo $row['eligible_leave']?> </td>
                                <td><?php echo $lop?></td>
                                <td><?php echo $total_netpay?></td>


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
<!--                                        <li class="page-item page-indicator"><a class="page-link" href="?page_no=--><?php //echo $prevPage?><!--&search=--><?php //echo $search ?><!--"><i class="fa-solid fa-less-than"></i></a></li>-->
                                        <li class="page-item page-indicator"><a class="page-link" href="?page_no=<?php echo $prevPage?>&search=<?php echo $search ?>&year=<?php echo $year ?>&month=<?php echo $month ?>"><i class="fa-solid fa-less-than"></i></a></li>
                                        <?php
                                    }

                                    if($search == "") {
                                        $sql = "SELECT COUNT(id) as count FROM `user`";
                                    }
                                    else {
                                        $sql = "SELECT COUNT(id) as count FROM `user` WHERE f_name LIKE '%$search%'";
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
<!--                                                                                               href="?page_no=--><?php //echo $i ?><!--&search=--><?php //echo $search ?><!--">--><?php //echo $i ?><!--</a>-->
                                                                                               href="?page_no=<?php echo $i ?>&search=<?php echo $search ?>&year=<?php echo $year ?>&month=<?php echo $month ?>"><?php echo $i ?></a>
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
<!--                                            <li class="page-item page-indicator"><a class="page-link" href="?page_no=--><?php //echo $nextPage ?><!--&search=--><?php //echo $search ?><!--"><i class="fa-solid fa-greater-than"></i></a></li>-->
                                            <li class="page-item page-indicator"><a class="page-link" href="?page_no=<?php echo $nextPage ?>&search=<?php echo $search ?>&year=<?php echo $year ?>&month=<?php echo $month ?>"><i class="fa-solid fa-greater-than"></i></a></li>
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


        <div class="modal fade" id="career_list"  data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">


                        <h5 class="modal-title" id="title">Satff</h5>

                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="basic-form" style="color: black;">
                            <form id="career_form" autocomplete="off">
                                <div class="form-row">

                                    <div class="form-group col-md-6">
                                        <label>Staff ID *</label>
                                        <input type="text" class="form-control" placeholder="Staff ID" id="staff_id" name="staff_id" style="border-color: #181f5a;color: black;text-transform: uppercase">

                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>Staff Name *</label>
                                        <input type="text" class="form-control" placeholder="Staff Name" id="staff_name" name="staff_name" style="border-color: #181f5a;color: black">
                                        <input type="hidden" class="form-control"  id="api" name="api">
                                        <input type="hidden" class="form-control"  id="old_pa_id" name="old_pa_id">
                                        <!--                                        <input type="hidden" class="form-control"  id="staff_id" name="staff_id">-->
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Branch Name *</label>
                                        <select data-search="true" class="form-control tail-select w-full" id="branch_name" name="branch_name" style="border-color: #181f5a;color: black">
                                            <option value=''>Select Branch</option>
                                            <?php
                                            $sqlDevice = "SELECT * FROM `branch`";
                                            $resultDevice = mysqli_query($conn, $sqlDevice);
                                            if (mysqli_num_rows($resultDevice) > 0) {
                                                while ($rowDevice = mysqli_fetch_array($resultDevice)) {
                                                    ?>
                                                    <option
                                                        value='<?php echo $rowDevice['branch_id']; ?>'><?php echo strtoupper($rowDevice['branch_name']); ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>

                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Role *</label>
                                        <select data-search="true" class="form-control tail-select w-full" id="role" name="role" style="border-color: #181f5a;color: black">
                                            <option value=''>Select Role</option>
                                            <option value='admin'>Admin</option>
                                            <option value='superadmin'>Super Admin</option>
                                            <option value='staff'>Staff</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Mobile *</label>
                                        <input type="number" class="form-control" placeholder="Mobile" id="mobile" name="mobile" style="border-color: #181f5a;color: black">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Email *</label>
                                        <input type="email" class="form-control" placeholder="Email" id="email" name="email" style="border-color: #181f5a;color: black">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Password *</label>
                                        <input type="text" class="form-control" placeholder="Password" id="password" name="password" style="border-color: #181f5a;color: black">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Eligible Leave Per Month *</label>
                                        <input type="number" class="form-control" placeholder="Sick + casual Leaves" id="leave" name="leave" style="border-color: #181f5a;color: black">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Active Status</label>
                                        <label class="switch">
                                            <input type="checkbox" checked id="access_status"  name="access_status">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <h4>Salary Payment</h4>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>Gross salary *</label>
                                        <input type="number" class="form-control" placeholder="Per Month Salary" id="gross" name="gross" style="border-color: #181f5a;color: black">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Deductions *</label>
                                        <input type="text" class="form-control" placeholder="Deduction per Month" id="deduction" name="deduction" style="border-color: #181f5a;color: black">
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


    $(document).on("click", ".excel_download", function () {
        window.location.href = "excel_download.php?month=<?php echo $month?>&year=<?php echo $year?>&search=<?php echo $search?>";
    });

    function addTitle() {
        $("#title").html("Add Staff");
        $('#career_form')[0].reset();
        $('#api').val("add_api.php")
        // $('#game_id').prop('readonly', false);
    }

    function editTitle(data) {

        $("#title").html("Edit Staff- "+data);
        $('#career_form')[0].reset();
        $('#api').val("edit_api.php");

        $.ajax({

            type: "POST",
            url: "view_api.php",
            data: 'staff_id='+data,
            dataType: "json",
            success: function(res){
                if(res.status=='success')
                {
                    $("#staff_name").val(res.staff_name);
                    $("#branch_name").val(res.branch_name);
                    $("#role").val(res.role);
                    $("#mobile").val(res.mobile);
                    $("#email").val(res.email);
                    $("#password").val(res.password);
                    $("#leave").val(res.leave);
                    $("#gross").val(res.gross);
                    $("#deduction").val(res.deduction);
                    $("#access_status").val(res.access_status);

                    $("#old_pa_id").val(res.id);
                    $("#staff_id").val(res.staff_id);
                    // $('#game_id').prop('readonly', true);
                    var edit_model_title = "Edit Staff - "+data;
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
    $("#career_form").validate(
        {
            ignore: '.ignore',
            // Specify validation rules
            rules: {
                staff_id: {
                    required: true
                },
                staff_name: {
                    required: true
                },
                branch_name: {
                    required: true
                },
                role: {
                    required: true
                },
                //    mobile: {
                //        required: true
                //    },
                mobile: {
                    required: true,
                    maxlength: 10,
                    minlength: 10
                },
                email: {
                    required: true
                },
                password: {
                    required: true
                },
                leave: {
                    required: true
                },
                gross: {
                    required: true
                },
                deduction: {
                    required: true
                },
            },
            // Specify validation error messages
            messages: {
                staff_id: "*This field is required",
                staff_name: "*This field is required",
                branch_name: "*This field is required",
                role: "*This field is required",
                mobile: {
                    required:"*This field is required",
                    maxlength:"*Mobile Number Should Be 10 Character",
                    minlength:"*Mobile Number Should Be 10 Character"
                },
                email: "*This field is required",
                password: "*This field is required",
                deduction: "*This field is required",
                gross: "*This field is required",
                leave: "*This field is required",
            }
            // Make sure the form is submitted to the destination defined
        });

    //add data

    $('#add_btn').click(function () {
        $("#career_form").valid();
        if($("#career_form").valid()==true) {
            var api = $('#api').val();
            var form = $("#career_form");
            var access_status = $('#access_status').is(":checked");

            console.log(access_status);

            if(access_status == true)
            {
                access_status =1;
            }
            else{
                access_status =0;
            }
            var formData = new FormData(form[0]);
            formData.append("active_status",access_status);
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
                        data: 'staff_id='+data,
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
        $('#search').val('<?php echo $search;?>');
        $('#month').val('<?php echo $month;?>');
        $('#year').val('<?php echo $year;?>');

    });

</script>

</body>
</html>
