<?php
/**
 * Created by PhpStorm.
 * User: shahzadmiraj
 * Date: 2019-09-01
 * Time: 21:31
 */
include  ("../../connection/connect.php");
$companyid=$_GET['companyid'];
$hallBranches='';

if (isset($_GET['hallBranches']))
{
    $hallBranches = $_GET['hallBranches'];
    if ($hallBranches == 0) {
        //go to display company detail
        header("Location:../companyRegister/companydisplay.php?companyid=" . $companyid . "");
        exit();
    }
}

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
            margin:0px;
            padding:0px;
        }
    </style>
</head>
<body class="container" >


<h1 align="center">
    Hall Branches Register
</h1>
<form>
    <div class="form-group row">
    <label class="col-form-label col-4">Hall Branch Name:</label>
    <input name="hallname" class="form-control col-8" type="text">
    </div>

    <div class="form-group row">
        <label class="col-form-label col-4">Hall Type:</label>
        <select name="halltype" class="form-control col-8">
            <option value="1">Marquee</option>
            <option value="2">Hall</option>
            <option value="3">Deera /Open area</option>
        </select>
    </div>
    <div class="form-group row">
        <label class="col-form-label col-4">Hall Branch Image:</label>
        <input name="image" class="form-control col-8" type="file">
    </div>
    <div class="form-group row">
        <label class="col-form-label col-4">Hall Branch Address</label>
    </div>
    <div class="form-group row">
        <label class="col-form-label col-8">Maximum Capacity of guests in hall:</label>
        <input name="capacity" class="form-control col-4" type="number">
    </div>

    <div class="form-group row">
        <label class="col-form-label col-8">No of Partition in Hall:</label>
        <input name="partition" class="form-control col-4" type="number">
    </div>

    <div class="form-inline form-group">
        <input name="parking" class="form-check-input  " type="checkbox">
        <label class="form-check-label ">Have Your own parking</label>
    </div>
    <div class="form-group row">
        <input id="cancel" type="button" class="btn btn-danger col-4 form-control"  value="cancel">
        <input id="submit" type="button" class=" btn btn-success col-4 form-control" value="Submit">
    </div>


</form>





<script>

    $(document).ready(function () {
        $('#submit').click(function () {
            var formdata = new FormData($("form")[0]);
            formdata.append("option", "CreateHall");
            formdata.append("companyid",<?php echo $companyid;?>);
            $.ajax({
                url: "../companyServer.php",
                method: "POST",
                data: formdata,
                contentType: false,
                processData: false,
                success: function (data)
                {
                    if(!($.isNumeric(data)))
                    {
                        alert(data);
                    }
                    else
                    {
                        //hall detail

                        <?php
                        if (isset($_GET['hallBranches']))
                        {
                            ?>

                        window.location.href="daytimeAll.php?companyid=<?php echo $companyid; ?>&hallid="+data+"&hallBranches=<?php  $hallBranches--;  echo $hallBranches;?>";

                            <?php

                        }
                        else
                        {
                            ?>

                        window.history.back();
                            <?php

                        }

                        ?>
                    }

                }
            });
        });
        $("#cancel").click(function ()
        {


            <?php
            if (isset($_GET['hallBranches']))
            {
                ?>


            //remove one hall
            window.location.href="?hallBranches=<?php  $hallBranches--;  echo $hallBranches;?>&companyid=<?php echo $companyid;?>";

                <?php

            }
            else
            {
                ?>

            window.history.back();
                <?php

            }

            ?>

        });
    });

</script>
</body>
</html>
