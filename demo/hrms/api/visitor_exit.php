
<?php
date_default_timezone_set("Asia/Kolkata");

header('Access-Control-Allow-Origin: *');
if(isset($_GET['qr_code'])&&isset($_GET['api_key']) ) {
    $qr_code = clean($_GET['qr_code']);
    $api_key = clean($_GET['api_key']);

    $date = clean(date("Y-m-d H:i:s"));

    Include("../../includes/connection.php");
    $sqlquery = "select * from devices where api_key='$api_key'";
    $result = mysqli_query($conn, $sqlquery);

    if (mysqli_num_rows($result) > 0) {


        $sqlValidate = "SELECT * FROM `visitor_details` WHERE qr_code='$qr_code' ";
        $resValidate = mysqli_query($conn, $sqlValidate);

        if (mysqli_num_rows($resValidate) > 0) {


            $row = mysqli_fetch_assoc($resValidate);

            if($row['exit_dt'] =='0000-00-00 00:00:00') {

                $sqlInsert = "UPDATE `visitor_details` SET `exit_dt`='$date' WHERE qr_code='$qr_code'  ";
                mysqli_query($conn, $sqlInsert);
            }

            $json_array['status'] = "success";
            $json_array['msg'] = "success";
            $json_response = json_encode($json_array);
            echo $json_response;

        } else {
            //staff id already exist

            $json_array['status'] = "failure";
            $json_array['msg'] = "Invalid Login Details !!!";
            $json_response = json_encode($json_array);
            echo $json_response;
        }


    } else {
        //Parameters missing

        $json_array['status'] = "failure";
        $json_array['msg'] = "invalid device !!!";
        $json_response = json_encode($json_array);
        echo $json_response;
    }
}
else
{
    //Parameters missing

    $json_array['status'] = "failure";
    $json_array['msg'] = "Parameter Missing !!!";
    $json_response = json_encode($json_array);
    echo $json_response;
}



function clean($data) {
    $data= str_replace("'","",$data);
    $data= str_replace('"',"",$data);
    return filter_var($data, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
}
?>