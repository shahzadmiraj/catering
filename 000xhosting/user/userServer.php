<?php
/**
 * Created by PhpStorm.
 * User: shahzadmiraj
 * Date: 2019-09-10
 * Time: 11:50
 */

include_once ("../connection/connect.php");
session_start();

if(isset($_POST["option"]))
{
    if($_POST['option']=="login")
    {
        $userName=$_POST['username'];
        $password=$_POST['password'];
        $sql='SELECT u.id,u.isOwner FROM user as u WHERE (u.username="'.$userName.'")AND(u.password="'.$password.'")';
        $userDetail=queryReceive($sql);
        if(count($userDetail)==0)
        {
            echo "please user is not registerd";
        }
        else
        {

            $_SESSION['userid']=$userDetail[0][0];
            $_SESSION['isOwner']=$userDetail[0][1];
            $_SESSION['username']=$userName;


        }
    }
}





?>