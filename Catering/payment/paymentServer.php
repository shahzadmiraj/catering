<?php
/**
 * Created by PhpStorm.
 * User: shahzadmiraj
 * Date: 2019-09-08
 * Time: 14:52
 */
include_once ("../connection/connect.php");
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
    if($_POST['option']=='GetPayment')
    {

        $name=$_POST['name'];
        $amount=$_POST['Amount'];
        $status=$_POST['status'];
        $rating=$_POST['rating'];
        $personality=$_POST['personality'];
        $userId=$_POST['user_id'];
        $orderTable_id=$_POST['orderTable_id'];
        $dateTime=date('Y-m-d H:i:s');;
        $sql='INSERT INTO `payment`(`id`, `amount`, `nameCustomer`, `receive`, `personality`, `rating`, `IsReturn`, `orderTable_id`, `user_id`, `sendingStatus`) VALUES (NULL,'.$amount.',"'.$name.'","'.$dateTime.'","'.$personality.'",'.$rating.','.$status.','.$orderTable_id.','.$userId.',0)';
        querySend($sql);
    }
}