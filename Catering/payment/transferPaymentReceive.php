<?php
/**
 * Created by PhpStorm.
 * User: shahzadmiraj
 * Date: 2019-09-08
 * Time: 14:15
 */

include_once ("../connection/connect.php");

$userId='';
$orderTable_id="";
if(!isset($_GET['option']))
{
    $userId = $_GET['user_id'];
    $orderTable_id = $_GET['order'];
}
$userId = $_SESSION['userid'];

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
<body class="alert-light">
<?php
include_once ("../webdesign/header/header.php");
?>
<div class="container"  style="margin-top:150px">

    <div id="from3">
        <h1 align="center">your payments Receive Requests</h1>

        <?php
        if(!isset($_GET['option']))
        {
          echo '
        <a class="btn-success form-control col-4 " href="/Catering/order/PreviewOrder.php?order='.$orderTable_id.'"> <- Preview Order</a>';
        }
        else
        {

            echo '
        <a class="btn-success form-control col-4 " href="/Catering/user/userDisplay.php"> <- Preview Order</a>';
        }
        ?>
        <div class="form-group row border">
            <label class="font-weight-bold col-2 col-form-label">ID</label>
            <label class="font-weight-bold col-4 col-form-label">User</label>
            <label class="font-weight-bold col-4 col-form-label">Send Date</label>
            <label class="font-weight-bold col-2 col-form-label">View</label>
        </div>


        <?php


        if(!isset($_GET['option']))
        {
            $sql = 'SELECT py.id,(SELECT u.username FROM user as u WHERE u.id=py.user_id) as username,py.amount,py.nameCustomer,py.IsReturn,t.senderTimeDate,py.receive,t.id,py.sendingStatus FROM orderTable as ot INNER join payment as py on ot.id=py.orderTable_id INNER join transfer as t on py.id=t.payment_id where (ot.id=' . $orderTable_id . ') AND (t.user_id=' . $userId . ')AND (py.sendingStatus in (1,2))
';
        }
        else
        {
            //userDisplay
            $sql = 'SELECT py.id,(SELECT u.username FROM user as u WHERE u.id=py.user_id) as username,py.amount,py.nameCustomer,py.IsReturn,t.senderTimeDate,py.receive,t.id,py.sendingStatus FROM orderTable as ot INNER join payment as py on ot.id=py.orderTable_id INNER join transfer as t on py.id=t.payment_id where   (t.user_id=' . $userId . ') AND (py.sendingStatus in (1,2))
';
        }
        $paymentDetail=queryReceive($sql);
        $displayDetailOfPayment='';
        for($l=0;$l<count($paymentDetail);$l++)
        {
            $displayDetailOfPayment= '<div class="form-group row border">
            <label class="col-2 col-form-label">'.$paymentDetail[$l][0].'</label>
            <label class="col-4 col-form-label">'.$paymentDetail[$l][1].'</label>
            <label class="col-4 col-form-label">'.$paymentDetail[$l][5].'</label>
            <input type="button" data-formid="formDetail'.$l.'" class="showDetail col-2 form-control btn-primary" value="Detail">
            </div>
            
            
            
            
            
            
            <form class="allforms col-12 card shadow  " id="formDetail'.$l.'" style="background-color:gainsboro;display: none">
            
            <div class="form-group row">
            <label class="col-4 col-form-label">payment id</label>
            <label class="col-6 col-form-label">'.$paymentDetail[$l][0].'</label>
            </div>
            <div class="form-group row">
            <label class="col-4 col-form-label">User Name</label>
            <label class="col-6 col-form-label">'.$paymentDetail[$l][1].'</label>
            </div>
            <div class="form-group row">
            <label class="col-4 col-form-label">Amount</label>
            <label class="col-6 col-form-label">'.$paymentDetail[$l][2].'</label>
            </div>
            <div class="form-group row">
            <label class="col-4 col-form-label">Customer name</label>
            <label class="col-6 col-form-label">'.$paymentDetail[$l][3].'</label>
            </div>
            <div class="form-group row">
            <label class="col-4 col-form-label">payment Status</label>
            <label class="col-6 col-form-label">';

            if($paymentDetail[$l][4]==0)
            {
                $displayDetailOfPayment.= "Get amount from customer";
            }
            else
            {
                $displayDetailOfPayment.= "return amount to customer";
            }


            $displayDetailOfPayment.='</label>
            </div>
            <div class="form-group row">
            <label class="col-4 col-form-label">User Get amount Date</label>
            <label class="col-6 col-form-label">'.$paymentDetail[$l][6].'</label>
            </div>
            <div class="form-group row">
            <label class="col-4 col-form-label">User senting amount Date</label>
            <label class="col-6 col-form-label">'.$paymentDetail[$l][5].'</label>
            </div>
            <div class="form-group row">';

            if($paymentDetail[$l][8]==1)
            {

                $displayDetailOfPayment.= '<input  data-paymentid="'.$paymentDetail[$l][0].'" data-tranferid="'.$paymentDetail[$l][7].'" type="button" class="configration col-6 form-control btn btn-danger" value="unconfirm">
                                        <input data-paymentid="'.$paymentDetail[$l][0].'" data-tranferid="'.$paymentDetail[$l][7].'" type="button" class="configration col-6 form-control btn btn-success" value="confirm">';
            }
            else if($paymentDetail[$l][8]==2)
            {

                $displayDetailOfPayment.='<input  type="button" class="confirmed btn btn-info col-6" value="confirmed">';

            }
            $displayDetailOfPayment.='</div>
            </form>
            ';
        }
        echo $displayDetailOfPayment;
        ?>
    </div>


</div>





<script>


    $(document).ready(function () {
        var previous='';
        $('.showDetail').click(function ()
        {
            var formid=$(this).data("formid");
            var value=$(this).val();
            if((previous!=formid)&& (previous!=''))
            {
                $("#"+previous).val("Detail");
                $("#"+previous).hide('slow');
            }
            previous=formid;
            if(value=="Detail")
            {
                $(this).val("preview");
                $("#"+formid).show('slow');
            }
            else if(value=="preview")
            {
                $(this).val("Detail");
                $("#"+formid).hide('slow');
            }
        });

        $(".configration").click(function ()
        {
            var tranferid=$(this).data("tranferid");
            var paymentid=$(this).data("paymentid");
            var value=$(this).val();
            $.ajax({
                url:"paymentServer.php",
                data:{paymentid:paymentid,value:value,tranferid:tranferid,option:"paymentconfigration"} ,
                dataType:"text",
                method:"POST",
                success:function (data)
                {
                    if(data!='')
                    {
                        alert(data);
                    }
                    else
                    {
                        location.reload(true);
                    }
                }
            });
        });
        $(".confirmed").click(function () {
           alert("The payment has been confirmed by you");
        });

    });
</script>
</body>
</html>
