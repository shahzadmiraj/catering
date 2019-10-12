<?php
/**
 * Created by PhpStorm.
 * User: shahzadmiraj
 * Date: 2019-09-18
 * Time: 10:45
 */


include_once ("../connection/connect.php");

$hallid="";
$cateringid='';
$_GET['hallid']=1;
if(isset($_GET['hallid']))
    $hallid=$_GET['hallid'];
if(isset($_GET['cateringid']))
    $cateringid=$_GET['cateringid'];
$hallorcater='';
if(!empty($hallid))
{
    $hallorcater="(od.hall_id=".$hallid.")";
}
else
{

    $hallorcater="(od.catering_id=".$cateringid.")";
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

<div class="container"  style="margin-top:150px">

<form class="col-12 shadow card mb-4" id="formId1" style="display: none">
    <h2>Search order :</h2>

    <div class="form-group row">
        <label class="col-form-label col-4"> Customer Name</label>
        <input  name="p_name" type="text" class="changeColumn form-control col-8">
    </div>
    <div class="form-group row">
        <label class="col-form-label col-4"> Customer CNIC</label>
        <input  name="p_cnic" type="number" class="changeColumn form-control col-8">
    </div>
    <div class="form-group row">
        <label class="col-form-label col-4"> Customer ID</label>
        <input  name="p_id" type="number" class="changeColumn form-control col-8">
    </div>
    <div class="form-group row">
        <label class="col-form-label col-4"> Customer Phone</label>
        <input  name="n_number" type="text" class="changeColumn form-control col-8">
    </div>
    <div class="form-group row">
        <label class="col-form-label col-4">booking Date</label>
        <input  name="od_booking_date" type="date" class="changeColumn form-control col-8">
    </div>
    <div class="form-group row">
        <label class="col-form-label col-4"> Destination Date</label>
        <input  name="od_destination_date" type="date" class="changeColumn form-control col-8">
    </div>

    <div class="form-group row">
        <label class="col-form-label col-4">Order Status</label>
        <select  name="<?php
        if($hallid=="")
        {
            echo "od_status_catering";
        }
        else
        {
            echo "od_status_hall";
        }
        ?>" class="changeColumn form-control col-8 ">
            <option value="None">None</option>
            <?php
            $OrderStatus=array("Running","Cancel","Delieved","Clear");
            for($i=0;$i<count($OrderStatus);$i++)
            {

                echo '<option value='.$OrderStatus[$i].'>'.$OrderStatus[$i].'</option>';

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
            <td>order status</td>
            <td>received amount</td>
            <td>System  Amount</td>
            <td>remaining system amount </td>
            <td>your demanded amount</td>
            <td>remaining demand amount</td>

    </tbody>
    <?php
    $sql="SELECT DISTINCT od.id, (SELECT p.name FROM person as p WHERE p.id=od.person_id), (SELECT sum(py.amount) FROM payment as py WHERE (py.IsReturn=0)AND(py.orderDetail_id=od.id)) ,od.total_amount,od.total_amount, (SELECT SUM(dd.price*dd.quantity) FROM dish_detail as dd WHERE dd.orderDetail_id=od.id),od.status_catering,od.status_hall FROM orderDetail as od LEFT join payment as py on od.id=py.orderDetail_id where ".$hallorcater."";
$details=queryReceive($sql);
    $display='';
    for ($i=0;$i<count($details);$i++)
    {
        $display.=' <tr data-orderid="'.$details[$i][0].'" class="orderDetail">
        <td >'.$details[$i][0].'</td>
        <td>'.$details[$i][1].'</td>
        <td>';
        if(!empty($hallid))
        {
            //if order status is hall
            $display.=$details[$i][7];

        }
        else
        {
            //if order status is catering
            $display.=$details[$i][6];

        }


        $display.='</td>
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
            location.href="/Catering/order/PreviewOrder.php?order="+orderid+"&cateringid=<?php echo $cateringid;?>&hallid=<?php echo $hallid;?>";
        });




        $(document).on("change",'.changeColumn',function (e)
        {
            e.preventDefault();
            var formdata=new FormData($('#formId1')[0]);
            formdata.append("hallorcater","<?php echo $hallorcater;?>");
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
