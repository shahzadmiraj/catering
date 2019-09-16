<?php
/**
 * Created by PhpStorm.
 * User: shahzadmiraj
 * Date: 2019-09-07
 * Time: 11:31
 */

$orderId=$_GET['order'];
include_once ("../connection/connect.php");

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
<body>
<?php
include_once ("../webdesign/header/header.php");
?>
<div class="container"  style="margin-top:200px">

    <h1 align="center"> Selected Dishes / items Detail</h1>

        <div class="form-group row border ">
            <label class="font-weight-bold border-right col-1  ">No</label>
            <label class="font-weight-bold border-right col-2 ">dish name</label>
            <label class=" font-weight-bold border-right col-3 ">quantity</label>
            <label class=" font-weight-bold border-right col-2 ">each price</label>
            <label class="font-weight-bold border-right col-2 ">total</label>
            <label class=" font-weight-bold col-2 ">Detail</label>
        </div>

        <?php
        $sql='SELECT dd.id,d.name,dd.quantity,dd.price,d.id FROM dish_detail as dd INNER JOIN
dish as d 
on d.id=dd.dish_id
where 
 (dd.orderTable_id='.$orderId.') AND ISNULL(dd.expire_date)';
        $totalAmount=0;
        $dishesDetail=queryReceive($sql);
        for($i=0;$i<count($dishesDetail);$i++)
        {
            $totalAmount+=(int)$dishesDetail[$i][2]*(int)$dishesDetail[$i][3];
            echo '<div class=" row border ">
            <label class="border-right col-form-label col-1">'.$i.'</label>
            <label class="border-right col-form-label col-3">'.$dishesDetail[$i][1].'</label>
            <label class=" border-right col-form-label col-2">'.$dishesDetail[$i][2].'</label>
            <label class="border-right col-form-label col-2">'.$dishesDetail[$i][3].'</label>
            <label class=" border-right col-form-label col-2">'.(int)$dishesDetail[$i][2]*(int)$dishesDetail[$i][3].'</label>
            <a href="/Catering/dish/dishPreview.php?dishId='.$dishesDetail[$i][4].'&dishDetailId='.$dishesDetail[$i][0].'&order='.$_GET['order'].'&option=Allselected"  class="detailBtn form-control btn-primary col-2">Detail</a>
        </div>';
        }
        ?>





    <div class="col-12 p-3">
    <div class="col-12 row">
        <label class=" border col-form-label col-7"> dishes total amount</label>
        <label class=" border col-form-label col-5">
            <?php
                echo $totalAmount;

                $sql='SELECT `total_amount`,`extre_charges` FROM `orderTable` WHERE id='.$orderId.'';
                $orderDetail=queryReceive($sql);
            ?>
        </label>
    </div>

    <div class="col-12 row">
        <label class=" border col-form-label col-7"> extra charges</label>
        <label class=" border col-form-label col-5">

            <?php
                echo $orderDetail[0][1];
            ?>
        </label>
    </div>
    <div class="col-12 row">
        <label class=" border col-form-label col-7"> charges with amount</label>
        <label class=" border col-form-label col-5">

            <?php
            echo $orderDetail[0][1]+$totalAmount;
            ?>
        </label>
    </div>

    <div class="col-12 row">
        <label class=" border col-form-label col-7"> your demand amount</label>
        <label class=" border col-form-label col-5">
            <?php
            echo $orderDetail[0][0];
            ?>
        </label>
    </div>


    </div>
    <div class="col-12  row ">
        <a href="/Catering/order/PreviewOrder.php?order=<?php echo $_GET['order'];?>"  class="form-control btn-info col-5">Order Preview</a>
        <a href="/Catering/dish/dishDisplay.php?order=<?php echo $_GET['order'];?>" class="form-control btn-success col-5">dish Add +</a>
    </div>



</div>




<script>

</script>
</body>
</html>
