<?php
/**
 * Created by PhpStorm.
 * User: shahzadmiraj
 * Date: 2019-09-01
 * Time: 21:31
 */
include_once ("../connection/connect.php");
session_start();
?>
<!DOCTYPE html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="../bootstrap.min.css">
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
<body>

<div class="container">

    <h1 align="center">
        Customer create
    </h1>
    <form id="form">
        <div class="form-group row">
        <label for="number" class="col-2 col-form-label">Phone no:</label>
        <input id="number"class="allnumber form-control col-8" type="number" name="number[]"  >
        <input type="button" class="form-control btn-primary col-2" id="Add_btn" value="+">
        </div>
        <div class="col-12" id="number_records">
            <p> extra numbers</p>
        </div>
        <div class="form-group row">
        <label for="name" class="col-form-label col-2"> Name:</label>
        <input id="name"  name="name"class="form-control col-10" >
        </div>
        <div class="form-group row">
        <label for="cnic" class="col-form-label col-2"> CNIC:</label>
        <input id="cnic" name="cnic" class="form-control col-10" >
        </div>

            <h3 align="center"> Address</h3>
        <div class="form-group row">
            <label for="city" class="col-form-label col-2"> City:</label>
            <input id="city" name="city" class="form-control col-10" >
        </div>

        <div class="form-group row">
            <label for="area" class="col-form-label col-2"> Area/ Block:</label>
            <input  id="area" name="area" class="form-control col-10">
        </div>

        <div class="form-group row">
            <label for="streetNo" class="col-form-label col-2">Street No :</label>
            <input id="streetNo" name="streetNo" class="form-control col-10">
        </div>

        <div class="form-group row">
            <label for="houseNo" class="col-form-label col-2">House No:</label>
            <input id="houseNo" name="houseNo" class="form-control col-10">
        </div>
        <div class="col-12">
            <p>if customer is already existed</p>
        </div>
        <button class="col-2 form-control btn btn-danger" id="cancelCustomer">cancel</button>
        <button class="col-2 form-control btn btn-outline-primary" id="submit">submit</button>
    </form>
</div>


<script>


   $(document).ready(function ()
   {


       $("#cancelCustomer").click(function () {
          window.history.back();
          return false;
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
              "                <label for=\"number_"+number+"\" class=\"col-2 col-form-label\">Phone no:</label>\n" +
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


           // var error=0;
           // var name=$("#name");
           // var nameRedex=new  RegExp(/[a-zA-Z]{2,20}$/,'i');
           // if(!nameRedex.test(name.val()))
           // {
           //     name.css("background-color", "red");
           //     alert("name is invalid");
           //     error++;
           // }
           // else
           // {
           //     name.css("background-color", "white");
           // }
           // if(error>0)
           // {
           //     return false;
           // }

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
           $.ajax({
               url:"customerBookingServer.php",
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
                        window.location.href="http://192.168.64.2/Catering/order/orderCreate.php";
                        //return false;
                    }
               }
           });

       });
   });

</script>

</body>
</html>
