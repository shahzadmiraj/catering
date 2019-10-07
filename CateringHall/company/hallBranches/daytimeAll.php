<?php
include_once ('../../connection/connect.php');
$hallid=$_GET['hallid'];
$companyid=$_GET['companyid'];
$hallBranches=$_GET['hallBranches'];
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
            margin:0;
            padding: 0;
        }
    </style>
</head>
<body class="container">
<h1 align="center">Setting OF Hall</h1>
<div class="form-group row ">
    <div data-daytime="Morning" class="col-4 daytime "style="height: 25vh">
        <div class="card-header">
        <img src="../../gmail.png"  style="height: 20vh;width: 100%">
        <p align="center" >Morning Prize list</p>
        </div>
    </div>
    <div data-daytime="Afternoon" class=" daytime col-4"style="height: 25vh">
        <div class="card-header">
            <img src="../../gmail.png" style="height: 20vh;width: 100%">
            <p align="center" >Afternoon Prize list</p>
        </div>
    </div>
    <div data-daytime="Evening" class=" daytime col-4"style="height: 25vh">
        <div class="card-header">
            <img src="../../gmail.png"  style="height: 20vh;width: 100%">
            <p align="center" >Evening Prize list</p>
        </div>
    </div>
</div>
<div class="shadow" id="showDaytimes" style="margin-top: 20%;width: 100%">



</div>
<div class="form-group row">
    <a href="hallRegister.php?companyid=<?php echo $companyid;?>&hallBranches=<?php echo $hallBranches;?>" class="btn btn-outline-success col-5"> Save And Next </a>
</div>

<!---->
<!--<tr>-->
<!--    <td scope="col" >-->
<!--        <h4 align="center">Months</h4>-->
<!--        <div class="form-group row p-2 shadow btn-light">-->
<!--            <label class="col-form-label col-6 font-weight-bold"> Prize Only Seating </label>-->
<!--            <input class="form-control col-6" type="number">-->
<!--            <h3 align="center" class="col-12 mt-3">List of prize with Food</h3>-->
<!--            <a  href="#" class="form-control  btn-primary col-12 text-center"> Add New Package</a>-->
<!--            <a  href="#" class="form-control  btn-success col-4 text-center m-2"> Package name</a>-->
<!--        </div>-->
<!--    </td>-->
<!--</tr>-->
<script>

    $(document).ready(function ()
    {
       $(".daytime").click(function ()
       {
           var daytime=$(this).data("daytime");

           var formdata=new FormData();
           formdata.append("option","showdaytimelist");
           formdata.append("daytime",daytime);
           formdata.append("hallid",<?php echo $hallid; ?>);
           formdata.append("companyid",<?php echo $companyid;?>);
           formdata.append("hallBranches",<?php echo $hallBranches;?>)
           $.ajax({
               url:"../companyServer.php",
               method:"POST",
               data:formdata,
               contentType: false,
               processData: false,
               success:function (data)
               {
                   $("#showDaytimes").html(data);
               }
           });


       }) ;

        $(document).on("change",".changeSeating",function () {
            var id=$(this).data("menuid");
            var value=$(this).val();
            var formdata=new FormData();
            formdata.append("option","changeSeating");
            formdata.append("packageid",id);
            formdata.append("value",value);
            $.ajax({
                url:"../companyServer.php",
                method:"POST",
                data:formdata,
                contentType: false,
                processData: false,
                success:function (data)
                {
                    if(data!='')
                    {
                        alert(data);
                        return false;
                    }

                }
            });


        }) ;












    });



</script>
</body>
</html>
