<?php
/**
 * Created by PhpStorm.
 * User: shahzadmiraj
 * Date: 2019-09-01
 * Time: 21:31
 */
include_once ("../connection/connect.php");
$hallid=$_GET['hallid'];
$cateringid=$_GET['cateringid'];

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
            margin:auto;
            padding: auto;
        }
    </style>
</head>
<body class="alert-light">
<div class="container" style="margin-top:150px" >

<form id="form">
        <p align="center" class="col-12 mb-4">
            Customer create
        </p>
        <input id="customer" hidden value="">
    <div class="form-group row">
        <label for="number" class="col-3 col-form-label">Phone no:</label>
        <input id="number"class="allnumber form-control col-7" type="number" name="number[]"  >
        <input type="button" class="form-control btn-primary col-2" id="Add_btn" value="+">
        </div>
        <div class="col-12 border mb-3 " id="number_records">
        </div>
        <div class="form-group row">
        <label for="name" class="col-form-label col-3">Name:</label>
        <input type="text" id="name"  name="name"class="form-control col-9" >
        </div>
        <div class="form-group row">
            <label for="name" class="col-form-label col-3">Image:</label>
            <input type="file"  name="image"  class="form-control col-9" >
        </div>

        <div class="form-group row">
        <label for="cnic" class="col-form-label col-3">CNIC:</label>
        <input type="number" id="cnic" name="cnic" class="form-control col-9" >
        </div>

            <h3 align="center"> Address</h3>
        <div class="form-group row">
            <label for="city" class="col-form-label col-3">City:</label>
            <input type="text" id="city" name="city" class="form-control col-9" >
        </div>

        <div class="form-group row">
            <label for="area" class="col-form-label col-3">Area/ Block:</label>
            <input type="text"  id="area" name="area" class="form-control col-9">
        </div>

        <div class="form-group row">
            <label for="streetNo" class="col-form-label col-3">Street No :</label>
            <input type="number" id="streetNo" name="streetNo" class="form-control col-9">
        </div>

        <div class="form-group row">
            <label for="houseNo" class="col-form-label col-3">House No:</label>
            <input type="number" id="houseNo" name="houseNo" class="form-control col-9">
        </div>
        <div class="form-group row col-12">

            <button type="button" class="col-5 form-control btn btn-danger" id="cancelCustomer">cancel</button>
            <button type="button" class="col-5 form-control btn btn-outline-primary" id="submit">submit</button>
        </div>
    </form>
</div>


<script>


   $(document).ready(function ()
   {

       $(document).on("change",".allnumber",function ()
       {
           //number exist
           var value=$(this).val();
           $.ajax({
               url:"customerBookingServer.php",
               data:{value:value,option:"customerExist"},
               dataType:"text",
               method: "POST",
               success:function (data)
               {
                   if((!($.isNumeric(data))) && (data==""))
                   {
                       return false;
                   }
                   else
                   {
                       window.location.href="/Catering/customer/customerEdit.php?customer="+data+"&option=CustomerCreate&hallid=<?php echo $hallid;?>&cateringid=<?php echo $cateringid;?>";
                   }
               }
           });
       });


       $("#cancelCustomer").click(function ()
       {
          window.history.back();
       });
       var number=0;


       $('.number_records').map(function () {
           number++;
       }).get().join();

       $("#Add_btn").click(function ()
       {
           if(number>1)
           {
               alert("no of numbers not more then 3");
               return false;
           }
          $("#number_records").append("<div class=\"form-group row\" id=\"Each_number_row_"+number+"\">\n" +
              "                <label for=\"number_"+number+"\" class=\"col-2 col-form-label\">#</label>\n" +
              "                <input id=\"number_"+number+"\" class=\"allnumber form-control col-8\" type=\"number\" name=\"number[]\">\n" +
              "                <input class=\"form-control btn btn-danger col-2 remove_number \" id=\"remove_numbers_"+number+"\" data-removenumber=\""+number+"\" value=\"-\">\n" +
              "            </div>");
           number++;
       });

       $(document).on("click",".remove_number",function () {
          var id=$(this).data("removenumber");
          $("#Each_number_row_"+id).remove();
          number--;
       });

       $("#submit").click(function (e) {
           e.preventDefault();



           if($.trim($("#number").val())=="")
           {
               alert("number must be enter");
               return false;
           }
           if($.trim($("#name").val())=="")
           {

               alert("name must be enter");
               return false;
           }


           var formdata=new FormData($('form')[0]);
           formdata.append("option","customerCreate");
           $.ajax({
               url:"customerBookingServer.php",
               method:"POST",
               data:formdata,
               contentType: false,
               processData: false,
               success:function (data)
               {

                    if(!($.isNumeric(data)))
                    {
                        return false;
                    }
                    else
                    {
                        if("<?php echo $hallid;?>"=="")
                        {
                            //this is the oder of catering
                            window.location.href="/Catering/order/orderCreate.php?customer="+data+"&option=CustomerCreate&cateringid=<?php echo $cateringid;?>";
                        }
                        else
                        {
                            //this is the order of hall
                            window.location.href="../company/hallBranches/hallorder.php?customer="+data+"&hallid=<?php echo $hallid;?>";
                        }
                    }
               }
           });

       });
   });

</script>

</body>
</html>
