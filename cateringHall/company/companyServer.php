<?php
/**
 * Created by PhpStorm.
 * User: shahzadmiraj
 * Date: 2019-09-03
 * Time: 17:20
 */
include_once ("../connection/connect.php");


if(isset($_POST['option']))
{
    if($_POST['option']=="createUser")
    {

        $username=chechIsEmpty($_POST['username']);
        $password=chechIsEmpty($_POST['password']);
        $sql='SELECT u.id FROM user as u WHERE (u.password="'.$password.'") AND (u.username="'.$username.'")';
        $userExist=queryReceive($sql);
        if(count($userExist)!=0)
        {
            echo "user is already exist";
            exit();
        }

        $name = trim($_POST['name']);
        $numberArray = $_POST['number'];
        $isowner=1;
        $cnic = $_POST['cnic'];
        $city = $_POST['city'];
        $area = $_POST['area'];
        $streetNo = chechIsEmpty($_POST['streetNo']);
        $houseNo = chechIsEmpty($_POST['houseNo']);
        $date = date('Y-m-d');
        $sql='INSERT INTO `person`(`name`, `cnic`, `id`, `date`) VALUES ("'.$name.'","'.$cnic.'",NULL,"'.$date.'")';
        querySend($sql);
        $last_id = mysqli_insert_id($connect);
        $sql="INSERT INTO `address` (`id`, `address_street_no`, `address_house_no`, `person_id`, `address_city`, `address_town`) VALUES (NULL, '".$streetNo."', '".$houseNo."', '".$last_id."', '".$city."', '".$area."');";
        querySend($sql);
        for ($i=0;$i<count($numberArray);$i++)
        {

            $sql = "INSERT INTO `number`(`number`, `id`, `is_number_active`, `person_id`) VALUES ('".$numberArray[$i]."',NULL,1,$last_id)";
            querySend($sql);
        }
        $customerId = $last_id;
        $sql='INSERT INTO `user`(`id`, `username`, `password`, `person_id`, `isExpire`,`isowner`, `company_id`) VALUES (NULL,"'.$username.'","'.$password.'",'.$customerId.',NULL,"'.$isowner.'",NULL)';
        querySend($sql);
        $userid = mysqli_insert_id($connect);

        $sql='INSERT INTO `company`(`id`, `name`, `expire`, `user_id`) VALUES (NULL,"'.$_POST['companyName'].'",NULL,'.$userid.')';
        querySend($sql);
        $companyid=mysqli_insert_id($connect);
        echo $companyid;


    }
    else if($_POST['option']=="createCatering")
    {
        $companyid=$_POST['companyid'];
        $namecatering=$_POST['namecatering'];
        $Cateringimage='';
        $sql=(string) "";
        if(!empty($_FILES['image']["name"]))
        {
            $Cateringimage = "../../images/catering/" . $_FILES['image']['name'];
            $resultimage = ImageUploaded($_FILES, $Cateringimage);//$dishimage is destination file location;
            if ($resultimage != "") {
                print_r($resultimage);
                exit();
            }
        }
        $sql='INSERT INTO `catering`(`id`, `name`, `expire`, `image`, `location_id`, `company_id`) VALUES (NULL,"'.$namecatering.'",NULL,"'.$Cateringimage.'",NULL,'.$companyid.')';
        querySend($sql);
        $cateringid=mysqli_insert_id($connect);
            if(!isset($_POST['dishtypename']))
            {
                exit();
            }
        $dishtypename=$_POST['dishtypename'];
        $dishtypeid='';
        $dishid=$_POST['dishid'];
        $dishname=$_POST['dishname'];
        $image=$_POST['image'];
        for($i=0;$i<count($dishtypename);$i++)
        {
            $sql='SELECT `id` FROM `dish_type` WHERE (name="'.$dishtypename[$i].'") AND (catering_id='.$cateringid.')';
            $detail=queryReceive($sql);
            if(count($detail)>0)
            {
                $dishtypeid=$detail[0][0];
            }
            else
            {
                $sql='INSERT INTO `dish_type`(`id`, `name`, `isExpire`, `catering_id`) VALUES (NULL,"'.$dishtypename[$i].'",NULL,'.$cateringid.')';
                querySend($sql);
                $dishtypeid=mysqli_insert_id($connect);
            }

            $sql='INSERT INTO `dish`(`name`, `id`, `image`, `dish_type_id`, `isExpire`, `catering_id`) VALUES ("'.$dishname[$i].'",NULL,"'.$image[$i].'",'.$dishtypeid.',NULL,'.$cateringid.')';
            querySend($sql);
            $idDishe=mysqli_insert_id($connect);
            $sql='SELECT `name` FROM `SystemAttribute` WHERE ISNULL(isExpire) AND (systemDish_id='.$dishid[$i].')';
            $detailAttributes=queryReceive($sql);
            for($j=0;$j<count($detailAttributes);$j++)
            {


                $sql='INSERT INTO `attribute`(`name`, `id`, `dish_id`, `isExpire`) VALUES ("'.$detailAttributes[$j][0].'",NULL,'.$idDishe.',NULL)';
                querySend($sql);
            }


        }
    }
}
?>