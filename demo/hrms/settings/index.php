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
    <title>Settings</title>
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
        .activity-list {
            list-style-type: none;
            padding: 0;
        }

        .activity-list li {
            position: relative;
            margin-bottom: 20px;
        }

        .activity-user {
            float: left;
            margin-right: 20px;
        }

        .activity-content {
            overflow: hidden;
        }

        .activity-content .timeline-content {
            margin-bottom: 10px;
        }

        .activity-content .account-btn {
            position: absolute;
            top: 15px;
            right: 20px;
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

    $header_name ="Settings";
    Include ('../../includes/header.php') ?>



    <div class="content-body">
        <div class="page-titles" style="margin-left: 21px;">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)"></a>HRMS</li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Settings</a></li>


            </ol>

        </div>


        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"></h4>
                    <div style="display: flex;justify-content: flex-end;">

                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="activity">
                                <div class="activity-box">
                                    <ul class="activity-list">
<!--                                        <li>-->
<!--                                            <div class="activity-user">-->
<!--                                                <i class="las la-lock" style="color: black;width: 100px;font-size: 31px;"></i>-->
<!--                                            </div>-->
<!--                                            <div class="activity-content" style="margin-left: 50px">-->
<!--                                                <div class="timeline-content">-->
<!---->
<!--                                                    <h4 style="color: black"><b>Password Update</b></h4>-->
<!--                                                    <span class="time">change password for your convenience</span>-->
<!---->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                            <div  style="height: 32px;width: 32px;margin: 0;padding: 0;position: absolute;top: 15px;right: 55px;">-->
<!--                                                <button class="btn btn-primary account-btn" type="button"   onclick="pwd()">change</button>-->
<!--                                            </div>-->
<!--                                        </li>-->


                                        <li>
                                            <div class="activity-user">
                                                <i class="las la-image"
                                                   style="color: black;width: 100px;font-size: 31px;"></i>
                                            </div>
                                            <div class="activity-content" style="margin-left: 50px">
                                                <div class="timeline-content">

                                                    <h4 style="color: black"><b>Company logo Update</b></h4>
                                                    <span class="time">change Logo for device</span>

                                                </div>
                                            </div>
                                            <div style="height: 32px;width: 32px;margin: 0;padding: 0;position: absolute;top: 15px;right: 55px;">
                                                <button class="btn btn-primary account-btn" type="button" onclick="logo()">
                                                    change
                                                </button>
                                            </div>
                                        </li>

                                        <li>
                                            <div class="activity-user">
                                                <i class="lab la-whatsapp"
                                                   style="color: black;width: 100px;font-size: 31px;"></i>
                                            </div>
                                            <div class="activity-content" style="margin-left: 50px">
                                                <div class="timeline-content">

                                                    <h4 style="color: black"><b>Whatsapp Url</b></h4>
                                                    <span class="time">change URL for Notification</span>

                                                </div>
                                            </div>
                                            <div style="height: 32px;width: 32px;margin: 0;padding: 0;position: absolute;top: 15px;right: 55px;">
                                                <button class="btn btn-primary account-btn" type="button"
                                                        onclick="whatsapp()">change
                                                </button>
                                            </div>
                                        </li>

                                        <li>
                                            <div class="activity-user">
                                                <i class="las la-id-badge"
                                                   style="color: black;width: 100px;font-size: 31px;"></i>
                                            </div>
                                            <div class="activity-content" style="margin-left: 50px">
                                                <div class="timeline-content">

                                                    <h4 style="color: black"><b>Face License</b></h4>
                                                    <span class="time">change License key</span>

                                                </div>
                                            </div>
                                            <div style="height: 32px;width: 32px;margin: 0;padding: 0;position: absolute;top: 15px;right: 55px;">
                                                <button class="btn btn-primary account-btn" type="button"
                                                        onclick="facekey()">change
                                                </button>
                                            </div>
                                        </li>


                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal custom-modal fade" data-backdrop="static" data-keyboard="false" id="new_password" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Change Password</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="input-block mb-4">
                            <div class="row align-items-center">
                                <div class="col">
                                    <label class="col-form-label">New Password</label>
                                </div>
                                <div class="col-auto">

                                </div>
                            </div>
                            <div class="position-relative">
                                <input style="color:black;"style="color:black"class="form-control" type="password" name="npassword"  id="newpassword">
                                <input style="color:black;"style="color:black"type="checkbox" name="checkbox" id="showPasswordCheckboxs" onclick="togglePasswords()"> Show password
                            </div>
                        </div>
                        <form>
                            <div class="input-block mb-4">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <label class="col-form-label">Confirm Password</label>
                                    </div>
                                    <div class="col-auto">

                                    </div>
                                </div>
                                <div class="position-relative">
                                    <input style="color:black;"style="color:black"class="form-control" type="password" name="cpassword"  id="confirmpassword">
                                    <input style="color:black;"style="color:black"type="checkbox" name="checkbox" id="showPasswordCheckboxss" onclick="togglePasswordss()"> Show password
                                </div>
                        </form>
                        <div class="input-block mb-4 text-center">
                            <button class="btn btn-primary account-btn" type="button" onclick="updates()" id="update">Update password</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>



    <div class="modal custom-modal fade" id="add_cat" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="head">Add Year</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="pwd" style="margin: 10px">

                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <label class="col-form-label">Current Password</label>
                        </div>
                        <div class="col-md-12">
                            <input style="color:black;"style="color:black"class="form-control" type="password" name="password" id="cpassword">
                            <label class="col-form-label">
                                <input style="color:black;"style="color:black"type="checkbox" name="checkbox" id="showPasswordCheckbox" onclick="togglePassword()"> Show password
                            </label>
                        </div>
                    </div>
                    <div class="input-block mb-4">
                        <button class="btn btn-primary account-btn" type="submit" onclick="check();">Verify password</button>
                    </div>

                </div>

                <div class="modal-body" id="logo" style="margin: 5px;margin-top: 0px">

                    <form id="profile">
                        <div class="col-md-12">

                            <label class="col-form-label col-md-6">Device Logo</label>
                            <div class="col-md-12">
                                <span class="text-danger">+ Choose Image only with PNG formate</span><br>
                                <span class="text-danger">+ Choosen Image must be 3400*950px dimension</span>
                                <input style="color:black;"style="color:black"class="form-control " type="file" name="profile" id="image" required="" >
                            </div>

                        </div>
                    </form>
                    <div class="input-block mb-4 " style="margin-top: 25px">
                        <button class="btn btn-primary account-btn" type="button"  id="verify">Update</button>
                    </div>
                </div>



                <div class="modal-body" id="whatsapps" style="margin: 5px;margin-top: 0px">

                    <form id="app">
                        <div class="col-md-12">
                            <?php
                            $sqlquery = "SELECT * FROM `whatsapp` WHERE `id`=1";

                            $result = mysqli_query($conn,$sqlquery);


                            if(mysqli_num_rows($result)) {


                                while ($row = mysqli_fetch_assoc($result)) {
                                    ?>
                                    <div class="input-block mb-4">
                                        <div class="row align-items-center">
                                            <div class="col-md-6">
                                                <label class="col-form-label">Whatsapp url</label>
                                            </div>
                                            <div class="col-auto">

                                            </div>
                                        </div>
                                        <div class="position-relative col-md-12">
                                            <span class="text-danger">+ Replace the Message area to off_msg</span><br>
                                            <span class="text-danger">+ Replace the Mobile area to off_mobile</span><br>
                                            <span class="text-danger">+ Replace the Image area to off_img</span><br>

                                            <textarea class="form-control" type="text" name="watsapp" id="watsapp" style="color:black;"><?php echo $row['url']; ?></textarea>

                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                    </form>
                    <div class="input-block mb-4 " style="margin-top: 25px">
                        <button class="btn btn-primary account-btn" type="button"  id="whatsapp">Update</button>
                    </div>
                </div>

                <div class="modal-body" id="license" style="margin: 5px;margin-top: 0px">

                    <form id="key">
                        <div class="col-md-12">
                            <?php
                            $sqlquery = "SELECT * FROM face_license WHERE `id`=1";

                            $result = mysqli_query($conn,$sqlquery);


                            if(mysqli_num_rows($result)) {


                                while ($row = mysqli_fetch_assoc($result)) {
                                    ?>

                                    <div class="input-block mb-4">
                                        <div class="row align-items-center">
                                            <div class="col-md-6">
                                                <label class="col-form-label">Package Name</label>
                                            </div>
                                            <div class="col-auto">

                                            </div>
                                        </div>
                                        <div class="position-relative col-md-12">
                                            <input style="color:black;"class="form-control" type="text" name="package" id="package" value="<?php echo $row['package_name']; ?>"></input>

                                        </div>
                                    </div>

                                    <div class="input-block mb-4">
                                        <div class="row align-items-center">
                                            <div class="col-md-6">
                                                <label class="col-form-label">License Key</label>
                                            </div>
                                            <div class="col-auto">

                                            </div>
                                        </div>
                                        <div class="position-relative col-md-12">
                                            <textarea class="form-control" type="text" name="license"  id="license_key" style="color:black;"><?php echo $row['license_key']; ?></textarea>

                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                            ?>

                        </div>
                    </form>
                    <div class="input-block mb-4 " style="margin-top: 25px">
                        <button class="btn btn-primary account-btn" type="button"  id="keychange">Update</button>
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

    function pwd() {
        $('#logo').hide();
        $('#license').hide();
        $('#pwd').show();
        $('#whatsapps').hide();
        document.getElementById('head').innerText='Password update';
        $('#add_cat').modal('show');
    }
    function logo() {
        $('#profile')[0].reset();
        $('#pwd').hide();
        $('#logo').show();
        $('#license').hide();
        $('#whatsapps').hide();
        document.getElementById('head').innerText='Device Logo update';
        $('#add_cat').modal('show');
    }
    function whatsapp() {
        $('#app')[0].reset();
        $('#pwd').hide();
        $('#logo').hide();
        $('#license').hide();
        $('#whatsapps').show();
        document.getElementById('head').innerText='Whatsapp Url update';
        $('#add_cat').modal('show');
    }
    function facekey() {
        $('#key')[0].reset();
        $('#pwd').hide();
        $('#logo').hide();
        $('#license').show();
        $('#whatsapps').hide();
        document.getElementById('head').innerText='Face License';
        $('#add_cat').modal('show');
    }
</script>
<script>
    function togglePassword() {
        var passwordInput = document.getElementById('cpassword');
        var checkbox = document.getElementById('showPasswordCheckbox');

        if (checkbox.checked) {
            passwordInput.type = 'text';
        } else {
            passwordInput.type = 'password';
        }
    } function togglePasswords() {
        var passwordInput = document.getElementById('newpassword');
        var checkbox = document.getElementById('showPasswordCheckboxs');

        if (checkbox.checked) {
            passwordInput.type = 'text';
        } else {
            passwordInput.type = 'password';
        }
    } function togglePasswordss() {
        var passwordInput = document.getElementById('confirmpassword');
        var checkbox = document.getElementById('showPasswordCheckboxss');

        if (checkbox.checked) {
            passwordInput.type = 'text';
        } else {
            passwordInput.type = 'password';
        }
    }
</script>

<script>
    function check() {
        // document.getElementById('verify').disabled = true;

        // Corrected the way to get the value of the 'cpassword' field
        var pwd = document.getElementById('cpassword').value;

        $.ajax({
            type: "POST",
            url: 'verify.php',
            data: { pwd: pwd }, // Corrected the way to send data
            dataType: "json",
            success: function (res) {
                if (res.status == 'success') {
                    $('#add_cat').modal('hide');
                    $('#new_password').modal('show');
                } else if (res.status == "failure") {
                    // document.getElementById('verify').disabled = false;
                    $('#add_cat').modal('hide');
                    Swal.fire(
                        {
                            title: "Failure", // Corrected the icon from "failure" to "error"
                            text: res.msg,
                            icon: "error",
                            button: "OK",
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            closeOnClickOutside: false,
                        }
                    );
                    // Commented out the following line as it may cause unexpected behavior
                    // window.location.reload();
                }
            },
            // Removed unnecessary comma
        });
    }



    function updates() {

        var pwd1= document.getElementById('newpassword').value;
        var pwd2= document.getElementById('confirmpassword').value;

        if(pwd1!=pwd2){

            var text="Newpassword & Confirmpassword are not same"
            Swal.fire(
                {
                    title: "Failure", // Corrected the icon from "failure" to "error"
                    text: text,
                    icon: "error",
                    button: "OK",
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    closeOnClickOutside: false,
                }
            );
        }else{


            $.ajax({
                type: "POST",
                url: 'update.php',
                data: { pwd: pwd1 }, // Corrected the way to send data
                dataType: "json",
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




                    } else if (res.status == "failure") {
                        // document.getElementById('verify').disabled = false;

                        Swal.fire(
                            {
                                title: "Failure", // Corrected the icon from "failure" to "error"
                                text: res.msg,
                                icon: "error",
                                button: "OK",
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                closeOnClickOutside: false,
                            }
                        );
                        // Commented out the following line as it may cause unexpected behavior
                        // window.location.reload();
                    }
                },
                // Removed unnecessary comma
            });



        }

    }
</script>


<script>
    $(document).ready(function() {
        $("#profile").validate(
            {
                ignore: '.ignore',
                rules: {


                    profile: {
                        required: true
                    },


                },
                messages: {

                    profile: "*This field is required",


                }

            });
    });




</script>
<script type="text/javascript">

    $(document).ready(function(){






        $("#verify").click(function(){




            $("#profile").valid();

            if($("#profile").valid()==true) {

                validateImage();

                function validateImage() {
                    var fileInput = document.getElementById('image');
                    var filePath = fileInput.value;
                    var allowedExtensions = /(\.png)$/i;

                    if (!allowedExtensions.exec(filePath)) {
                        alert('Please upload file having extensions .png only.');
                        fileInput.value = '';

                    }else {

                        var file = fileInput.files[0];
                        var img = new Image();
                        img.src = window.URL.createObjectURL(file);

                        img.onload = function() {
                            var width = img.naturalWidth,
                                height = img.naturalHeight;

                            window.URL.revokeObjectURL(img.src);

                            if (width !== 3400 || height !== 950) {
                                alert("Please upload an image with dimensions 3400px x 950px.");
                                fileInput.value = '';
                                return false;
                            }



                            document.getElementById('verify').disabled = true;

                            $("#verify").html('<i class="fa-solid fa-spinner fa-spin"></i>');


                            var formElem = $("#profile");
                            var formdata = new FormData(formElem[0]);



                            $.ajax({
                                type:"POST",
                                url:'logo.php',
                                data:formdata,
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
                                        document.getElementById('verify').disabled = false;

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
                                        // .then((value) => {
                                        //     window.window.location.reload();
                                        // });
                                    }

                                },



                            });

                        };
                    }
                }

            }
        });




    });


