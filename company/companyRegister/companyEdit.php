
<?php
//../cateringBranches/cateringEDIT.php?
//../../system/user/userEdit.php?
include_once ("../../connection/connect.php");
if(!isset($_COOKIE['companyid']))
{
    header("location:../../user/userLogin.php");
}
if(isset($_GET['action']))
{
    $_SESSION['tempid']=$_GET['id'];

    if($_GET['action']=="user")
    {
        //user
        header("location:../../system/user/userEdit.php");
    }
    else if($_GET['action']=="hall")
    {
        //hall
        header("location:../hallBranches/daytimeAll.php");
    }
    else
    {
        //catering
        header("location:../cateringBranches/cateringEDIT.php");
    }

}

$companyid=$_COOKIE['companyid'];
$sql='SELECT `id`, `name`, `expire`, `user_id` FROM `company` WHERE id='.$companyid.'';
$companydetail=queryReceive($sql);
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

        #hallbranches
        {

            width: 100%;/*
            height: 50vh;
            overflow: auto;*/
            background-size: 100% 100%;
            margin: auto;



        }
        #cateringbranches
        {
            width: 100%;
            /*height: 50vh;
            overflow: auto;*/
            background-size: 100% 100%;
            margin: auto;

        }
        #userbranches
        {

            width: 100%;
            /*height: 50vh;
            overflow: auto;*/
            background-size: 100% 100%;
            margin: auto;
        }

    </style>
</head>



<?php
include_once ("../../webdesign/header/header.php");
?>



<div class="jumbotron  shadow " style="background-image: url(https://i2.wp.com/findlawyer.com.ng/wp-content/uploads/2018/05/Pros-and-Cons-of-Working-at-Large-Companies.jpg?resize=1024%2C512&ssl=1);background-size:100% 115%;background-repeat: no-repeat;">

    <div class="card-body text-center" style="opacity: 0.7 ;background: white;">
        <h1 class="display-5 "><i class="fas fa-city mr-2"></i><?php echo $companydetail[0][1];?><br>Edit your company</h1>
        <p>setting you company of hall branches,catering branches ,user informations ,packages edit</p>

        <h1 class="text-center"> <a href="../companyRegister/companydisplay.php" class="col-6 btn btn-warning "> <i class="fas fa-city mr-2"></i>My Company</a></h1>

    </div>
</div>



<div class="container">



                    <!--USERS-->
<div class="col-12 row mt-5">
    <h2 align="center" class="col-7"> <i class="fas fa-user  mr-1"></i> Users</h2>
    <a href="../../system/user/usercreate.php" class="btn btn-success col-5"><i class="fas fa-user-plus"></i> Add User</a>
</div>
    <hr class="border border-white">
<div class="form-group row shadow m-auto newcolor" id="userbranches">
    <?php
    $sql='SELECT u.id, u.username, u.isExpire,(SELECT p.image FROM person as p WHERE p.id=u.person_id) FROM user as u WHERE u.company_id='.$companyid.'';
    $users=queryReceive($sql);
    $display='';
    for($i=0;$i<count($users);$i++)
    {
      $display.='
    <a href="?action=user&id='.$users[$i][0].'" class="col-sm-12 col-md-4 col-xl-3 m-2">
        <div class="card  col-12  rounded-circle shadow" style="height: 25vh"  >
            <img class="card-img-top  col-12 rounded-circle" src="';

      if(file_exists($users[$i][3])&&($users[$i][3]!=""))
      {
          $display.=$users[$i][3];

      }
      else
          {
              $display.='https://www.pavilionweb.com/wp-content/uploads/2017/03/man-300x300.png';
          }

      $display.='" alt="Card image" >
        </div>
        <h4 align="center" ><i class="fas fa-user mr-1"></i> '.$users[$i][1].'</h4>';
      if($users[$i][2]!="")
      {
          $display.='
        <i>Expire</i>';
      }
    $display.='</a>';
        

    }
    echo $display;


    ?>
</div>




                    <!--Hall Branches-->
<div class="col-12 mt-5 row">
    <h2 align="center" class=" col-6"> <i class="fas fa-place-of-worship mr-2"></i> Halls</h2>
    <a href="../hallBranches/hallRegister.php" class="btn btn-success col-6"><i class="fas fa-plus"></i><i class="fas fa-place-of-worship mr-2"></i>Add Hall</a>
</div>
    <hr class="border border-white">
<div class="form-group row shadow newcolor " id="hallbranches">
    <?php
    $sql='SELECT `id`, `name`, `expire`, `image` FROM `hall` WHERE company_id='.$companyid.'';
    $halldetails=queryReceive($sql);
    $display='';
    for($i=0;$i<count($halldetails);$i++)
    {
        $display.='
    <a href="?action=hall&id='.$halldetails[$i][0].'" class="col-sm-12 col-md-4 col-xl-3 m-2">
        <div class="card  col-12  rounded-circle shadow" style="height: 25vh"  >
            <img class="card-img-top  col-12 rounded-circle" src="';

        if(file_exists('../'.$halldetails[$i][3])&&($halldetails[$i][3]!=''))
        {
            $display.='../'.$halldetails[$i][3];

        }
        else
        {
            $display.='data:image/jpeg;base64,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';
        }

        $display.='" alt="Card image" >
        </div>
        <h4 align="center" ><i class="fas fa-place-of-worship mr-1"></i>'.$halldetails[$i][1].'</h4>';
        if($halldetails[$i][2]!="")
        {
            $display.='
        <i>Expire</i>';
        }
        $display.='</a>';


    }
    echo $display;


    ?>
