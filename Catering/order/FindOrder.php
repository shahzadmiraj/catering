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
    if (!$result)
    {
        echo $sql;
        echo("Error description: " . mysqli_error($connect));
    }else{
        return mysqli_fetch_all($result);
    }
}
if(!isset($_GET['is_active']))
{
    exit();
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
    <h1 align="center"> Orders</h1>

        <form class="col-12 shadow card " id="formId1">
        <h2>Search order :</h2>

        <div class="form-group row">
            <label class="col-form-label col-4"> customer name</label>
            <input  name="p_name" type="text" class="changeColumn form-control col-8">
        </div>
        <div class="form-group row">
            <label class="col-form-label col-4"> customer CNIC</label>
            <input  name="p_cnic" type="number" class="changeColumn form-control col-8">
        </div>
            <div class="form-group row">
                <label class="col-form-label col-4"> customer ID</label>
                <input  name="p_id" type="number" class="changeColumn form-control col-8">
            </div>
        <div class="form-group row">
            <label class="col-form-label col-4"> customer phone</label>
            <input  name="n_number" type="text" class="changeColumn form-control col-8">
        </div>
        <div class="form-group row">
            <label class="col-form-label col-4">booking Date</label>
            <input  name="ot_booking_date" type="date" class="changeColumn form-control col-8">
        </div>
        <div class="form-group row">
            <label class="col-form-label col-4"> destination date</label>
            <input  name="ot_destination_date" type="date" class="changeColumn form-control col-8">
        </div>
        <div class="form-group row">
            <label class="col-form-label col-4">order status</label>
            <select  name="ot_is_active" class="changeColumn form-control col-8 ">
                <option value="None">None</option>
                <?php
                $OrderStatus=array("running","cancel","delieved","clear");
                for($i=0;$i<count($OrderStatus);$i++)
                {

                        echo '<option value='.$i.'>'.$OrderStatus[$i].'</option>';

                }
                ?>
            </select>
        </div>
        <div class="form-group row">
            <a href="http://192.168.64.2/Catering/user/userDisplay.php" class="col-4 form-control btn-danger">cancel</a>
            <button type="button" class="col-4 form-control btn-success">Find</button>
        </div>

        </form>
        <div class="col-12 card shadow" id="recordsAll">
            <?php
            $sql='SELECT p.id,p.name,ot.destination_date,ot.id  FROM person as p INNER join number as n on p.id=n.person_id
    INNER join orderTable as ot
    on p.id=ot.person_id
   WHERE
    ot.is_active='.$_GET['is_active'].'
    ORDER BY ot.destination_date DESC';

            $records=queryReceive($sql);
            if(count($records)>0)
            {

                $displayRecord = '<h2 align="center">display records</h2>
            <div class="form-group row border mb-0 p-1">
                <label class="font-weight-bold col-form-label col-2">order Id</label>
                <label class="font-weight-bold col-form-label col-5">customer Name</label>
                <label class="font-weight-bold col-form-label col-3">destination Date</label>
                <label class="font-weight-bold col-form-label col-2">Detail</label>
            </div>';

                for ($j=0;$j<count($records);$j++)
                {
                    $displayRecord .= ' <div class="form-group row border">
                <label class="col-form-label col-2">'.$records[$j][3].'</label>
                <label class="col-form-label col-5">'.$records[$j][1].'</label>
                <label class="col-form-label col-3">'.$records[$j][2].'</label>
                <a href="http://192.168.64.2/Catering/order/PreviewOrder.php?order='.$records[$j][3].'" class="btn-primary col-2 form-control ">Detail</a>
            </div>';
                }
            }
            else
            {
                $displayRecord = '<h2 align="center">Not Found</h2>';
            }
            echo $displayRecord
            ?>

        </div>


</div>





<script>

    $(document).ready(function () {

        $(document).on("change",'.changeColumn',function (e)
        {
                e.preventDefault();
                var formdata=new FormData($('#formId1')[0]);
                $.ajax({
                    url:"FindOrderServer.php",
                    method:"POST",
                    data:formdata,
                    contentType: false,
                    processData: false,
                    success:function (data)
                    {
                        $("#recordsAll").html(data);
                        // console.log(data);
                    }
                });
        });




    });





</script>
</body>
</html>
