<?php
/**
 * Created by PhpStorm.
 * User: shahzadmiraj
 * Date: 2019-09-08
 * Time: 14:15
 */

include_once ("../connection/connect.php");
$_POST["user_id"]=1;
$_POST["orderTable_id"]=1;
$userId=$_POST['user_id'];
$orderTable_id=$_POST['orderTable_id'];

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
    <div class="col-12 card shadow" id="from3">
        <h1 align="center">your payments</h1>
        <div class="form-group row border">
            <label class="font-weight-bold col-2 col-form-label">ID</label>
            <label class="font-weight-bold col-4 col-form-label">Amount</label>
            <label class="font-weight-bold col-4 col-form-label">Date</label>
            <label class="font-weight-bold col-2 col-form-label">Send</label>
        </div>


        <?php
        $sql='SELECT py.id,py.amount,py.receive FROM payment as py
WHERE (py.user_id='.$userId.') AND (py.orderTable_id='.$orderTable_id.') AND (py.sendingStatus in (0,1))  order BY
py.receive  DESC';
        $paymentDetail=queryReceive($sql);
        for($l=0;$l<count($paymentDetail);$l++)
        {
            echo '<div class="form-group row border">
            <label class="col-2 col-form-label">'.$paymentDetail[$l][0].'</label>
            <label class="col-3 col-form-label">'.$paymentDetail[$l][1].'</label>
            <label class="col-5 col-form-label">'.$paymentDetail[$l][2].'</label>
            <a href="#'.$paymentDetail[$l][0].'" class="col-2 form-control btn-primary">Send</a>
        </div>';
        }
        ?>
    </div>


</div>





<script>

    $(document).ready(function () {



    });
</script>
</body>
</html>
