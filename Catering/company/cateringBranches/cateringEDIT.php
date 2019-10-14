<?php
/**
 * Created by PhpStorm.
 * User: shahzadmiraj
 * Date: 2019-09-01
 * Time: 21:31
 */
include_once ("../../connection/connect.php");
$cateringid=$_GET['cateringid'];
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

    <style>
        *{
            margin:auto;
            padding: auto;
        }
    </style>
</head>
<body class="alert-light">

<div class="container" >

    <h1 align="center">Setting OF Catering</h1>
    <img src="
<?php
    if(file_exists('../'.$cateringdetail[0][2]) &&($cateringdetail[0][2]!=""))
    {
        echo '../'.$cateringdetail[0][2];
    }
    else
    {
        echo "../../gmail.png";
    }
    ?>

" class="rounded mx-auto d-block m-4" alt="..." style="height: 30vh">

    <form id="formcatering">
        <input type="number" hidden name="cateringid" value="<?php echo $cateringid; ?>">
        <input type="text" hidden name="previousimage" value="<?php echo $cateringdetail[0][2]; ?>">
        <div class="form-group row">
            <label class="col-form-label col-4">Catering Branch Name:</label>
            <input name="cateringname" class="form-control col-8" type="text" value="<?php echo $cateringdetail[0][0]; ?>">
        </div>
        <div class="form-group row">
            <label class="col-form-label col-4">Catering Branch Image:</label>
            <input name="image" class="form-control col-8" type="file">
        </div>
        <div class="form-group row">
            <label class="col-form-label col-4">Catering Branch Address</label>
        </div>
        <div class="form-group row col-12 mb-5">

            <input id="expirecatering" type="button" class="rounded mx-auto d-block btn btn-outline-danger col-5 " value="Expire catering">
            <input id="submiteditcatering" type="button" class="rounded mx-auto d-block btn btn-primary col-5 " value="Submit">

        </div>
    </form>

    <h1 class="font-weight-bold  " align="center">System Dish info </h1>




    <h3 align="center"> Dish Type information</h3>
    <div class="col-12 form-group row font-weight-bold border">
        <label class="col-9  col-form-label ">Name Dish type</label>
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




    <div class="col-12 card shadow mb-2 p-4 ">

        <div class="col-12 row alert-dark">
            <h3 class="rounded mx-auto d-block m-4 col-8" align="center"> Dish information</h3>
            <a  href="dish/addDish.php?cateringid=<?php echo $cateringid; ?>" class="float-right btn btn-outline-primary col-4 ">Add dish +</a>
        </div>

        <?php

        $sql='SELECT id,name FROM dish_type WHERE catering_id='.$cateringid.'';
        $dishTypes=queryReceive($sql);
        $Display='';
        $display='<div class="form-group row " style="height: 50vh;overflow:auto">';
        for($j=0;$j<count($dishTypes);$j++)
        {


            $display.='<h4 class="col-12" align="center">'.$dishTypes[$j][1].'</h4>';
            $sql = 'SELECT d.name, d.id, (SELECT dt.name from dish_type as dt WHERE dt.id=d.dish_type_id),(SELECT dt.isExpire from dish_type as dt WHERE dt.id=d.dish_type_id), d.isExpire,d.image FROM dish as d WHERE dish_type_id=' . $dishTypes[$j][0] . ' ';
            $Dishes = queryReceive($sql);




            for ($i = 0; $i < count($Dishes); $i++) {
                $display .= '<a href="dish/EditDish.php?dishid=' . $Dishes[$i][1] . '&cateringid='.$cateringid.'" class="col-4">
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
            <p class="col-12 p-0" > ' . $Dishes[$i][0] . '</p>
            <i class="col-12 ';


                if (($Dishes[$i][3] == "") && ($Dishes[$i][4] == "")) {
                    $display .= " text-primary ";
                } else {
                    $display .= " text-danger ";
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
                    location.reload();

                }


            }
        });
    });


});



</script>

</body>
</html>