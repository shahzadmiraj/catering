<?php
/**
 * Created by PhpStorm.
 * User: shahzadmiraj
 * Date: 2019-09-01
 * Time: 21:31
 */
include_once ("../connection/connect.php");
session_start();

//$customerId='';
//if(isset($_GET['customer']))
//{
//    $customerId=$_GET['customer'];
//}
//if(isset($_SESSION['customer']))
//{
//    $customerId=$_SESSION['customer'];
//}
//
////if(isset($_SESSION['customer']) && isset($_GET['customer']))
////{
////    echo "confusing of session and Get";
////    exit();
////}
//if($customerId=="")
//{
//    echo "Set session or Get for customerid";
//    exit();
//}
//$_SESSION['customer']=$customerId;
//
////
if(!isset($_SESSION['customer']))
{
    echo "please session is create for customer";
    exit();
}
$customerId=$_SESSION['customer'];
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
           // background-color: #6c757d;
        }
    </style>
</head>
<body>

<div class="container">

    <h1 align="center">
        Customer View and Edit;
    </h1>
    <form id="form">
        <div class="col-12" id="number_records">
            <?php
            for($i=0;$i<count($numbers);$i++)
            {
                echo '
        <div class="form-group row" id="Each_number_row_'.$numbers[$i][1].'">
                <label  class="col-2 col-form-label" for="number_'.$numbers[$i][1].'">Phone no:</label>
                <input  class=" numberchange  allnumber form-control col-8" type="text" name="number[]" value="'.$numbers[$i][0].'" id="number_'.$numbers[$i][1].'" data-columne="number" data-columneid='.$numbers[$i][1].'>
                <input class="form-control btn btn-danger col-2 remove_number " id="remove_numbers_'.$numbers[$i][1].'" data-removenumber="'.$numbers[$i][1].'" value="-">
            </div>';
            }
            ?>

        </div>
        <div class="form-group row" >
            <label for="newNumber" class="col-form-label col-2"> number New:</label>
            <input id="newNumber"  name="newNumber"class="form-control col-8" >
            <input type="button" value="+" class="col-2 btn-success form-control" id="newadd">
        </div>
        <div class="form-group row">
            <label for="name" class="col-form-label col-2"> Name:</label>
            <?php
                echo'<input id="name"  name="name"class=" personchange form-control col-10" value="'.$person[0][0].'" data-columne="name">';
            ?>
        </div>
        <div class="form-group row">
            <label for="cnic" class="col-form-label col-2"> CNIC:</label>
            <?php
                echo '
            <input id="cnic" name="cnic" class=" personchange form-control col-10" value="'.$person[0][1].'" data-columne="cnic">';
            ?>
        </div>

        <h3 align="center"> Address</h3>
        <div class="form-group row">
            <label for="city" class="col-form-label col-2"> City:</label>
            <?php
                echo '<input id="city" name="city" class=" addresschange form-control col-10" value="'.$address[0][1].'" data-columne="address_city">';
            ?>

        </div>

        <div class="form-group row">
            <label for="area" class="col-form-label col-2"> Area/ Block:</label>
            <?php
                echo '<input  id="area" name="area" class=" addresschange form-control col-10" value="'.$address[0][2].'" data-columne="address_town">';
            ?>

        </div>

        <div class="form-group row">
            <label for="streetNo" class="col-form-label col-2">Street No :</label>
            <?php
                echo '     <input id="streetNo" name="streetNo" class=" addresschange form-control col-10" value="'.$address[0][3].'" data-columne="address_street_no">';
            ?>

        </div>

        <div class="form-group row">
            <label for="houseNo" class="col-form-label col-2">House No:</label>
            <?php
                echo '<input id="houseNo" name="houseNo" class=" addresschange form-control col-10" value="'.$address[0][4].'" data-columne="address_house_no">';
            ?>

        </div>
        <div class="col-12">
            <p>if customer is already existed</p>
        </div>
        <a href="http://192.168.64.2/Catering/order/PreviewOrder.php" class="col-2 form-control btn btn-danger" id="cancel">cancel</a>
        <a href="http://192.168.64.2/Catering/order/PreviewOrder.php" class="col-2 form-control btn btn-outline-primary" id="submit">ok</a>
    </form>
</div>




<script>
 $(document).ready(function () {


     function execute_person_address(column,text,type)
     {
         $.ajax({
             url: "customerEditServer.php",
             data:{columnname:column,value:text,edittype:type,option:"change"},
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
             data:{columnname:column,value:text,edittype:type,id:id,option:"change"},
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


     function phoneCheck(idText)
     {
         var id=$("#"+idText);
         var text=id.val();
         if((isNaN(text))||  (text.length!=11))
         {
             id.css("background-color", "red");
             return false;
         }

         id.css("background-color", "white");
         return true;

     }


     var number=0;

     $('.number_records').map(function () {
         number++;
     }).get().join();

     $("#newadd").click(function ()
     {
         if(number>1)
         {
             alert("no of numbers not more then 3");
             return false;
         }
            var numberText=$("#newNumber").val();
         if((isNaN(numberText))||  (numberText.length!=11))
         {
             alert("number is invalid");
             return false;
         }

         $.ajax({
             url: "customerEditServer.php",
             data:{option:"addNumber",number:numberText},
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
         number--;
     });

 });
</script>
</body>
</html>
