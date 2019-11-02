<?php
/**
 * Created by PhpStorm.
 * User: shahzadmiraj
 * Date: 2019-09-15
 * Time: 11:41
 */
include_once ("connection/connect.php");

?>

<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <script src="jquery-3.3.1.js"></script>
    <link rel="stylesheet" type="text/css" href="bootstrap.min.css">
    <script type="text/javascript" src="bootstrap.min.js"></script>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="webdesign/css/complete.css">
    <style>

        .carousel-item img
        {
            margin: 0;
            height: 60vh;
        }
        .carousel-caption
        {
            background-color: rgba(253, 248, 239, 0.6);
            font-weight: bold;
            color: rgba(0, 0, 0, 1);
        }
        .checked {
            color: orange;
        }
        .pictures {
            position: relative;
            text-align: center;
            color: white;
        }
        .top-right {
             position: absolute;
             top: 8px;
             right: 16px;
         }







    </style>
</head>
<body>
<?php
include_once ("webdesign/header/header.php");

?>


<div class="bd-example">
    <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleCaptions" data-slide-to="1" class="active"></li>
            <li data-target="#carouselExampleCaptions" data-slide-to="2" class="active"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item  active">
                <img src="style1.jpg" class="d-block w-100" alt="...">
                <div class="carousel-caption ">
                    <h5 class="display-4">Hall Booking</h5>
                    <p>book your nearest Hall,Marquee and Dera and get 10% discount</p>
                </div>
            </div>
            <div class="carousel-item  ">
                <img src="dolar.jpeg" class="d-block w-100" alt="...">
                <div class="carousel-caption ">
                    <h5 class="display-4">Free Company Register</h5>
                    <p>Register hall and catering company and get free software</p>
                </div>
            </div>
            <div class="carousel-item ">
                <img src="https://indiebookbutler.com/wp-content/uploads/2015/08/Free.jpg" class="d-block w-100" alt="...">
                <div class="carousel-caption ">
                    <div class="col-12 p-0 m-0">

                        <!-- Links -->
                        <h4 class="text-uppercase font-weight-bold">Software Features</h4>
                        <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
                        <p>
                            <a href="/Catering/company/companyRegister/companyRegister.php" class="text-dark">Marquee Management software</a>
                        </p>
                        <p>
                            <a href="/Catering/company/companyRegister/companyRegister.php" class="text-dark">Hall Management software</a>
                        </p>
                        <p>
                            <a href="/Catering/company/companyRegister/companyRegister.php" class="text-dark">Catering Management software</a>
                        </p>
                        <p>
                            <a href="/Catering/company/companyRegister/companyRegister.php" class="text-dark">Dera / Open area Management software</a>
                        </p>
                    </div>
                </div>
            </div>

        </div>
        <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</div>





<div class="container">

<div class="jumbotron card card-image mr-5 ml-5 " style="background-image: url(https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcTggd_nzKxicPajH1Mw7Jvwb1JSakcZFoHgsqEZH3Z1Dj2RMYWk);margin-top: -15px;background-repeat: no-repeat; background-size: cover;">



    <div class="text-white  text-center  row" >
        <div class="input-group mb-2 mr-sm-2">
            <div class="input-group-prepend">
                <div class="input-group-text"><i class="fas fa-clock"></i></div>
            </div>
            <select class="custom-select "  size="1">
                <option>Morning Time </option>
                <option>Afternoon Time</option>
                <option>Evening Time</option>
            </select>
        </div>
    </div>




    <div class="text-white  text-center  row" >
        <div class="input-group mb-2 mr-sm-2">
            <div class="input-group-prepend">
                <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
            </div>
            <input type="date" class="form-control py-0" id="inlineFormInputGroupUsername2" placeholder="Booking Date">
        </div>
    </div>


    <div class="text-white  text-center  row" >
        <div class="input-group mb-2 mr-sm-2">
            <div class="input-group-prepend">
                <div class="input-group-text"><i class="fas fa-utensils"></i></div>
            </div>
            <select class="custom-select "  size="1">
                <option>Per head Only Seating</option>
                <option>Per head Seating + Food</option>
            </select>
        </div>
    </div>


<div class="m-auto">
<button class="btn btn-danger"><i class="fas fa-check"></i>
    Submit</button>
</div>

</div>


















