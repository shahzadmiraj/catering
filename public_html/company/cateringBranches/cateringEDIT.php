<?php
/**
 * Created by PhpStorm.
 * User: shahzadmiraj
 * Date: 2019-09-01
 * Time: 21:31
 */
include_once ("../../connection/connect.php");

if(isset($_GET['action']))
{

    if($_GET['action']=="expire")
    {
        $date=date('Y-m-d H:i:s');
        $sql='UPDATE `catering` SET `expire`="'.$date.'" WHERE id='.$_SESSION['tempid'].'';
    }
    else
    {
        $sql='UPDATE `catering` SET `expire`=NULL WHERE id='.$_SESSION['tempid'].'';

    }
    querySend($sql);
    header("location:../companyRegister/companyEdit.php");
}
if(isset($_GET['dishdetail']))
{
    $_SESSION['2ndpage']=$_GET['dishid'];
    header("location:dish/EditDish.php");
}
$cateringid=$_SESSION['tempid'];
$sql='SELECT  `name`, `expire`, `image`, `location_id` FROM `catering` WHERE id='.$cateringid.'';
$cateringdetail=queryReceive($sql);


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

    </style>
</head>
<body>
<?php
include_once ("../../webdesign/header/header.php");

?>
<div class="jumbotron  shadow text-center" style="background-image: url(<?php
if(file_exists('../'.$cateringdetail[0][2]) &&($cateringdetail[0][2]!=""))
{
    echo '../'.$cateringdetail[0][2];
}
else
{
    echo "https://www.hnfc.com.my/data1/images/slide2.jpg";
}
?>
        );background-size:100% 100%;background-repeat: no-repeat">

    <div class="card-body " style="opacity: 0.7 ;background: white;">
        <h1 class="display-5 text-center"><i class="fas fa-utensils fa-3x mr-1"></i><?php echo $cateringdetail[0][0];?> Edit Catering Branches</h1>
        <p class="lead">Edit dishes information,dishes type,images and others </p>

        <h1 class="text-center"> <a href="../companyRegister/companyEdit.php" class="col-6 btn btn-info "> <i class="fas fa-city mr-2"></i>Edit Company</a></h1>

    </div>
</div>




<div class="container" >

    <form id="formcatering">
        <input type="number" hidden name="cateringid" value="<?php echo $cateringid; ?>">
        <input type="text" hidden name="previousimage" value="<?php echo $cateringdetail[0][2]; ?>">
        <div class="form-group row">
            <label class="col-form-label ">Catering Branch Name:</label>





            <div class="input-group mb-3 input-group-lg">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-utensils"></i></span>
                </div>
                <input name="cateringname" class="form-control" type="text" value="<?php echo $cateringdetail[0][0]; ?>">
            </div>


        </div>
        <div class="form-group row">
            <label class="col-form-label ">Catering Branch Image:</label>






            <div class="input-group mb-3 input-group-lg">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-camera"></i></span>
                </div>
                <input name="image" class="form-control" type="file">
            </div>



        </div>
        <div class="form-group row">
            <h3 align="center">  <i class="fas fa-map-marker-alt"></i>Address(optional)</h3>
        </div>
        <div class="form-group row col-12 mb-5">


            <?php
            if($cateringdetail[0][1]=="")
            {
                echo '<a href="?action=expire" class="btn btn-danger col-6">Expire</a>';

            }
            else
            {
                echo '<a href="?action=active" class="btn btn-warning col-6">Active</a>';
            }

            ?>

                <button id="submiteditcatering" type="button" class="rounded mx-auto d-block btn btn-primary col-5 " value="Submit"><i class="fas fa-check "></i>Submit</button>

        </div>
    </form>

    <h1 class="font-weight-bold">System Dish info </h1>
