<?php
/**
 * Created by PhpStorm.
 * User: shahzadmiraj
 * Date: 2019-09-15
 * Time: 13:36
 */
session_start();
session_destroy();

setcookie('userid',"" , time() - (86400 * 30), "/");
setcookie("isOwner","",time() - (86400 * 30), "/");
setcookie("username","",time() - (86400 * 30), "/");
header("location:userLogin.php");
exit();
?>