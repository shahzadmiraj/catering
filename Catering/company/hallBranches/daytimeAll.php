<?php
include_once ('../../connection/connect.php');
$hallid='';
$companyid='';
$hallBranches='';
if(isset($_GET['hallid']))
$hallid=$_GET['hallid'];
if(isset($_GET['companyid']))
$companyid=$_GET['companyid'];
if(isset($_GET['hallBranches']))
$hallBranches=$_GET['hallBranches'];
$sql='SELECT `name`, `max_guests`, `noOfPartitions`, `ownParking`, `expire`, `image`, `hallType`, `location_id` FROM `hall` WHERE id='.$hallid.'';
$halldetail=queryReceive($sql);


?>
<!DOCTYPE html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="../../bootstrap.min.css">
    <script src="../../jquery-3.3.1.js"></script>
    <script type="text/javascript" src="../../bootstrap.min.js"></script>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <link rel="stylesheet" href="../../webdesign/css/complete.css">

    <style>

        #formhall
        {
            margin: 5%;;

        }
        #showDaytimes
        {
            background: #dd3e54;  /* fallback for old browsers */
            background: -webkit-linear-gradient(to right, #6be585, #dd3e54);  /* Chrome 10-25, Safari 5.1-6 */
            background: linear-gradient(to right, #6be585, #dd3e54); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */

        }
    </style>
</head>
<body>

<?php
include_once ("../../webdesign/header/header.php");

?>




<div class="jumbotron jumbotron-fluid text-center" style="background-image: url(<?php
if(file_exists("../".$halldetail[0][5])&&($halldetail[0][5]!=""))
{
    echo "../".$halldetail[0][5];
}
else
{
    echo "https://www.pakvenues.com/system/halls/cover_images/000/000/048/original/Umar_Marriage_Hall_lahore.jpg?1566758537";
}
?>);background-repeat: no-repeat ;background-size: 100% 100%">
    <div class="container" style="background-color: white;opacity: 0.7">
        <h1 class="display-4"><i class="fas fa-place-of-worship"></i><?php echo $halldetail[0][0]; ?></h1>
        <p class="lead">You can control hall setting and also month wise prize list.Prize list consist of per head with food  and per head only seating .</p>
    </div>
</div>
<div class="container">
<h1>Hall Setting</h1>
<hr class="mt-2 mb-3 border-white">
<form class="shadow card-body" id="formhall" >
    <input type="number" hidden name="hallid" value="<?php echo $hallid; ?>">

    <input type="text" hidden name="previousimage" value="<?php echo $halldetail[0][5]; ?>">
    <div class="form-group row">
        <label class="col-form-label ">Hall Branch Name:</label>
<!--        <input name="hallname" class="form-control col-8" type="text" value="--><?php //echo $halldetail[0][0]; ?><!--">-->




        <div class="input-group mb-3 input-group-lg">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-place-of-worship"></i></span>
            </div>
            <input name="hallname" type="text" class="form-control" value="<?php echo $halldetail[0][0]; ?>">
        </div>



    </div>

    <div class="form-group row">
        <label class="col-form-label">Hall Type:</label>




        <div class="input-group mb-3 input-group-lg">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fab fa-accusoft"></i></span>
            </div>

        <select name="halltype" class="form-control">
            <?php
            $halltype=array("Marquee","Hall","Deera /Open area");

            echo '<option value="'.$halldetail[0][6].'">'.$halltype[$halldetail[0][6]].'</option>';
            for($i=0;$i<count($halltype);$i++)
            {
                if($i!=$halldetail[0][6])
                {

                    echo '<option value="'.$i.'">'.$halltype[$i].'</option>';
                }
            }


            ?>
        </select>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-form-label ">Hall Branch Image:</label>
<!--        <input name="image" class="form-control col-8" type="file">-->





        <div class="input-group mb-3 input-group-lg">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-camera-retro"></i></span>
            </div>
            <input name="image" type="file" class="form-control">
        </div>

    </div>
    <div class="form-group row">
        <label class="col-form-label"><i class="fas fa-map-marker-alt"> </i>Hall Branch Address</label>
    </div>
    <div class="form-group row">
        <label class="col-form-label">Maximum Capacity of guests in hall:</label>
<!--        <input name="capacity" class="form-control col-4" type="number" value="--><?php //echo $halldetail[0][1]; ?><!--">-->





        <div class="input-group mb-3 input-group-lg">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-users"></i></span>
            </div>
            <input type="number" value="<?php echo $halldetail[0][1]; ?>" class="form-control" name="capacity">
        </div>


    </div>

    <div class="form-group row">
        <label class="col-form-label ">No of Partition in Hall:</label>
<!--        <input name="partition" class="form-control col-4" type="number" value="--><?php //echo $halldetail[0][2]; ?><!--">-->



        <div class="input-group mb-3 input-group-lg">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-columns"></i></span>
            </div>
            <input name="partition" type="number" class="form-control" value="<?php echo $halldetail[0][2]; ?>">
        </div>


    </div>

    <div class="form-group row">
<!--        <input name="parking" class="form-check-input" type="checkbox" --><?php //if($halldetail[0][3]==1){ echo "checked";} ?><!-- >-->
<!--        <label class="form-check-label ">Have Your own parking</label>-->

        <div class="input-group mb-3 input-group-lg">
            <div class="input-group-prepend">
                <span class="input-group-text">
                <input name="parking" class="form-check-input " type="checkbox" <?php if($halldetail[0][3]==1){ echo "checked";} ?> ><i class="fas fa-parking"></i>
                </span>
            </div>
            <label class="form-check-label ml-3">  Have Your own parking</label>
        </div>

    </div>
    <div class="form-group row mb-5">

        <button id="expirehall" type="button" class="rounded mx-auto d-block btn btn-danger col-5 " value="Expire hall"><span class="fas fa-window-close "></span>   Expire hall</button>
        <button id="submitedithall" type="button" class="rounded mx-auto d-block btn btn-primary col-5 " value="Submit"> <i class="fas fa-check "></i>Save</button>

    </div>


</form>

    <h1>Prize list Setting</h1>
    <hr class="mt-2 mb-3 border-white">

<div class="form-group row ">
    <div data-daytime="Morning" class="col-4 daytime p-0 "style="height: 25vh">
        <div class="card-header">
        <img class="rounded-circle" src="https://www.incimages.com/uploaded_files/image/970x450/getty_503667408_2000133320009280259_352507.jpg"  style="height: 20vh;width: 100%;">
        <p align="center" >Morning Prize list</p>
        </div>
    </div>
    <div data-daytime="Afternoon" class=" daytime col-4 p-0"style="height: 25vh">
        <div class="card-header">
            <img class="rounded-circle" src="https://www.ellieteramoto.com/wordpress/wp-content/uploads/2018/11/the-sun-and-lake-kussharo-hokkaido-japan.jpg" style="height: 20vh;width: 100%">
            <p align="center" >Afternoon Prize list</p>
        </div>
    </div>
    <div data-daytime="Evening" class=" daytime col-4 p-0"style="height: 25vh">
        <div class="card-header">
            <img class="rounded-circle" src="https://www.murals.shop/1777-thickbox_default/starry-sky-half-moon-scenic-cloudscape-wall-mural.jpg"  style="height: 20vh;width: 100%">
            <p align="center" >Evening Prize list</p>
        </div>
    </div>
</div>
<div  class="border" id="showDaytimes" style="margin-top: 20%;height: 60vh;width:100%; overflow: auto">



</div>


    <div class="container">

        <h1 class="font-weight-light text-lg-left mt-4 mb-3">Gallery</h1>


        <form action="" method="POST" enctype="multipart/form-data" class="form-inline">
            <input type="file" name="userfile[]" value="" multiple="" class="col-8 btn  btn-light">
            <input type="submit" name="submit" value="Upload" class="btn btn-success col-4">
        </form>
        <?php

        if(isset($_FILES['userfile']))
        {

            $file_array=reArray($_FILES['userfile']);
            $Distination='';
            for ($i=0;$i<count($file_array);$i++)
            {
                $Distination= '../../images/hall/'.$file_array[$i]['name'];
                $error=MutipleUploadFile($file_array[$i],$Distination);
                if(count($error)>0)
                {
                    echo '<h4 class="badge-danger">'.$file_array[$i]['name'].'.'.$error[0].'</h4>';
                }
                else
                {
                    $sql='INSERT INTO `images`(`id`, `image`, `expire`, `catering_id`, `hall_id`) VALUES (NULL,"'.$Distination.'",NULL,NULL,'.$hallid.')';
                    querySend($sql);
                }

            }
            unset($_FILES['userfile']);

        }



        ?>



        <hr class="mt-3 mb-5 border-white">

        <div class="row text-center text-lg-left" style="height: 70vh;overflow: auto">


            <?php


            $sql='SELECT `id`, `image` FROM `images` WHERE hall_id='.$hallid.'' ;
            echo showGallery($sql);

            ?>


        </div>

    </div>






        <h1 class="font-weight-light text-lg-left mt-4 mb-0">Comments</h1>

        <hr class="mt-2 mb-3">
        <div class="row bootstrap snippets">

            <div class="col-md-12 col-md-offset-2 col-sm-12 m-auto">
                <div class="comment-wrapper">
                    <div class="panel panel-info ">

                        <div class="panel-body">
                            <textarea class="form-control" placeholder="write a comment..." rows="3"></textarea>
                            <br>

                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-comments"></i></div>
                                </div>
                                <input type="email" class="form-control "  placeholder="Email">
                            </div>


                            <button type="button" class="btn btn-info pull-right float-right col-5">Post</button>
                            <div class="clearfix"></div>
                            <hr>
                            <ul class="media-list">





                                <li class="media">
                                    <a href="#" class="pull-left">
                                        <img src="https://bootdey.com/img/Content/user_1.jpg" alt="" class="img-circle">
                                    </a>
                                    <div class="media-body">
                                <span class="text-muted pull-right">
                                    <small class="text-muted">30 min ago</small>
                                </span>
                                        <strong class="text-success">@MartinoMont</strong>
                                        <p>
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                            Lorem ipsum dolor sit amet, <a href="#">#consecteturadipiscing </a>.
                                        </p>
                                    </div>
                                </li>



                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>



<div class="col-12 mt-2">
    <a href="hallRegister.php?companyid=<?php echo $companyid;?>&hallBranches=<?php echo $hallBranches;?>" class="btn btn-success col-5 float-right"><i class="fas fa-arrow-right"></i> Save And Next </a>
</div>

<!---->
<!--<tr>-->
<!--    <td scope="col" >-->
<!--        <h4 align="center">Months</h4>-->
<!--        <div class="form-group row p-2 shadow btn-light">-->
<!--            <label class="col-form-label col-6 font-weight-bold"> Prize Only Seating </label>-->
<!--            <input class="form-control col-6" type="number">-->
<!--            <h3 align="center" class="col-12 mt-3">List of prize with Food</h3>-->
<!--            <a  href="#" class="form-control  btn-primary col-12 text-center"> Add New Package</a>-->
<!--            <a  href="#" class="form-control  btn-success col-4 text-center m-2"> Package name</a>-->
<!--        </div>-->
<!--    </td>-->
<!--</tr>-->


</div>
<?php
include_once ("../../webdesign/footer/footer.php");
?>

<script>

    $(document).ready(function ()
    {
        function showdaytimelist(daytime)
        {
            var formdata=new FormData();
            formdata.append("option","showdaytimelist");
            formdata.append("daytime",daytime);
            formdata.append("hallid","<?php echo $hallid; ?>");
            formdata.append("companyid","<?php echo $companyid;?>");
            formdata.append("hallBranches","<?php echo $hallBranches;?>");
            formdata.append("hallname","<?php echo $halldetail[0][0]; ?>")
            $.ajax({
                url:"../companyServer.php",
                method:"POST",
                data:formdata,
                contentType: false,
                processData: false,
                success:function (data)
                {
                    $("#showDaytimes").html(data);
                }
            });
        }

       $(".daytime").click(function ()
       {
           var daytime=$(this).data("daytime");
           showdaytimelist(daytime);
       }) ;
        showdaytimelist("Morning");

        $(document).on("change",".changeSeating",function () {
            var id=$(this).data("menuid");
            var value=$(this).val();
            var formdata=new FormData();
            formdata.append("option","changeSeating");
            formdata.append("packageid",id);
            formdata.append("value",value);
            $.ajax({
                url:"../companyServer.php",
                method:"POST",
                data:formdata,
                contentType: false,
                processData: false,
                success:function (data)
                {
                    if(data!='')
                    {
                        alert(data);
                        return false;
                    }

                }
            });


        }) ;

        $("#submitedithall").click(function ()
        {
            var formdata=new FormData($("#formhall")[0]);
            formdata.append("option","halledit");
            $.ajax({
                url:"../companyServer.php",
                method:"POST",
                data:formdata,
                contentType: false,
                processData: false,
                success:function (data)
                {
                    if(data!='')
                    {
                        alert(data);
                        return false;
                    }
                    else
                    {

                    }


                }
            });


        });












    });



</script>
</body>
</html>
