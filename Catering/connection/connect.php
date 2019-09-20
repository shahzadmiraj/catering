<?php
/**
 * Created by PhpStorm.
 * User: shahzadmiraj
 * Date: 2019-09-01
 * Time: 21:25
 */
session_start();
date_default_timezone_set("asia/karachi");
$connect=mysqli_connect('localhost',"root","","a111");
//$connect=mysqli_connect("localhost","id10884474_shahzad","11111","id10884474_catering");
    if(!$connect)
    {
        echo "fail connection";
    }
    if (mysqli_connect_errno())
    {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }


function queryReceive($sql)
{
    global $connect;
    $result = mysqli_query($connect, $sql);
    if (!$result)
    {
        echo $sql;
        echo("Error description: " . mysqli_error($connect));
    }else
        {
        return mysqli_fetch_all($result);
    }
}


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



function chechIsEmpty($value)
{
    if($value=="")
    {
        return 0;
    }
    return $value;
}
function arrayCheckIsEmpty($valuesArray)
{
    for ($a=0;$a<count($valuesArray);$a++)
    {
        if($valuesArray[$a]=="")
        {
            $valuesArray[$a]=0;
        }
    }
    return $valuesArray;
}

function ImageUploaded($File,$DestinationFile)
{
    if(isset($File['image']))//         name=image
    {

        $errors= array();

        $file_size = $File['image']['size'];
        $file_tmp = $File['image']['tmp_name'];
        $file_type = $File['image']['type'];
        $passbyreference=explode('.',$File['image']['name']);
        $file_ext=strtolower(end($passbyreference));

        $extensions= array("jpeg","jpg","png");

        if(in_array($file_ext,$extensions)=== false){
            $errors[]="extension not allowed, please choose a JPEG or PNG file.";
        }

        if($file_size > 2097152)
        {
            $errors[]='File size must be excately 2 MB';
        }

//        if (file_exists($DestinationFile))
//        {
//            $errors[]= "Sorry, file already exists.";
//        }

        if(empty($errors)==true)
        {
            move_uploaded_file($file_tmp,$DestinationFile);
            return "";
        }else{
             return $errors;
        }
    }
    return "";


}

?>