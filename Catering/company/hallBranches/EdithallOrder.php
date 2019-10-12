<?php
/**
 * Created by PhpStorm.
 * User: shahzadmiraj
 * Date: 2019-09-01
 * Time: 21:31
 */
include  ("../../connection/connect.php");
$hallid=$_GET['hallid'];
$orderid=$_GET['order'];
$sql='SELECT `id`, `hall_id`, `catering_id`, (SELECT hp.isFood from hallprice as hp WHERE hp.id=orderDetail.hallprice_id),
 `user_id`, `sheftCatering`, `sheftHall`, `sheftCateringUser`, 
 `sheftHallUser`, `address_id`, `person_id`, `total_amount`, 
 `total_person`, `status_hall`, `destination_date`, 
 `booking_date`, `destination_time`, `status_catering`, 
 `notice`,`describe`,(SELECT hp.describe from hallprice as hp WHERE hp.id=orderDetail.hallprice_id),hallprice_id,(SELECT hp.price from hallprice as hp WHERE hp.id=orderDetail.hallprice_id) FROM `orderDetail` WHERE id='.$orderid.'';
$detailorder=queryReceive($sql);
?>
<!DOCTYPE html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="../../bootstrap.min.css">
    <script src="../../jquery-3.3.1.js"></script>
    <script type="text/javascript" src="../../bootstrap.min.js"></script>
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
<body class="container" >
<h1 align="center">Order Create of Hall</h1>
<form class="form">
    <div class="form-group row">
        <label class="col-form-label col-4">No of Guests</label>
        <input name="guests" type="number" class="form-control col-8" value="<?php echo $detailorder[0][12]; ?>">
    </div>
    <div class="form-group row">
        <label class="col-form-label col-4">Date</label>
        <input   id="date" name="date" type="date" class="checkpackage form-control col-8" value="<?php echo $detailorder[0][14]; ?>">
    </div>
    <div class="form-group row">
        <label class="col-form-label col-4">Time</label>
        <select id="time" name="time" class="checkpackage form-control col-8">
            <?php

            ///////set time
            if($detailorder[0][16]=="09:00:00")
            {
                //morning
                echo '
            <option value="Morning">Morning</option>
            <option value="Afternoon">Afternoon</option>
            <option value="Evening">Evening</option>';

            }
            else if($detailorder[0][16]=="12:00:00")
            {
                //afternoon
                echo '

            <option value="Afternoon">Afternoon</option>
            <option value="Morning">Morning</option>
            <option value="Evening">Evening</option>';
            }
            else
            {
                //evening
                echo '
            <option value="Evening">Evening</option>
            <option value="Morning">Morning</option>
            <option value="Afternoon">Afternoon</option>';


            }
            ?>

        </select>
    </div>
    <div class="form-group row">
        <label class="col-form-label col-4">Per Head With</label>
        <select id="perheadwith" name="perheadwith" class="checkpackage form-control col-8">

            <?php

            if($detailorder[0][3]==0)
            {
                // only seating
                echo '
            <option value="0">Only seating</option>
            <option value="1">Food + Seating</option>';
            }
            else
            {
                //food and seating
                echo '
            <option value="1">Food + Seating</option>
            <option value="0">Only seating</option>';
            }
            ?>

        </select>
    </div>
    <div id="groupofpackages" class="col-12 alert-warning shadow">


    </div>

    <div id="selectmenu" class="alert-info  m-2 form-group row shadow" >


    </div>
    <div class="form-group row">
        <label class="col-form-label col-4">Describe /Comments</label>
        <textarea  name="describe" class="form-control col-8"><?php echo $detailorder[0][19]; ?></textarea>
    </div>
    <div class="form-group row">
        <label class="col-form-label col-4">Total amount:</label>
        <input name="totalamount" type="number" class="form-control col-8" value="<?php echo $detailorder[0][11]; ?>">
    </div>

    <?php

        $status=array("Running","Deliever","Cancel","Clear");
        $display='
    <div class="form-group row">
        <label class="col-form-label col-4">Order status</label>
        <select  name="orderStatus" class=" form-control col-8">
        <option value="'.$detailorder[0][13].'">'.$detailorder[0][13].'</option>';
        for($i=0;$i<count($status);$i++)
        {
            if($status[$i]!=$detailorder[0][13])
            {
                $display.='<option value="'.$status[$i].'">'.$status[$i].'</option>';
            }
        }
        $display.=' </select>
    </div>';
       echo $display;


    ?>


    <div class="form-group row">
        <label class="col-form-label col-4">Booked date</label>
        <input readonly type="date" class="form-control col-8" value="<?php echo $detailorder[0][15]; ?>">
    </div>

    <div class="form-group row">

        <input id="cancel" type="button" class=" col-4 btn btn-danger" value="Cancel">
        <input id="submitform" type="button" class=" col-4 btn btn-success" value="Save">
    </div>

