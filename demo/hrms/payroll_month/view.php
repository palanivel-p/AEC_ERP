<?php
header('Access-Control-Allow-Origin: *');
Include("../../includes/connection.php");
if(isset($_POST['payroll_id'])){

    $payroll_id =$_POST['payroll_id'];

    $sqlquery = "SELECT * FROM `payroll_month` WHERE payroll_id='$payroll_id'";
    $result = mysqli_query($conn,$sqlquery);
    if(mysqli_num_rows($result) > 0)
    {
        $row = mysqli_fetch_array($result);




        $json_array['status'] = 'success';
        $json_array['payroll_month'] = $row['payroll_month'];
        $json_array['payroll_days'] = $row['payroll_days'];
        $json_array['payroll_id'] = $row['payroll_id'];



        $json_response = json_encode($json_array);
        echo $json_response;
    } else
    {
        //staff id already exist
        $json_array['status'] = "failure";
        $json_array['msg'] = "Invalid Payroll Month ID !!!";
        $json_response = json_encode($json_array);
        echo $json_response;
    }


}
else
{


    $json_array['status'] = "failure";
    $json_array['msg'] = "Please try after sometime !!!";
    $json_response = json_encode($json_array);
    echo $json_response;
}
?>