<hr>



    <h3 align="center"> Dish Type information</h3>
    <div class="col-12 form-group row font-weight-bold border">
        <label class="col-9  col-form-label "><i class="fas fa-utensils mr-1"></i>Name Dish type</label>
        <label class="col-3  col-form-label ">Detail</label>
    </div>

    <div  class="col-12" style="height: 25vh;overflow:auto">


        <?php
        $sql='SELECT `id`, `name`, `isExpire` FROM `dish_type` WHERE catering_id='.$cateringid.'';
        $dishTypes=queryReceive($sql);
        $Display='';
        for($i=0;$i<count($dishTypes);$i++)
        {
            $Display.= '<div class="form-group row  border " id="Delele_Dish_Type_'.$dishTypes[$i][0].'">
            <input data-dishtypeid="'.$dishTypes[$i][0].'"   value="'.$dishTypes[$i][1].'" class="changeDishType col-9  form-control ">
            <input data-dishtypeid="'.$dishTypes[$i][0].'"  class=" btn Delele_Dish_Type col-3  form-control  ';

            if($dishTypes[$i][2]=="")
            {

                $Display.='btn-primary  ';
            }
            else
            {
                $Display.=' btn-danger ';
            }

            $Display.=' " value="';

            if($dishTypes[$i][2]=="")
            {

                $Display.='Disable';
            }
            else
            {
                $Display.='Enable';
            }




            $Display.= '"></div>';
        }
        echo $Display;
        ?>



    </div>


    <div class="col-12 row mb-4">
        <h3 class="rounded mx-auto d-block m-4 col-6" align="center"> Dish information</h3>
        <a  href="dish/addDish.php" class="float-right btn btn-success col-4 form-control mt-4">Add dish +</a>
    </div>
    <hr>

    <div class="col-12 card shadow mb-2 p-4 ">

        <?php

        $sql='SELECT id,name FROM dish_type WHERE catering_id='.$cateringid.'';
        $dishTypes=queryReceive($sql);
        $Display='';
        $display='<div class="form-group row " style="height: 50vh;overflow:auto">';
        for($j=0;$j<count($dishTypes);$j++)
        {


            $display.='<h4 class="col-12 newcolor" align="center">'.$dishTypes[$j][1].'</h4>';
            $sql = 'SELECT d.name, d.id, (SELECT dt.name from dish_type as dt WHERE dt.id=d.dish_type_id),(SELECT dt.isExpire from dish_type as dt WHERE dt.id=d.dish_type_id), d.isExpire,d.image FROM dish as d WHERE dish_type_id=' . $dishTypes[$j][0] . ' ';
            $Dishes = queryReceive($sql);




            for ($i = 0; $i < count($Dishes); $i++) {
                $display .= '<a href="?dishdetail=yes&dishid=' . $Dishes[$i][1] . '&cateringid='.$cateringid.'" class="col-sm-12 col-md-6 col-xl-4 border">
              <img src="';

                if(file_exists(substr($Dishes[$i][5],3))&&($Dishes[$i][5]!=""))
                {
                    $display.=substr($Dishes[$i][5],3);
                }
                else
                {
                    $display.='../../gmail.png';
                }




                $display.='" style="height: 20vh" class="col-12">  
            <p class="col-12 p-0" ><i class="fas fa-utensils mr-1"></i>' . $Dishes[$i][0] . '</p>
            <i class="col-12 ';


                if (($Dishes[$i][3] == "") && ($Dishes[$i][4] == "")) {
                    $display .= " text-primary ";
                } else {
                    $display .= "text-danger ";
                }

                $display .= '">';
                if ($Dishes[$i][3] != "") {
                    $display .= $Dishes[$i][2] . " Diable ";
                }
                if ($Dishes[$i][4] != "") {
                    $display .= " Dish Diable ";
                }

                $display .= '</i>
        </a>';
            }
        }
        $display.='</div>';
        echo $display;


        ?>



    </div>








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
            $Distination= '../../images/catering/'.$file_array[$i]['name'];
            $error=MutipleUploadFile($file_array[$i],$Distination);
            if(count($error)>0)
            {
                echo '<h4 class="badge-danger">'.$file_array[$i]['name'].'.'.$error[0].'</h4>';
            }
            else
            {
                $sql='INSERT INTO `images`(`id`, `image`, `expire`, `catering_id`, `hall_id`) VALUES (NULL,"'.$Distination.'",NULL,'.$cateringid.',NULL)';
                querySend($sql);
            }

        }
        unset($_FILES['userfile']);

    }



    ?>



    <hr class="mt-3 mb-5 border-white">

    <div class="row text-center text-lg-left" style="height: 70vh;overflow: auto">


        <?php


        $sql='SELECT `id`, `image` FROM `images` WHERE catering_id='.$cateringid.'' ;
        echo showGallery($sql);

        ?>


    </div>

</div>




<?php
include_once ("../../webdesign/footer/footer.php");
?>
<script>
$(document).ready(function () {


   $(document).on("change",".changeDishType",function ()
   {
       var id=$(this).data("dishtypeid");
       var value=$(this).val();
       $.ajax({
          url:"dish/dishServer.php",
          data:{id:id,value:value,option:"changeDishType"},
          dataType:"text",
          method:"POST",
          success:function (data)
          {
              if(data!="")
              {
                  alert(data);
              }

          }
       });

   });

    $(document).on("click",".Delele_Dish_Type",function ()
    {
        var id=$(this).data("dishtypeid");
        var value=$(this).val();
        $.ajax({
            url:"dish/dishServer.php",
            data:{value:value,id:id,option:"Delele_Dish_Type"},
            dataType:"text",
            method:"POST",
            success:function (data)
            {
                if(data!="")
                {
                    alert(data);
                }
                else
                {
                    location.reload();
                }

            }
        });

    });
    $("#submiteditcatering").click(function () {
        var formdata = new FormData($("#formcatering")[0]);
        formdata.append("option", "cateringedit");
        $.ajax({
            url: "../companyServer.php",
            method: "POST",
            data: formdata,
            contentType: false,
            processData: false,
            success: function (data) {
                if (data != '')
                {
                    alert(data);
                    return false;
                } else
                {
                    window.location.href="../companyRegister/companyEdit.php";

                }


            }
        });
    });


});



</script>

</body>
</html>