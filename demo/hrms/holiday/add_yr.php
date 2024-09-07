<?php
Include("../../includes/connection.php");

date_default_timezone_set("Asia/Kolkata");   //India time (GMT+5:30)

if(isset($_POST['year']) && isset($_POST['nodays'])) {

    $year = clean($_POST['year']);
    $nodays = clean($_POST['nodays']);

    $id = 'Y' . $year;

    $sqlquery = "select * from holiday_years where `year`='$year'";
    $result = mysqli_query($conn, $sqlquery);

    if (mysqli_num_rows($result) == 0) {

         $sqlInsert = "INSERT INTO `holiday_years`(`year`, `year_name`, `year_id`) VALUES ('$year','$nodays','$id')";
        mysqli_query($conn, $sqlInsert);


        $json_array['status'] = "success";
        $json_array['msg'] = "Thank You !!!";

        $json_response = json_encode($json_array);
        echo $json_response;


    }else{

        $json_array['status'] = "failure";
        $json_array['msg'] = "Already registered";
        $json_response = json_encode($json_array);
        echo $json_response;
    }


}
else
{
    //Parameters missing


    $json_array['status'] = "failure";
    $json_array['msg'] = "Parameters Missing !!!";
    $json_response = json_encode($json_array);
    echo $json_response;
}




function clean($data) {
    $data= str_replace("'","",$data);
    $data= str_replace('"',"",$data);
    return filter_var($data, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
}
?>