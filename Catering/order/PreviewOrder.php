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
    if (!$result) {
        echo("Error description: " . mysqli_error($connect));
    }else{
        return mysqli_fetch_all($result);
    }
}
//$orderId='';
//if(isset($_GET['order']))
//{
//    $orderId=$_GET['order'];
//}
//if(isset($_SESSION['order']))
//{
//    $orderId=$_SESSION['order'];
//}
//
//if(isset($_SESSION['order']) && isset($_GET['order']))
//{
//    echo "confusing of session and Get";
//    exit();
//}
//if($orderId=="")
//{
//    echo "Set session or Get for Order iD";
//    exit();
//}

if(!isset($_SESSION['order']))
{
    echo "session is not set";
    exit();
}
$orderId=$_SESSION['order'];

$sql='SELECT (SELECT p.name FROM person as p WHERE p.id=ot.person_id),ot.person_id FROM orderTable as ot WHERE ot.id='.$orderId.'';
$orderDetailPerson= queryReceive($sql);
$customerID=$orderDetailPerson[0][1];
$_SESSION['customer']=$customerID;
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
            <a href="http://192.168.64.2/Catering/customer/customerEdit.php?customer=<?php echo $customerID;?>" class="text-center col-5 form-control btn-success">Customer Preview</a>
            <a href="http://192.168.64.2/Catering/order/orderEdit.php?order=<?php echo $orderId;?>" class="text-center col-5 form-control btn-success">Order Preview</a>
        </div>

        <div class="form-group row">
            <a href="http://192.168.64.2/Catering/dish/AllSelectedDishes.php" class="col-5  text-center form-control btn-success">Dish Preview</a>
            <a href="#" class="col-5 text-center form-control btn-success">Payment History</a>
        </div>
        <div class="form-group row">
            <a href="http://192.168.64.2/Catering/payment/getPayment.php?user_id=<?php echo $_SESSION['userid'];?>&orderTable_id=<?php echo $orderId;?>" class="col-5 text-center form-control btn-success">Get payment</a>
            <a href="#" class="col-5 text-center form-control btn-success">Transfer payment</a>
        </div>

        <div class="form-group row">
            <a href="#" class="col-5 text-center form-control btn-success">Receive payment</a>
            <a href="http://192.168.64.2/Catering/user/userDisplay.php" class="col-5 text-center form-control btn-success">User Display</a>
        </div>
    </div>

</div>




<script>



</script>
</body>
</html>
