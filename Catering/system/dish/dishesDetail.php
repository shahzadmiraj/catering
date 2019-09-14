<?php
/**
 * Created by PhpStorm.
 * User: shahzadmiraj
 * Date: 2019-09-01
 * Time: 21:31
 */
include_once ("../../connection/connect.php");
//date_default_timezone_set("asia/karachi");
//mysqli_insert_id($connect);
// //$timestamp = date('Y-m-d H:i:s');
//    $date = date('Y-m-d');
//$timeSet=date('H:i',time($orderDetail[0][7]));
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
//  $.ajax({
//               url:"customerBookingServer.php",
//               method:"POST",
//               data:formdatd,
//               contentType: false,
//               processData: false,
//               success:function (data)
//               {
//                   console.log(data);
//               }
//           });
function querySend($sql)
{
    global $connect;
    $result = mysqli_query($connect, $sql);
    if (!$result) {
        echo("Error description: " . mysqli_error($connect));
    }
}

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
<body>
<div class="container">


    <div class="form-group row col-12 p-2">
        <a class="col-4    btn-warning form-control  btn">User Display</a>
        <label class="font-weight-bold col-4  col-form-label " >System Dish info </label>
        <a  href="http://192.168.64.2/Catering/system/dish/addDish.php" class="col-4 btn-outline-primary btn form-control ">Add dish +</a>
    </div>


    <div class="col-12 card shadow">
        <h3 align="center"> Dish Type information</h3>
        <div class="form-group row font-weight-bold border">
            <label class="col-9  col-form-label ">Name Dish type</label>
            <label class="col-3  col-form-label ">Detail</label>
        </div>
        <div class="form-group row  border">
            <input id="addDishtypeValue" class="col-9  form-control " placeholder="Add new Dish type">
            <button  id="addDishtype" class="col-3  btn-success col-form-label ">Add +</button>
        </div>


        <?php
        $sql='SELECT dt.id, dt.name,dt.isExpire FROM dish_type as dt';
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




    <div class="col-12 card shadow mb-5">
        <h3 align="center"> Dish information</h3>
        <div class="form-group row font-weight-bold border">
            <label class="col-4  col-form-label ">Dish Id</label>
            <label class="col-5  col-form-label " >Dish Name </label>
            <label class="col-3  col-form-label ">Detail</label>
        </div>

        <?php

        $sql='SELECT d.name, d.id, (SELECT dt.name from dish_type as dt WHERE dt.id=d.dish_type_id),(SELECT dt.isExpire from dish_type as dt WHERE dt.id=d.dish_type_id), d.isExpire FROM dish as d WHERE 1 ';
        $Dishes=queryReceive($sql);
        $display='';

        for($i=0;$i<count($Dishes);$i++)
        {
            $display.= '<div class="form-group row  border">
            <label class="col-2  col-form-label ">'.$Dishes[$i][1].'</label>
            <label class="col-6  col-form-label " > '.$Dishes[$i][0].'</label>
            <a href="http://192.168.64.2/Catering/system/dish/EditDish.php?dishid='.$Dishes[$i][1].'" class="col-4  form-control btn ';


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
    $("#addDishtype").click(function () {
       var value=$("#addDishtypeValue").val();
        $.ajax({
            url:"dishServer.php",
            data:{value:value,option:"addDishtype"},
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