<?php
/**
 * Created by PhpStorm.
 * User: shahzadmiraj
 * Date: 2019-09-10
 * Time: 11:50
 */

include_once ("../connection/connect.php");


if(isset($_POST["option"]))
{
    if($_POST['option']=="login")
    {
        $userName=$_POST['username'];
        $password=$_POST['password'];
        $sql='SELECT u.id,u.isOwner,u.company_id,(SELECT p.image FROM person as p WHERE p.id=u.person_id) FROM user as u WHERE (u.username="'.$userName.'")AND(u.password="'.$password.'")';
        $userDetail=queryReceive($sql);
        if(count($userDetail)==0)
        {
            echo "please user is not registerd";
        }
        else
        {


           /* setcookie('userid',$userDetail[0][0] , time() + (86400 * 30), "/");
            setcookie("isOwner",$userDetail[0][1],time() + (86400 * 30), "/");
            setcookie("username",$userName,time() + (86400 * 30), "/");
            setcookie("companyid",$userDetail[0][2],time() + (86400 * 30), "/");
            setcookie("userimage",$userDetail[0][3],time() + (86400 * 30), "/");
            $_SESSION['userid']=$_COOKIE['userid'];
            $_SESSION['isOwner']=$_COOKIE['isOwner'];
            $_SESSION['username']=$_COOKIE['username'];
            $_SESSION['companyid']=$_COOKIE['companyid'];
            $_SESSION['userimage']=$_COOKIE['userimage'];*/

            $_SESSION['userid']=$userDetail[0][0];
            $_SESSION['isOwner']=$userDetail[0][1];
            $_SESSION['username']=$userName;
            $_SESSION['companyid']=$userDetail[0][2];
            $_SESSION['userimage']=$userDetail[0][3];
        }
    }
}





?>