<?php
/**
 * Created by PhpStorm.
 * User: shahzadmiraj
 * Date: 2019-09-11
 * Time: 16:25
 */
include_once ("../../connection/connect.php");
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
    if($_POST["option"]=="addDishsystem")
    {
        $dishname=$_POST['dishname'];
        $dishimage=$_POST['dishimage'];
        $addAttributes=$_POST['attribute'];
        $dishtype=$_POST["dishtype"];
        $sql='INSERT INTO `dish`(`name`, `id`, `image`, `dish_type_id`, `isExpire`) VALUES ("'.$dishname.'",NULL,"'.$dishimage.'",'.$dishtype.',NULL)';
        querySend($sql);
        $dishid=mysqli_insert_id($connect);
        for($i=0;$i<count($addAttributes);$i++)
        {
            $sql='INSERT INTO `attribute`(`name`, `id`, `dish_id`, `isExpire`) VALUES ("'.$addAttributes[$i].'",NULL,'.$dishid.',NULL)';
            querySend($sql);
        }


    }
    else if($_POST['option']=="attributesCreate")
    {
        $dishid=$_POST["dishid"];
        $addAttributes=$_POST['attribute'];
        for($i=0;$i<count($addAttributes);$i++)
        {
            $sql='INSERT INTO `attribute`(`name`, `id`, `dish_id`, `isExpire`) VALUES ("'.$addAttributes[$i].'",NULL,'.$dishid.',NULL)';
            querySend($sql);
        }
    }
    else if($_POST['option']=="dishchanges")
    {
        $dishid=$_POST['dishid'];
        $column=$_POST['column'];
        $text=$_POST['text'];
        $sql='UPDATE `dish` SET '.$column.'="'.$text.'" WHERE id='.$dishid.'';
        querySend($sql);
    }
    else if($_POST['option']=='changeAttributes')
    {
        $attributeid=$_POST['attributeid'];
        $text=$_POST['text'];
        $sql='UPDATE `attribute` SET `name`="'.$text.'" WHERE id='.$attributeid.'';
        querySend($sql);
    }
    else if($_POST['option']=="RemoveAttribute")
    {
        $attributeid=$_POST['attributeid'];
        $timestamp = date('Y-m-d H:i:s');
        $sql='UPDATE attribute as a SET a.isExpire="'.$timestamp.'" WHERE a.id='.$attributeid.'';
        querySend($sql);
    }
    else if($_POST['option']=="ExpireDish")
    {
        $timestamp = date('Y-m-d H:i:s');
        $dishid=$_POST['dishid'];
        $value=$_POST['value'];
        if($value=="Show dish")
        {
            $sql='UPDATE dish as d SET d.isExpire=NULL  WHERE d.id='.$dishid.'';
        }
        else
        {
            $sql='UPDATE dish as d SET d.isExpire="'.$timestamp.'"  WHERE d.id='.$dishid.'';
        }

        querySend($sql);
    }
    else if($_POST['option']=="changeDishType")
    {
        $id=$_POST['id'];
        $value=$_POST['value'];
        $sql='UPDATE dish_type as dt SET dt.name="'.$value.'" WHERE dt.id='.$id.'';
        querySend($sql);
    }
    else if($_POST['option']=="Delele_Dish_Type")
    {
        $id=$_POST['id'];
        $value=$_POST['value'];
        if($value=="Disable")
        {
            $timestamp = date('Y-m-d H:i:s');
            $sql = 'UPDATE dish_type as dt SET dt.isExpire="' . $timestamp . '" WHERE dt.id=' . $id . '';
        }
        else
        {

            $sql = 'UPDATE dish_type as dt SET dt.isExpire=NULL WHERE dt.id=' . $id . '';
        }
        querySend($sql);
    }
    else if($_POST['option']=="addDishtype")
    {
        $value=$_POST['value'];
        $sql='INSERT INTO `dish_type`(`id`, `name`, `isExpire`) VALUES (NULL,"'.$value.'",NULL)';
        querySend($sql);
    }
}


?>