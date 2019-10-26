<?php
/**
 * Created by PhpStorm.
 * User: shahzadmiraj
 * Date: 2019-09-06
 * Time: 16:48
 */
include_once ("../connection/connect.php");

if((!isset($_POST['dishid']))&&($_GET['order']))
{
    header("location:AllSelectedDishes.php?order=".$_GET['order']."");
    exit();
}
$orderId=$_GET['order'];

?>


<!DOCTYPE html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="/Catering/bootstrap.min.css">
    <script src="../jquery-3.3.1.js"></script>
    <script type="text/javascript" src="../bootstrap.min.js"></script>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <link rel="stylesheet" href="../webdesign/css/complete.css">




    <style>

    </style>
</head>
<body>

<?php
include_once ("../webdesign/header/header.php");
?>
<div class="jumbotron  shadow" style="background-image: url(http://tongil.com.au/wp-content/uploads/2018/02/ingredients.jpg);background-size:100% 115%;background-repeat: no-repeat">

    <div class="card-header text-center" style="opacity: 0.7 ;background: white;">
        <h3 class="text-dark"><i class="fas fa-file-word fa-3x mr-2 "></i>Dishes Create</h3>
    </div>

</div>

<div class="container">

    <input hidden type="number" id="orderIdindish" value="<?php echo $_GET["order"];?>">

    <?php
    $dishesId=$_POST['dishid'];
    $types=$_POST['types'];
    $totalDishes=0;
    $display='';
    $number=0;
    for ($i=0;$i<count($types);$i++)
    {
        $totalDishes+=$types[$i];
        for ($k=$types[$i];$k>0;$k--)
        {
            $value=$dishesId[$i];
            $sql = 'SELECT d.id,d.name,d.image FROM dish as d WHERE d.id=' . $value . '';
            $dishDetail = queryReceive($sql);
            $display .= '
    <form  id="form_' . $number . '">

        <div class="card-header shadow-lg p-4 mb-4 border  col-12">';

            $image = substr($dishDetail[0][2], 6);
            if(!file_exists($image))
            {
                $image='https://vector.me/files/images/1/4/145000/icon_food_bowl_plate_dan_outline_symbol_silhouette_cartoon_dish_free_knife_logo_fork_plates_cartoons_spoon_dinner_iammisc_spoons_forks_knives_sendok_garpu_diner_piring.jpg';
            }
        $display.='<div class="row">
<div class="col-6 m-auto card-body">
<img src="'.$image.'" style="height: 20vh;width: 100%">
<h2>'.$dishDetail[0][1].'</h2>
</div>
</div>';





//            <h2 align="center">' . $dishDetail[0][1] . '</h2>
            $display.='<input hidden type="number" name="dishId" value="' . $value . '">';


            $sql = 'SELECT a.id,a.name FROM attribute as a INNER JOIN dish as d
on d.id=a.dish_id
WHERE (d.id=' . $value . ') AND (ISNULL(a.isExpire))';

            $attributeDetail = queryReceive($sql);
            for ($j = 0; $j < count($attributeDetail); $j++) {
                $display .= ' <div class="form-group row">
            <label  class="col-form-label">' . $attributeDetail[$j][1] . '</label>
            <input hidden name="attributeId[]"  value="' . $attributeDetail[$j][0] . '">
            
            <div class="input-group mb-3 input-group-lg">
    <div class="input-group-prepend">
        <span class="input-group-text"><i class="fas fa-sticky-note"></i></span>
    </div>
                <input name="attributeValue[]" class="form-control" type="number" placeholder="etc rice,mutton,..">

</div>
            
            
            
            
        </div>';

            }

            $display .= ' <div class="form-group row">
                <label  class="col-form-label">each price</label>
                
                
                <div class="input-group mb-3 input-group-lg">
    <div class="input-group-prepend">
        <span class="input-group-text"><i class="fas fa-money-bill-alt"></i></span>
    </div>
                <input name="each_price" class="form-control" type="number" placeholder="etc one dish price 1000xx">
</div>
                
                
            </div>
            <div class="form-group row">
                <label class="col-form-label">Quantity</label>
                
                
                           <div class="input-group mb-3 input-group-lg">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-sort-amount-up"></i></span>
                </div>
                                <input name="quantity" class="form-control" type="number" placeholder="how many dishes 1,2,3,...">
            
            </div> 
                            
                
                
            </div>
            <div class="form-group row">
                <label class="col-form-label">describe</label>
                
                
                                <div class="input-group mb-3 input-group-lg">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-comments"></i></span>
                    </div>
                <textarea  name="describe" class="form-control" type="text" placeholder="important comments for dish"></textarea>
                </div>
                
                
            </div>
            <div class="form-group row justify-content-center">
                <button type="button" data-formid="' . $number . '" class="cancelForm form-control btn col-5 btn-danger" value="cancel"><i class="fas fa-trash-alt"></i>Cancel</button>
                <button type="button" data-formid="' . $number . '" class="submitForm form-control btn col-5 btn-primary" value="submit"><i class="fas fa-check "></i>Submit</button>
            </div>
        </div>

    </form>';
            $number++;

        }
    }
    echo $display;

    echo '<h4 align="center">total number of dishes<input readonly type="number" id="totalRemaing" value='.$totalDishes.'></h4>';
    ?>
</div>




<?php
include_once ("../webdesign/footer/footer.php");
?>

<script>
    $(document).ready(function ()
    {
       var totalitems= $("#totalRemaing").val();
       function redirect()
       {
           totalitems--;
            if(totalitems==0)
            {
                var orderid=$("#orderIdindish").val();
                window.location.href="/Catering/dish/AllSelectedDishes.php?order="+orderid;
            }
       }

       $(document).on('click','.submitForm',function ()
       {
           var orderid=$("#orderIdindish").val();
          var id=$(this).data("formid");
          var formdata=new FormData($("#form_"+id)[0]);
          formdata.append("option",'createDish');
           $.ajax({
               url:"dishServer.php?order="+orderid,
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
                  else
                  {
                      $("#form_"+id).remove();
                      redirect();
                  }
               }
           });
       });
       $(document).on('click','.cancelForm',function () {
           var id=$(this).data("formid");
           $("#form_"+id).remove();
           redirect();
       });

    });

</script>
</body>
</html>
