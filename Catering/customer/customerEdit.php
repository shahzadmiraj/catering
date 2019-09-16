<?php
/**
 * Created by PhpStorm.
 * User: shahzadmiraj
 * Date: 2019-09-01
 * Time: 21:31
 */
include_once ("../connection/connect.php");

$customerId=$_GET['customer'];
$sql = "SELECT `name`, `cnic`, `id`, `date` FROM `person` WHERE id=$customerId";
$person=queryReceive($sql);
$sql = "SELECT a.id, a.address_city, a.address_town, a.address_street_no, a.address_house_no, a.person_id FROM address as a inner JOIN person p ON a.person_id=p.id
WHERE a.person_id=$customerId
ORDER by a.person_id;";
$address=queryReceive($sql);
$sql="SELECT n.number, n.id, n.is_number_active, n.person_id FROM number as n inner JOIN person as p ON p.id=n.person_id
WHERE p.id=$customerId
order BY n.id";
$numbers=queryReceive($sql);
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
<body class="">
<?php
include_once ("../webdesign/header/header.php");
?>

<div class="container " style="margin-top:200px" >


<form id="form" >
        <h1 align="center">
            Customer Preview
        </h1>
    <?php


    echo '<input id="customerId" type="number" hidden value="'.$_GET["customer"].'">';
    ?>
        <div class="col-12" id="number_records">
            <?php
            for($i=0;$i<count($numbers);$i++)
            {
                echo '
        <div class="form-group row" id="Each_number_row_'.$numbers[$i][1].'">
                <label  class="col-3 col-form-label" for="number_'.$numbers[$i][1].'">Phone no:</label>
                <input  class=" numberchange  allnumber form-control col-7" type="text" name="number[]" value="'.$numbers[$i][0].'" id="number_'.$numbers[$i][1].'" data-columne="number" data-columneid='.$numbers[$i][1].'>
                <input class="form-control btn btn-danger col-2 remove_number " id="remove_numbers_'.$numbers[$i][1].'" data-removenumber="'.$numbers[$i][1].'" value="-">
            </div>';
            }
            ?>

        </div>
        <div class="form-group row" >
            <label for="newNumber" class="col-form-label col-3">New Number</label>
            <input id="newNumber"  name="newNumber"class="form-control col-7" >
            <input type="button" value="+" class="col-2 btn-success form-control" id="newadd">
        </div>
        <div class="form-group row">
            <label for="name" class="col-form-label col-3"> Name:</label>
            <?php
                echo'<input type="text" id="name"  name="name" class=" personchange form-control col-9" value="'.$person[0][0].'" data-columne="name">';
            ?>
        </div>
        <div class="form-group row">
            <label for="cnic" class="col-form-label col-3"> CNIC:</label>
            <?php
                echo '
            <input type="number" id="cnic" name="cnic" class=" personchange form-control col-9" value="'.$person[0][1].'" data-columne="cnic">';
            ?>
        </div>

        <h3 align="center"> Address</h3>
        <div class="form-group row">
            <label for="city" class="col-form-label col-3"> City:</label>
            <?php
                echo '<input  type="text"  id="city" name="city" class=" addresschange form-control col-9" value="'.$address[0][1].'" data-columne="address_city">';
            ?>

        </div>

        <div class="form-group row">
            <label for="area" class="col-form-label col-3"> Area/ Block:</label>
            <?php
                echo '<input  type="text" id="area" name="area" class=" addresschange form-control col-9" value="'.$address[0][2].'" data-columne="address_town">';
            ?>

        </div>

        <div class="form-group row">
            <label for="streetNo" class="col-form-label col-3">Street No :</label>
            <?php
                echo '     <input type="number"  id="streetNo" name="streetNo" class=" addresschange form-control col-9" value="'.$address[0][3].'" data-columne="address_street_no">';
            ?>

        </div>

        <div class="form-group row">
            <label for="houseNo" class="col-form-label col-3">House No:</label>
            <?php
                echo '<input type="number" id="houseNo" name="houseNo" class=" addresschange form-control col-9" value="'.$address[0][4].'" data-columne="address_house_no">';
            ?>

        </div>
        <div class="col-12 shadow">
            <h4 align="center">Customer personality</h4>
            <?php
            $sql='SELECT py.personality,py.rating FROM person as p INNER join orderTable as ot
