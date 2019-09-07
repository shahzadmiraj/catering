<?php
/**
 * Created by PhpStorm.
 * User: shahzadmiraj
 * Date: 2019-09-01
 * Time: 21:25
 */
date_default_timezone_set("asia/karachi");
$connect=mysqli_connect('localhost',"root","","a111");
    if (mysqli_connect_errno())
    {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }
?>