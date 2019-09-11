<?php
/**
 * Created by PhpStorm.
 * User: shahzadmiraj
 * Date: 2019-09-05
 * Time: 17:56
 */


include_once ("../connection/connect.php");
session_start();

function querySend($sql)
{
    global $connect;
    $result = mysqli_query($connect, $sql);
    if (!$result) {
        echo("Error description: " . mysqli_error($connect));
    }
}
//if(!$_SESSION['customer'])
//{
//    echo "session customer is not created";
//    exit();
//}
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
    $sql='INSERT INTO `address`(`address_city`, `address_town`, `address_street_no`, `address_house_no`, `person_id`) VALUES ("lahore","'.$area.'",'.$streetno.','.$houseno.',NULL)';
    querySend($sql);
    $address_id=mysqli_insert_id($connect);
    //$customerId=$_SESSION['customer'];

    $sql='INSERT INTO `orderTable`(`id`, `total_amount`, `order_comments`, `total_person`, `is_active`, `destination_date`, `booking_date`, `destination_time`, `address_id`, `extre_charges`, `person_id`) VALUES (NULL,0,"'.$describe.'",'.$persons.',1,"'.$date.'","'.$currentDate.'","'.$time.'",'.$address_id.',0,'.$customerId.')';
    querySend($sql);
    //$_SESSION['order']=mysqli_insert_id($connect);
    $ordeID=mysqli_insert_id($connect);
    echo json_decode($ordeID);
}

?>