<?php
///**
// * Created by PhpStorm.
// * User: shahzadmiraj
// * Date: 2019-09-01
// * Time: 21:31
// */
//
//
//?>
<!--<!DOCTYPE html>-->
<!--<head>-->
<!--    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">-->
<!--    <link rel="stylesheet" type="text/css" href="/Catering/../bootstrap.min.css">-->
<!--    <script src="../../jquery-3.3.1.js"></script>-->
<!--    <script type="text/javascript" src="../../bootstrap.min.js"></script>-->
<!--    <meta charset="utf-8">-->
<!--    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">-->
<!--    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>-->
<!--    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>-->
<!---->
<!--    <style>-->
<!--        *{-->
<!--            margin:auto;-->
<!--            padding: auto;-->
<!--        }-->
<!--    </style>-->
<!--</head>-->
<!--<body >-->

<div class=" btn-danger w-100 shadow fixed-top ">
<p align="center">Welcome to New Kashmir Food Center</p>
    <p align="center " class="text-capitalize">
        <?php
        if(isset($_SESSION['username']))
        {
            echo '<span class="btn-light  shadow font-weight-bold btn col-4">'.$_SESSION['username'].'</span>';
        }
        ?>
    </p>
<a href="/Catering/user/userDisplay.php" class="btn btn-warning">Home Page</a>
</div>




<!---->
<!--<script>-->
<!---->
<!---->
<!--</script>-->
<!--</body>-->
<!--</html>-->
