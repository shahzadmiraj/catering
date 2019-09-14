<?php
/**
 * Created by PhpStorm.
 * User: shahzadmiraj
 * Date: 2019-09-05
 * Time: 22:10
 */


include_once ("../connection/connect.php");
session_start();
function querySend($sql)
{
    global $connect;
    $result = mysqli_query($connect, $sql);
    if (!$result)
    {
        echo  $sql;
        echo("Error description: " . mysqli_error($connect));
    }
}

if($_POST['option']=="orderChange")
{
    $columnName=$_POST['column_name'];
    $coumnText=$_POST['value'];
    $orderId=$_POST['orderid'];
    $sql='UPDATE `orderTable` SET '.$columnName.'="'.$coumnText.'" WHERE id='.$orderId.'';
    querySend($sql);
}
else if($_POST['option']=="addressChange")
{
    $columnName=$_POST['column_name'];
    $coumnText=$_POST['value'];
    $addressId=$_POST['addressId'];
    $sql='UPDATE `address` SET '.$columnName.'="'.$coumnText.'" WHERE id='.$addressId.'';
    querySend($sql);
}
else if($_POST['option']=="orderstatus")
{
        $orderstatusid=$_POST['orderstatusid'];
        $orderid=$_POST['orderid'];
        $dataTime=date('Y-m-d H:i:s');
        $sql='INSERT INTO `change_status`(`id`, `orderTable_id`, `order_status_id`, `user_id`, `dateTime`) VALUES (NULL,'.$orderid.','.$orderstatusid.','.$_SESSION['userid'].',"'.$dataTime.'")';
        querySend($sql);
}

?>