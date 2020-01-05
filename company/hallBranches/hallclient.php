
<?php
include_once ('../../connection/connect.php');
$hallid=$_GET['hallid'];
$packageid=$_GET['packageid'];
$date=$_GET['date'];
$time=$_GET['time'];

$sql='SELECT `name`, `max_guests`, `noOfPartitions`, `ownParking`,`image`, `hallType`, `location_id` FROM `hall` WHERE id='.$hallid.'';
$hallinformations=queryReceive($sql);
$sql='SELECT u.username,p.name,n.number,p.image from company as c INNER JOIN hall as h 
on (h.company_id=c.id)
LEFT JOIN user as u 
on (c.user_id=u.id)
left join person as p 
on (u.person_id=p.id)
left JOIN number as n 
on (p.id=n.person_id)
WHERE h.id='.$hallid.'';
$owndetail=queryReceive($sql);


$sql='SELECT `isFood`, `price`, `describe`,`package_name` FROM `hallprice` WHERE id='.$packageid.'';
$packagedtail=queryReceive($sql);


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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="../../webdesign/css/complete.css">
    <style>
        html body{
            width: 100%;
            height: 100%;
            margin-top:20px;
        }
        .comment-wrapper .panel-body {
            max-height:650px;
            overflow:auto;
        }

        .comment-wrapper .media-list .media img {
            width:64px;
            height:64px;
            border:2px solid #e5e7e8;
        }

        .comment-wrapper .media-list .media {
            border-bottom:1px dashed #efefef;
            margin-bottom:25px;
        }

    </style>
</head>
<body>
<?php
include_once ("../../webdesign/header/header.php");
?>

<div class="jumbotron  shadow" style="background-image: url(
<?php
if(file_exists($hallinformations[0][4]))
{
    echo $hallinformations[0][4];
}
else
{
    echo "https://weddingspot-prod-s3-1.s3.amazonaws.com/__sized__/images/venues/2218/Royal-Palm-Banquet-Hall-Farmingdale-NY-2c26ce40-b77e-404c-afb9-aae846a77332-97450e389c42885476f1fbe9bc5bca5a.jpg";
}

?>);background-size:100% 115%;background-repeat: no-repeat">

    <div class="card-body text-center" style="opacity: 0.7 ;background: white;">
        <h1 class="display-5 "><i class="fas fa-place-of-worship"></i> <?php echo $hallinformations[0][0];?></h1>
        <p class="lead">Free Order Booking</p>
    </div>
</div>




<div class="container">
    <h1 class="font-weight-light  text-lg-left mt-4 mb-0">Package Detail</h1>
    <hr class="mt-2 mb-3">

            <div class="card p-3 border-0">

                <h1 class="m-3 text-danger text-right">
                        <i class="far fa-money-bill-alt mr-3"></i>RS:<i> <?php echo $packagedtail[0][1];?> </i>
                </h1>
                <h3 class="m-3 ">
                    <i class="far fa-calendar-alt"></i>Date:<span class="text-info"><?php echo $date;?></span>
                </h3>
                <h3 class="m-3 ">
                    <i class="fas fa-clock"></i>Time:<span class="text-info"><?php echo $time;?></span>
                </h3>

                <?php

                if($packagedtail[0][0]==0)
                {
                    //if food is not
                    echo '<h3 class="m-3 ">
                    <i class="material-icons">
                        airline_seat_recline_normal
                    </i>with Seating
                </h3>';
                }
                else
                {
                    //if food
                    echo ' <h5 class="m-3 ">
                    <i class="material-icons">
                        fastfood
                    </i>package name: <span class="text-info">'.$packagedtail[0][3].'</span>
                </h5>
                
                
                <p class="d-block m-3 ">
                    <i class="far fa-clipboard"></i>

                    <span class="font-weight-bold text-info">Menu Note:</span>
                    '.$packagedtail[0][2].'
                </p>
               
                ';
                }


                    ?>




        </div>

    <?php

        $sql='SELECT `id`, `dishname`, `image` FROM `menu` WHERE ISNULL(expire) && (hallprice_id='.$packageid.')';
        $menudetail=queryReceive($sql);

        if($packagedtail[0][0]==1)
        {
            //if food then show dishes

            $display = ' 
                <div class="container">

                <h2 class="font-weight-light text-center text-lg-left mt-4 mb-0">Menu</h2>

                <hr class="mt-2 mb-5">
                
                
                <div class="row text-center text-lg-left">
                ';
            for ($i = 0; $i < count($menudetail); $i++) {
                $display .= '
                    <div class="col-lg-3 col-md-4 col-6">
                        <a href="#' . $menudetail[$i][0] . '" class="d-block mb-4 h-100">
                            <img class="img-fluid img-thumbnail" src="' . $menudetail[$i][2] . '" alt="" style="width: 100%;height: 20vh">

                            <h3>' . $menudetail[$i][1] . '</h3>

                        </a>
                    </div>';
            }

            $display .= '
        
                </div>

            </div>';
            echo $display;
        }


    ?>

            <!--<div class="container">

                <h2 class="font-weight-light text-center text-lg-left mt-4 mb-0">Menu</h2>

                <hr class="mt-2 mb-5">

                <div class="row text-center text-lg-left">

                    <div class="col-lg-3 col-md-4 col-6">
                        <a href="#" class="d-block mb-4 h-100">
                            <img class="img-fluid img-thumbnail" src="https://source.unsplash.com/pWkk7iiCoDM/400x300" alt="">

                            <h3>sdsddsfds</h3>

                        </a>
                    </div>


                </div>

            </div>-->



