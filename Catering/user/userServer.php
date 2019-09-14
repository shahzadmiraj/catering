<?php
/**
 * Created by PhpStorm.
 * User: shahzadmiraj
 * Date: 2019-09-10
 * Time: 11:50
 */

include_once ("../connection/connect.php");
session_start();
function queryReceive($sql)
{
    global $connect;
    $result = mysqli_query($connect, $sql);
    if (!$result) {
        echo("Error description: " . mysqli_error($connect));
    }else{
        return mysqli_fetch_all($result);
    }
}

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
            //one day
            setcookie("userName",$userName,time()+86400);
            setcookie("userid",$userDetail[0][0],time()+86400);
            $_SESSION['userid']=$userDetail[0][0];
            $_SESSION['isOwner']=$userDetail[0][1];

        }
    }
}





?>