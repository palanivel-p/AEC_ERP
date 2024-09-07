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
    <title>Visitors List</title>
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
        input{
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

    $header_name ="Visitors";
    Include ('../../includes/header.php') ?>



    <div class="content-body">
        <div class="page-titles" style="margin-left: 21px;">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Table</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Visitors</a></li>


            </ol>

        </div>


        <div class="col-lg-12">
            <div class="card" style="zoom: 90%">
                <div class="card-header">
                    <h4 class="card-title">Visitors List</h4>
                    <div style="display: flex;justify-content: flex-end;">
                        <form class="form-inline">

                            <div class="form-group mx-sm-3 mb-2">

                                <input type="text" class="form-control" placeholder="Search By Name" name="search" id="search" style="border-radius:20px;color:black;" >
                            </div>
                            <div class="form-group mx-sm-3 mb-2">

                                <input class="form-control " type="date" id="from_date" name="from" style="border-radius:20px;color:black;" value=<?php echo $fdate ?> >
                            </div>
                            <div class="form-group mx-sm-3 mb-2">

                                <input class="form-control " type="date" name="to" id="to_date" style="border-radius:20px;color:black;" value=<?php echo $ldate  ?> >
                            </div>
                            <button type="submit" class="btn btn-primary mb-2">Search</button>
                        </form>
                        <button type="button" class="excel_download btn btn-success mb-2" style="margin-left: 20px;">
            <span class="text-white">
                <i class="fa fa-download"></i>
            </span>
                            Visitors List
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">


                        <table class="table table-responsive-md" style="text-align: center;">
                            <thead>
                            <tr>
                                <th class="width80"><strong>#</strong></th>
                                <th><strong>Visitor Name</strong></th>
                                <th><strong>Mobile</strong></th>
                                <th><strong>Send</strong></th>
                                <th><strong>Company</strong></th>
                                <th><strong>Person To Meet</strong></th>
                                <th><strong>Entry</strong></th>
                                <th><strong>Exit</strong></th>
                                <th><strong>Image</strong></th>
                          <th><strong>Action</strong></th>


                            </tr>
                            </thead>
                            <?php
                            if($search == "") {
                                $sql = "SELECT * FROM visitor_details WHERE `visit_dt` BETWEEN '$from' AND '$to' ORDER BY id DESC LIMIT $start, 10";
                            }
                            else {
                                $sql = "SELECT * FROM visitor_details WHERE `name` LIKE '%$search%' AND `visit_dt` BETWEEN '$from' AND '$to' ORDER BY id DESC LIMIT $start, 10";
                            }
                            $result = mysqli_query($conn, $sql);
                            if (mysqli_num_rows($result)>0) {
                            $sNo = $start;
                            while($row = mysqli_fetch_assoc($result)) {

                            $sNo++;

                            $eid = $row['to_emp_id'];

                            $sqlquerys = "SELECT * FROM staff WHERE staff_id='$eid'";

                            $results = mysqli_query($conn, $sqlquerys);
                            $rows = mysqli_fetch_assoc($results);

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
                                <td><?php echo $row['name']?></td>
                                <td> <?php echo $rows['mobile']?> </td>
                                <td> <?php
                                    if (date('Y-m-d', strtotime($row['visit_dt'])) == date('Y-m-d')) {
                                        ?>
                                        <a class="btn btn-sm btn-success"
                                           onclick="resend('<?php echo $row['visitor_id']; ?>');"
                                           style="width: 90px"
                                           id="<?php echo $row['visitor_id']; ?>">Resend</a>
                                        <?php
                                    } else {
                                        ?>
                                        NA
                                        <?php
                                    }
                                    ?> </td>
                                <td> <?php echo $row['company']; ?></td>
                                <td><?php echo $rows['staff_name']; ?>-<?php echo $rows['designation']; ?></td>
                                <td> <?php
                                    $originalDateTime = $row['visit_dt'];
                                    $formattedDate = date("d-m-Y", strtotime($originalDateTime));
                                    $formattedTime = date("h:i A", strtotime($originalDateTime));
                                    echo $formattedDate . ' ' . $formattedTime;
                                    ?></td>
                                <td> <?php
                                    $originalDateTime = $row['exit_dt'];
                                    if($originalDateTime=="0000-00-00 00:00:00"){
                                        echo  $exit_dt="NA";
                                    }else{
                                        $formattedDate = date("d-m-Y", strtotime($originalDateTime));
                                        $formattedTime = date("h:i A", strtotime($originalDateTime));
                                        echo  $exit_dt = $formattedDate . ' ' . $formattedTime;
                                    }
                                    ?></td>
                                <td>  <?php
                                    $img = $row['img'];
                                    if ($img == '0') {
                                        ?>
                                        <a class="btn btn-sm btn-primary" >unavailable</a>
                                        <?php
                                    } else {
                                        ?>
                                        <!--                                                    <a class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#visitor_img" onclick="image(<?php //echo $row['visitor_id']; ?>);">View</a>-->
                                        <a class="btn btn-sm btn-success"  onclick="image('<?php echo $row['visitor_id']; ?>');" style="width: 90px">View</a>
                                        <?php
                                    }
                                    ?></td>
                                <td><div class="dropdown">
                                        <button type="button" class="btn btn-success light sharp" data-toggle="dropdown">
                                            <svg width="20px" height="20px" viewbox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><circle fill="#000000" cx="5" cy="12" r="2"></circle><circle fill="#000000" cx="12" cy="12" r="2"></circle><circle fill="#000000" cx="19" cy="12" r="2"></circle></g></svg>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" onclick="view('<?php echo $row['visitor_id']; ?>')" ><i class="fa-solid fa-pencil m-r-5"></i> View</a>
                                            <!-- <a class="dropdown-item" style="cursor: pointer" onclick="delete_model('<?php //echo $row['staff_id'];?>')">Delete</a> -->
                                        </div>
                                    </div></td>

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
                                        <li class="page-item page-indicator"><a class="page-link" href="?page_no=<?php echo $prevPage?>&search=<?php echo $search ?>&from=<?php echo $fdate ?>&to=<?php echo $ldate ?>"><i class="fa-solid fa-less-than"></i></a></li>
                                        <?php
                                    }


                                    if($search == "") {
                                        $sql = "SELECT COUNT(id) as count FROM visitor_details  WHERE `visit_dt` BETWEEN '$from' AND '$to' ";
                                    }
                                    else {
                                        $sql = "SELECT COUNT(id) as count FROM visitor_details WHERE name LIKE '%$search%' AND `visit_dt` BETWEEN '$from' AND '$to'";
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
                                                                                               href="?page_no=<?php echo $i ?>&search=<?php echo $search ?>&from=<?php echo $fdate ?>&to=<?php echo $ldate ?>"><?php echo $i ?></a>
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
                                            <li class="page-item page-indicator"><a class="page-link" href="?page_no=<?php echo $nextPage ?>&search=<?php echo $search ?>&from=<?php echo $fdate ?>&to=<?php echo $ldate ?>"><i class="fa-solid fa-greater-than"></i></a></li>
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


        <div class="modal custom-modal fade" data-backdrop="static" data-keyboard="false" id="visitor_img" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Visitor image</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <img id="v_Image" src="">

                    </div>
                </div>
            </div>
        </div>

        <div class="modal custom-modal fade" data-backdrop="static" data-keyboard="false" id="visitor_details" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="head">Visitor image</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-12">
                            <form id="profile">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="input-block mb-3">
                                            <label class="col-form-label">Full Name <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" name="full_name" id="name" readonly style=" color: black;!important;">
                                            <input class="form-control" type="hidden" name="vid" id="vid" >
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="input-block mb-3">
                                            <label class="col-form-label">Date <span class="text-danger">*</span></label>
                                            <div class="cal-icon"><input class="form-control datetimepicker" type="text" name="birth_date" id="date" readonly style=" color: black;!important;"></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="input-block mb-3">
                                            <label class="col-form-label">Mobile<span class="text-danger">*</span></label>
                                            <input class="form-control" type="number" name="mobile" id="mobile" readonly style=" color: black;!important;">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="input-block mb-3">
                                            <label class="col-form-label">Company <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" name="company" id="company" readonly style=" color: black;!important;">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="input-block mb-3">
                                            <label class="col-form-label">Person to Meet <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" name="to_meet" id="tomeet" readonly style=" color: black;!important;">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="input-block mb-3">
                                            <label class="col-form-label">No.of Peoples <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" name="num_people" id="peoples" readonly style=" color: black;!important;">
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="input-block mb-12">
                                            <label class="col-form-label">Purpose <span class="text-danger">*</span></label>
                                            <textarea class="form-control" name="purpose" id="purpose" readonly style=" color: black;!important;"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="submit-section">
                                    <button class="btn btn-primary submit-btn" type="button" data-dismiss="modal" aria-label="Close">Close</button>
                                </div>
                            </form>
                        </div>
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
        window.location.href = "excel_download.php?from=<?php echo $from?>&to=<?php echo $to?>&search=<?php echo $search?>";
    });


    function image(id) {
        document.getElementById('head').innerText='Visitor Image';
        var vid = id;
        var link = 'https://jbcargo.in/hrms/visitors/visitors_img/' + vid + '.jpg';

        // Set the src attribute of the img tag
        document.getElementById('v_Image').src = link;
        $('#visitor_img').modal('show');
    }

    function view(id) {


        document.getElementById('head').innerText='Visitor Details';


        $.ajax({

            type: "POST",
            url: "view_api.php",
            data: 'id='+id,
            dataType: "json",
            success: function(res){
                if(res.status=='success')
                {

                    $("#vid").val(res.id);
                    $("#name").val(res.name);
                    $("#mobile").val(res.mobile);
                    $("#company").val(res.company);
                    $("#purpose").val(res.purpose);
                    $("#peoples").val(res.count);
                    $("#tomeet").val(res.to_emp_id);

// Assuming res.visit_dt is a valid date string
                    var originalDateTime = new Date(res.visit_dt);
                    var formattedDate = originalDateTime.toLocaleDateString('en-GB', { day: '2-digit', month: '2-digit', year: 'numeric' });
                    var formattedTime = originalDateTime.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });

                    $("#date").val(formattedDate + ' ' + formattedTime);

                    $('#visitor_details').modal('show');

                }

                else if(res.status=='failure')
                {
                    swal(  {
                        title: "Failure",
                        text: res.msg,
                        icon: "error",
                        button: "OK",
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        closeOnClickOutside: false,
                    })
                        .then((value) => {
// window.window.location.reload();

                        });
                }
            },
            error: function(){
                swal("Check your network connection");

// window.window.location.reload();

            }

        });





    }



    function resend(id) {

        $("#" + id).html('<i class="fa-solid fa-spinner fa-spin"></i>');
        document.getElementById(id).disabled = true;



        $.ajax({

            type: "POST",
            url: "resend.php",
            data: 'id='+id,
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

                    document.getElementById(id).disabled = false;
                    $("#" + id).text('Resend');
                }

                else if(res.status=='failure')
                {
                    swal(  {
                        title: "Failure",
                        text: res.msg,
                        icon: "error",
                        button: "OK",
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        closeOnClickOutside: false,
                    })
                        .then((value) => {
// window.window.location.reload();

                        });
                    document.getElementById(id).disabled = false;
                    $("#" + id).text('Resend');
                }
            },
            error: function(){
                swal("Check your network connection");

// window.window.location.reload();

            }

        });





    }

    $( document ).ready(function() {
        $('#search').val('<?php echo $search;?>');

    });

    $( document ).ready(function() {
        $('#from_date').val('<?php echo $from;?>');
        $('#to_date').val('<?php echo $to;?>');



    });
</script>

</body>
</html>
