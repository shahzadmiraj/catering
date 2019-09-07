<?php
/**
 * Created by PhpStorm.
 * User: shahzadmiraj
 * Date: 2019-09-05
 * Time: 13:39
 */
session_start();
include_once ("../connection/connect.php");

function querySend($sql)
{
    global $connect;
    $result = mysqli_query($connect, $sql);
    if (!$result) {
        echo("Error description: " . mysqli_error($connect));
    }
}

if(isset($_POST['option']))
{

    if($_POST['option']=="change")
    {

        if (isset($_SESSION['customer']))
        {
            $customerId = $_SESSION['customer'];
            $column_name = $_POST['columnname'];
            $text = $_POST['value'];
            $number_table = $_POST['edittype'];
            if ($number_table == 1) {
                //address table change
                $sql = 'UPDATE address as a SET a.' . $column_name . '="' . $text . '" WHERE a.person_id=' . $customerId . ' ';
                querySend($sql);
            } else if ($number_table == 2) {
                //person change table change
                $sql = 'UPDATE person as p SET p.' . $column_name . '="' . $text . '" WHERE p.id=' . $customerId . ' ';
                querySend($sql);
            } else if ($number_table == 3) {
                //number table change
                $numberId = $_POST['id'];
                $sql = 'UPDATE number as n SET n.' . $column_name . '="' . $text . '" WHERE (n.person_id=' . $customerId . ') AND (n.id=' . $numberId . ')';
                querySend($sql);
            }


        }
    }
    else if($_POST['option']=="deleteNumber")
    {

        $id=$_POST['id'];
        $sql='DELETE FROM number  WHERE id='.$id.'';
        querySend($sql);
    }
    else if($_POST['option']=="addNumber")
    {
        if (isset($_SESSION['customer']))
        {
            $customerId = $_SESSION['customer'];
            $numberText=$_POST['number'];
            $sql='INSERT INTO `number`(`number`, `id`, `is_number_active`, `person_id`) VALUES ('.$numberText.',NULL,1,'.$customerId.')';
            querySend($sql);
        }
    }
}

?>