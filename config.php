<?php
/**
 * Created by PhpStorm.
 * User: fhasanli
 * Date: 12/13/2018
 * Time: 3:20 PM
 */

define('host','localhost');
define('username','root');
define('password','');
define('db_name','lottery');

function connect(){
    global $db;
    $db=mysqli_connect(host,username,password, db_name) or die(mysqli_error() );
    return $db;
}
connect();
mysqli_query($db,"set names utf8");
//mysqli_set_charset($link, "utf8")
ini_set('max_execution_time', 300);
ini_set('memory_limit', '-1');

function safe($value,$strip=true)
{
    global $db;
    $value=trim($value);
    $value=htmlentities( $value, ENT_QUOTES, 'utf-8' );
    if($strip==true) $value=strip_tags($value);
    $value=mysqli_real_escape_string($db,$value);
    $from=array('\\', "\0", "\n", "\r", "'", '"', "\x1a", "\x00","\x0B"); $to=array('\\\\', '\\0', '\\n', '\\r', "\\'", '\\"', '\\Z',"\\0","");
    $value=str_replace($from, $to, $value);
    return $value;
}