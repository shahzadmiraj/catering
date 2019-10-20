<?php
/**
 * Created by PhpStorm.
 * User: shahzadmiraj
 * Date: 2019-09-01
 * Time: 21:31
 */
include_once ("../../connection/connect.php");


?>
<!DOCTYPE html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="/Catering/../bootstrap.min.css">
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
<body>
<?php
include_once("../../webdesign/header/headerclient.php");
?>
<div class="container"  style="margin-top:150px">

    <form>
    <div class="col-12 shadow card p-4">
    <div class="form-group row">
<!--        <a href="#" class="form-control col-3 btn-warning"> Previous</a>-->
        <span class="font-weight-bold text-center col-9 form-control"> Add Dish in System</span>
    </div>
        <div class="form-group row">
            <label class="col-4 col-form-label">Dish Name</label>
            <input name="dishname" class="col-8 form-control" type="text">
        </div>
        <div class="form-group row">
            <label class="col-4 col-form-label">Dish Image</label>
            <input  name="image" class="col-8 form-control" type="file">
        </div>
        <div class="form-group row">
            <label class="col-4 col-form-label">Attribute Name</label>
            <input id="attributetext" class="col-6 form-control" type="text">
            <input id="addAttribute" type="button" class="col-2 form-control btn-primary" value="+">
        </div>
       <div class="col-12" id="attributeHere">

       </div>
        <div class="form-group row">
            <label class="col-4 col-form-label">Dish Type</label>
            <select name="dishtype" class="col-8 form-control">
                <?php $sql='SELECT `id`, `name` FROM `dish_type` WHERE 1' ;
                $dish_type=queryReceive($sql);
                for($i=0;$i<count($dish_type);$i++)
                {
                    echo '<option value="'.$dish_type[$i][0].'">'.$dish_type[$i][1].'</option>';
                }

                ?>
            </select>
        </div>
        <div class="form-group row">
            <a href="/Catering/system/dish/dishesDetail.php" class="col-4 form-control btn-danger"> Cancel</a>
            <input id="submit" type="button" value="Submit" class="col-8 form-control btn-success">
        </div>


    </div>
    </form>


</div>




<script>
    //window.history.back();



    $(document).ready(function ()
    {
        var rows=0;
        $("#addAttribute").click(function ()
        {
            var text=$("#attributetext").val();
            $("#attributeHere").append('<div class="form-group row" id="removeid_'+rows+'">\n' +
                '               <label class="col-4 col-form-label">Attribute Name</label>\n' +
                '               <input value="'+text+'" name="attribute[]" class="col-6 form-control" type="text">\n' +
                '               <input data-removeid="'+rows+'" type="button" class="col-2 form-control btn-danger removeattribute" value="-">\n' +
                '           </div>');
            $("#attributetext").val("");
            rows++;

        }) ;

        $(document).on('click','.removeattribute',function ()
        {
            var id=$(this).data("removeid");
            $("#removeid_"+id).remove();

        });


        $("#submit").click(function (e) {
           e.preventDefault();
           var formdata=new FormData($("form")[0]);
            formdata.append("option","addDishsystem");//addDishsystem
             $.ajax({
              url:"dishServer.php",
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
                      window.location.href="/Catering/system/dish/dishesDetail.php";
                  }
              }
          });
        });



    });




</script>
</body>
</html>
