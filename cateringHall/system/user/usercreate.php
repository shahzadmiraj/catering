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
<body class="alert-light">
<?php
include_once ("../../webdesign/header/header.php");
?>
<div class="container"  style="margin-top:150px">

    <form id="form" >
        <h1 align="center">
            User Create
        </h1>
        <div class="col-12 card shadow p-4 mb-3">
            <h3 align="center"> Create LogIn form</h3>
            <div class="form-group row">
                <label for="username" class="col-form-label col-4 ">User Name</label>
                <input type="text" id="username" name="username" class="form-control col-8">
            </div>
            <div class="form-group row">
                <label for="password" class="col-form-label col-4">Password</label>
                <input type="text" id="password" name="password" class="form-control col-8">
            </div>
            <div class=" col-12">
                <input value="yes" type="checkbox" id="isowner" name="isowner">
                <span class="form-check-label">Is this user is a owner</span>
            </div>
        </div>
        <input id="customer" hidden value="">
        <div class="form-group row">
            <label for="number" class="col-2 col-form-label">Phone no:</label>
            <input id="number"class="allnumber form-control col-8" name="number[]"  >
            <input type="button" class="form-control btn-primary col-2" id="Add_btn" value="+">
        </div>
        <div class="col-12" id="number_records">
            <p> extra numbers</p>
        </div>
        <div class="form-group row">
            <label for="name" class="col-form-label col-2"> Name:</label>
            <input type="text" id="name"  name="name"class="form-control col-10" >
        </div>
        <div class="form-group row">
            <label for="cnic" class="col-form-label col-2"> CNIC:</label>
            <input type="number" id="cnic" name="cnic" class="form-control col-10" >
        </div>

        <h3 align="center"> Address</h3>
        <div class="form-group row">
            <label for="city" class="col-form-label col-2"> City:</label>
            <input type="text" id="city" name="city" class="form-control col-10" >
        </div>

        <div class="form-group row">
            <label for="area" class="col-form-label col-2"> Area/ Block:</label>
            <input type="text"  id="area" name="area" class="form-control col-10">
        </div>

        <div class="form-group row">
            <label for="streetNo" class="col-form-label col-2">Street No :</label>
            <input type="number" id="streetNo" name="streetNo" class="form-control col-10">
        </div>

        <div class="form-group row">
            <label for="houseNo" class="col-form-label col-2">House No:</label>
            <input type="number" id="houseNo" name="houseNo" class="form-control col-10">
        </div>

        <div class="form-group row">
        <button class="col-6 form-control btn btn-danger" id="cancelCustomer">cancel</button>
        <button class="col-6 form-control btn btn-outline-primary" id="submit">submit</button>
        </div>
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
            formdata.append("option","createUser");
            $.ajax({
                url:"userServer.php",
                method:"POST",
                data:formdata,
                contentType: false,
                processData: false,
                success:function (data)
                {

                    if(data!="")
                    {
                        alert(data);
                        return false;
                    }
                    else
                    {
                        window.location.href="/Catering/user/userDisplay.php";
                    }
                }
            });

        });
    });

</script>

</body>
</html>
