<?php
/**
 * Created by PhpStorm.
 * User: shahzadmiraj
 * Date: 2019-09-01
 * Time: 21:31
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
function querySend($sql)
{
    global $connect;
    $result = mysqli_query($connect, $sql);
    if (!$result) {
        echo("Error description: " . mysqli_error($connect));
    }
}



$sql='SELECT `id`, `name` FROM `dish_type` WHERE 1';
$dishTypeDetail=queryReceive($sql);

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
            padding:auto;
        }

    </style>
</head>
<body class="alert-light">
<?php
include_once ("../webdesign/header/header.php");
?>
<div class="container"  style="margin-top:180px">


    <form class="card" id="formid" method="post" action="dishCreate.php?order=<?php echo $_GET['order'];?>&option=dishDisplay">
        <div class="col-12" id="selected">
    <div class="form-group row border">
        <label  class="text-center col-form-label col-7">Dish Name</label>
        <label class="text-center col-form-label col-3">No of kind</label>
        <label class=" text-center col-form-label col-2">Delete</label>
    </div>



        </div>
        <div class="form-group row col-12 ">

        <?php
            if(isset($_GET['option']))
            {
                if($_GET['option']=="orderCreate")
                {
                    echo '<a href="/order/orderEdit.php?order='.$_GET['order'].'&customer='.$_GET['customer'].'&option=dishDisplay" class="col-5 form-control btn btn-danger">Edit Order</a>';
                }
                else if($_GET['option']=="orderEdit")
                {

                    echo '<button id="cancelDish" type="button" class="col-5 btn btn-danger form-control">Edit order</button>';
                }
            }
            else
            {
                echo '<button id="cancelDish" type="button" class="col-5 btn btn-danger form-control">Edit order</button>';
            }
        ?>

            <button id="submit" type="submit" class="btn-success form-control btn col-5">Submit</button>
        </div>

    </form>



    <div class="card" style="margin-top: 20px">
    <?php

        $display='';
        for($i=0;$i<count($dishTypeDetail);$i++)
        {
            $display.='<div class="col-12">
                <h2 align="center"> '.$dishTypeDetail[$i][1].'</h2>
        <div class="col-12  row ">';

            $sql='SELECT `name`, `id`, `image`, `dish_type_id` FROM `dish` WHERE dish_type_id='.$dishTypeDetail[$i][0].'';
            $dishDetail=queryReceive($sql);

            for ($j=0;$j<count($dishDetail);$j++)
            {
                $display .= '  <div class="card  shadow-lg  bg-white " style="width:200px;">
        <img class="card-img-top" src="../gmail.png" alt="Card image">
        <div class="card-body">
            <label class="card-title co">' . $dishDetail[$j][0] . '</label>
            <button type="button" data-dishname="'. $dishDetail[$j][0] .'" data-dishid="'. $dishDetail[$j][1] .'" class="add btn btn-primary col-12">Select</button>
        </div></div>';
            }
            $display.='</div>';
        }
        echo $display;
    ?>

    </div>

</div>



<script>

    $(document).ready(function () {

       $(document).on('click','.add',function () {
           var dishName=$(this).data("dishname");
           var dishId=$(this).data("dishid");
           $('#selected').append('\n' +
               '            <div class="form-group row " id="dishid_'+dishId+'">\n' +
               '                <h2 class="form-control col-7">'+dishName+'</h2>\n' +
               '                <input type="number" value="1" name="types[]" class="form-control col-3">\n' +
               '                <input type="number" hidden name="dishid[]" value="'+dishId+'">\n' +
               '                <input type="button" class="remove form-control col-2 btn-primary" data-dishid="'+dishId+'" value="-">\n' +
               '            </div>');

       }) ;

       $(document).on('click','.remove',function () {
          var id=$(this).data("dishid");
          $("#dishid_"+id).remove();
       });


        $("#cancelDish").click(function () {
            window.history.back();
            return false;
        });

    });


</script>
</body>
</html>
