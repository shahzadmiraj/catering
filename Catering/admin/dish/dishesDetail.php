<?php
/**
 * Created by PhpStorm.
 * User: shahzadmiraj
 * Date: 2019-09-01
 * Time: 21:31
 */
include_once ("../../connection/connect.php");


?>
<!DOCTYPE html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="/Catering/../bootstrap.min.css">
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

<div class="container"  style="margin-top:150px">


    <h1 class="font-weight-bold  " align="center">System Dish info </h1>






    <div class="col-12 card shadow mb-3 p-5">
        <h3 align="center"> Dish Type information</h3>
        <div class="form-group row font-weight-bold border">
            <label class="col-9  col-form-label ">Name Dish type</label>
            <label class="col-3  col-form-label ">Detail</label>
        </div>

        <?php
        $sql='SELECT `id`, `name`, `isExpire` FROM `systemDishType` WHERE 1';
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
        <h3 align="center"> Dish information        <a  href="addDish.php" class=" btn-outline-primary btn form-control ">Add dish +</a>
        </h3>
        <?php

        $sql='SELECT d.name, d.id, (SELECT dt.name from systemDishType as dt WHERE dt.id=d.systemDishType_id),(SELECT dt.isExpire from systemDishType as dt WHERE dt.id=d.systemDishType_id), d.isExpire,d.image FROM systemDish as d WHERE 1 ';
        $Dishes=queryReceive($sql);
        $display='<div class="form-group row">';

        for($i=0;$i<count($Dishes);$i++)
        {
            $display.= '<div class="card col-4">
              <img src="'.$Dishes[$i][5].'" style="height: 20vh">  
            <label class="col-12 form-check-label" > '.$Dishes[$i][0].'</label>
            <a href="EditDish.php?dishid='.$Dishes[$i][1].'" class="col-12  form-control btn ';


            if(($Dishes[$i][3]=="")&&($Dishes[$i][4]==""))
            {
                $display.=" btn-primary ";
            }
            else
            {
                $display.=" btn-danger ";
            }

            $display.='">';
            if($Dishes[$i][3]!="")
            {
                $display.=$Dishes[$i][2]." Diable ";
            }
            if($Dishes[$i][4]!="")
            {
                $display.=" Dish Diable ";
            }
            if(($Dishes[$i][3]=="")&&($Dishes[$i][4]==""))
            {
                $display.=" Detail ";
            }

            $display.='</a>
        </div>';


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
          url:"dishServer.php",
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
            url:"dishServer.php",
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


});



</script>

</body>
</html>