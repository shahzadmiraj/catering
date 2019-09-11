<?php
/**
 * Created by PhpStorm.
 * User: shahzadmiraj
 * Date: 2019-09-03
 * Time: 17:20
 */
//session_start();
include_once ("../connection/connect.php");


    //new customer is created;

//if(!isset($_SESSION['customer']))
//{
    $name = trim($_POST['name']);
    //array of numbers
    $numberArray = $_POST['number'];
    $cnic = $_POST['cnic'];
    $city = $_POST['city'];
    $area = $_POST['area'];
    $streetNo = $_POST['streetNo'];
    $houseNo = $_POST['houseNo'];
    //$timestamp = date('Y-m-d G:i:s');
    $date = date('Y-m-d');
    $sql = "INSERT INTO `person`(`name`, `cnic`, `date`) VALUES ('$name','$cnic','$date')";
    $result = mysqli_query($connect, $sql);
    if (!$result) {
        echo("Error description: " . mysqli_error($connect));
    }
    $last_id = mysqli_insert_id($connect);
    $sql = "INSERT INTO `address`(`id`, `address_city`, `address_town`, `address_street_no`, `address_house_no`, `person_id`) VALUES (NULL,'$city','$area',$streetNo,$houseNo,$last_id)";
    $result = mysqli_query($connect, $sql);
    if (!$result) {
        echo("Error description: " . mysqli_error($connect));
    }

    foreach ($numberArray as $key => $value) {

        $sql = "INSERT INTO `number`(`number`, `id`, `is_number_active`, `person_id`) VALUES ('$value',NULL,1,$last_id)";
        $result = mysqli_query($connect, $sql);
        if (!$result) {
            echo("Error description: " . mysqli_error($connect));
        }
    }
    $customerId=$last_id;
    echo  json_decode($customerId);
//}
?>