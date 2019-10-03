<?php
/**
 * Created by PhpStorm.
 * User: shahzadmiraj
 * Date: 2019-09-01
 * Time: 21:31
 */
include  ("../../connection/connect.php");
$hallid=$_GET['hallid']=1;
$personid=$_GET['personid']=1;
$userid=$_GET['userid']=1;


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
    <input type="number" hidden name="hallid" value="<?php echo $hallid;?>">
    <input type="number" hidden name="personid" value="<?php echo $personid;?>">
    <input type="number" hidden name="userid" value="<?php echo $userid;?>">
<div class="form-group row">
    <label class="col-form-label col-4">No of Guests</label>
    <input name="guests" type="number" class="form-control col-8">
</div>
<div class="form-group row">
    <label class="col-form-label col-4">Date</label>
    <input   id="date" name="date" type="date" class="checkpackage form-control col-8">
</div>
<div class="form-group row">
    <label class="col-form-label col-4">Time</label>
    <select id="time" name="time" class="checkpackage form-control col-8">
        <option value="Morning">Morning</option>
        <option value="Afternoon">Afternoon</option>
        <option value="Evening">Evening</option>
    </select>
</div>
<div class="form-group row">
    <label class="col-form-label col-4">Per Head With</label>
    <select id="perheadwith" name="perheadwith" class="checkpackage form-control col-8">
        <option value="0">Only seating</option>
        <option value="1">Food + Seating</option>
    </select>
</div>
<div id="groupofpackages" class="col-12 alert-warning shadow">


</div>

    <div id="selectmenu" class="alert-info  m-2 form-group row shadow" >


    </div>
    <div class="form-group row">
        <label class="col-form-label col-4">Describe /Comments</label>
        <textarea  name="describe" class="form-control col-8"></textarea>
    </div>
<div class="form-group row">
    <label class="col-form-label col-4">Total amount:</label>
    <input name="totalamount" type="number" class="form-control col-8">
</div>

    <div class="form-group row">
        <input type="button" class=" col-4  btn btn-danger"  value="Back">
        <input id="submitform" type="button" class=" col-4 btn btn-success" value="Submit">
    </div>

</form>

<script>
    $(document).ready(function () {
        function checkpackage(date, time, perheadwith) {
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
            if (!checkpackage(date, time, perheadwith)) {

                return false;
            }

            var formdata = new FormData;
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




        $(document).on("click","input[type=radio]",function () {

            var packageid=$("input[name='defaultExampleRadios']:checked").val();
            if($("#perheadwith").val()!="1")
                return false;

            var describe=$("#describe"+packageid).val();
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

        });
        $("#submitform").click(function ()
        {
            var packageid='';
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
                    alert("please select Package From Package Detail");
                    return false;
                }
            }
            var formdata = new FormData($("form")[0]);
            formdata.append("packageid", packageid);
            formdata.append("option", "createOrderofHall");

            $.ajax({
                url: "../companyServer.php",
                method: "POST",
                data: formdata,
                contentType: false,
                processData: false,
                success: function (data)
                {



                }


            });




        });








    });




</script>
</body>
</html>
