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
    <h1 align="center"> Orders</h1>

        <form class="col-12 shadow card " id="formId1">
        <h2>Search order :</h2>
        <div class="form-group row">
            <label class="col-form-label col-4"> customer name</label>
            <input  name="p_name" type="text" class="changeColumn form-control col-8">
        </div>
        <div class="form-group row">
            <label class="col-form-label col-4"> customer id</label>
            <input  name="p_cnic" type="number" class="changeColumn form-control col-8">
        </div>
        <div class="form-group row">
            <label class="col-form-label col-4"> customer phone</label>
            <input  name="n_number" type="text" class="changeColumn form-control col-8">
        </div>
        <div class="form-group row">
            <label class="col-form-label col-4">booking Date</label>
            <input  name="ot_booking_date" type="date" class="changeColumn form-control col-8">
        </div>
        <div class="form-group row">
            <label class="col-form-label col-4"> destination date</label>
            <input  name="ot_destination_date" type="date" class="changeColumn form-control col-8">
        </div>
        <div class="form-group row">
            <label class="col-form-label col-4">order status</label>
            <select  data-index="0" name="cs_order_status_id" class="changeColumn form-control col-8 ">
                <option value="5">None</option>
            </select>
        </div>
        <div class="form-group row">
            <button type="button" class="col-4 form-control btn-danger">cancel</button>
            <input  id="submitBtn" type="submit" class="col-4 form-control btn-success">
        </div>

        </form>


</div>





<script>
    //window.history.back();
    // SELECT * FROM person as p INNER join number as n on p.id=n.person_id
    // INNER join orderTable as ot
    // on p.id=ot.person_id
    // INNER join change_status as cs
    // on ot.id=cs.orderTable_id

    $(document).ready(function () {

        $("#submitBtn").click(function (e) {
            e.preventDefault();
            var formdata=new FormData($('#formId1')[0]);
             $.ajax({
              url:"FindOrderServer.php",
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
              }
          });
        });

    });





</script>
</body>
</html>