</form>

<script>
    $(document).ready(function () {
        $("#cancel").click(function ()
        {
            window.history.back();
        });
        function checkpackage(date, time, perheadwith)
        {
            if ((date != "") && (time != "") && (perheadwith != "")) {
                return 1;
            }
            return 0;

        }

        $(".checkpackage").change(function () {
            var date = $("#date").val();
            var month = new Date(date).getMonth();
            var time = $("#time").val();
            var perheadwith = $("#perheadwith").val();
            $("#selectmenu").html("");
            if (!checkpackage(date, time, perheadwith))
            {

                return false;
            }

            var formdata = new FormData;
            formdata.append("date",date);
            formdata.append("month", month);
            formdata.append("time", time);
            formdata.append("perheadwith", perheadwith);
            formdata.append("option", "checkpackages1");
            formdata.append("hallid",<?php echo $hallid;?>);
            $.ajax({
                url: "../companyServer.php",
                method: "POST",
                data: formdata,
                contentType: false,
                processData: false,
                success: function (data)
                {
                    $("#groupofpackages").html(data);

                }


            });


        });

        function menushow(packageid,describe)
        {
            var formdata = new FormData;
            formdata.append("packageid", packageid);
            formdata.append("option", "viewmenu");

            $.ajax({
                url: "../companyServer.php",
                method: "POST",
                data: formdata,
                contentType: false,
                processData: false,
                success: function (data)
                {
                    $("#selectmenu").html(data);
                    $("#selectmenu").append("<h3 align='center' class='col-12'>Menu Description</h3><p class='col-12'>"+describe+"</p>");
                }


            });
        }

        menushow(<?php  echo $detailorder[0][21]; ?>,"<?php echo $detailorder[0][20]; ?>"+"<span class='btn-danger'> ....    with price is <?php echo $detailorder[0][22]; ?></span>");

        $(document).on("click","input[type=radio]",function ()
        {

            var packageid=$("input[name='defaultExampleRadios']:checked").val();
            if($("#perheadwith").val()!="1")
                return false;

            var describe=$("#describe"+packageid).val();
            menushow(packageid,describe);


        });

        var packageid=<?php echo $detailorder[0][21]; ?>;

        $("#submitform").click(function ()
        {
            var date = $("#date").val();
            var time = $("#time").val();
            var perheadwith = $("#perheadwith").val();
            if (!checkpackage(date, time, perheadwith))
            {
                alert("Please select Date,Time and Per Head");
                return false;
            }
            if($(".checkclasshas")[0])
            {
                packageid=$("input[name='defaultExampleRadios']:checked").val();
                if(!packageid)
                {
                    alert("Please select Package From Package Detail");
                    return false;
                }
            }
            var formdata = new FormData($("form")[0]);
            formdata.append("perheadwith",perheadwith);
            formdata.append("packageid", packageid);
            formdata.append("order",<?php echo $orderid;  ?>);
            formdata.append("option", "Edithallorder");
            $.ajax({
                url: "../companyServer.php",
                method: "POST",
                data: formdata,
                contentType: false,
                processData: false,
                success: function (data)
                {
                    if(data!="")
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
