<?php
/**
 * Created by PhpStorm.
 * User: shahzadmiraj
 * Date: 2019-09-01
 * Time: 21:31
 */
include_once ("../connection/connect.php");

$sql='SELECT dt.id, dt.name FROM dish_type as dt WHERE ISNULL(dt.isExpire)';
$dishTypeDetail=queryReceive($sql);

?>
<!DOCTYPE html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="/Catering/bootstrap.min.css">
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
<div class="container"  style="margin-top:150px">

    <h1 align="center" >Select Dishes</h1>
    <form class="card " id="formid" method="post" action="dishCreate.php?order=<?php echo $_GET['order'];?>&option=dishDisplay">

        <div class="col-12" id="selected">
    <div class="form-group row">
        <label  class="text-center col-form-label col-5">Dish Name</label>
        <label class="text-center col-form-label col-3">Types</label>
        <label class=" text-center col-form-label col-3">Delete</label>
    </div>



        </div>
        <div class="form-group row col-12 ">

        <?php
            if(isset($_GET['option']))
            {
                if($_GET['option']=="orderCreate")
                {
                    echo '<a href="/Catering/order/orderEdit.php?order='.$_GET['order'].'&customer='.$_GET['customer'].'&option=dishDisplay" class="col-5 form-control btn btn-danger">Edit Order</a>';
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



    <div class="col-12 border " style="margin-top: 20px;background-color: hsl(346, 100%, 64%);">
    <?php

        $display='';
        for($i=0;$i<count($dishTypeDetail);$i++)
        {
            $display.='<h2 align="center " class="col-12 btn-warning"> '.$dishTypeDetail[$i][1].'</h2>';

            $sql='SELECT `name`, `id`, `image`, `dish_type_id` FROM `dish` WHERE (dish_type_id='.$dishTypeDetail[$i][0].') AND (ISNULL(isExpire))';
            $dishDetail=queryReceive($sql);
            $display.='<div class="form-group row">';
            for ($j=0;$j<count($dishDetail);$j++)
            {
                $display .= ' 
         <div class="col-6 card mb-1 p-1 shadow bg-white" style="    height: 260px;">
        <img class="card-img-top " src="../gmail.png" alt="Card image" style="height: 150px">
        <div class="form-group col-12">
            <p class="font-weight-bold p-0 card-title col-12
            ">' . $dishDetail[$j][0] . '</p>
            <button type="button" data-dishname="'. $dishDetail[$j][0] .'" data-dishid="'. $dishDetail[$j][1] .'" class="add col-12 mb-0 btn btn-primary">Select</button>
        </div>
        </div>';
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
               '                <input type="button" class="remove form-control col-2 btn-danger" data-dishid="'+dishId+'" value="-">\n' +
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
