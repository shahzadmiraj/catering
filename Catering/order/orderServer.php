<?php
/**
 * Created by PhpStorm.
 * User: shahzadmiraj
 * Date: 2019-09-05
 * Time: 17:56
 */


include_once ("../connection/connect.php");
session_start();
$userid=$_SESSION['userid'];

function querySend($sql)
{
    global $connect;
    $result = mysqli_query($connect, $sql);
    if (!$result)
    {
        echo $sql;
        echo("Error description: " . mysqli_error($connect));
    }
}

if(!isset($_POST['function']))
{
    echo "option in order is not created";
    exit();
}
$customerId=$_GET['customer'];
if($_POST['function']=="add")
{
    $persons=$_POST['persons'];
    $time=$_POST['time'];
    $date=$_POST['date'];
    $area=$_POST['area'];
    $streetno=$_POST['streetno'];
    $houseno=$_POST['houseno'];
    $describe=$_POST['describe'];
    $currentDate=date('Y-m-d');
    $CurrenttimeDate = date('Y-m-d H:i:s');
    $sql='INSERT INTO `address`(`id`, `address_street_no`, `address_house_no`, `person_id`, `address_city`, `address_town`) VALUES (NULL,"'.$streetno.'","'.$houseno.'","'.$customerId.'","lahore","'.$area.'")';
    querySend($sql);
    $address_id=mysqli_insert_id($connect);
    $sql='INSERT INTO `orderTable`(`id`, `total_amount`, `order_comments`, `total_person`, `is_active`, `destination_date`, `booking_date`, `destination_time`, `address_id`, `extre_charges`, `person_id`) VALUES (NULL,0,"'.$describe.'","'.$persons.'",0,"'.$date.'","'.$currentDate.'","'.$time.'","'.$address_id.'",0,"'.$customerId.'")';
    querySend($sql);
    $ordeID=mysqli_insert_id($connect);
    //$sql='INSERT INTO `change_status`(`id`, `orderTable_id`, `order_status_id`, `user_id`, `dateTime`) VALUES (NULL,'.$ordeID.',1,'.$userid.',"'.$CurrenttimeDate.'")';
    //querySend($sql);



    echo json_decode($ordeID);
}

?>