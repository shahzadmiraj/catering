<?php
/**
 * Created by PhpStorm.
 * User: shahzadmiraj
 * Date: 2019-09-10
 * Time: 14:04
 */
session_start();

if(!isset($_SESSION['username']))
{
    header("location:userLogin.php");
    exit();
}

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
            padding: auto;
        }
    </style>
</head>
<body class="alert-light container">
<?php
 include_once ("../webdesign/header/header.php");
?>

<div class="col-12 " style="margin-top:200px" >


    <div class="col-12 shadow card p-0 ">
<!--        $OrderStatus=array("running","cancel","delieved","clear");-->

        <h1 align="center" class="col-12">User Desplay</h1>
        <div class="col-12">
        <div class="form-group row">
            <a href="/Catering/customer/CustomerCreate.php?option=userDisplay" class="text-center  col-5 form-control btn-primary">Order Create</a>
            <a href="/Catering/order/FindOrder.php?is_active=0" class="text-center col-5  form-control btn-primary">Running Order</a>
        </div>

        <div class="form-group row">
            <a href="/Catering/order/FindOrder.php?is_active=2" class="col-5  text-center form-control btn-primary">deliver Orders</a>
            <a href="/Catering/order/FindOrder.php?is_active=3" class="col-5 text-center form-control btn-primary">Clear Orders</a>
        </div>
        <div class="form-group row">
            <a href="/Catering/order/FindOrder.php?is_active=1" class="col-5 text-center form-control btn-primary">Cancel Orders</a>
            <a href="/Catering/payment/transferPaymentReceive.php?option=userDisplay" class="col-5 text-center form-control btn-primary">Receive payment</a>
        </div>
        <div class="form-group row">
            <a href="/Catering/system/dish/dishesDetail.php" class="p-0 col-5 text-center form-control btn-primary">Guideline Dishes</a>
            <a href="/Catering/system/user/usercreate.php" class="col-5 text-center form-control btn-primary">User Create</a>
        </div>
        <div class="form-group row">
            <a  href="/Catering/user/logout.php" class="col-5 text-center form-control btn-primary">Log out</a>
        </div>
        </div>
    </div>

</div>
<script>



</script>
</body>
</html>

