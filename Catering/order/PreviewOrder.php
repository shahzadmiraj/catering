<?php
/**
 * Created by PhpStorm.
 * User: shahzadmiraj
 * Date: 2019-09-01
 * Time: 21:31
 */
include_once ("../connection/connect.php");
session_start();
function queryReceive($sql)
{
    global $connect;
    $result = mysqli_query($connect, $sql);
    if (!$result)
    {   echo $sql;
        echo("Error description: " . mysqli_error($connect));
    }else{
        return mysqli_fetch_all($result);
    }
}

$orderId=$_GET['order'];

$sql='SELECT (SELECT p.name FROM person as p WHERE p.id=ot.person_id),ot.person_id FROM orderTable as ot WHERE ot.id='.$orderId.'';
$orderDetailPerson= queryReceive($sql);
$customerID=$orderDetailPerson[0][1];
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
<body class="alert-light">
<?php
include_once ("../webdesign/header/header.php");
?>
<div class="container"  style="margin-top:180px">


    <h1 align="center">Order Preview</h1>
    <div class="col-12 shadow card p-3">
        <h4 class="col-12">

            <div class="form-group row">
                <label class="col-form-label col-6">Customer Name</label>
                <label class="col-form-label col-6"><?php
                    echo  $orderDetailPerson[0][0];
                    ?></label>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-6">Order ID</label>
                <label class="col-form-label col-6"><?php
                    echo  $orderId;
                    ?></label>
            </div>
        </h4>
        <div class="form-group row">
            <a href="../customer/customerEdit.php?customer=<?php echo $customerID;?>&order=<?php echo $orderId;?>&option=PreviewOrder" class="text-center col-5 form-control btn-success">Customer Preview</a>
            <a href="../order/orderEdit.php?order=<?php echo $orderId;?>&option=PreviewOrder" class="text-center col-5 form-control btn-success">Order Preview</a>
        </div>

        <div class="form-group row">
            <a href="../dish/AllSelectedDishes.php?order=<?php echo $orderId;?>&option=PreviewOrder" class="col-5  text-center form-control btn-success">Dish Preview</a>
            <a href="../payment/paymentHistory.php?user_id=<?php echo $_SESSION['userid'];?>&order=<?php echo $orderId;?>" class="col-5 text-center form-control btn-success">Payment History</a>
        </div>
        <div class="form-group row">
            <a href="../payment/getPayment.php?user_id=<?php echo $_SESSION['userid'];?>&order=<?php echo $orderId;?>" class="col-5 text-center form-control btn-success">Get payment</a>
            <a href="../payment/transferPayment.php?user_id=<?php echo $_SESSION['userid'];?>&order=<?php echo $orderId;?>" class="col-5 text-center form-control btn-success">Transfer payment</a>
        </div>

        <div class="form-group row">
            <a href="../payment/transferPaymentReceive.php?user_id=<?php echo $_SESSION['userid'];?>&order=<?php echo $orderId;?>" class="col-5 text-center form-control btn-success">Receive payment</a>
            <a href="../user/userDisplay.php" class="col-5 text-center form-control btn-success">User Display</a>
        </div>
    </div>

</div>




<script>



</script>
</body>
</html>
