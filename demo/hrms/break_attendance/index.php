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
    <title>Break Attendance</title>

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

    $header_name ="Break";
    Include ('../../includes/header.php') ?>



    <div class="content-body">
        <div class="page-titles" style="margin-left: 21px;">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Table</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Break</a></li>


            </ol>

        </div>


        <div class="col-lg-12">
            <div class="card" style="zoom: 90%">
                <div class="card-header">
                    <h4 class="card-title">Break List</h4>
                    <div style="display: flex;justify-content: flex-end;">
                        <form class="form-inline">

                            <div class="form-group mx-sm-3 mb-2">

                                <input type="text" class="form-control" placeholder="Search By ID" name="search" id="search" style="border-radius:20px;color:black;" >
                            </div>
                            <div class="form-group mx-sm-3 mb-2">

                                <input class="form-control " type="date" id="from_date" name="from" style="border-radius:20px;color:black;" value=<?php echo $fdate ?> >
                            </div>
                            <div class="form-group mx-sm-3 mb-2">

                                <input class="form-control " type="date" name="to" id="to_date" style="border-radius:20px;color:black;" value=<?php echo $ldate  ?> >
                            </div>
                            <button type="submit" class="btn btn-primary mb-2">Search</button>
                        </form>
                        <button type="button" style="margin-left: 20px;" class="excel_download btn btn-success mb-2" >
            <span class="text-white">
                <i class="fa fa-download"></i>
            </span>
                            Break Attendance
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">


                        <table class="table table-responsive-md" style="text-align: center;">
                            <thead>
                            <tr>
                                <th class="width80"><strong>#</strong></th>
                                <th><strong>Staff ID</strong></th>
                                <th><strong>Staff Name</strong></th>
                                <th><strong>Date</strong></th>
                                <th><strong>Break out</strong></th>
                                <th><strong>Break In</strong></th>
                                <th><strong>Duration</strong></th>
