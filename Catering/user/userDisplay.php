<?php
$hallid='';
$cateringid='';
if(isset($_GET['hallid']))
 $hallid =$_GET['hallid'];
if(isset($_GET['cateringid']))
    $cateringid=$_GET['cateringid'];
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


<div class="col-12 " style="margin-top:150px" >


    <div class="shadow card p-2 badge-warning">
<!--        $OrderStatus=array("running","cancel","delieved","clear");-->

            <h1 align="center" class="col-12">User Desplay</h1>
            <a href="/Catering/customer/CustomerCreate.php?option=userDisplay&hallid=<?php echo $hallid;?>&cateringid=<?php echo $cateringid;?>" class="mb-1 text-center   form-control btn-primary">Order Create</a>
            <a href="/Catering/order/FindOrder.php?order_status=Running&cateringid=<?php  echo $cateringid;?>&hallid=<?php echo $hallid;?>" class="mb-1 text-center   form-control btn-primary">Running Order</a>
            <a href="/Catering/order/FindOrder.php?order_status=Deliever&cateringid=<?php  echo $cateringid;?>&hallid=<?php echo $hallid;?>" class="mb-1  text-center form-control btn-primary">Deliever Orders</a>
            <a href="/Catering/order/FindOrder.php?order_status=Clear&cateringid=<?php  echo $cateringid;?>&hallid=<?php echo $hallid;?>" class="mb-1 text-center form-control btn-primary">Clear Orders</a>
            <a href="/Catering/order/FindOrder.php?order_status=Cancel&cateringid=<?php  echo $cateringid;?>&hallid=<?php echo $hallid;?>" class="mb-1 text-center form-control btn-primary">Cancel Orders</a>
            <a href="/Catering/payment/transferPaymentReceive.php?option=userDisplay" class="mb-1 text-center form-control btn-primary">Receive payment</a>
            <a href="/Catering/system/dish/dishesDetail.php" class="mb-1 text-center form-control btn-primary">Guideline Dishes</a>
            <a href="/Catering/system/user/usercreate.php" class="mb-1 text-center form-control btn-primary">User Create</a>
            <a  href="/Catering/payment/RemainingAmount.php" class="mb-1 text-center form-control btn-primary">Remaining payments</a>
            <a  href="/Catering/user/logout.php" class="mb-1 text-center form-control btn-primary">Log out</a>

    </div>

</div>
<script>



</script>
</body>
</html>

