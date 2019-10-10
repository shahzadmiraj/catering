<?php
/**
 * Created by PhpStorm.
 * User: shahzadmiraj
 * Date: 2019-09-01
 * Time: 21:31
 */
include_once ("../connection/connect.php");

$hallid=$_GET['hallid']=1;
$cateringid=$_GET['cateringid']='';
$hallorcater="";
$order_status=$_GET['order_status'];
if(!empty($hallid))
{
    $hallorcater="(od.hall_id=".$hallid.")";
    $order_status='(od.status_hall="'.$order_status.'")';
}
else
{

    $hallorcater="(od.catering_id=".$cateringid.")";
    $order_status='(od.status_catering="'.$order_status.'")';
}
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
            margin:0px;
            padding: 0px;
        }
    </style>
</head>
<body class="alert-light">

<div class="container"  style="margin-top:150px">

    <h1 align="center"> Orders</h1>

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
            <input  name="od_booking_date" type="date" class="changeColumn form-control col-8">
        </div>
        <div class="form-group row">
            <label class="col-form-label col-4"> destination date</label>
            <input  name="od_destination_date" type="date" class="changeColumn form-control col-8">
        </div>

        <div class="form-group row">
            <label class="col-form-label col-4">order status</label>
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
            <a href="/Catering/user/userDisplay.php" class="col-4 form-control btn-danger">cancel</a>
            <button type="button" class="col-4 form-control btn-success">Find</button>
        </div>

        </form>


    <h3 align="center" ><button data-display="hide" id="searchBtn" class="btn-outline-info btn float-left ">Search Order</button>display records</h3>
        <div  id="recordsAll">
            <?php
            $sql='SELECT od.id,(SELECT p.name FROM person as p WHERE p.id=od.person_id),(SELECT p.image FROM person as p WHERE p.id=od.person_id),od.destination_date,od.destination_time,od.status_hall,od.status_catering,od.hall_id,od.catering_id,(SELECT hp.package_name FROM hallprice as hp WHERE hp.id=od.hallprice_id) FROM orderDetail as od WHERE '.$hallorcater.' AND '.$order_status.'';
            $orderdetail=queryReceive($sql);
            $display='';
            for ($i=0;$i<count($orderdetail);$i++)
            {
                $display.='
        <a href="#'.$orderdetail[$i][0].'" class="col-12   row  shadow m-3">
        <img src="';
                if(file_exists($orderdetail[$i][2]))
                {
                    $display.= $orderdetail[$i][2];
                }
                else
                {
                    $display.="../gmail.png";
                }



                $display.='"class="col-3 p-0">
        <div class="col-9">
            <label class="col-12">Order id:<i class="text-secondary">'.$orderdetail[$i][0].'</i> </label>
            <label class="col-12">Name: <i class="text-secondary">'.$orderdetail[$i][1].'</i></label>
            <label class="col-12">Date: <i class="text-secondary">'.$orderdetail[$i][3].'</i></label>
        </div>
        <label class="col-12">Time: <i class="text-secondary">';

                if(!empty($hallid))
                {
                    //if order is hall order timing
                    if ($orderdetail[$i][4] == "09:00:00")
                    {
                        $display .= "Morning";
                    } else if ($orderdetail[$i][4] == "12:00:00") {
                        $display .= "Afternoon";
                    } else
                     {
                        $display .= "18:00:00";
                    }
                }
                else
                {
                    //catering order
                    $display.=$orderdetail[$i][4];
                }

                $display.='</i></label>';

                if($orderdetail[$i][7]!="")
                {
                    //if order is hall

                    $display .= '<label class="col-12">Per Head:<i class="text-secondary">';
                    if ($orderdetail[$i][9] != "")
                    {
                        //hall is booked wth food+seaating
                        $display.=$orderdetail[$i][9].'   Food+Seating';
                    } else
                    {
                        //hall is book only seating
                        $display.='Only Seating';

                    }
                    $display.='</i> </label>';
                }


                if(($orderdetail[$i][6]!="")&&($orderdetail[$i][8]!=""))
                    {
                        //catering status
                        $display.='
        <label class="col-12">Catering Status:<i class="text-secondary">'.$orderdetail[$i][6].'</i> </label>';
                    }
                if(($orderdetail[$i][5]!="")&&($orderdetail[$i][7]!=""))
                    {
                        //hall status
                        $display.='
        <label class="col-12">Hall Status:<i class="text-secondary">'.$orderdetail[$i][5].'</i> </label>';
                    }
                $display.='</a>';

            }
            echo $display;
            ?>



        </div>

<!--    <a href="#" class="col-12  btn-outline-danger row  shadow m-3">-->
<!--        <img src="../gmail.png" class="col-3 p-0">-->
<!--        <div class="col-9">-->
<!--            <label class="col-12">order id:<i class="text-secondary">1</i> </label>-->
<!--            <label class="col-12">Name: <i class="text-secondary">shahzad miraj</i></label>-->
<!--            <label class="col-12">date: <i class="text-secondary">12:9:21</i></label>-->
<!--        </div>-->
<!--        <label class="col-12">time: <i class="text-secondary">1</i></label>-->
<!--        <label class="col-12">catering status:<i class="text-secondary">1</i> </label>-->
<!--        <label class="col-12">Hall status:<i class="text-secondary">1</i> </label>-->
<!--    </a>-->





</div>





<script>

    $(document).ready(function () {

        $(document).on("change",'.changeColumn',function (e)
        {
                e.preventDefault();
                var formdata=new FormData($('#formId1')[0]);
                formdata.append("hallorcater","<?php echo $hallorcater;?>");
                $.ajax({
                    url:"FindOrderServer.php",
                    method:"POST",
                    data:formdata,
                    contentType: false,
                    processData: false,
                    success:function (data)
                    {
                        $("#recordsAll").html(data);
                        // console.log(data);
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
