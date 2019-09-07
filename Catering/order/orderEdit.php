<?php
/**
 * Created by PhpStorm.
 * User: shahzadmiraj
 * Date: 2019-09-01
 * Time: 21:31
 */
include_once ("../connection/connect.php");
session_start();
if(!isset($_SESSION['customer'])|| !isset($_SESSION['order']))
{
    echo "customer or order of session is not created";
    exit();
}
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
$orderId=$_SESSION['order'];
$sql='SELECT `id`, `total_amount`, `order_comments`, `total_person`, `is_active`, `destination_date`, `booking_date`, `destination_time`, `address_id`, `extre_charges`, `person_id` FROM `order` WHERE id='.$orderId.'';
$orderDetail=queryReceive($sql);
$addressId=$orderDetail[0][8];
$sql='SELECT `id`, `address_city`, `address_town`, `address_street_no`, `address_house_no`, `person_id` FROM `address` WHERE id='.$addressId.'';
$addresDetail=queryReceive($sql);

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
    <h1 align="center"> Order View and EDIT</h1>
    <form >
        <div class="form-group row">
            <label for="persons" class="col-4 col-form-label"> no of guests</label>
            <?php
                echo '<input data-column="total_person" type="number" name="persons" id="persons" class=" order col-8 form-control" value="'.$orderDetail[0][3].'">';
            ?>
        </div>

        <div class="form-group row">
            <label for="time" class="col-4 col-form-label">delivery Time</label>
            <?php
                $timeSet=date('H:i',time($orderDetail[0][7]));
                echo '<input data-column="destination_time"  type="time" name="time" id="time"  class=" order col-8 form-control" value="'.$timeSet.'">';
            ?>

        </div>

        <div class="form-group row">
            <label for="date" class="col-4 col-form-label">delivery Date</label>
            <?php
                echo '<input data-column="destination_date"  type="date" name="date" id="date" class="order change col-8 form-control" value="'.$orderDetail[0][5].'">';
            ?>

        </div>
        <div class="form-group row">
            <label for="describe" class="col-4 col-form-label">describe order </label>
            <?php
            echo '<input data-column="order_comments"  type="text" id="describe" name="describe" class="order change form-control col-8 form-control"  value="'.$orderDetail[0][2].'">';
            ?>

        </div>
        <h3 align="center"> Deliver Address</h3>
        <div class="form-group row">
            <label for="area" class="col-4 col-form-label">area / block </label>
            <?php
                echo '<input  data-column="address_town" type="text" data-addressid='.$addressId.' name="area" id="area" class=" address col-8 form-control" value="'.$addresDetail[0][2].'">'
            ?>

        </div>
        <div class="form-group row">
            <label for="streetNO" class="col-4 col-form-label">Street no #</label>
            <?php
                echo '<input data-column="address_street_no"  type="number" data-addressid='.$addressId.' name="streetno" id="streetNO" class=" address col-8 form-control" value="'.$addresDetail[0][3].'">';
            ?>

        </div>
        <div class="form-group row">
            <label for="houseno" class="col-4 col-form-label">house no# </label>
            <?php
                echo '<input  data-column="address_house_no"  type="number" data-addressid='.$addressId.' name="houseno" id="houseno" class=" address col-8 form-control" value="'.$addresDetail[0][4].'">';
            ?>

        </div>

        <div class="form-group row">
            <label class="form-check-label col-4" for="extra_charger">extra charger</label>
            <?php
                echo '<input data-column="extre_charges"  type="number" class=" order col-8 form-control" id="extra_charger"  value="'.$orderDetail[0][9].'" >';
            ?>

        </div>

        <div class="form-group row">
            <label class="form-check-label col-4" for="total_amount">total amount</label>

            <?php
                echo '<input  data-column="total_amount" type="number" class=" order col-8 form-control" id="total_amount"  value="'.$orderDetail[0][1].'">';
            ?>

        </div>

        <div class="form-group row">
            <label class="form-check-label col-4" for="booking_date">order booking date</label>

            <?php
                echo '<input  type="date" readonly class="col-8 form-control" id="booking_date"  value="'.$orderDetail[0][6].'">';
            ?>

        </div>

        <div class="form-group row">
            <button type="button"  id='cancel'class="form-control col-4 btn btn-danger"> cancel</button>
            <button type="button" id="submit" class="form-control col-4 btn-success"> ok</button>

        </div>


    </form>
</div>




<script>
    $(document).ready(function ()
    {



        $(document).on("change",'.order',function () {
            var columnName=$(this).data("column");
            var text=$(this).val();

            $.ajax({
                url: "orderEditServer.php",
                data:{column_name:columnName,value:text,option:'orderChange'},
                dataType:"text",
                method:"POST",
                success:function (data) {
                    if(data!='')
                    {
                        alert(data);
                    }
                }
            });

        });

        $(document).on("change",'.address',function () {
            var columnName=$(this).data("column");
            var addressId=$(this).data("addressid");
            var text=$(this).val();
            $.ajax({
                url: "orderEditServer.php",
                data:{column_name:columnName,value:text,option:'addressChange',addressId:addressId},
                dataType:"text",
                method:"POST",
                success:function (data) {
                    if(data!='')
                    {
                        alert(data);
                    }
                }
            });

        });

    });

</script>
</body>
</html>
