<?php
/**
 * Created by PhpStorm.
 * User: shahzadmiraj
 * Date: 2019-09-03
 * Time: 17:20
 */

include_once ("../connection/connect.php");

if(isset($_POST['option']))
{
    if($_POST['option']=="customerCreate")
    {
        $name = trim($_POST['name']);
        $numberArray = $_POST['number'];
        $cnic = $_POST['cnic'];
        $city = $_POST['city'];
        $area = $_POST['area'];
        $streetNo = $_POST['streetNo'];
        $houseNo = $_POST['houseNo'];
        $date = date('Y-m-d');
        $sql = 'INSERT INTO `person`(`name`, `cnic`, `id`, `date`) VALUES ("' . $name . '","' . $cnic . '",NULL,"' . $date . '")';
        querySend($sql);
        $last_id = mysqli_insert_id($connect);
        $sql='INSERT INTO `address`(`id`, `address_street_no`, `address_house_no`, `person_id`, `address_city`, `address_town`) VALUES (NULL,"'.$streetNo.'","'.$houseNo.'",'.$last_id.',"'.$city.'","'.$area.'")';
        querySend($sql);
        for ($i = 0; $i < count($numberArray); $i++) {

            $sql='INSERT INTO `number`(`number`, `id`, `is_number_active`, `person_id`) VALUES ("'.$numberArray[$i].'",NULL,1,'.$last_id.')';
            querySend($sql);
        }
        $customerId = $last_id;
        echo json_decode($customerId);
    }
    else if($_POST['option']=="customerExist")
    {

        $value=$_POST['value'];
            $sql='SELECT  n.person_id FROM number as n WHERE n.number="'.$value.'"';
            $customerexist=queryReceive($sql);
            if(count($customerexist)>0)
            {
                echo $customerexist[0][0];
            }


    }
}

?>