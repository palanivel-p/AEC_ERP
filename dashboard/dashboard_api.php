<?php
if(isset($_POST['panel_api_key']))
{
    Include("../includes/conn.php");
    include("../includes/conn1.php");


    $panel_api_key = $_POST['panel_api_key'];
    $api_key = $_COOKIE['panel_api_key'];
    $added_by = $_COOKIE['staff_id'];


//    $sqlValidateCookie="SELECT * FROM `staff` WHERE staff_id='$added_by'";
//    $resValidateCookie=mysqli_query($conn1,$sqlValidateCookie);
//    if(mysqli_num_rows($resValidateCookie) > 0)
//    {
        $sqlDevice= "SELECT COUNT(id) as count FROM `device_inventory`";
        $resultDevice = mysqli_query($conn, $sqlDevice);
        $rowDevice = mysqli_fetch_assoc($resultDevice);
        $totalDevice = $rowDevice['count'];

        $sqlSim= "SELECT COUNT(id) as count FROM `sim_inventory`";
        $resultSim = mysqli_query($conn, $sqlSim);
        $rowSim = mysqli_fetch_assoc($resultSim);
        $totalSim = $rowSim['count'];

        $sqlFastag= "SELECT COUNT(id) as count FROM `fastag_inventory`";
        $resultFastag = mysqli_query($conn, $sqlFastag);
        $rowFastag = mysqli_fetch_assoc($resultFastag);
        $totalFastag = $rowFastag['count'];

        $sqlRenewal= "SELECT COUNT(id) as count FROM `renewal_history`";
        $resultRenewal = mysqli_query($conn, $sqlRenewal);
        $rowRenewal = mysqli_fetch_assoc($resultRenewal);
        $totalRenewal = $rowRenewal['count'];
//        $sqlData="SELECT * FROM `sim_inventory` WHERE id='$id'";
//        $resData=mysqli_query($conn2,$sqlData);
//        mysqli_num_rows($resData) ;
//        if(mysqli_num_rows($resData) > 0)
//        {
//            $row = mysqli_fetch_array($resData);

            $json_array['status'] = 'success';
            $json_array['totalDevice'] = $totalDevice;
            $json_array['totalSim'] = $totalSim;
            $json_array['totalFastag'] = $totalFastag;
            $json_array['totalRenewal'] = $totalRenewal;


//            $allow_allocation='false';
//
//            $sqlMobile="SELECT `id` FROM `device_inventory` WHERE `device_mobile`='$mobile_no'";
//            $resMobile=mysqli_query($conn2,$sqlMobile);
//            if(mysqli_num_rows($resMobile) > 0)
//            {
//                $allow_allocation='true';
//            }
//
//            $json_array['allow_allocation'] = $allow_allocation;

            $json_response = json_encode($json_array);
            echo $json_response;
//        }


//    }
//    else
//    {
//        //staff id already exist
//
//        $json_array['status'] = "wrong";
//        $json_array['msg'] = "Invalid API key !!!";
//        $json_response = json_encode($json_array);
//        echo $json_response;
//    }
}
else
{
    //Parameters missing

    $json_array['status'] = "failure";
    $json_array['msg'] = "Please try after sometime !!!";
    $json_response = json_encode($json_array);
    echo $json_response;
}




?>
