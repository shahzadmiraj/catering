<?php
/**
 * Created by PhpStorm.
 * User: shahzadmiraj
 * Date: 2019-09-06
 * Time: 23:08
 */





include_once ("../connection/connect.php");
function querySend($sql)
{
    global $connect;
    $result = mysqli_query($connect, $sql);
    if (!$result) {
        echo("Error description: " . mysqli_error($connect));
    }
}
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

session_start();
if(!isset($_POST['option']))
{
    echo "option is not created";
    exit();
}
if(!isset($_SESSION['order']))
{
    echo "order is not create";
    exit();
}
$orderId=$_SESSION['order'];

if($_POST['option']=='createDish')
{
    $dishId=$_POST['dishId'];
    $attributesId=$_POST['attributeId'];
    $attributesValue=$_POST['attributeValue'];
    $each_price=$_POST['each_price'];
    $quantity=$_POST['quantity'];
    $describe=$_POST['describe'];
    $CurrentDateTime=date('Y-m-d H:i:s');
    $sql='INSERT INTO `dish_detail`(`id`, `describe`, `price`, `expire_date`, `quantity`, `dish_id`, `orderTable_id`)VALUES(NULL,"'.$describe.'",'.$each_price.',NULL,'.$quantity.','.$dishId.','.$orderId.')';
    querySend($sql);
    $dishDetailId=mysqli_insert_id($connect);
    for ($i=0;$i<count($attributesId);$i++)
    {
        $sql='INSERT INTO `attribute_name`(`id`, `quantity`, `attribute_id`, `dish_detail_id`) 
VALUES (NULL,'.$attributesValue[$i].','.$attributesId[$i].','.$dishDetailId.')';
        querySend($sql);
    }

}
else if($_POST["option"]=='attributeChange')
{
    $attributeid=$_POST['attributeid'];
    $valueAttribute=$_POST['value'];
    $sql='UPDATE attribute_name as an SET an.quantity ='.$valueAttribute.' WHERE an.id='.$attributeid.'';
    querySend($sql);
}
else if($_POST['option']=='dishDetailChange')
{
    $dishDetailId=$_POST['dishDetailId'];
    $columnName=$_POST['columnName'];
    $columnValue=$_POST['columnValue'];
    $sql='UPDATE dish_detail as dd SET dd.'.$columnName.'="'.$columnValue.'" WHERE dd.id='.$dishDetailId.'';
    querySend($sql);
    echo $sql;
}
else if($_POST['option']=='deleteDish')
{
    $dishDetailId=$_POST['dishDetailId'];
    $currentDate=date('Y-m-d H:i:s');
    $sql='UPDATE dish_detail as dd SET dd.expire_date="'.$currentDate.'"  WHERE dd.id='.$dishDetailId.'';
    querySend($sql);

}