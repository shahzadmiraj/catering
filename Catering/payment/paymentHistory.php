<?php
/**
 * Created by PhpStorm.
 * User: shahzadmiraj
 * Date: 2019-09-01
 * Time: 21:31
 */
include_once ("../connection/connect.php");



$userId=$_GET['user_id'];
$orderTable_id=$_GET['order'];
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

    <h1 align="center">payment History</h1>
    <a class="btn-success form-control col-4 " href="http://192.168.64.2/Catering/order/PreviewOrder.php?order=<?php echo $orderTable_id; ?>"> <- Preview Order</a>
    <div class="col-12  shadow border card" style="background-color: #80bdff">
        <?php
        $sql='SELECT py.id,(SELECT u.username FROM user as u where u.id=py.user_id) as sender,
(SELECT u.username FROM user as u where u.id=t.user_id) as receiver,py.amount,
t.senderTimeDate,t.Isconfirm,py.receive,py.nameCustomer,py.IsReturn,t.Isget
FROM orderTable as ot INNER JOIN payment as py
on ot.id=py.orderTable_id
INNER join transfer as t
on py.id=t.payment_id
WHERE (ot.id='.$orderTable_id.')';
        $historyPayment=queryReceive($sql);
        $display='';

for($k=0;$k<count($historyPayment);$k++)
{

   $display.=' <div class="col-12  shadow border card" >
        <div class="form-group row" >
            <label class="col-4 col-form-label" > Payment Id </label >
            <label class="col-8 col-form-label" > '.$historyPayment[$k][0].'</label >
        </div >
        <div class="form-group row" >
            <label class="col-4 col-form-label" > Sender User </label >
            <label class="col-8 col-form-label" > '.$historyPayment[$k][1].'</label >
        </div >
        <div class="form-group row" >
            <label class="col-4 col-form-label" > Receive User </label >
            <label class="col-8 col-form-label" > '.$historyPayment[$k][2].'</label >
        </div >
        <div class="form-group row" >
            <label class="col-4 col-form-label" > Amount</label >
            <label class="col-8 col-form-label" > '.$historyPayment[$k][3].'</label >
        </div >
        <div class="form-group row" >
            <label class="col-4 col-form-label" > Sending Date </label >
            <label class="col-8 col-form-label" > '.$historyPayment[$k][4].'</label >
        </div >
        <div class="form-group row" >
            <label class="col-4 col-form-label" > Receiving Date </label >
            <label class="col-8 col-form-label" > ';

            if($historyPayment[$k][5]=="")
            {
                $display.= "request has delivered for confirm to user";
            }
            else
            {
                $display.= $historyPayment[$k][5];
            }
         $display.= ' </label >
        </div >

        <div class="form-group row" >
            <label class="col-4 col-form-label" > Geting payment Date </label >
            <label class="col-8 col-form-label" > '.$historyPayment[$k][6].'</label >
        </div >
        <div class="form-group row" >
            <label class="col-4 col-form-label" > Customer Name </label >
            <label class="col-8 col-form-label" > '.$historyPayment[$k][7].'</label >
        </div >
        <div class="form-group row" >
            <label class="col-4 col-form-label" > payment status </label >
            <label class="col-8 col-form-label" > ';
             if($historyPayment[$k][8]==0)
             {
                 $display.='get payment from customer';
             }
             else
             {

                 $display.='return payment to customer';
             }


             $display.='</label >
        </div >
        <div class="form-group row" >
            <label class="col-4 col-form-label" > transfer Status </label >
            <label class="col-8 col-form-label" > ';

                 if($historyPayment[$k][9]==0)
                 {
                     $display.="not confirm";
                 }
                 else
                 {
                     $display.="yes,I get the amount from user";
                 }
                $display.= '
            </label >
        </div >
    </div >';
   echo $display;

}

?>

    </div>



    <h1 align = "center" > Payment user have on to it </h1 >
    <div class="col-12  shadow border card" style="background-color: #c69500" >

        <?php

        $sql='SELECT py.id,(SELECT u.username FROM user as u where u.id=py.user_id), py.amount,py.receive,py.nameCustomer,py.IsReturn FROM orderTable as ot INNER JOIN payment as py on ot.id=py.orderTable_id WHERE (ot.id='.$orderTable_id.') AND (py.sendingStatus=0)';
        $WhyPayment=queryReceive($sql);
$display='';
        for($t=0;$t<count($WhyPayment);$t++)
        {

    $display.='<div class="col-12  shadow border card mb-3" >
        <div class="form-group row" >
            <label class="col-4 col-form-label" > Payment Id </label >
            <label class="col-8 col-form-label" > '.$WhyPayment[$t][0].'</label >
        </div >
        <div class="form-group row" >
            <label class="col-4 col-form-label" > User Name </label >
            <label class="col-8 col-form-label" > '.$WhyPayment[$t][1].'</label >
        </div >
        <div class="form-group row" >
            <label class="col-4 col-form-label" > Amount</label >
            <label class="col-8 col-form-label" > '.$WhyPayment[$t][2].'</label >
        </div >
        <div class="form-group row" >
            <label class="col-4 col-form-label" > Receiving Date </label >
            <label class="col-8 col-form-label" > '.$WhyPayment[$t][3].'</label >
        </div >
        <div class="form-group row" >
            <label class="col-4 col-form-label" > Customer Name </label >
            <label class="col-8 col-form-label" > '.$WhyPayment[$t][4].'</label >
        </div >
        <div class="form-group row" >
            <label class="col-4 col-form-label" > payment status </label >
            <label class="col-8 col-form-label" > ';
        if($WhyPayment[$t][5]==0)
        {
            $display.='get payment from customer';
        }
        else
        {

            $display.='return payment to customer';
        }
            $display.='</label >
        </div >
    </div >';

        }
        echo $display;

?>




    </div>
</div>





<script>


</script>
</body>
</html>
