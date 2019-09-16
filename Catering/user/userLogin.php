<?php
/**
 * Created by PhpStorm.
 * User: shahzadmiraj
 * Date: 2019-09-01
 * Time: 21:31
 */


session_start();
if(isset($_SESSION["userid"]))
{

    header('location:userDisplay.php');
    exit();
}

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
<body class="container">

<div class="badge-danger col-12 shadow fixed-top  " style="height: 170px">
    <h1 align="center">Welcome  to</h1>
       <h2 align="center"> New Kashmir Food Center</h2>
</div>



<div class="col-12 card badge-dark" style="margin-top:180px;" >
    <h1 align="center">User Login</h1>
    <form class="col-12" id="formLogin">
    <div class="form-group row">
        <label class="col-form-label col-5">UserName</label>
        <input  type="text" class="col-7 form-control" name="username">
    </div>
        <div class="form-group row">
            <label class="col-form-label col-5">Password</label>
            <input type="password" class="col-7 form-control" name="password">
        </div>

        <div class="form-group row">
            <input id="login" type="button" class="form-control btn btn-success"  value="logIN">
        </div>
    </form>
</div>




<script>

    $(document).ready(function () {

       $('#login').click(function ()
       {

           var formdata=new FormData($("#formLogin")[0]);
           formdata.append("option","login");
            $.ajax({
              url:"userServer.php",
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
                     location.reload();
                  }

              }
          });

       });
    });


</script>
</body>
</html>
