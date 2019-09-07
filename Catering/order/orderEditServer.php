<?php
/**
 * Created by PhpStorm.
 * User: shahzadmiraj
 * Date: 2019-09-05
 * Time: 22:10
 */


include_once ("../connection/connect.php");
session_start();
if(!isset($_SESSION['order']))
{
    echo "order of session is not create";
    exit();
}
function querySend($sql)
{
    global $connect;
    $result = mysqli_query($connect, $sql);
    if (!$result) {
        echo("Error description: " . mysqli_error($connect));
    }
}
if(!isset($_POST['column_name']))
{
    echo "column is not set";
    exit();
}

$columnName=$_POST['column_name'];
$coumnText=$_POST['value'];
if($_POST['option']=="orderChange")
{
    $orderId=$_SESSION['order'];
    $sql='UPDATE `order` SET '.$columnName.'="'.$coumnText.'" WHERE id='.$orderId.'';
    querySend($sql);
}
else if($_POST['option']=="addressChange")
{
    $addressId=$_POST['addressId'];
    $sql='UPDATE `address` SET '.$columnName.'="'.$coumnText.'" WHERE id='.$addressId.'';
    querySend($sql);
}

?>