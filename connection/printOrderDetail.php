<?php
include_once ('connect.php');
require('../fpdf181/fpdf.php');

class PDF extends FPDF
{
// Page header
    function Header()
    {
        // Logo
        $this->Image('../gmail.png',10,6,20);
        // Arial bold 15
        $this->SetFont('Arial','B',15);
        // Move to the right
        $this->Cell(80);
        // Title
        $this->Cell(30,10,'Event Guru',1,0,'C');
        // Line break
        $this->Ln(20);
    }

// Page footer
    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Page number
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }
    function billing()
    {



        //order
        $orderId=16;
        $sql='SELECT `id`, `hall_id`, `catering_id`, (SELECT hp.isFood from hallprice as hp WHERE hp.id=orderDetail.hallprice_id),
 `user_id`, `sheftCatering`, `sheftHall`, `sheftCateringUser`, 
 `sheftHallUser`, `address_id`, `person_id`, `total_amount`, 
 `total_person`, `status_hall`, `destination_date`, 
 `booking_date`, `destination_time`, `status_catering`, 
 `notice`,`describe`,(SELECT hp.describe from hallprice as hp WHERE hp.id=orderDetail.hallprice_id),hallprice_id,(SELECT hp.price from hallprice as hp WHERE hp.id=orderDetail.hallprice_id) FROM `orderDetail` WHERE id='.$orderId.'';
        $detailorder = queryReceive($sql);




        //customer information
        $sql = "SELECT `name`, `cnic`, `id`, `date`, `image` FROM `person` WHERE id=".$detailorder[0][9]."";
        $person=queryReceive($sql);

        //numbers
        $sql="SELECT n.number, n.id, n.is_number_active, n.person_id FROM number as n inner JOIN person as p ON p.id=n.person_id
WHERE p.id=.$detailorder[0][9].
order BY n.id";
        $numbers=queryReceive($sql);




        if($detailorder[0][1]!="")
        {
                 //catering order

            $sql = 'SELECT `id`, `address_city`, `address_town`, `address_street_no`, `address_house_no`, `person_id` FROM `address` WHERE id=' . $detailorder[0][8] . '';
            $addresDetail = queryReceive($sql);





            //order billing

            $sql="SELECT DISTINCT ot.id, (SELECT p.name FROM person as p WHERE p.id=ot.person_id), (SELECT sum(py.amount) FROM payment as py WHERE (py.IsReturn=0)AND(py.orderDetail_id=ot.id)) ,ot.id,ot.total_amount, (SELECT SUM(dd.price*dd.quantity) FROM dish_detail as dd WHERE dd.orderDetail_id=ot.id),(SELECT p.image FROM person as p WHERE p.id=ot.person_id) FROM orderDetail as ot LEFT join payment as py on ot.id=py.orderDetail_id WHERE ot.id=".$orderId."";
            $details=queryReceive($sql);

            //person address
            $sql = "SELECT a.id, a.address_city, a.address_town, a.address_street_no, a.address_house_no, a.person_id FROM address as a inner JOIN person p ON a.person_id=p.id
WHERE a.person_id=.$detailorder[0][10].
ORDER by a.person_id;";
            $address=queryReceive($sql);
        }
        else
        {
            //hall order


            if($detailorder[0][3]==1)
            {

                //with menu
                $sql = 'SELECT `dishname`, `image` FROM `menu` WHERE (hallprice_id=' . $packageid . ') AND ISNULL(expire)';
                $menu = queryReceive($sql);
            }
        }




    }
}

// Instanciation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);

$pdf->Output();
?>