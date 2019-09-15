<?php
/**
 * Created by PhpStorm.
 * User: shahzadmiraj
 * Date: 2019-09-15
 * Time: 13:36
 */
session_start();
session_destroy();
header("location:userLogin.php");
exit();
?>