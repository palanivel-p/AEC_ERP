<?php Include("../../includes/connection.php");

$start=0;

$yearid=$_GET['year'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Holiday</title>
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

    $header_name ="Holidays";
    Include ('../../includes/header.php') ?>



    <div class="content-body">
        <div class="page-titles" style="margin-left: 21px;">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Table</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Holidays</a></li>


            </ol>

        </div>


        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Holidays List</h4>
                    <div style="display: flex;justify-content: flex-end;">
                        <button type="button" class="btn btn-primary mb-2"  style="margin-left: 20px;"  data-toggle="modal" data-target="#add_cat">ADD Holidays</button>

                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">


                        <table class="table table-responsive-md" style="text-align: center;">
                            <thead>
                            <tr>
                                <th class="width80"><strong>#</strong></th>
                                <th><strong>Date</strong></th>
                                <th><strong>Day</strong></th>
                                <th><strong>Name</strong></th>
                                <th><strong>Action</strong></th>


                                <!--                                <th><strong>Type</strong></th>-->


                            </tr>
                            </thead>
                            <?php

                            $sno=$start;

                            $sqlquery = "SELECT * FROM holiday_list  WHERE `year_id`='$yearid' ORDER BY `date` ASC ";


                            $result = mysqli_query($conn,$sqlquery);


                            if(mysqli_num_rows($result)>0) {


                            while ($row = mysqli_fetch_assoc($result)) {
                            $sno++;


                            ?>
                            <tbody>

                            <tr>
                                <td><strong><?php echo $sno;?></strong></td>
                                <td> <?php echo (new DateTime($row['date']))->format('d-m-Y'); ?> </td>
                                <td> <?php echo $row['day']; ?> </td>
                                <td><?php echo $row['details']; ?> </td>

                                  <td>  <div class="dropdown">
                                        <button type="button" class="btn btn-success light sharp" data-toggle="dropdown">
                                            <svg width="20px" height="20px" viewbox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><circle fill="#000000" cx="5" cy="12" r="2"></circle><circle fill="#000000" cx="12" cy="12" r="2"></circle><circle fill="#000000" cx="19" cy="12" r="2"></circle></g></svg>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item"  onclick="deleteholiday('<?php echo $row['id']; ?>')">Delete</a>

                                            <!-- <a class="dropdown-item" style="cursor: pointer" onclick="delete_model('<?php //echo $row['staff_id'];?>')">Delete</a> -->
                                        </div>
                                    </div>
                                </td>

                            </tr>
                            <?php } }
                            ?>

                            </tbody>
                        </table>


                    </div>
                </div>
            </div>
        </div>


        <div class="modal custom-modal fade" id="add_cat" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Holiday</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="year">
                            <div class="input-block mb-3">
                                <label class="col-form-label">Date <span class="text-danger">*</span></label>
                                <input class="form-control" type="date" name="date" style="color: black">
                            </div>
                            <div class="input-block mb-3">
                                <label class="col-form-label">Details <span class="text-danger">*</span></label>
                                <div ><input class="form-control" type="text" name="detail" style="color: black"></div>
                            </div>
                            <div class="submit-section">
                                <button class="btn btn-primary btn" id="add" type="button">Submit</button>
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
        // Validation configuration for the form with the id "manual"
        $("#year").validate({
            ignore: '.ignore',
            rules: {
                date: {
                    required: true,
                },
                detail: {
                    required: true
                },
            },
            messages: {
                year: "*This field is required",
                nodays: "*This field is required",
            }
        });
    });








    $(document).ready(function() {
        // Event handler for the element with the id "add"
        $("#add").click(function() {
            // Validate the form with id "year"
            $("#year").valid();

            // If the form is valid, proceed with AJAX submission
            if ($("#year").valid() == true) {
                // Disable the button and show a loading spinner
                document.getElementById('add').disabled = true;
                $("#add").html('<i class="fa-solid fa-spinner fa-spin"></i>');

                // Create a FormData object from the form with id "year"
                var formElem = $("#year");
                var formdata = new FormData(formElem[0]);

                // AJAX request to "add_yr.php" for form submission
                $.ajax({
                    type: "POST",
                    url: "add_holiday.php",
                    data: formdata,
                    processData: false,
                    contentType: false,
                    dataType: "json",
                    success: function(res) {
                        // Handle the response from the server
                        if (res.status == 'success') {
                            // Show success message with Swal (SweetAlert) and reload the page
                            Swal.fire({
                                title: "Success",
                                text: res.msg,
                                icon: "success",
                                button: "OK",
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                closeOnClickOutside: false,
                            }).then((value) => {
                                window.window.location.reload();
                            });
                        } else if (res.status == "failure") {
                            // Show failure message with Swal and enable the button
                            Swal.fire({
                                title: "Failure",
                                text: res.msg,
                                icon: "failure",
                                button: "OK",
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                closeOnClickOutside: false,
                            }).then((value) => {
                                document.getElementById('add').disabled = false;
                                document.getElementById('add').innerText = 'ADD';
                            });
                        }
                    },
                });
            }
        });
    });

</script>
<script>
    function deleteholiday(id) {
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
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "delete.php",
                    data: 'id=' + id,
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
                            }).then(() => {
                                window.location.reload();
                            });
                        }
                    },
                });
            }
        });
    }


</script>







</body>
</html>
