<?php
/**
 * Created by PhpStorm.
 * User: fhasanli
 * Date: 12/26/2018
 * Time: 12:36 PM
 */

exit();

require_once "config.php";

$file = fopen("cs_attempts_new.txt","r");

while(!feof($file))
{
    $content = fgets($file);
    $array = explode(",",$content);
    list($number,$count) = $array;
//    $number=str_replace('"','',$number);
    $number=str_replace("'",'',$number);

    for($i=0;$i<$count;$i++)
    {
        $query = "INSERT INTO numbers (phone) VALUES ('$number')";
        mysqli_query($db, $query);
    }
}