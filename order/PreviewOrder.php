<?php
/**
 * Created by PhpStorm.
 * User: shahzadmiraj
 * Date: 2019-09-01
 * Time: 21:31
 */
include_once ("../connection/connect.php");

$hallid="";
$cateringid='';

$orderId=$_GET['order'];
if(isset($_GET['order']))
{
    $sql='SELECT od.hall_id,od.catering_id FROM orderDetail as  od WHERE od.id='.$orderId.'';
    $result=queryReceive($sql);
    if($result[0][0]!="")
    {
        $hallid=$result[0][0];
    }
    else
    {
        $cateringid=$result[0][1];
    }
}

$_SESSION['userid']=1;

$sql='SELECT (SELECT p.name FROM person as p WHERE p.id=od.person_id),od.person_id,(SELECT p.image FROM person as p WHERE p.id=od.person_id) FROM orderDetail as od WHERE od.id='.$orderId.'';
$orderDetailPerson= queryReceive($sql);
$customerID=$orderDetailPerson[0][1];
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
    <link rel="stylesheet" href="../webdesign/css/complete.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">

    <style>

    </style>
</head>
<body>
<?php
include_once ("../webdesign/header/header.php");
?>

<div class="jumbotron  shadow" style="background-image: url(https://www.myofficeapps.com/wp-content/uploads/2017/10/streamline-process.jpg);background-size:100% 130%;background-repeat: no-repeat">

    <div class="card-body text-center" style="opacity: 0.7 ;background: #fdfdff;">
        <h3 ><i class="fas fa-book fa-2x mr-2"></i>Order informations </h3>
    </div>

</div>
<div class="row justify-content-center col-12" style="margin-top: -60px">

    <div class="card text-center card-header">
    <img src="<?php

    if($orderDetailPerson[0][2]=="")
    {
        echo 'https://www.pavilionweb.com/wp-content/uploads/2017/03/man-300x300.png';
    }
    else
    {
        echo $orderDetailPerson[0][2];
    }

    ?> " style="height: 20vh;" class="figure-img rounded-circle" alt="image is not set">
        <h5 ><?php
            echo  $orderDetailPerson[0][0];
            ?></h5>
        <label >Order ID:<?php
            echo  $orderId;
            ?></label>
    </div>
</div>



<div class="container row m-auto">


    <a href="/Catering/customer/customerEdit.php?customer=<?php echo $customerID;?>&order=<?php echo $orderId;?>&option=PreviewOrder&name=<?php echo $orderDetailPerson[0][0];?>&image=<?php echo $orderDetailPerson[0][2]?>" class="h-25 col-5 shadow text-dark m-2 text-center"><i class="fas fa-user-edit fa-5x"></i><h4>Customer Preview</h4></a>
        <?php
            if(isset($hallid))
            {
                //1 hall order edit                //2 make hall order to user displaye
                echo '<a href="../company/hallBranches/EdithallOrder.php?hallid='.$hallid.'&order='.$orderId.'" class="h-25 col-5 shadow text-dark m-2 text-center"><i class="fas fa-cart-arrow-down fa-5x"></i><h4>Order Edit</h4></a>

            <a href="/Catering/user/userDisplay.php?hallid='.$hallid.'" class="h-25 col-5 shadow text-dark m-2 text-center"><i class="fas fa-grip-horizontal fa-5x"></i><h4>User Display</h4></a>

';

            }
            else
            {
                //catering order editor                  //2 make catering order to user displaye
                echo '<a href="/Catering/order/orderEdit.php?order='.$orderId.'&option=PreviewOrder" class="h-25 col-5 shadow text-dark m-2 text-center"><i class="fas fa-cart-arrow-down fa-5x"></i><h4>Order edit</h4></a>

            <a href="/Catering/user/userDisplay.php?cateringid='.$cateringid.'" class="h-25 col-5 shadow text-dark m-2 text-center"><i class="fas fa-grip-horizontal fa-5x"></i><h4>User Display</h4></a>
';
            }
        ?>

            <a href="/Catering/dish/AllSelectedDishes.php?order=<?php echo $orderId;?>&option=PreviewOrder&name=<?php echo $orderDetailPerson[0][0];?>&image=<?php echo $orderDetailPerson[0][2]?>" class="h-25 col-5 shadow text-dark m-2 text-center"><i class="fas fa-file-word fa-5x"></i><h4>Bill Detail/ extend  </h4></a>
            <a href="/Catering/payment/paymentHistory.php?user_id=<?php echo $_SESSION['userid'];?>&order=<?php echo $orderId;?>&name=<?php echo $orderDetailPerson[0][0];?>&image=<?php echo $orderDetailPerson[0][2]?>" class="h-25 col-5 shadow text-dark m-2 text-center"><i class="fas fa-history fa-5x"></i><h4>Payment History</h4></a>

            <a href="/Catering/payment/getPayment.php?user_id=<?php echo $_SESSION['userid'];?>&order=<?php echo $orderId;?>&name=<?php echo $orderDetailPerson[0][0];?>&image=<?php echo $orderDetailPerson[0][2]?>" class="h-25 col-5 shadow text-dark m-2 text-center"><i class="far fa-money-bill-alt fa-5x"></i><h4>Get payment from customer</h4></a>
            <a href="../payment/paymentDisplaySend.php?user_id=<?php echo $_SESSION['userid'];?>&order=<?php echo $orderId;?>&name=<?php echo $orderDetailPerson[0][0];?>&image=<?php echo $orderDetailPerson[0][2]?>" class="h-25 col-5 shadow text-dark m-2 text-center"> <i class="fas fa-share-alt fa-5x"></i><h4>Transfer payment <p>(user to user)</p> </h4></a>

    <a href="/Catering/payment/transferPaymentReceive.php?user_id=<?php echo $_SESSION['userid'];?>&order=<?php echo $orderId;?>&name=<?php echo $orderDetailPerson[0][0];?>&image=<?php echo $orderDetailPerson[0][2]?>" class="h-25 col-5 shadow text-dark m-2 text-center"><i class="fas fa-clipboard-check fa-5x"></i><h4>Payment Receiving Request <p>(user to user)</p> </h4></a>


</div>



<?php
include_once ("../webdesign/footer/footer.php");
?>

<script>



</script>
</body>
</html>
