<?php
/**
 * Created by PhpStorm.
 * User: shahzadmiraj
 * Date: 2019-09-27
 * Time: 17:29
 */
include_once ("../../connection/connect.php");
$companyid=$_GET['companyid'];
$CateringBranches=$_GET['CateringBranches'];
$hallBranches=$_GET['hallBranches'];
if($CateringBranches==0)
{
    header("location:../hallBranches/hallRegister.php?hallBranches=$hallBranches&companyid=$companyid");
    exit();
}
$sql='SELECT name,id FROM systemDishType WHERE ISNULL(isExpire)';
$dishType=queryReceive($sql);

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

<?php

$H=0;
for($M=0;$M<$CateringBranches;$M++)
{

    echo '<div  class="col-12 border shadow mb-4" id="removeform'.$M.'">';
    $M++;
    echo '<h1 align="center"> Catering Registeration '.$M.'</h1>';
    $M--;
    echo '<form id="formsubmit'.$M.'" >';


    ?>
    <div class="form-group row">
        <label class="col-form-label col-4">Catering Branch name:</label>
        <input name="namecatering" type="text" class="form-control col-8">
    </div>
    <div class="form-group row">
        <label class="col-form-label col-4">Catering Branch Image:</label>
        <input name="image" type="file" class="form-control col-8">
    </div>

    <div class="col-5">
        <p> Map of address</p>
    </div>
    <h3 align="center"> select Dishes</h3>


    <?php

    $display = '';
    for ($i = 0; $i < count($dishType); $i++) {
        $display = '<h1 align="center">' . $dishType[$i][0] . '</h1>';
        $sql = 'SELECT `name`, `id`, `image` FROM `systemDish` WHERE ISNULL(isExpire)AND
systemDishType_id=' . $dishType[$i][1] . '';
        $dishDetail = queryReceive($sql);
        for ($j = 0; $j < count($dishDetail); $j++) {
            $display .= '
    <div class="col-4 table-bordered">
    
    <input id="dishtypename' .$H. '"  hidden type="text" name="dishtypename[]" value="' . $dishType[$i][0] . '">
    <input id="dishid' .$H. '"  hidden type="number" name="dishid[]" value="' . $dishDetail[$j][1] . '">
    <input id="dishname' . $H . '" name="dishname[]" hidden value="' . $dishDetail[$j][0] . '">
    <input id="image' . $H. '" name="image[]" hidden value="' . $dishDetail[$j][2] . '">
    <img class="col-12" src="' . $dishDetail[$j][2] . '" style="height: 20vh" >
    <p class="col-12"> ' . $dishDetail[$j][0] . '</p>
    <input   data-dishshow="' .$H. '" type="button" class="selectdish form-control col-12 btn-danger" value="Remove">
    </div>';
            $H++;
        }

    }
    echo $display;


    ?>
    <div class="form-group row mt-3">
        <input data-formid="<?php echo $M; ?>" type="button" class="cancelform btn btn-outline-danger col-5 form-control " value="cancel">
    <input data-formid="<?php echo $M; ?>" type="button" class="submitform btn btn-primary col-5  form-control" value="submit">
    </div>
        </form>

    <?php
    echo '</div>';

}
?>





<script>
$(document).ready(function () {

    var NoCatering=<?php echo $CateringBranches;?>;
  $(document).on("click",".selectdish",function ()
  {
      var id=$(this).data("dishshow");
      var value=$(this).val();
      if(value=="Remove")
      {
          $("#dishtypename"+id).attr("name","");
          $("#dishid"+id).attr("name","");

          $("#dishname"+id).attr("name","");
          $("#image"+id).attr("name","");
          $(this).val("Select");
          $(this).removeClass("btn-danger");
          $(this).addClass("btn-success");
      }
      else
      {

          $("#dishtypename"+id).attr("name","dishtypename[]");
          $("#dishid"+id).attr("name","dishid[]");
          $("#dishname"+id).attr("name","dishname[]");
          $("#image"+id).attr("name","image[]");
          $(this).val("Remove");
          $(this).removeClass("btn-success");
          $(this).addClass("btn-danger");
      }

  });

  function nextpage(formid)
  {
      $("#removeform"+formid).remove();
      NoCatering--;
      if(NoCatering<=0)
      {
          window.location.href="../hallBranches/hallRegister.php?hallBranches=<?php echo $hallBranches; ?>&companyid=<?php echo $companyid; ?>";
      }
  }


    $(".submitform").click(function () {
        var formid=$(this).data("formid");
        var formdata=new FormData($("#formsubmit"+formid)[0]);
        formdata.append("option","createCatering");
        formdata.append("companyid",<?php  echo $companyid;?>);
        $.ajax({
            url:"../companyServer.php",
            method:"POST",
            data:formdata,
            contentType: false,
            processData: false,
            success:function (data)
            {

                if(data!="")
                {
                    alert(data);
                    return false;
                }
                else
                {
                    nextpage(formid);
                }
            }
        });


    });
    $(".cancelform").click(function ()
    {
        var formid=$(this).data("formid");
        nextpage(formid);

    });






});


</script>
</body>
</html>
