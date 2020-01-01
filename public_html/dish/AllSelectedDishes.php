<?php
/**
 * Created by PhpStorm.
 * User: shahzadmiraj
 * Date: 2019-09-07
 * Time: 11:31
 */

include_once ("../connection/connect.php");

$orderId=$_SESSION['order'];

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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <link rel="stylesheet" href="../webdesign/css/complete.css">

    <style>

    </style>
</head>
<body class="text-white">

<?php
include_once ("../webdesign/header/header.php");
?>
<div class="jumbotron  shadow" style="background-image: url(https://qph.fs.quoracdn.net/main-qimg-b1822af85b86aabaa253ad7948880cb7);background-size:100% 115%;background-repeat: no-repeat">

    <div class="card-header text-center" style="opacity: 0.7 ;background: white;">
        <h3 class="text-dark"><i class="fas fa-file-word fa-3x mr-2 "></i>BILL DETAIL</h3>
    </div>

</div>




<div class="container">


    <div class="row justify-content-center col-12" style="margin-top: -60px">

        <div class="card text-center card-header">
            <img src="

            <?php

            $sql="SELECT DISTINCT ot.id, (SELECT p.name FROM person as p WHERE p.id=ot.person_id), (SELECT sum(py.amount) FROM payment as py WHERE (py.IsReturn=0)AND(py.orderDetail_id=ot.id)) ,ot.id,ot.total_amount, (SELECT SUM(dd.price*dd.quantity) FROM dish_detail as dd WHERE dd.orderDetail_id=ot.id),(SELECT p.image FROM person as p WHERE p.id=ot.person_id) FROM orderDetail as ot LEFT join payment as py on ot.id=py.orderDetail_id WHERE ot.id=".$orderId."";
            $details=queryReceive($sql);
            if($details[0][6]=="")
            {
                echo 'https://www.pavilionweb.com/wp-content/uploads/2017/03/man-300x300.png';
            }
            else
            {
                echo $details[0][6];
            }

            ?> " style="height: 20vh;" class="figure-img rounded-circle" alt="image is not set">
            <h5 ><?php
                echo  $details[0][1];
                ?></h5>
            <label >Order ID:<?php
                echo  $details[0][0];
                ?></label>
        </div>
    </div>

    <?php


    echo '
        <div class="col-12 shadow card-header mb-3 border">
    <div class="form-group row">
        <label class="col-6 form-check-label"> received amount</label>
        <label class="col-6 form-check-label">'.(int)$details[0][2].' </label>
    </div>
    <div class="form-group row">
        <label class="col-6 form-check-label"> System  Amount</label>
        <label class="col-6 form-check-label"> '.(int)$details[0][5].'</label>
    </div>
    <div class="form-group row">
        <label class="col-6 form-check-label"> remaining system amount</label>
        <label class="col-6 form-check-label">'.(int) ($details[0][5]-$details[0][2]).' </label>
    </div>
    <div class="form-group row">
        <label class="col-6 form-check-label"> your demanded amount</label>
        <label class="col-6 form-check-label">'.(int) $details[0][4].' </label>
    </div>
    <div class="form-group row">
        <label class="col-6 form-check-label">remaining demand amount </label>
        <label class="col-6 form-check-label"> '.(int) ($details[0][4]-$details[0][2]).'</label>
    </div>
    
    </div>
    ';
    ?>


<div class="col-12" style="overflow: auto">
        <div class="form-group row border">
            <label class="font-weight-bold border-right col-3 "><h1 class="fas fa-concierge-bell mr-2"></h1> dish name</label>
            <label class=" font-weight-bold border-right col-3 "><h1 class="fas fa-hashtag mr-2"></h1>quantity</label>
            <label class=" font-weight-bold border-right col-3 "><h1 class="far fa-money-bill-alt mr-2"></h1>each price</label>
            <label class="font-weight-bold border-right col-3 "><h1 class="fas fa-list-alt mr-2"></h1>total</label>

        </div>

        <?php
        $sql='SELECT dd.id,d.name,dd.quantity,dd.price,d.id FROM dish_detail as dd INNER JOIN
dish as d 
on d.id=dd.dish_id
where 
 (dd.orderDetail_id='.$orderId.') AND ISNULL(dd.expire_date)';
        $totalAmount=0;
        $dishesDetail=queryReceive($sql);
        for($i=0;$i<count($dishesDetail);$i++)
        {
            $totalAmount+=(int)$dishesDetail[$i][2]*(int)$dishesDetail[$i][3];
            echo '    
            <a href="dishPreview.php?dishId='.$dishesDetail[$i][4].'&dishDetailId='.$dishesDetail[$i][0].'&order='.$orderId.'&option=Allselected" class="row card-body border text-white p-0 shadow" >
            <label class="border-right col-form-label col-3">'.$dishesDetail[$i][1].'</label>
            <label class="border-right col-form-label col-3">'.$dishesDetail[$i][2].'</label>
            <label class="border-right col-form-label col-3">'.$dishesDetail[$i][3].'</label>
            <label class="border-right col-form-label col-3">'.(int)$dishesDetail[$i][2]*(int)$dishesDetail[$i][3].'</label>
            
            
            </a>';
        }








        ?>
</div>








    <div class="col-12  row justify-content-center mt-4 ">
        <a href="dishDisplay.php" class="form-control btn-success col-5"><i class="fas fa-concierge-bell"></i>dish Add +</a>
        <a class="nav-link btn btn-warning col-5" href="../order/PreviewOrder.php"><i class="fas fa-shopping-cart"></i> Order Preview</a>

    </div>



</div>




<?php
include_once ("../webdesign/footer/footer.php");
?>
<script>

</script>
</body>
</html>
