<?php
/**
 * Created by PhpStorm.
 * User: shahzadmiraj
 * Date: 2019-09-01
 * Time: 21:31
 */
include_once ("../connection/connect.php");

//mysqli_insert_id($connect);
// //$timestamp = date('Y-m-d G:i:s');
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
<body>

<div class="container">

    <form class="card" id="formid" method="post" action="dishCreate.php">
        <div class="col-12" id="selected">
    <div class="form-group row border">
        <label  class="text-center col-form-label col-4">Dish Name</label>
        <label class="text-center col-form-label col-4">No of kind</label>
        <label class=" text-center col-form-label col-4">Delete</label>
    </div>



        </div>

        <button id="submit" type="submit" class="btn-success">Submit</button>
        <button id="cancelDish" type="button" class="btn-danger">cancel</button>

    </form>



    <div class="card" style="margin-top: 20px">
    <?php

        $display='';
        for($i=0;$i<count($dishTypeDetail);$i++)
        {
            $display.='<div class="col-12">
                <h2 align="center"> '.$dishTypeDetail[$i][1].'</h2>
        <div class="col-12 row p-4">';

            $sql='SELECT `name`, `id`, `image`, `dish_type_id` FROM `dish` WHERE dish_type_id='.$dishTypeDetail[$i][0].'';
            $dishDetail=queryReceive($sql);

            for ($j=0;$j<count($dishDetail);$j++)
            {
                $display .= '  <div class="card col-4 shadow-lg p-0 mb-1 bg-white " style="width:200px;">
        <img class="card-img-top" src="../gmail.png" alt="Card image">
        <div class="card-body">
            <h4 class="card-title">' . $dishDetail[$j][0] . '</h4>
            <button type="button" data-dishname="'. $dishDetail[$j][0] .'" data-dishid="'. $dishDetail[$j][1] .'" class="add btn btn-primary col-12">Select</button>
        </div>';
            }
            $display.='</div></div>';
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
               '                <h2 class="form-control col-4">'+dishName+'</h2>\n' +
               '                <input type="number" value="1" name="types[]" class="form-control col-4">\n' +
               '                <input type="number" hidden name="dishid[]" value="'+dishId+'">\n' +
               '                <input type="button" class="remove form-control col-4 btn-primary" data-dishid="'+dishId+'" value="-">\n' +
               '            </div>');

       }) ;

       $(document).on('click','.remove',function () {
          var id=$(this).data("dishid");
          $("#dishid_"+id).remove();
       });

        // $('#submit').click(function (e) {
        //     e.preventDefault();
        //     var formdata=new FormData($('form')[0]);
        //     $.ajax({
        //         url:"dishCreate.php",
        //         method:"POST",
        //         data:formdata,
        //         contentType: false,
        //         processData: false,
        //         success:function (data)
        //         {
        //             if(data!='')
        //             {
        //                 alert(data);
        //             }
        //             else
        //             {
        //                 window.location.href="http://192.168.64.2/Catering/dish/dishCreate.php";
        //             }
        //         }
        //     });
        //
        // });
        $("#cancelDish").click(function () {
            window.history.back();
            return false;
        });

    });


</script>
</body>
</html>
