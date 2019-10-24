<?php
include_once ("../../connection/connect.php");
$hallname=$_GET['hallname'];
$month=$_GET['month'];
$daytime=$_GET['daytime'];
$hallid=$_GET['hallid'];
$companyid=$_GET['companyid'];
$hallBranches=$_GET['hallBranches'];
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

        form
        {
            margin: 5%;


        }
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
        <h1 class="display-5 "><i class="fas fa-plus-square"></i>Add new Package</h1>
        <ol class="list-unstyled">
            <li><i class="fas fa-place-of-worship"></i>Hall name:<?php echo $hallname;?></li>
            <li><i class="fas fa-table"></i>Month:<?php echo $month?></li>
            <li><i class="far fa-clock"></i>Daytime:<?php echo $daytime;?></li>
        </ol>
    </div>
</div>

<div class="container">
<form id="submitpackage" >
    <?php
    echo '<input hidden type="text" name="month"  value="'.$month.'">
                <input hidden type="text" name="daytime"  value="'.$daytime.'">
                    <input hidden type="text" name="hallid"  value="'.$hallid.'">
                    ';
    ?>
<div class="form-group row">
    <lable class="col-form-label">Packages Name</lable>


    <div class="input-group mb-3 input-group-lg">
        <div class="input-group-prepend">
            <span class="input-group-text"><i class="fas fa-hamburger"></i></span>
        </div>
        <input name="packagename" class="form-control" type="text" placeholder="chicken menu,mutton menu">

    </div>
</div>

<div class="form-group row">
    <lable class="col-form-label">Packages Rate per head</lable>

    <div class="input-group mb-3 input-group-lg">
        <div class="input-group-prepend">
            <span class="input-group-text"><i class="fas fa-money-bill-alt"></i></span>
        </div>
        <input name="rate" class="form-control" type="number" placeholder="Price like 1000 per head">
    </div>
</div>

<div class="form-group row">
    <lable class="col-form-label">Packages Description</lable>

    <div class="input-group mb-3 input-group-lg">
        <div class="input-group-prepend">
            <span class="input-group-text"><i class="fas fa-comments"></i></span>
        </div>
        <textarea name="describe" class="form-control" placeholder="describe package information for client" ></textarea>

    </div>
</div>

    <h3  align="center"><i class="fas fa-thumbs-up"></i> Selected Menu of Package</h3>
    <div id="selectedmenu" class="row form-group m-0" style="overflow:auto;width: 100% ;height: 40vh">

    </div>
    <div class="col-12 mt-2 ">
        <button id="btnsubmit" type="button" value="Submit" class="btn btn-primary col-5 float-right"><i class="fas fa-check "></i>Submit</button>
        <button id="btncancel" type="button" value="Cancel" class="btn btn-danger col-5 float-right"><span class="fas fa-window-close "></span>Cancel</button>
    </div>


</form>



<h3  align="center" class="mt-5"><i class="far fa-hand-pointer mr-2"></i>Select Dishes</h3>
    <div id="selectmenu" class="border m-2 p-0  row"  style="overflow:auto;width: 100% ;height: 40vh" >

        <?php

        for ($i=0;$i<count($dishtype);$i++)
        {
            $sql = 'SELECT `name`, `id`, `image` FROM `systemDish` WHERE ISNULL(isExpire) AND (systemDishType_id=' . $dishtype[$i][1] . ') ';
            $dishdetail=queryReceive($sql);

            for ($j=0;$j<count($dishdetail);$j++)
            {
                echo '
        <div id="dishid'.$dishdetail[$j][1].'" class="col-4 alert-danger border m-1 form-group p-0" style="height: 30vh;" >
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
       formdata.append("option","CreatePackage");
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
   $("#btncancel").click(function () {
       window.history.back();
   });
});


</script>
</body>
</html>
