<?php
/**
 * Created by PhpStorm.
 * User: shahzadmiraj
 * Date: 2019-09-01
 * Time: 21:31
 */
include  ("../../connection/connect.php");
$companyid=$_GET['company']=2;
$sql='SELECT `id`, `name`,`image` FROM `hall` WHERE ISNULL(expire) AND (company_id='.$companyid.')';
$halls=queryReceive($sql);

$sql='SELECT `id`, `name`,`image` FROM `catering` WHERE ISNULL(expire) AND (company_id='.$companyid.')';
$caterings=queryReceive($sql);
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
<body>
<h1 align=" center">Company Name</h1>

<div class="col-12 m-1 mb-5 form-group row shadow  alert-warning  " >
<h1 align="center" class="col-12">Branches of Hall</h1>


<?php
$display='';
for ($i=0;$i<count($halls);$i++)
{
  $display.= '
    <a href="'.$halls[$i][0].'" class="col-5 m-2">
    <div class="card  col-12  rounded-circle shadow" style="height: 25vh"  >
        <img class="card-img-top  col-12 rounded-circle" src="';
  if(file_exists($halls[$i][2]))
  {
      $display.=$halls[$i][2];
  }
  else
  {
      $display.='../../gmail.png';
  }


  $display.='" alt="Card image" >
    </div>
    <h4 align="center" >'.$halls[$i][1].'</h4>
    </a>';
}
echo $display;
?>

</div>


<div class="col-12 m-1 mb-5 form-group row shadow  alert-success  " >
    <h1 align="center" class="col-12">Branches of Catering</h1>


    <?php
    $display='';
    for ($i=0;$i<count($caterings);$i++)
    {
        $display.= '
    <a href="'.$caterings[$i][0].'" class="col-5 m-2">
    <div class="card  col-12  rounded-circle shadow" style="height: 25vh"  >
        <img class="card-img-top  col-12 rounded-circle" src="';
        if(file_exists($caterings[$i][2]))
        {
            $display.=$caterings[$i][2];
        }
        else
        {
            $display.='../../gmail.png';
        }


        $display.='" alt="Card image" >
    </div>
    <h4 align="center" >'.$caterings[$i][1].'</h4>
    </a>';
    }
    echo $display;
    ?>

</div>






<script>

</script>
</body>
</html>
