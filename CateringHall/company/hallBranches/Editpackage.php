<?php
include_once ("../../connection/connect.php");

$packageid=$_GET['packageid'];
$hallid=$_GET['hallid'];
$companyid=$_GET['companyid'];
$hallBranches=$_GET['hallBranches'];

$sql='SELECT `id`, `month`, `isFood`, `price`, `describe`, `dayTime`, `expire`, `hall_id`, `package_name` FROM `hallprice` WHERE id='.$packageid.'';
$packageDetail=queryReceive($sql);


$sql='SELECT name,id FROM systemDishType WHERE ISNULL(isExpire)';
$dishtype=queryReceive($sql);

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
<body>
<h1 align="center">Add new Package</h1>

    <div class="form-group row">
        <lable class="col-4 col-form-label">Packages Name</lable>
        <input data-columnname="package_name"     class="packagechange col-8 form-control" type="text" value="<?php echo $packageDetail[0][8]?>">
    </div>

    <div class="form-group row">
        <lable class="col-4 col-form-label">Packages Rate per head</lable>
        <input data-columnname="price" class="packagechange col-3 form-control" type="number" value="<?php echo $packageDetail[0][3]?>">
    </div>

    <div class="form-group row">
        <lable class="col-4 col-form-label">Packages Description</lable>
        <input data-columnname="describe" type="text"  class="packagechange col-6 form-control" value="<?php echo $packageDetail[0][4]?>" >
    </div>
<form id="submitpackage">
    <h3  align="center"> Selected Menu of Package</h3>
    <div id="selectedmenu" class="alert-warning row form-group shadow" style="height: 40vh">

        <?php
        $sql='SELECT `id`, `dishname`, `image`, `expire`, `hallprice_id` FROM `menu` WHERE (hallprice_id='.$packageid.') AND ISNULL(expire)';
        $menuDetail=queryReceive($sql);
        for($i=0;$i<count($menuDetail);$i++)
        {

            echo '
        <div id="alreadydishid'.$menuDetail[$i][0].'" class="col-3 alert-danger border m-2 form-group" style="height: 30vh;" >
            <img src="'.$menuDetail[$i][2].'" class="col-12" style="height: 15vh">
            <p class="col-form-label" class="form-control col-12">'.$menuDetail[$i][1].'</p>
            <input data-dishid="'.$menuDetail[$i][0].'" type="button" value="Remove" class="form-control alreadydishid col-12  btn btn-success">
        </div>';


        }


        ?>




    </div>
    <div class="col-12">
        <input id="btncancel" type="button" value="<?php

        if($packageDetail[0][6]==NULL)
        {
            echo "Click Expire";
        }
        else
        {
            echo "Click Show";
        }
        ?>" class="btn btn-danger col-4">
        <input id="btnsubmit" type="button" value="OK" class="btn btn-primary col-4">
    </div>

</form>



<h3  align="center" class="mt-5">Select Dishes</h3>
<div id="selectmenu" class="alert-dark border m-2 form-group row shadow" >

    <?php

    for ($i=0;$i<count($dishtype);$i++)
    {
        $sql = 'SELECT `name`, `id`, `image` FROM `systemDish` WHERE ISNULL(isExpire) AND (systemDishType_id=' . $dishtype[$i][1] . ') ';
        $dishdetail=queryReceive($sql);

        for ($j=0;$j<count($dishdetail);$j++)
        {
            echo '
        <div id="dishid'.$dishdetail[$j][1].'" class="col-3 alert-danger border m-2 form-group" style="height: 30vh;" >
            <img src="'.$dishdetail[$j][2].'" class="col-12" style="height: 15vh">
            <p class="col-form-label" class="form-control col-12">'.$dishdetail[$j][0].'</p>
            <input data-dishid="'.$dishdetail[$j][1].'" type="button" value="Select" class="form-control col-12 touchdish btn btn-success">
            <input hidden type="text"  name="dishname[]"  value="'.$dishdetail[$j][0].'">
             <input hidden type="text"  name="image[]"  value="'.$dishdetail[$j][2].'">
        </div>';

        }


    }
    ?>


</div>


<script>
    $(document).ready(function () {


        $(".packagechange").change(function () {
            var columnname=$(this).data("columnname");
            var value=$(this).val();
            var formdata=new FormData;
            formdata.append("option","packagechange");
            formdata.append("packageid",<?php echo $packageid;?>);
            formdata.append("value",value);
            formdata.append("columnname",columnname);
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
                    }
                    else
                    {
                        window.history.back();
                    }
                }
            });


        });


        $(document).on("click",".touchdish",function ()
        {
            var value=$(this).val();
            var id=$(this).data("dishid");
            if(value=="Remove")
            {
                $(this).val("Select");
                var text=$("#dishid"+id)[0].outerHTML;
                $("#dishid"+id).remove();
                $("#selectmenu").append(text);

            }
            else
            {

                $(this).val("Remove");
                var text=$("#dishid"+id)[0].outerHTML;
                $("#dishid"+id).remove();
                $("#selectedmenu").append(text);

            }

        }) ;
        $("#btnsubmit").click(function ()
        {
            var formdata=new FormData($('#submitpackage')[0]);
            formdata.append("option","Extendmenu");
            formdata.append("packageid",<?php echo $packageid;?>)
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
                    }
                    else
                    {
                        window.history.back();
                    }
                }
            });

        });
        $("#btncancel").click(function ()
        {   var value=$(this).val();
            var formdata=new FormData;
            formdata.append("option","ExpireBtn");
            formdata.append("packageid",<?php echo $packageid;?>);
            formdata.append("expirevalue",value);
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
                    }
                    else
                    {
                        window.history.back();
                    }
                }
            });
        });

        $(".alreadydishid").click(function ()
        {
           var id= $(this).data("dishid");

           $.ajax({

               url:"../companyServer.php",
               method:"POST",
               data:{option:"alreadydishremove",id:id},
               dataType:"text",
               success:function (data)
               {
                    if(data!="")
                    {
                        alert(data);
                    }
                    else
                    {
                            $("#alreadydishid"+id).remove();
                    }
               }

           });


        });









    });


</script>
</body>
</html>
