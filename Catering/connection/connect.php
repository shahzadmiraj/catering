<?php
/**
 * Created by PhpStorm.
 * User: shahzadmiraj
 * Date: 2019-09-01
 * Time: 21:25
 */


//session are customerid,typebranch,typebranchid
session_start();
date_default_timezone_set("Asia/Karachi");
//date_default_timezone_get();

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

function dishesOfPakage($sql)
{
    $dishdetail = queryReceive($sql);
    $display='';
    for ($j = 0; $j < count($dishdetail); $j++)
    {
        $display.= '
        <div id="dishid' . $dishdetail[$j][1] . '" class="col-4 alert-danger border m-1 form-group p-0" style="height: 30vh;" >
            <img src="' . $dishdetail[$j][2] . '" class="col-12" style="height: 15vh">
            <p class="col-form-label" class="form-control col-12">' . $dishdetail[$j][0] . '</p>
            <input   data-image="' . $dishdetail[$j][2] . '" data-dishname="' . $dishdetail[$j][0] . '"  data-dishid="' . $dishdetail[$j][1] . '" type="button" value="Select" class="form-control col-12 touchdish btn btn-success">
            <input hidden type="text"  name="dishname[]"  value="' . $dishdetail[$j][0] . '">
             <input hidden type="text"  name="image[]"  value="' . $dishdetail[$j][2] . '">
        </div>';

    }
    return $display;
}






function showRemainings($sql)
{
    $display='<table class="table table-striped newcolor table-responsive" style="width: 100%;">
    <thead class="font-weight-bold">
    <tr>
            <th scope="col"><h1 class="fas fa-id-card col-12"></h1>order Id</th>
            <th scope="col"><h1 class="fas fa-user col-12"></h1>customer Name</th>
            <th scope="col"><h1 class="far fa-eye col-12"></h1>order status</th>
            <th scope="col"><h1 class="fab fa-amazon-pay col-12"></h1>received amount</th>
            <th scope="col">System  Amount</th>
            <th scope="col">remaining system amount </th>
            <th scope="col"><h1 class="far fa-money-bill-alt col-12"></h1>your demanded amount</th>
            <th scope="col">remaining demand amount</th>
    </tr>
    </thead>
    <tbody>';



    $details=queryReceive($sql);
    for ($i=0;$i<count($details);$i++)
    {
        $display.=' <tr data-orderid="'.$details[$i][0].'" class="orderDetail">
        <td  scope="row">'.$details[$i][0].'</td>
        <td>'.$details[$i][1].'</td>
        <td>';
        if(!empty($hallid))
        {
            //if order status is hall
            $display.=$details[$i][7];

        }
        else
        {
            //if order status is catering
            $display.=$details[$i][6];

        }


        $display.='</td>
        <td>'.(int)$details[$i][2].'</td>
        <td>'.(int)$details[$i][5].'</td>
        <td> '.(int) ($details[$i][5]-$details[$i][2]).'</td>
        <td>'.(int) $details[$i][4].'</td>
        <td>'.(int) ($details[$i][4]-$details[$i][2]).'</td>
 ';



        $display.='</tr>';
    }





    $display.='
    </tbody>

</table>';
    return $display;

}

?>