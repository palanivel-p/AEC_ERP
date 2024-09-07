<?php
Include("../../includes/connection.php");

if(isset($_POST['pwd'])) {

    $id = $_COOKIE["emp_id"];

    $password = clean($_POST['pwd']);


    $salt= 'NbTMUcflGKePnFi';
    $password_salt = sha1($salt.$password);







    $sqlValidate="SELECT * FROM `staff` WHERE staff_id='$id' AND password='$password_salt' AND status=1 ";
    $resValidate=mysqli_query($conn,$sqlValidate);

    if(mysqli_num_rows($resValidate)> 0)
    {
        $row = mysqli_fetch_array($resValidate);



        $info = urlencode("Password verified");
        $id = urlencode($id); // Assuming $id is a variable with the emp_id value

        $url = "https://gbtc.officetime.in/include/activity_log.php?message=$info&emp_id=$id";

        file_get_contents($url);





        $json_array['status'] = "success";
        $json_array['msg'] = "success";
//
        $json_response = json_encode($json_array);
        echo $json_response;

    }
    else
    {


        $json_array['status'] = "failure";
        $json_array['msg'] = "Invalid Password!!!";

        $json_response = json_encode($json_array);
        echo $json_response;
    }


}
else
{
    //Parameters missing

    $json_array['status'] = "failure";
    $json_array['msg'] = "Parameters missing!!!";

    $json_response = json_encode($json_array);
    echo $json_response;
}



function clean($data) {
    $data= str_replace("'","",$data);
    $data= str_replace('"',"",$data);
    return filter_var($data, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
};
?>