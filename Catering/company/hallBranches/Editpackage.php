<?php
include_once ("../../connection/connect.php");
$hallname=$_GET['hallname'];
$month=$_GET['month'];
$daytime=$_GET['daytime'];
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
    <link rel="stylesheet" href="../../webdesign/css/complete.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">

    <style>

        #selectedmenu
        {
            background: #F09819;  /* fallback for old browsers */
            background: -webkit-linear-gradient(to right, #EDDE5D, #F09819);  /* Chrome 10-25, Safari 5.1-6 */
            background: linear-gradient(to right, #EDDE5D, #F09819); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */

        }
        #selectmenu
        {
            background: #9796f0;  /* fallback for old browsers */
            background: -webkit-linear-gradient(to right, #fbc7d4, #9796f0);  /* Chrome 10-25, Safari 5.1-6 */
            background: linear-gradient(to right, #fbc7d4, #9796f0); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */

        }
    </style>
</head>
<body>

<?php
include_once ("../../webdesign/header/header.php");

?>

<div class="jumbotron  shadow" style="background-image: url(https://thumbs.dreamstime.com/z/spicy-dishes-dinner-menu-icon-design-grilled-chicken-curry-sauce-vegetable-stew-pasta-pesto-sauce-ham-curry-84629311.jpg);background-size:100% 115%;background-repeat: no-repeat;">

    <div class="card-body text-center" style="opacity: 0.7 ;background: white;">
        <h1 class="display-5 "><i class="fas fa-edit"></i>Edit Package <?php echo $packageDetail[0][8]?></h1>
        <ol class="list-unstyled">
            <li><i class="fas fa-place-of-worship"></i>Hall name:<?php echo $hallname;?></li>
            <li><i class="fas fa-table"></i>Month:<?php  echo $month?></li>
            <li><i class="far fa-clock"></i>Daytime:<?php echo $daytime;?></li>
        </ol>
    </div>
</div>

<div class="container">
    <div class="form-group row">
        <lable class="col-form-label">Packages Name</lable>



        <div class="input-group mb-3 input-group-lg">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-hamburger"></i></span>
            </div>
            <input data-columnname="package_name"     class="packagechange form-control" type="text" value="<?php echo $packageDetail[0][8]?>">
        </div>


    </div>

    <div class="form-group row">
        <lable class="col-form-label">Packages Rate per head</lable>




        <div class="input-group mb-3 input-group-lg">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-money-bill-alt"></i></span>
            </div>
            <input data-columnname="price" class="packagechange form-control" type="number" value="<?php echo $packageDetail[0][3]?>">
        </div>

    </div>

    <div class="form-group row">
        <lable class="col-form-label">Packages Description</lable>




        <div class="input-group mb-3 input-group-lg">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-comments"></i></span>
            </div>
            <input data-columnname="describe" type="text"  class="packagechange  form-control" value="<?php echo $packageDetail[0][4]?>" >
        </div>



    </div>
<form id="submitpackage">
    <h3  align="center"><i class="fas fa-thumbs-up"></i> Selected Menu of Package</h3>
    <div id="selectedmenu" class="row  form-group shadow m-auto " style="height: 40vh">

        <?php
        $sql='SELECT `id`, `dishname`, `image`, `expire`, `hallprice_id` FROM `menu` WHERE (hallprice_id='.$packageid.') AND ISNULL(expire)';
        $menuDetail=queryReceive($sql);
        for($i=0;$i<count($menuDetail);$i++)
        {

            echo '
        <div id="alreadydishid'.$menuDetail[$i][0].'" class="col-4 border m-2 form-group p-0 card-body shadow " style="height: 30vh;" >
            <img src="'.$menuDetail[$i][2].'" class="col-12" style="height: 15vh">
            <p class="col-form-label" class="form-control col-12">'.$menuDetail[$i][1].'</p>
            <input data-dishid="'.$menuDetail[$i][0].'" type="button" value="Remove" class="form-control alreadydishid col-12  btn btn-success">
        </div>';


        }


        ?>




    </div>
    <div class="mt-3 shadow" >
        <button id="btncancel" type="button" value="<?php

        if($packageDetail[0][6]==NULL)
        {
            echo "Click Expire";
        }
        else
        {
            echo "Click Show";
        }
        ?>" class="btn btn-danger col-4"><i class="fas fa-ban"></i><?php

            if($packageDetail[0][6]==NULL)
            {
                echo "Click Expire";
            }
            else
            {
                echo "Click Show";
            }
            ?></button>
        <button id="btnsubmit" type="button" value="OK" class="btn btn-primary col-4"><i class="fas fa-check "></i>OK</button>
    </div>

</form>



<h3  align="center" class="mt-5"><i class="far fa-hand-pointer mr-2"></i>SelectSelect Dishes</h3>
<div id="selectmenu" class="border  row m-auto"  style="overflow:auto;width: 100% ;height: 40vh" >

    <?php

    for ($i=0;$i<count($dishtype);$i++)
    {
        $sql = 'SELECT `name`, `id`, `image` FROM `systemDish` WHERE ISNULL(isExpire) AND (systemDishType_id=' . $dishtype[$i][1] . ') ';
        $dishdetail=queryReceive($sql);

        for ($j=0;$j<count($dishdetail);$j++)
        {
            echo '
        <div id="dishid'.$dishdetail[$j][1].'" class="col-4 border m-2 form-group p-0 card-body shadow" style="height: 30vh;" >
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
</div>

<?php
include_once ("../../webdesign/footer/footer.php");
?>
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
