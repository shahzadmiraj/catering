<?php
/**
 * Created by PhpStorm.
 * User: shahzadmiraj
 * Date: 2019-09-08
 * Time: 14:15
 */

//$_POST["user_id"]=1;
//$_POST["orderTable_id"]=1;

if(!isset($_GET["user_id"]) && !isset($_GET["orderTable_id"]))
{
    echo 'orderTable id and user id is not GET';
    exit();
}


$userId=$_GET['user_id'];
$orderTable_id=$_GET['orderTable_id'];
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
    <form class="col-12 card shadow" id="from2">
        <input hidden name="user_id" value="<?php
        echo $userId;
        ?>">
        <input hidden name="orderTable_id" value="<?php
        echo $orderTable_id;
        ?>">
        <h1 align="center"> Get Payment</h1>
        <div class="form-group row">
            <label class="col-4 col-form-label">Name</label>
            <input type="text" name="name" class="col-8 form-control">
        </div>
        <div class="form-group row">
            <label class="col-4 col-form-label">Amount</label>
            <input type="number" name="Amount" class="col-8 form-control">
        </div>
        <div class="form-group row">
            <label class="col-4 col-form-label">Status amount</label>
            <select name="status" class="custom-select col-8">
                <option value="0">Get Amount</option>
                <option value="1">Return Amount</option>
            </select>
        </div>
        <div class="form-group row">
            <label class="col-4 col-form-label">Rating Customer</label>
            <span id="showRange" class="form-control col-2"></span>
            <input id="rangeInput" step="1" type="range" max="5" min="1" value="3" name="rating" class="form-control col-6">

        </div>

        <div class="form-group row">
            <label class="col-4 col-form-label">personality</label>
            <textarea type="text" name="personality" class="col-8 form-control"></textarea>
        </div>
        <div class="form-group row">
            <a href="http://192.168.64.2/Catering/order/PreviewOrder.php" class="form-control col-3 btn-danger">cancel</a>
            <button id="submitBtnfrom" type="submit" class="form-control col-3 btn-primary">Submit</button>

        </div>

    </form>

</div>





<script>

    $(document).ready(function () {

        $('#showRange').html($("#rangeInput").val());
        $("#rangeInput").change(function () {
            $('#showRange').html($("#rangeInput").val());
        });
        $("#submitBtnfrom").click(function (e) {
            e.preventDefault();
            var formdata=new FormData($("#from2")[0]);
            formdata.append("option","GetPayment");
             $.ajax({
              url:"paymentServer.php",
              method:"POST",
              data:formdata,
              contentType: false,
              processData: false,
              success:function (data)
              {
                  if(data!='')
                  {
                      alert(data);
                  }
                  else
                  {
                      window.history.back();
                  }
              }
          });
        });


    });
</script>
</body>
</html>
