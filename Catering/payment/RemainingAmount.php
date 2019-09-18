<?php
/**
 * Created by PhpStorm.
 * User: shahzadmiraj
 * Date: 2019-09-18
 * Time: 10:45
 */


include_once ("../connection/connect.php");



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
<?php
include_once ("../webdesign/header/header.php");
?>
<div class="container"  style="margin-top:150px">

<form class="col-12 shadow card mb-4" id="formId1" style="display: none">
    <h2>Search order :</h2>

    <div class="form-group row">
        <label class="col-form-label col-4"> customer name</label>
        <input  name="p_name" type="text" class="changeColumn form-control col-8">
    </div>
    <div class="form-group row">
        <label class="col-form-label col-4"> customer CNIC</label>
        <input  name="p_cnic" type="number" class="changeColumn form-control col-8">
    </div>
    <div class="form-group row">
        <label class="col-form-label col-4"> customer ID</label>
        <input  name="p_id" type="number" class="changeColumn form-control col-8">
    </div>
    <div class="form-group row">
        <label class="col-form-label col-4"> customer phone</label>
        <input  name="n_number" type="text" class="changeColumn form-control col-8">
    </div>
    <div class="form-group row">
        <label class="col-form-label col-4">booking Date</label>
        <input  name="ot_booking_date" type="date" class="changeColumn form-control col-8">
    </div>
    <div class="form-group row">
        <label class="col-form-label col-4"> destination date</label>
        <input  name="ot_destination_date" type="date" class="changeColumn form-control col-8">
    </div>
    <div class="form-group row">
        <label class="col-form-label col-4">order status</label>
        <select  name="ot_is_active" class="changeColumn form-control col-8 ">
            <option value="None">None</option>
            <?php
            $OrderStatus=array("running","cancel","delieved","clear");
            for($i=0;$i<count($OrderStatus);$i++)
            {

                echo '<option value='.$i.'>'.$OrderStatus[$i].'</option>';

            }
            ?>
        </select>
    </div>
    <div class="form-group row">
        <a href="/Catering/payment/RemainingAmount.php" class="col-4 form-control btn-danger">cancel</a>
        <button type="button" class="col-4 form-control btn-success">Find</button>
    </div>

</form>

<h4 align="center" ><button data-display="hide" id="searchBtn" class="btn-outline-info btn float-left ">Search Order</button>Payments Records</h4>
<div  class="w-100" id="recordsAll1">
<table class="table table-bordered table-responsive" style="width: 100%;">
    <tbody class="font-weight-bold">
            <td >order Id</td>
            <td>customer Name</td>
            <td>received amount</td>
            <td>System  Amount</td>
            <td>remaining system amount </td>
            <td>your demanded amount</td>
            <td>remaining demand amount</td>

    </tbody>
    <?php
    //$OrderStatus=array("running","cancel","delieved","clear");
    $sql="SELECT DISTINCT ot.id, (SELECT p.name FROM person as p WHERE p.id=ot.person_id), (SELECT sum(py.amount) FROM payment as py WHERE (py.IsReturn=0)AND(py.orderTable_id=ot.id)) ,ot.extre_charges,ot.total_amount, (SELECT SUM(dd.price*dd.quantity) FROM dish_detail as dd WHERE dd.orderTable_id=ot.id) FROM orderTable as ot LEFT join payment as py on ot.id=py.orderTable_id WHERE ot.is_active in(0,2)";
$details=queryReceive($sql);
//print_r($details);
    $display='';
    for ($i=0;$i<count($details);$i++)
    {
        $display.=' <tr data-orderid="'.$details[$i][0].'" class="orderDetail">
        <td >'.$details[$i][0].'</td>
        <td>'.$details[$i][1].'</td>
        <td>'.(int)$details[$i][2].'</td>
        <td>'.(int)$details[$i][5].'</td>
        <td> '.(int) ($details[$i][5]-$details[$i][2]).'</td>
        <td>'.(int) $details[$i][4].'</td>
        <td>'.(int) ($details[$i][4]-$details[$i][2]).'</td>
 ';



        $display.='</tr>';
    }





    echo $display;










    ?>


</table>



</div>
</div>

<script>

    $(document).ready(function () {

        $(document).on("click",".orderDetail",function ()
        {
            var orderid=$(this).data("orderid");
            location.href="/Catering/order/PreviewOrder.php?order="+orderid;
        });




        $(document).on("change",'.changeColumn',function (e)
        {
            e.preventDefault();
            var formdata=new FormData($('#formId1')[0]);
            $.ajax({
                url:"RemainingFinderServer.php",
                method:"POST",
                data:formdata,
                contentType: false,
                processData: false,
                success:function (data)
                {
                    $("#recordsAll1").html(data);

                }
            });
        });


        $("#searchBtn").click(function () {
            var display=$(this).data("display");
            if(display=="hide")
            {
                $("#formId1").show('slow');
                $(this).data("display","show");
            }
            else
            {
                $("#formId1").hide('slow');

                $(this).data("display","hide");

            }

        });


    });

</script>
</body>
</html>