</div>


                        <!--Catering Branches-->
<div class="col-12 mt-5  row">
    <h2 align="center" class="col-7"> <i class="fas fa-utensils"></i> Caterings</h2>
    <a href="../cateringBranches/catering.php" class="btn btn-success col-5"><i class="fas fa-plus"></i> <i class="fas fa-utensils"></i> Add Catering</a>
</div>
    <hr class="border border-white">
<div class="form-group row shadow newcolor" id="cateringbranches">
    <?php
    $sql='SELECT `id`, `name`, `expire`, `image` FROM `catering` WHERE company_id='.$companyid.'';
    $cateringdetails=queryReceive($sql);
    $display='';
    for($i=0;$i<count($cateringdetails);$i++)
    {
        $display.='
    <a href="?action=catering&id='.$cateringdetails[$i][0].'" class="col-sm-12 col-md-4 col-xl-3 m-2">
        <div class="card  col-12  rounded-circle shadow" style="height: 25vh"  >
            <img class="card-img-top  col-12 rounded-circle" src="';

        if(file_exists('../'.$cateringdetails[$i][3])&&($cateringdetails[$i][3]!=''))
        {
            $display.='../'.$cateringdetails[$i][3];

        }
        else
        {
            $display.='data:image/jpeg;base64,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CdSbWuSSb8VsNktgqPDXmWLPJMWlvSyEFzWniGhoAbw42vpx422u3b6qLD534exzqkNblDRmcAXtD3sZ984NLiB3gaGwCrjYPaaWSvgifiMxD2ZZKWsiDHukI4wPjFhqBlDiD1TpwsFt88+75uy3Vy6f7kJ0DV3a0DQIOyIiAiIgIiICIiAiIgIiIChe0WyFXJWCuoK4wSGPo3xPYZYni1swYXWBtbs+9HDW80UcxraeWnmMTMOrZwAD0sTYyw3F7DM8G49SDx2B2ObhUMjOlMss8vSSSZQ0F1rAMYCbD28SeAsB03h7IOxaCGFswhMU/S5izPfqPba2Yf07+xePntUeh8S+CH6RPPao9D4l8EP0iD22ewLFIJ2vq8U8phDXAw+TxR3JHVdnbrot1tHhhq6OopQ7IaiB8ee18udpGa1xe1+9R/z2qPQ+JfBD9InntUeh8S+CH6RBqKzdaX0dFDHVdHVUL3FlU2M3LXOL8uUPuCHZSDm7D3qxacODGiQgvDRmIFgXW1IHYL9iiPntUeh8S+CH6RPPao9D4l8EP0iDD3hbuPspPHUR1HQPbCYXnIXdIy92jRwtbM/15h3KbUVOyGOOGMBrY2BrW6aNaABp7vesSlxCaamEzKd0crgbQTnI4WNrOLc1rgXHsUOm2ilNW2YsaXUzJ43wwl0rpGlsR6JgcGESB9nODgMrbE6G4Dcba7HuxGailEwj8jnEpBZmz2ex2W+YW+4+dSxYMNVKIHSyw2eGucIWOzuIAu1l9BnPCwuLnQnio357VHofEvgh+kQazFN3lU2rqKrCsQdSeVkmVhjDwXOJLnNcTpcuJ4XBJse6U7GbONw2kZSskfJlJJe7tJ7m3OVoAADewBanz2qPQ+JfBD9InntUeh8S+CH6RB13gbEyYnLSTRVIgfRl7mno85zudE5rh1gNDEON73Wdszg2IwTOfW4l5VGYy0R9BFFlfmaRJmZqdARb8ZYfntUeh8S+CH6RPPao9D4l8EP0iDc7WYF5fSvpulkhc4gtljJDmOabg2BFx2EX4HsOqiWH7uql9XS1WJVrajyEN6JrYQwuLCC10j73JBa0+OXjxvtPPao9D4l8EP0i96La+eSWOM4ViEYe9rTI9sQawOIBe4iS+UXufUglYREQEREBERAREQEREBERAREQEREBERAREQEREHBWgOyVOY2Ndm6WNz3snGUPZJISZHtsMozFxzAizr2NwpAiDrG2wAJuQOPf4rsiICIiAiIgIiICIiAiIgIiICIiAiIgIiICIiAiIgIiICIiAiIgIiICIiAiIgIiICIiAiIgIiICIiAiIgIiICIiAiIgIiICIiAiIgIiICIiAiIgIiICIiAiIgIiICIiAiIgIiICIiAiIgIiICIiAiIgIiICIiAiIgIiICIiAiIgIiICIiAiIgIiICIiD//Z';
        }

        $display.='" alt="Card image" >
        </div>
        <h4 align="center"><i class="fas fa-utensils mr-1"></i>'.$cateringdetails[$i][1].'</h4>';
        if($cateringdetails[$i][2]!="")
        {
            $display.='
        <i>Expire</i>';
        }
        $display.='</a>';


    }
    echo $display;


    ?>
</div>


</div>

<?php
include_once ("../../webdesign/footer/footer.php");
?>
<script>

</script>
</body>
</html>