<!--                                <th><strong>Type</strong></th>-->


                            </tr>
                            </thead>
                            <?php
                            if($search == "") {
                                $sql = "SELECT * FROM break_attendance WHERE `date` BETWEEN '$from' AND '$to' ORDER BY `id` DESC LIMIT $start, 10";
                            }
                            else {
                                $sql = "SELECT * FROM break_attendance WHERE emp_id='$search' AND `date` BETWEEN '$from' AND '$to' ORDER BY `id` DESC LIMIT $start, 10";
                            }
                            $result = mysqli_query($conn, $sql);
                            if (mysqli_num_rows($result)>0) {
                            $sNo = $start;
                            while($row = mysqli_fetch_assoc($result)) {

                            $sNo++;

                            $eid = $row['emp_id'];

                            $sqlquerys = "SELECT * FROM staff WHERE staff_id='$eid'";

                            $results = mysqli_query($conn, $sqlquerys);
                            $rows = mysqli_fetch_assoc($results);
                             $sqlCustomer = "SELECT * FROM `user` WHERE `staff_id`='$eid'";
                            $resCustomer = mysqli_query($conn, $sqlCustomer);
                            $rowCustomer = mysqli_fetch_assoc($resCustomer);
                            $f_name =  $rowCustomer['f_name'];
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
                                <td><?php echo $row['emp_id']?></td>
                                <td> <?php echo $f_name?> </td>
                                <td> <?php echo date('d-m-Y', strtotime($row['date']));?> </td>
                                <td> <?php $originalDateTime = $row['break_out'];
                                    $formattedDate = date("d-m-Y", strtotime($originalDateTime));
                                    $formattedTime = date("h:i A", strtotime($originalDateTime));
                                    echo $formattedDate . ' ' . $formattedTime;
                                    ?> </td>
                                <td><?php
                                    $originalDateTime = $row['break_in'];

                                    if ($originalDateTime == "0000-00-00 00:00:00") {
                                        echo "NA";
                                    } else {
                                        $formattedDate = date("d-m-Y", strtotime($originalDateTime));
                                        $formattedTime = date("h:i A", strtotime($originalDateTime));
                                        echo $formattedDate . ' ' . $formattedTime;
                                    }
                                    ?></td>
                                <td><?php
                                    $logTime = date("H:i:s", strtotime($row['break_out']));
                                    $a = date("H:i:s", strtotime($row['break_in']));

                                    $aa = strtotime($a);
                                    $bb = strtotime($logTime);

                                    $diff = $aa - $bb;

                                    $formattedDiff = gmdate("H:i:s", abs($diff));
                                    if($row['logout']=='0000-00-00 00:00:00'&&$row['date_time'] == $currentDate){
                                        echo'-';
                                    }else {


                                        if ($formattedDiff == "00:00:00") {
                                            echo 'NA';
                                        } else {
                                            echo $formattedDiff;
                                        }
                                    }

                                    ?></td>
<!--                                <td style="background-color: --><?php
//                                $loginTime = new DateTime($row['break_out']);
//                                $logoutTime = new DateTime($row['break_in']);
//
//                                if ($row['break_in'] == "0000-00-00 00:00:00") {
//                                    echo '#f24444'; // Set color to red if break in is 000000
//                                } else {
//                                    $interval = $loginTime->diff($logoutTime);
//
//
//                                    $breakin = date("H:i:s", strtotime($row['break_in']));
//                                    $breakout = date("H:i:s", strtotime($row['break_out']));
//
//                                    $aa = strtotime($breakout);
//                                    $bb = strtotime($breakin);
//
//                                    $diff = $bb-$aa;
//
//                                    if ($diff > 900) {
//                                        echo '#f24444'; // Set color to red if the difference is more than 15 minutes
//                                    } else {
//                                        echo '#55ce63'; // Set color to green if the difference is 15 minutes or less
//                                    }
//                                }
//                                ?>
<!--                                ;color: whitesmoke">-->
                                <?php
//                                    $logoutTimes = $row['break_in'];
//                                    if ($logoutTimes != "0000-00-00 00:00:00") {
//                                        $minutes = $interval->h * 60 + $interval->i;
//                                        $seconds = $interval->s;
//
//                                        echo "$minutes : $seconds Min";
//                                    } elseif($logoutTimes == "0000-00-00 00:00:00") {
//                                        echo "NA";
//                                    }
//                                    ?><!--</td>-->

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
                                        $sql = "SELECT COUNT(id) as count FROM break_attendance WHERE `date` BETWEEN '$from' AND '$to' ";
                                    }
                                    else {
                                        $sql = "SELECT COUNT(id) as count FROM break_attendance WHERE emp_id='$search' AND `date` BETWEEN '$from' AND '$to'";
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




        <div class="modal custom-modal fade" data-bs-backdrop="static" data-keyboard="false" id="attendance" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="header">Add Attendance</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                        </button>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="manual">

                            <div class="input-block mb-3">
                                <label class="col-form-label">Employee ID <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="id" id="id" style="border-color: #181f5a;color: black">
                                <input class="form-control" type="hidden" name="type" id="type">
                                <input class="form-control" type="hidden" name="url" id="url">
                                <input class="form-control" type="hidden" name="lid" id="lid">
                                <!--                            <input class="form-control" type="hidden" name="url" id="url">-->
                            </div>
                            <!--                        <div class="input-block mb-3" style="visibility: hidden">-->
                            <!--                            <label class="col-form-label">Type<span class="text-danger">*</span></label>-->
                            <!--                            <input class="form-control" type="hidden" name="type" id="type">-->
                            <!---->
                            <!--                            <label id="type-error" class="error" for="type"></label>-->
                            <!--                        </div>-->
                            <div class="input-block mb-3">
                                <label>Date <span class="text-danger">*</span></label>
                                <div class="cal-icon"><input class="form-control datetimepicker" type="date" name="date" id="date" style="border-color: #181f5a;color: black"></div>
                            </div>
                            <!--                        <div class="input-block mb-3">-->
                            <!--                            <label class="col-form-label" id="timeat">Time <span class="text-danger">*</span></label>-->
                            <!--                            <div class="">-->
                            <!--                                <input class="form-control timepicker" type="text" name="time" id="time">-->
                            <!--                            </div>-->
                            <!--                        </div>-->


                            <div class="container">
                                <label class="col-form-label" >Login Time: <span class="text-danger">*</span></label>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="input-block mb-3">


                                            <label for="hours">Hours:</label>
                                            <select id="inhours" name="inhours" class="form-control" style="border-color: #181f5a;color: black">
                                                <option value="00">00</option>
                                                <option value="01">01</option>
                                                <option value="02">02</option>
                                                <option value="03">03</option>
                                                <option value="04">04</option>
                                                <option value="05">05</option>
                                                <option value="06">06</option>
                                                <option value="07">07</option>
                                                <option value="08">08</option>
                                                <option value="09">09</option>
                                                <option value="10">10</option>
                                                <option value="11">11</option>
                                                <option value="12">12</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="input-block mb-3">
                                            <label for="minutes">Minutes:</label>
                                            <select id="inminutes" name="inminutes" class="form-control" style="border-color: #181f5a;color: black">
                                                <option value="00">00</option>
                                                <option value="01">01</option>
                                                <option value="02">02</option>
                                                <option value="03">03</option>
                                                <option value="04">04</option>
                                                <option value="05">05</option>
                                                <option value="06">06</option>
                                                <option value="07">07</option>
                                                <option value="08">08</option>
                                                <option value="09">09</option>
                                                <option value="10">10</option>
                                                <option value="11">11</option>
                                                <option value="12">12</option>
                                                <option value="13">13</option>
                                                <option value="14">14</option>
                                                <option value="15">15</option>
                                                <option value="16">16</option>
                                                <option value="17">17</option>
                                                <option value="18">18</option>
                                                <option value="19">19</option>
                                                <option value="20">20</option>
                                                <option value="21">21</option>
                                                <option value="22">22</option>
                                                <option value="23">23</option>
                                                <option value="24">24</option>
                                                <option value="25">25</option>
                                                <option value="26">26</option>
                                                <option value="27">27</option>
                                                <option value="28">28</option>
                                                <option value="29">29</option>
                                                <option value="30">30</option>
                                                <option value="31">31</option>
                                                <option value="32">32</option>
                                                <option value="33">33</option>
                                                <option value="34">34</option>
                                                <option value="35">35</option>
                                                <option value="36">36</option>
                                                <option value="37">37</option>
                                                <option value="38">38</option>
                                                <option value="39">39</option>
                                                <option value="40">40</option>
                                                <option value="41">41</option>
                                                <option value="42">42</option>
                                                <option value="43">43</option>
                                                <option value="44">44</option>
                                                <option value="45">45</option>
                                                <option value="46">46</option>
                                                <option value="47">47</option>
                                                <option value="48">48</option>
                                                <option value="49">49</option>
                                                <option value="50">50</option>
                                                <option value="51">51</option>
                                                <option value="52">52</option>
                                                <option value="53">53</option>
                                                <option value="54">54</option>
                                                <option value="55">55</option>
                                                <option value="56">56</option>
                                                <option value="57">57</option>
                                                <option value="58">58</option>
                                                <option value="59">59</option>
                                                <option value="60">60</option>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="input-block mb-3">
                                            <label for="period">AM/PM:</label>
                                            <select id="inperiod" name="inperiod" class="form-control" style="border-color: #181f5a;color: black">
                                                <option value="AM">AM</option>
                                                <option value="PM">PM</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>




                            <div class="container" id="logouttiming">
                                <label class="col-form-label" >Logout Time: <span class="text-danger">*</span></label>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="input-block mb-3">


                                            <label for="hours">Hours:</label>
                                            <select id="hours" name="hours" class="form-control" style="border-color: #181f5a;color: black">
                                                <option value="00">00</option>
                                                <option value="01">01</option>
                                                <option value="02">02</option>
                                                <option value="03">03</option>
                                                <option value="04">04</option>
                                                <option value="05">05</option>
                                                <option value="06">06</option>
                                                <option value="07">07</option>
                                                <option value="08">08</option>
                                                <option value="09">09</option>
                                                <option value="10">10</option>
                                                <option value="11">11</option>
                                                <option value="12">12</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="input-block mb-3">
                                            <label for="minutes">Minutes:</label>
                                            <select id="minutes" name="minutes" class="form-control" style="border-color: #181f5a;color: black">
                                                <option value="00">00</option>
                                                <option value="01">01</option>
                                                <option value="02">02</option>
                                                <option value="03">03</option>
                                                <option value="04">04</option>
                                                <option value="05">05</option>
                                                <option value="06">06</option>
                                                <option value="07">07</option>
                                                <option value="08">08</option>
                                                <option value="09">09</option>
                                                <option value="10">10</option>
                                                <option value="11">11</option>
                                                <option value="12">12</option>
                                                <option value="13">13</option>
                                                <option value="14">14</option>
                                                <option value="15">15</option>
                                                <option value="16">16</option>
                                                <option value="17">17</option>
                                                <option value="18">18</option>
                                                <option value="19">19</option>
                                                <option value="20">20</option>
                                                <option value="21">21</option>
                                                <option value="22">22</option>
                                                <option value="23">23</option>
                                                <option value="24">24</option>
                                                <option value="25">25</option>
                                                <option value="26">26</option>
                                                <option value="27">27</option>
                                                <option value="28">28</option>
                                                <option value="29">29</option>
                                                <option value="30">30</option>
                                                <option value="31">31</option>
                                                <option value="32">32</option>
                                                <option value="33">33</option>
                                                <option value="34">34</option>
                                                <option value="35">35</option>
                                                <option value="36">36</option>
                                                <option value="37">37</option>
                                                <option value="38">38</option>
                                                <option value="39">39</option>
                                                <option value="40">40</option>
                                                <option value="41">41</option>
                                                <option value="42">42</option>
                                                <option value="43">43</option>
                                                <option value="44">44</option>
                                                <option value="45">45</option>
                                                <option value="46">46</option>
                                                <option value="47">47</option>
                                                <option value="48">48</option>
                                                <option value="49">49</option>
                                                <option value="50">50</option>
                                                <option value="51">51</option>
                                                <option value="52">52</option>
                                                <option value="53">53</option>
                                                <option value="54">54</option>
                                                <option value="55">55</option>
                                                <option value="56">56</option>
                                                <option value="57">57</option>
                                                <option value="58">58</option>
                                                <option value="59">59</option>
                                                <option value="60">60</option>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="input-block mb-3">
                                            <label for="period">AM/PM:</label>
                                            <select id="period" name="period" class="form-control" style="border-color: #181f5a;color: black">
                                                <option value="AM">AM</option>
                                                <option value="PM">PM</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>






                            <div class="submit-section">
                                <button class="btn btn-primary submit-btn" id="add">Submit</button>
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

    $(document).on("click", ".excel_download", function () {
        window.location.href = "excel_download.php?from=<?php echo $from?>&to=<?php echo $to?>&search=<?php echo $search?>";
    });



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
