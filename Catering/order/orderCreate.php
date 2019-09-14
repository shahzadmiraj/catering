<?php
/**
 * Created by PhpStorm.
 * User: shahzadmiraj
 * Date: 2019-09-01
 * Time: 21:31
 */
include_once ("../connection/connect.php");
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
    <h1 align="center"> Order Create</h1>
    <form >
        <input type="number" hidden id="customeridForm" value=<?php echo $_GET['customer'];?>   >
        <div class="form-group row">
        <label for="persons" class="col-4 col-form-label"> no of guests</label>
        <input type="number" name="persons" id="persons" class="col-8 form-control">
        </div>

        <div class="form-group row">
            <label for="time" class="col-4 col-form-label">delivery Time</label>
            <input type="time" name="time" id="time" class="col-8 form-control">
        </div>

        <div class="form-group row">
            <label for="date" class="col-4 col-form-label">delivery Date</label>
            <input type="date" name="date" id="date" class="col-8 form-control">
        </div>
            <h3 align="center"> Deliver Address</h3>
        <div class="form-group row">
            <label for="area" class="col-4 col-form-label">area / block </label>
            <input type="text" name="area" id="area" class="col-8 form-control">
        </div>
        <div class="form-group row">
            <label for="streetNO" class="col-4 col-form-label">Street no #</label>
            <input type="number" name="streetno" id="streetNO" class="col-8 form-control">
        </div>
        <div class="form-group row">
            <label for="houseno" class="col-4 col-form-label">house no# </label>
            <input  type="number" name="houseno" id="houseno" class="col-8 form-control">
        </div>
        <div class="form-group row">
            <label for="describe" class="col-4 col-form-label">describe order </label>
            <textarea  id="describe" name="describe" class="form-control col-8 form-control"></textarea>
        </div>
        <div class="form-group row">

            <?php
                if(isset($_GET['option']))
                {
                    if(($_GET['option']=="CustomerCreate")||($_GET['option']=="customerEdit"))
                    {

                        echo '<a href="http://192.168.64.2/Catering/customer/customerEdit.php?customer='.$_GET['customer'].'&option=orderCreate" class="form-control col-4 btn btn-danger">Edit Customer</a>';
                    }
                }
                else
                {
                    echo '
            <button  type="button"  id=\'cancelorder\'class="form-control col-4 btn btn-danger"> cancel</button>';
                }

            ?>
            <button type="button" id="submit" class="form-control col-4 btn-success"> submit</button>
        </div>
    </form>

</div>




<script>
    $(document).ready(function ()
    {
       $("#submit").click(function (e)
       {
           e.preventDefault();
           var customerid=$("#customeridForm").val();
           var formdata=new FormData($('form')[0]);
           formdata.append('function',"add");
           $.ajax({
              url:"orderServer.php?customer="+customerid,
              data:formdata,
               method:"POST",
               contentType: false,
               processData: false,
               dataType:"text",
               success:function (data)
               {
                  if(!($.isNumeric(data)))
                  {
                      alert(data);
                  }
                  else
                  {
                      window.location.href="http://192.168.64.2/Catering/dish/dishDisplay.php?order="+data+"&customer="+customerid+"&option=orderCreate";
                  }
               }
           });

       });

       $("#cancelorder").click(function () {
           window.history.back();
           return false;

       });
    });

</script>
</body>
</html>