</script>

<script>
    $(document).ready(function() {
        $("#app").validate(
            {
                ignore: '.ignore',
                rules: {


                    watsapp: {
                        required: true
                    },


                },
                messages: {

                    watsapp: "*This field is required",


                }

            });
    });




</script>
<script type="text/javascript">

    $(document).ready(function(){






        $("#whatsapp").click(function(){




            $("#app").valid();

            if($("#app").valid()==true) {


                document.getElementById('whatsapp').disabled = true;

                $("#whatsapp").html('<i class="fa-solid fa-spinner fa-spin"></i>');


                var formElem = $("#app");
                var formdata = new FormData(formElem[0]);



                $.ajax({
                    type:"POST",
                    url:'app.php',
                    data:formdata,
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
                            document.getElementById('verify').disabled = false;

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
                            // .then((value) => {
                            //     window.window.location.reload();
                            // });
                        }

                    },



                });



            }
        });




    });


</script>





<script>
    $(document).ready(function() {
        $("#key").validate(
            {
                ignore: '.ignore',
                rules: {


                    package: {
                        required: true
                    },
                    license: {
                        required: true
                    },


                },
                messages: {

                    package: "*This field is required",
                    license: "*This field is required",


                }

            });
    });




</script>
<script type="text/javascript">

    $(document).ready(function(){






        $("#keychange").click(function(){




            $("#key").valid();

            if($("#key").valid()==true) {


                document.getElementById('keychange').disabled = true;

                $("#keychange").html('<i class="fa-solid fa-spinner fa-spin"></i>');


                var formElem = $("#key");
                var formdata = new FormData(formElem[0]);



                $.ajax({
                    type:"POST",
                    url:'key_add.php',
                    data:formdata,
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
                            document.getElementById('verify').disabled = false;

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
                            // .then((value) => {
                            //     window.window.location.reload();
                            // });
                        }

                    },



                });



            }
        });




    });


</script>







</body>
</html>
