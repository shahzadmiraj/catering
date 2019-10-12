<?php
include_once ('../../connection/connect.php');
$hallid=4;
$companyid='';
$hallBranches='';
if(isset($_GET['hallid']))
$hallid=$_GET['hallid'];
if(isset($_GET['companyid']))
$companyid=$_GET['companyid'];
if(isset($_GET['hallBranches']))
$hallBranches=$_GET['hallBranches'];
$sql='SELECT `name`, `max_guests`, `noOfPartitions`, `ownParking`, `expire`, `image`, `hallType`, `location_id` FROM `hall` WHERE id='.$hallid.'';
$halldetail=queryReceive($sql);

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
<img src="
<?php
if(file_exists($halldetail[0][5]))
{
    echo $halldetail[0][5];
}
else
{
    echo "../../gmail.png";
}
?>

" class="rounded mx-auto d-block" alt="..." style="height: 30vh">

<form class="col-12 shadow " >
    <div class="form-group row">
        <label class="col-form-label col-4">Hall Branch Name:</label>
        <input name="hallname" class="form-control col-8" type="text" value="<?php echo $halldetail[0][0]; ?>">
    </div>

    <div class="form-group row">
        <label class="col-form-label col-4">Hall Type:</label>
        <select name="halltype" class="form-control col-8">

            <option value="1">Marquee</option>
            <option value="2">Hall</option>
            <option value="3">Deera /Open area</option>
        </select>
    </div>
    <div class="form-group row">
        <label class="col-form-label col-4">Hall Branch Image:</label>
        <input name="image" class="form-control col-8" type="file">
    </div>
    <div class="form-group row">
        <label class="col-form-label col-4">Hall Branch Address</label>
    </div>
    <div class="form-group row">
        <label class="col-form-label col-8">Maximum Capacity of guests in hall:</label>
        <input name="capacity" class="form-control col-4" type="number" value="<?php echo $halldetail[0][1]; ?>">
    </div>

    <div class="form-group row">
        <label class="col-form-label col-8">No of Partition in Hall:</label>
        <input name="partition" class="form-control col-4" type="number" value="<?php echo $halldetail[0][2]; ?>">
    </div>

    <div class="col-12 form-group form-inline">
        <input name="parking" class="form-check-input" type="checkbox">
        <label class="form-check-label ">Have Your own parking</label>
    </div>
    <div class="form-group row col-12 mb-5">
        <input id="submit" type="button" class="rounded mx-auto d-block btn btn-success col-5 " value="Submit">
    </div>


</form>


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
<div class="shadow" id="showDaytimes" style="margin-top: 20%;width: 100%;height: 50vh;overflow: auto">



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
        function showdaytimelist(daytime)
        {
            var formdata=new FormData();
            formdata.append("option","showdaytimelist");
            formdata.append("daytime",daytime);
            formdata.append("hallid","<?php echo $hallid; ?>");
            formdata.append("companyid","<?php echo $companyid;?>");
            formdata.append("hallBranches","<?php echo $hallBranches;?>")
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
        }

       $(".daytime").click(function ()
       {
           var daytime=$(this).data("daytime");
           showdaytimelist(daytime);
       }) ;
        showdaytimelist("Morning");

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
