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
function showarray($arrays)
{
    echo '<pre>';
    print_r($arrays);
    echo '</pre>';
}
function reArray($file_post)
{
    $file_ary=array();
    $file_count=count($file_post['name']);
    $file_key=array_keys($file_post);
    for ($i=0;$i<$file_count;$i++)
    {
        foreach ($file_key as $key)
        {
            $file_ary[$i][$key]=$file_post[$key][$i];
        }
    }
    return $file_ary;
}

function MutipleUploadFile($File,$DestinationFile)
{
        $errors= array();

        $file_size = $File['size'];
        $file_tmp = $File['tmp_name'];
        $file_type = $File['type'];
        $passbyreference=explode('.',$File['name']);
        $file_ext=strtolower(end($passbyreference));

        $extensions= array("jpeg","jpg","png","mp4");

        if(in_array($file_ext,$extensions)=== false){
            $errors[]="extension not allowed, please choose a JPEG or PNG file or MP4 or JPEG.";
        }

        if($file_size > 10097152)
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
            return $errors;
        }else{
            return $errors;
        }



}
    function showGallery($sql)
    {
        $result=queryReceive($sql);

        $source='';
        $display='';
        $extensions= array("jpeg","jpg","png");
        for($k=0;$k<count($result);$k++)
        {
            if(file_exists($result[$k][1]))
            {


                $passbyreference = explode('.', $result[$k][1]);
                $file_ext = strtolower(end($passbyreference));

                if (in_array($file_ext, $extensions) === true) {
                    //image file

                    $display .= '
                        <div class="col-lg-4 col-md-6 col-12 mb-2 mt-2">
                            <a href="#" class="d-block mb-4 h-100">
                                <img class="img-fluid img-thumbnail" src="' . $result[$k][1] . '" alt="">
                            </a>
                        </div>';
                } else {
                    //video file

                    $source = $result[$k][1];
                    $video = substr_replace($source, "", -4);
                    $display .= '
                         
                          <div class="col-lg-4 col-md-6 col-12 mb-2 mt-2">
                                <div class="embed-responsive embed-responsive-16by9 d-block mb-4 h-100">
                                    <video width="320" height="440" controls class="card"  >
                                        <source src="' . $video . '.mp4" type="video/mp4">
                                        <source src="' . $video . '.ogg" type="video/ogg">
                                        Your browser does not support the video tag.
                                    </video>
                                </div>
                           </div>
                         
                         ';
                }
            }


        }
        return $display;


    }



?>