on p.id=ot.person_id
INNER JOIN payment as py
on ot.id=py.orderTable_id
WHERE
p.id='.$customerId.'';
            $personalitydetails=queryReceive($sql);
            for ($k=0;$k<count($personalitydetails);$k++)
            {
                echo '
            <p class=" mb-3 form-control">'.$personalitydetails[$k][0].' <span class="float-right border-danger border font-weight-bold">Rating: '.$personalitydetails[$k][1].' </span> </p>';
            }



            ?>

        </div>
        <div class="form-group row mb-3 p-4">

            <?php
            if(isset($_GET['option']))
            {
                if($_GET['option']=="orderCreate")
                {
                    echo '
        <a href="/Catering/customer/CustomerCreate.php" class="col-6 form-control btn btn-danger" id="cancel">Not this customer</a>
        <a href="/Catering/order/orderCreate.php?customer='.$customerId.'" class="col-6 form-control btn btn-outline-primary" id="submit">Next</a>';
                }
                else if(($_GET['option']=="orderCreate") || ($_GET['option']=="CustomerCreate"))
                {

                    echo '
        <a href="/Catering/customer/CustomerCreate.php?option=customerEdit" class="col-6 form-control btn btn-danger" id="cancel">Not this customer</a>
        <a href="/Catering/order/orderCreate.php?customer='.$customerId.'&option=customerEdit" class="col-6 form-control btn btn-outline-primary" id="submit">Order Create</a>';
                }
                else if($_GET['option']=="customerAndOrderalreadyHave")
                {

                    echo '
        <a href="/Catering/customer/CustomerCreate.php" class="col-6 form-control btn btn-danger" id="cancel">Not this customer</a>
        <a href="/Catering/order/orderEdit.php?order='.$_GET['order'].'&customer='.$_GET['customer'].'&option=customerEdit" class="col-6 form-control btn btn-outline-primary" id="submit">Edit order</a>';
                }
                else if($_GET['option']=="PreviewOrder")
                {
                    echo '<a href="/Catering/order/PreviewOrder.php?order='.$_GET['order'].'" class="col-6 form-control btn btn-outline-primary" >DONE</a>';
                }
            }

            ?>

        </div>
    </form>
</div>




<script>
 $(document).ready(function ()
 {

    var customerid=$("#customerId").val();
     function execute_person_address(column,text,type)
     {
         $.ajax({
             url: "customerEditServer.php",
             data:{columnname:column,value:text,edittype:type,option:"change",customerid:customerid},
             dataType:"text",
             method:"POST",
             success:function (data) {
                 if(data!='')
                 {
                     alert(data);
                 }
             }
         });
     }
     function execute_number(column,text,type,id)
     {
         $.ajax({
             url: "customerEditServer.php",
             data:{columnname:column,value:text,edittype:type,id:id,option:"change",customerid:customerid},
             dataType:"text",
             method:"POST",
             success:function (data) {
                 if(data!='') {
                     alert(data);
                 }
             }
         });
     }

    $(document).on('change','.addresschange',function () {
        //address change
       var column=$(this).data("columne");
       var text=$(this).val();
        execute_person_address(column,text,1);
    });

     $(document).on('change','.personchange',function () {
         //personchange change
         var column=$(this).data("columne");
         var text=$(this).val();
         execute_person_address(column,text,2);
     });


     $(document).on('change','.numberchange',function () {
         //numberchange change
         var column=$(this).data("columne");
         var id=$(this).data("columneid");
         var text=$(this).val();
         execute_number(column,text,3,id);
     });


     $("#newadd").click(function ()
     {

         var numberText=$('#newNumber').val();
         $.ajax({
             url: "customerEditServer.php",
             data:{option:"addNumber",number:numberText,customerid:customerid},
             dataType:"text",
             method:"POST",
             success:function (data) {
                 if(data!='')
                 {
                     alert(data);
                 }
                 else
                 {
                     location.reload()
                 }
             }
         });
     });


     $(document).on("click",".remove_number",function () {
         var id=$(this).data("removenumber");
         $.ajax({
             url: "customerEditServer.php",
             data:{ id:id,option:"deleteNumber"},
             dataType:"text",
             method:"POST",
             success:function (data) {
                 if(data!='')
                 {
                     alert(data);
                 }
                 else
                 {
                     $("#Each_number_row_"+id).remove();
                 }
             }
         });
     });

 });
</script>
</body>
</html>
