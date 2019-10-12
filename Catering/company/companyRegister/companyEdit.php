
<?php

include_once ("../../connection/connect.php");
$companyid=$_GET['companyid']=3;
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
<body class="container">
<h1 align="center">Company Edit</h1>
<div class="form-group row">
    <label class="col-form-label col-4">Company Name</label>
    <input type="text" class="form-control col-8" value="dsfbj">
</div>
<div class="form-group row">
    <label class="col-form-label col-4">Block/Unblock company</label>
    <input type="button" class="btn btn-outline-danger" value="Expire Company">
</div>

                    <!--USERS-->
<div class="col-12 alert-light row m-4">
    <h2 align="center" class=" col-9">Users</h2>
    <a href="../../system/user/usercreate.php" class="btn btn-success col-3">Add User</a>
</div>
<div class="form-group row shadow ml-1" style="height: 50vh;overflow: auto;width: 100%">
    <?php
    $sql='SELECT u.id, u.username, u.isExpire,(SELECT p.image FROM person as p WHERE p.id=u.person_id) FROM user as u WHERE u.company_id='.$companyid.'';
    $users=queryReceive($sql);
    $display='';
    for($i=0;$i<count($users);$i++)
    {
      $display.='
    <a href="../../system/user/userEdit.php?userid='.$users[$i][0].'" class="col-5 m-2">
        <div class="card  col-12  rounded-circle shadow" style="height: 25vh"  >
            <img class="card-img-top  col-12 rounded-circle" src="';

      if(file_exists($users[$i][3]))
      {
          $display.=$users[$i][3];

      }
      else
          {
              $display.='../../gmail.png';
          }

      $display.='" alt="Card image" >
        </div>
        <h4 align="center" >'.$users[$i][1].'</h4>';
      if($users[$i][2]!="")
      {
          $display.='
        <i class="text-danger ">Expire</i>';
      }
    $display.='</a>';
        

    }
    echo $display;


    ?>
</div>




                    <!--Hall Branches-->
<div class="col-12 alert-light row m-4">
    <h2 align="center" class=" col-9">Halls</h2>
    <button class="btn btn-success col-3">Add Hall</button>
</div>
<div class="form-group row shadow ml-1" style="height: 50vh;overflow: auto;width: 100%">
    <a href="../../user/userDisplay.php?hallid=2" class="col-5 m-2">
        <div class="card  col-12  rounded-circle shadow" style="height: 25vh"  >
            <img class="card-img-top  col-12 rounded-circle" src="../../gmail.png" alt="Card image" >
        </div>
        <h4 align="center" >23432</h4>
        <i class="text-danger ">Expire</i>
    </a>
</div>


                        <!--Catering Branches-->
<div class="col-12 alert-light row m-4">
    <h2 align="center" class=" col-8">Caterings</h2>
    <button class="btn btn-success col-4">Add Catering</button>
</div>
<div class="form-group row shadow ml-1" style="height: 50vh;overflow: auto;width: 100%">
    <a href="../../user/userDisplay.php?hallid=2" class="col-5 m-2">
        <div class="card  col-12  rounded-circle shadow" style="height: 25vh"  >
            <img class="card-img-top  col-12 rounded-circle" src="../../gmail.png" alt="Card image" >
        </div>
        <h4 align="center" >23432</h4>
        <i class="text-danger ">Expire</i>
    </a>
</div>


<!--<a href="../../user/userDisplay.php?hallid=2" class="col-5 m-2">
    <div class="card  col-12  rounded-circle shadow" style="height: 25vh"  >
        <img class="card-img-top  col-12 rounded-circle" src="../../gmail.png" alt="Card image" >
    </div>
    <h4 align="center" >23432</h4>
    <i class="text-danger ">Expire</i>
</a>-->

<script>

</script>
</body>
</html>
