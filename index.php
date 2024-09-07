<?php

if($_COOKIE["panel_api_key"]=='')
{

    header("Location:login?logout=1");
}
else
{
    header("Location: dashboard/");
}

?>

