<?php
/**
 * Created by PhpStorm.
 * User: shahzadmiraj
 * Date: 2019-09-06
 * Time: 16:48
 */
include_once ("../connection/connect.php");
session_start();
$_SESSION['order']=5;
if(!isset($_SESSION['order']))
{
        echo " session of order is not created";
        exit();
}
$_POST['dishid']=array(1,2);
$_POST['types']=array(1,2);
if(!isset($_POST['dishid']))
{
    echo "dish is not created";
    exit();
}

$orderId=$_SESSION['order'];
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
    <h1 align="center">Create dishes</h1>

    <?php
    $dishesId=$_POST['dishid'];
    $types=$_POST['types'];
    $display='';
    $number=0;
    for ($i=0;$i<count($types);$i++)
    {
        for ($k=$types[$i];$k>0;$k--)
        {
            $value=$dishesId[$i];
            $sql = 'SELECT d.id,d.name FROM dish as d WHERE d.id=' . $value . '';
            $dishDetail = queryReceive($sql);
            $display .= '
    <form class="col-12" id="form_' . $number . '">

        <div class="border shadow-lg p-4 mb-4 bg-white   col-12">
            <h2 align="center">' . $dishDetail[0][1] . '</h2>
            <input hidden type="number" name="dishId" value="' . $value . '">';


            $sql = 'SELECT a.id,a.name FROM attribute as a INNER JOIN dish as d
on d.id=a.dish_id
WHERE d.id=' . $value . '';

            $attributeDetail = queryReceive($sql);
            for ($j = 0; $j < count($attributeDetail); $j++) {
                $display .= ' <div class="form-group row">
            <label  class="col-form-label col-4">' . $attributeDetail[$j][1] . '</label>
            <input hidden name="attributeId[]"  value="' . $attributeDetail[$j][0] . '">
            <input name="attributeValue[]" class="form-control col-8" type="number">
        </div>';

            }

            $display .= ' <div class="form-group row">
                <label  class="col-form-label col-4">each price</label>
                <input name="each_price" class="form-control col-8" type="number">
            </div>
            <div class="form-group row">
                <label class="col-form-label col-4">Quantity</label>
                <input name="quantity" class="form-control col-8" type="number">
            </div>
            <div class="form-group row">
                <label class="col-form-label col-4">describe</label>
                <textarea  name="describe" class="form-control col-8" type="text"></textarea>
            </div>
            <div class="form-group row">
                <input type="button" data-formid="' . $number . '" class="cancelForm form-control btn col-4 btn-danger" value="cancel">
                <input type="button" data-formid="' . $number . '" class="submitForm form-control btn col-4 btn-primary" value="submit">
            </div>
        </div>

    </form>';
            $number++;

        }
    }
    echo $display;
    ?>
</div>




<script>
    $(document).ready(function () {
       $(document).on('click','.submitForm',function () {
          var id=$(this).data("formid");
          var formdata=new FormData($("#form_"+id)[0]);
          formdata.append("option",'createDish');
           $.ajax({
               url:"dishServer.php",
               method:"POST",
               data:formdata,
               contentType: false,
               processData: false,
               success:function (data)
               {
                  if(data!='')
                  {
                      alert(data);
                  }
                  else
                  {
                      $("#form_"+id).remove();
                  }
               }
           });
       });
       $(document).on('click','.cancelForm',function () {
           var id=$(this).data("formid");
           $("#form_"+id).remove();
       });

    });

</script>
</body>
</html>
