<?php
/**
 * Created by PhpStorm.
 * User: shahzadmiraj
 * Date: 2019-09-07
 * Time: 13:49
 */
include_once ("../connection/connect.php");

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


?>


<!DOCTYPE html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="../bootstrap.min.css">
    <script src="../jquery-3.3.1.js"></script>
    <script type="text/javascript" src="../bootstrap.min.js"></script>
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

<h1 align="center">Preview of Dish</h1>

<?php

$display='';
    $dishId=$_GET['dishId'];
    $dishDetailId=$_GET['dishDetailId'];
    $sql = 'SELECT d.id,d.name FROM dish as d WHERE d.id=' . $dishId . '';
    $dishDetail = queryReceive($sql);
    $display .= '
    <form class="col-12" id="form">

        <div class="border shadow-lg p-4 mb-4 bg-white   col-12">
            <h2 align="center">' . $dishDetail[0][1] . '</h2>
            <input hidden id="dishDetailID" value="'.$dishDetailId.'">
            ';


            $sql = 'SELECT an.id,an.quantity,a.name FROM dish_detail as dd inner join attribute_name as an 
on dd.id=an.dish_detail_id
INNER join attribute as a 
on a.id=an.attribute_id
WHERE dd.id='.$dishDetailId.'';

            $attributeDetail = queryReceive($sql);
            for ($j = 0; $j < count($attributeDetail); $j++) {
            $display .= ' <div class="form-group row">
                <label  class="col-form-label col-4">' . $attributeDetail[$j][2] . '</label>
                <input data-attributeid="'. $attributeDetail[$j][0] .'" class=" attributeChange form-control col-8" type="number" value="'. $attributeDetail[$j][1] .'">
            </div>';

            }
            $sql='SELECT `describe`, `price`, `quantity` FROM `dish_detail` WHERE id='.$dishDetailId.'';

            $dishDetailOfDetai=queryReceive($sql);
            $display .= ' <div class="form-group row">
                <label  class="col-form-label col-4">each price</label>
                <input data-column="price" class="dishDetailChange form-control col-8" type="number" value="'.$dishDetailOfDetai[0][1].'">
            </div>
            <div class="form-group row">
                <label class="col-form-label col-4">Quantity</label>
                <input data-column="quantity" class="dishDetailChange form-control col-8" type="number" value="'.$dishDetailOfDetai[0][2].'">
            </div>
            <div class="form-group row">
                <label class="col-form-label col-4">describe</label>
                <input  data-column="describe" class="dishDetailChange form-control col-8" type="text" value="'.$dishDetailOfDetai[0][0].'"></input>
            </div>
            <div class="form-group row">
                <input id="cancel_dish" type="button"  class="cancelForm form-control btn col-4 btn-danger" value="dish cancel">
                <input  id="ok" type="button" class="submitForm form-control btn col-4 btn-primary" value="ok">
            </div>
        </div>

    </form>';

            echo $display;
            ?>

</div>



<script>

    $(document).ready(function () {
       $(document).on('change','.attributeChange',function () {
           var attributeid=$(this).data('attributeid');
           var  valueAttribute=$(this).val();

            $.ajax({
              url:"dishServer.php",
                data:{attributeid:attributeid,value:valueAttribute,option:"attributeChange"},
              method:"POST",
                dataType:"text",
              success:function (data)
              {
                  if(data!="")
                  {
                      alert(data);
                  }
              }
          });
       }) ;
       $(document).on('change','.dishDetailChange',function () {
           var dishDetailId=$("#dishDetailID").val();
           var columnName=$(this).data("column");
           var columnValue=$(this).val();

           $.ajax({
              url:"dishServer.php",
              data: {dishDetailId:dishDetailId,columnName:columnName,columnValue:columnValue,option:"dishDetailChange" },
               dataType: "text",
               method:"POST",
               success:function (data) {
                  if(data!="")
                  {
                      console.log(data);
                  }
               }
           });
       });

       $('#cancel_dish').click(function () {
           var dishDetailId=$("#dishDetailID").val();
           $.ajax({
               url:"dishServer.php",
               data: {dishDetailId:dishDetailId,option:"deleteDish" },
               dataType: "text",
               method:"POST",
               success:function (data) {
                   if(data!="")
                   {
                       console.log(data);

                   }
                   else
                   {
                       window.history.back();
                   }
               }
           });

       });
        $('#ok').click(function () {
            window.history.back();
        });

    });

</script>
</body>
</html>

