<?php
/**
 * Created by PhpStorm.
 * User: shahzadmiraj
 * Date: 2019-09-08
 * Time: 23:30
 */
include_once ("../connection/connect.php");

$userId=$_GET['user_id'];
$paymentId=$_GET['payment'];
$orderid=$_GET['order'];

$sql='SELECT `id`, `amount`, `nameCustomer`, `receive`, `IsReturn`,`sendingStatus` FROM `payment` WHERE id='.$paymentId.'';
$paymentDetail=queryReceive($sql);
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


    <div class="col-12 shadow card">
        <h1 align="center">Send payment To User</h1>


        <div class="form-group row">
            <label class="col-4 col-form-label"> User </label>
            <select id="userIdlabel" class="col-8">
                <option value="none">None</option>
                <?php
                    $sql='SELECT id, username FROM user WHERE id !='.$userId.' ';
                    $userDetail=queryReceive($sql);
                    for($y=0;$y<count($userDetail);$y++)
                    {
                        echo '<option value='.$userDetail[$y][0].'>'.$userDetail[$y][1].'</option>';
                    }
                ?>
            </select>
        </div>
        <div class="form-group row">
            <label class="col-4 col-form-label"> payment ID</label>
            <input readonly value="<?php echo $paymentDetail[0][0]; ?>" id="paymentId" class="col-8 form-control">
        </div>
        <div class="form-group row">
            <label class="col-4 col-form-label"> Amount</label>
            <label class="col-8 col-form-label"> <?php

                echo $paymentDetail[0][1];
                ?></label>
        </div>
        <div class="form-group row">
            <label class="col-4 col-form-label"> customer Name</label>
            <label class="col-8 col-form-label"> <?php

                echo $paymentDetail[0][2];
                ?></label>
        </div>
        <div class="form-group row">
            <label class="col-4 col-form-label"> Receive Date</label>
            <label class="col-8 col-form-label"> <?php

                echo $paymentDetail[0][3];
                ?></label>
        </div>
        <div class="form-group row">
            <label class="col-4 col-form-label"> payment Status</label>
            <label class="col-8 col-form-label"> <?php

                if($paymentDetail[0][4]==0)
                {
                    echo "Get amount to customer";
                }
                else
                {
                    echo "return amount to customer";
                }
                ?></label>
        </div>


        <div class="form-group row">
            <a href="/Catering/payment/transferPayment.php?order=<?php echo $orderid; ?>&user_id=<?php echo $userId;?> " class="col-6 btn btn-danger "> Cancel</a>
            <input  id="paymentsend" type="button" class="col-6 btn btn-success" value="<?php

            if($paymentDetail[0][5]==0)
            {
                echo "Send";
            }
            else if ($paymentDetail[0][5]==1)
            {
                echo "Confirming";
            }
            else
            {
                echo "not part of this";
            }
            ?>">

        </div>

    </div>



</div>





<script>
    //window.history.back();
    $(document).ready(function () {
       $("#paymentsend") .click(function () {
          var btnsender=$(this).val();
          if(btnsender=='Send')
          {
              var userID=$("#userIdlabel").val();
              if(userID=='none')
              {
                  alert("please select User");
                  return false;
              }
              var paymentId=$("#paymentId").val();
              $.ajax({
                 url:"paymentServer.php",
                 data:{useid:userID,paymentId:paymentId,option:"paymentsend"} ,
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
                            window.location.href="/Catering/payment/transferPayment.php?order=<?php echo $orderid;?>&user_id=<?php echo $userId;?>";
                        }
                  }
              });

          }
          else if(btnsender=='Confirming')
          {
              alert("your request has been sent to the next user so please wait for it");
              window.location.href="/Catering/payment/transferPayment.php?order=<?php echo $orderid; ?>&user_id=<?php echo $userId;?>";
          }
       });

    });
</script>
</body>
</html>

