<?php
/**
 * Created by PhpStorm.
 * User: shahzadmiraj
 * Date: 2019-09-08
 * Time: 01:51
 */

include_once ("../connection/connect.php");
$hallorcater=$_POST['hallorcater'];
$sql="SELECT DISTINCT od.id,p.name, (SELECT sum(py.amount) FROM payment as py WHERE (py.IsReturn=0)AND(py.orderDetail_id=od.id)) ,od.total_amount,od.total_amount, (SELECT SUM(dd.price*dd.quantity) FROM dish_detail as dd WHERE dd.orderDetail_id=od.id),od.status_catering,od.status_hall FROM orderDetail as od LEFT join payment as py on (od.id=py.orderDetail_id) left JOIN person as p 
on (p.id=od.person_id) LEFT join number as n 
on (p.id=n.person_id) where ";


if(isset($_POST['p_name']))
{
    if($_POST['p_name']!='')
        $sql.=' (p.name LIKE "%'.$_POST["p_name"].'%") AND ';
}

if(isset($_POST['p_cnic']))
{
    if($_POST['p_cnic']!='')
        $sql.=' (p.cnic LIKE "%'.$_POST["p_cnic"].'%") AND ';
}
if(isset($_POST['p_id']))
{
    if($_POST['p_id']!='')
        $sql.=' (p.id ='.$_POST["p_id"].') AND ';
}
if(isset($_POST['n_number']))
{
    if($_POST['n_number']!='')
        $sql.=' (n.number LIKE "%'.$_POST["n_number"].'%") AND ';
}
if(isset($_POST['od_booking_date']))
{
    if($_POST['od_booking_date']!='')
        $sql.=' (od.booking_date = "'.$_POST["od_booking_date"].'") AND ';
}
if(isset($_POST['od_destination_date']))
{
    if($_POST['od_destination_date']!='')
        $sql.=' (od.destination_date ="'.$_POST["od_destination_date"].'") AND ';
}
if(isset($_POST['od_status_catering']))
{
    if($_POST['od_status_catering']!='None')
        $sql.=' (od.status_catering = "'.$_POST["od_status_catering"].'") AND ';
}

if(isset($_POST['od_status_hall']))
{
    if($_POST['od_status_hall']!='None')
        $sql.=' (od.status_hall = "'.$_POST["od_status_hall"].'") AND ';
}


$sql.=''.$hallorcater.' 
order by 
od.destination_date DESC';
$details=queryReceive($sql);


$display='<table class="table table-bordered table-responsive" style="width: 100%;">
    <tbody class="font-weight-bold">
            <td >order Id</td>
            <td>customer Name</td>
            <td>order status</td>
            <td>received amount</td>
            <td>System  Amount</td>
            <td>remaining system amount </td>
            <td>your demanded amount</td>
            <td>remaining demand amount</td>

    </tbody>';


for ($i=0;$i<count($details);$i++)
{
    $display.=' <tr data-orderid="'.$details[$i][0].'" class="orderDetail">
        <td >'.$details[$i][0].'</td>
        <td>'.$details[$i][1].'</td>
        <td>';
    if(!empty($hallid))
    {
        //if order status is hall
        $display.=$details[$i][7];

    }
    else
    {
        //if order status is catering
        $display.=$details[$i][6];

    }


    $display.='</td>
        <td>'.(int)$details[$i][2].'</td>
        <td>'.(int)$details[$i][5].'</td>
        <td> '.(int) ($details[$i][5]-$details[$i][2]).'</td>
        <td>'.(int) $details[$i][4].'</td>
        <td>'.(int) ($details[$i][4]-$details[$i][2]).'</td>
 ';



    $display.='</tr>';
}



$display.='</table>';

echo $display;




?>