<div class="row mt-5" >

    <?php


    $monthsArray = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
    $currentdate=date("Y/m/d");
    $maxDate = new DateTime('now');
    $maxDate->modify('+1 month'); // or you can use '-90 day' for deduct

    $NextMonthNo=$maxDate->format('m');
    $NextMonthNo=$NextMonthNo-1;
    $maxDate = $maxDate->format('Y-m-d');
    $CurrentMonthNo=date('m');
    $CurrentMonthNo=$CurrentMonthNo-1;
    $sql='SELECT h.id,h.image,h.name,h.max_guests,hp.id,hp.month,hp.isFood,hp.price,hp.dayTime,hp.package_name,h.hallType FROM hall as h INNER join hallprice as hp
ON
(h.id=hp.hall_id)
left join orderDetail as od on (h.id=od.hall_id) 


WHERE
 ((od.hall_id IS NULL) or ((od.status_hall="Cancel")AND
(od.destination_date between "'.$currentdate.'" AND "'.$maxDate.'" ))) AND (ISNULL(h.expire)) AND
((ISNULL(hp.expire)) AND ((hp.month="'.$monthsArray[$CurrentMonthNo].'")or (hp.month="'.$monthsArray[$NextMonthNo].'"))) limit 20
';

function showHalls($sql)
{
    $halltype=array("Marquee","Hall","Deera /Open area");

    $display = '';
    $AllHalls=queryReceive($sql);
    for ($i=0;$i<count($AllHalls);$i++)
    {

        $display.='
        
       <a href="company/hallBranches/hallclient.php?hallid='.$AllHalls[$i][0].'&packageid='.$AllHalls[$i][4].'&date='.$AllHalls[$i][5].'&time='.$AllHalls[$i][8].'" class="card-body booking-card col-sm-11 col-md-5 col-xl-3 p-0 m-2">

            <!-- Card image -->
            <div class="view overlay">
                <div class="container pictures">
                    <img src="';
        if(file_exists($AllHalls[$i][1]) &&($AllHalls[$i][1]!=""))
        {
            $display.=$AllHalls[$i][1];
        }
        else
        {
            $display.='https://www.pakvenues.com/system/halls/cover_images/000/000/048/original/Umar_Marriage_Hall_lahore.jpg?1566758537';
        }

        $display.='" alt="Snow" style="width:100%;height: 100%">
                    <h5 class="top-right text-dark">43.3Km</h5>
                </div>
            </div>

            <!-- Card content -->
            <div class="card-body">

                <!-- Title -->
                <h4 class="card-title font-weight-bold text-center"><a> '.$AllHalls[$i][2].'</a></h4>
                <!-- Data -->

                <span class="fa fa-star checked"></span>
                <span class="fa fa-star checked"></span>
                <span class="fa fa-star checked"></span>
                <span class="fa fa-star"></span>
                <span class="fa fa-star"></span>
                <h3 class="text-right"><i class="far fa-money-bill-alt"></i><span class="font-weight-bold"> RS:<i class="text-warning"> '.$AllHalls[$i][7].' </i></span></h3>
                <h4><i class="fas fa-clock"></i> Time <span class="text-warning">'.$AllHalls[$i][8].'</span> </h4>
                <h4><i class="far fa-calendar-alt"></i> Month <span class="text-warning">'.$AllHalls[$i][5].'</span></h4>
                <h4><i class="fas fa-users"></i> Max Guests  <span class="text-warning">'.$AllHalls[$i][3].'</span></h4>
                <h4><i class="fab fa-accusoft"></i> Hall Type: <span class="text-warning">'.$halltype[$AllHalls[$i][10]].'</span></h4>';
        if( $AllHalls[$i][6]==0)
        {
            $display.='
                <h4><i class="material-icons">airline_seat_recline_normal</i> <span class="text-warning">with Seating</span></h4>';
        }
        else
        {
            $display.='
                <h4><i class="material-icons">fastfood</i> package name  <span class="text-warning">'.$AllHalls[$i][9].'</span></h4>';
        }


        $display.='</div>
        </a>';
    }




     return $display;
}



    echo showHalls($sql);
?>














</div>


    <a href="company/companyRegister/companyRegister.php" class="col-3 btn btn-outline-danger">Company Register</a>
    <a href="company/companyRegister/companydisplay.php?companyid=3" class="col-3 btn btn-outline-danger">Log in</a>










</div>


<?php
include_once ("webdesign/footer/footer.php");
?>
<script>

    $(document).ready(function () {


        $('.carousel').carousel({
            interval: 5000
        });


    });


</script>
</body>
</html>

