<?php
/**
 * Created by PhpStorm.
 * User: shahzadmiraj
 * Date: 2019-09-08
 * Time: 01:51
 */

include_once ("../connection/connect.php");
$sql='SELECT DISTINCT ot.id, (SELECT p.name FROM person as p WHERE p.id=ot.person_id), (SELECT sum(py.amount) FROM payment as py WHERE (py.IsReturn=0)AND(py.orderDetail_id=ot.id)) ,ot.extre_charges,ot.total_amount, (SELECT SUM(dd.price*dd.quantity) FROM dish_detail as dd WHERE dd.orderDetail_id=ot.id) FROM person as p INNER JOIN orderDetail as ot
on p.id=ot.person_id
LEFT join payment as py on ot.id=py.orderDetail_id WHERE   ';

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
if(isset($_POST['ot_booking_date']))
{
    if($_POST['ot_booking_date']!='')
        $sql.=' (ot.booking_date = "'.$_POST["ot_booking_date"].'") AND ';
}
if(isset($_POST['ot_destination_date']))
{
    if($_POST['ot_destination_date']!='')
        $sql.=' (ot.destination_date ="'.$_POST["ot_destination_date"].'") AND ';
}
if(isset($_POST['ot_is_active']))
{
    if($_POST['ot_is_active']!='None')
        $sql.=' (ot.is_active = '.$_POST["ot_is_active"].') AND ';
}


$sql.='  (p.id IS NOT NULL)
order by 
ot.destination_date DESC';
$details=queryReceive($sql);


$display='<table class="table table-bordered table-responsive" style="width: 100%;">
    <tbody class="font-weight-bold">
            <td >order Id</td>
            <td>customer Name</td>
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