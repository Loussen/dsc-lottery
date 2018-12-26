<?php
    require_once "config.php";

    $response = json_encode(array("code"=>0, "content" => "Error system", "err_param" => ''));

    if($_POST)
    {
        if(isset($_POST['msisdn']) && !empty($_POST['msisdn']))
        {
            $msisdn = safe($_POST['msisdn']);

            $info=mysqli_fetch_assoc(mysqli_query($db,"select `company`,`fullname` from `users` where `phone1`='$msisdn' or `phone2`='$msisdn'"));

            $response = json_encode(array("code"=>1, "name" => $info['fullname'], "company" => $info['company']));
        }
    }

    echo $response;
?>