</div>










<div class="container" >
    <h1 class="font-weight-light text-lg-left mt-4 mb-0">Hall Information</h1>
    <hr class="mt-2 mb-5">

    <div class="row card-body mb-2">

        <div class="container p-0">

            <div class="row">
            <img src="<?php
            if(file_exists($owndetail[0][3]))
            {
                echo $owndetail[0][3];
            }
            else
            {
                echo "https://cdn.pixabay.com/photo/2016/04/25/07/49/man-1351346_960_720.png";
            }

            ?> " class="img-thumbnail" style="width: 200px">
            <h4 class="m-3"><span class="text-white">Name: <?php echo $owndetail[0][1];?></span></h4>
            </div>

            <?php
            $display='';
            for($i=0;$i<count($owndetail);$i++)
            {
                $display.='<h5 class="m-3">
                <i class="fas fa-phone-volume"></i>
          Phone No:<span class="text-white"> '.$owndetail[$i][2].'</span></h5>';
            }
            echo $display;



            ?>



            <h5 class="m-3">
                <i class="fas fa-users"></i>
                  Maximum Guest: <span class="text-white"><?php echo $hallinformations[0][0];?></span></h5>

            <h5 class="m-3">
                <i class="fas fa-columns"></i>
                Number of partitions: <span class="text-white"><?php echo $hallinformations[0][0];?></span></h5>
            <h5 class="m-3">
                <i class="fas fa-parking"></i>Parking : <span class="text-white"><?php


                if($hallinformations[0][0]==1)
                {
                    echo " Yes";
                }
                else
                {
                    echo " NO";
                }


                ?>
           </span> </h5>

            <h5 class="m-3">
                <i class="fas fa-archway"></i>
                Hall Type: <span class="text-white"><?php
                $halltype=array("Marquee","Hall","Deera /Open area");

                echo $halltype[$hallinformations[0][5]];

                ?> </span></h5>
        </div>
    </div>

</div>



<div class="container">

    <h1 class="font-weight-light text-lg-left mt-5 mb-3">Gallery</h1>


    <form action="" method="POST" enctype="multipart/form-data" class="form-inline">
        <input type="file" name="userfile[]" value="" multiple="" class="col-8 btn  btn-light">
        <input id="submitmultiphotos" type="submit" name="submit" value="Upload" class="btn btn-success col-4">
    </form>
    <?php

    if(isset($_FILES['userfile']))
    {

        $file_array=reArray($_FILES['userfile']);
        $Distination='';
        for ($i=0;$i<count($file_array);$i++)
        {
            $Distination= '../../images/hall/'.$file_array[$i]['name'];
            $error=MutipleUploadFile($file_array[$i],$Distination);
            if(count($error)>0)
            {
                echo '<h4 class="badge-danger">'.$file_array[$i]['name'].'.'.$error[0].'</h4>';
            }
            else
            {
                $sql='INSERT INTO `images`(`id`, `image`, `expire`, `catering_id`, `hall_id`) VALUES (NULL,"'.$Distination.'",NULL,NULL,'.$hallid.')';
                querySend($sql);
            }

        }
        unset($_FILES['userfile']);

    }



    ?>



    <hr class="mt-3 mb-5">

    <div class="row text-center text-lg-left">


        <?php


        $sql='SELECT `id`, `image` FROM `images` WHERE hall_id='.$hallid.'' ;
        echo showGallery($sql);

        ?>


    </div>

</div>











<?php



include_once ("comment.php");
include_once ("../../webdesign/footer/footer.php");
?>
<script>


    $(document).ready(function ()
    {
        $("#submitmultiphotos").change(function (e)
        {
            e.preventDefault();
            var formData=new FormData($(this)[0]);
            $.ajax({
                url:"",
                method:"POST",
                data:formData,
                contentType: false,
                processData: false,

                beforeSend: function() {
                    $("#preloader").show();
                },
                success:function (data)
                {
                    $("#preloader").hide();
                        location.reload();


                }
            });




        });





    });






</script>
</body>
</html>
