<?php
/**
 * Created by PhpStorm.
 * User: shahzadmiraj
 * Date: 2019-09-08
 * Time: 01:51
 */

include_once ("../connection/connect.php");
$sql='SELECT p.id,p.name,ot.destination_date,ot.id  FROM person as p INNER join number as n on p.id=n.person_id
    INNER join orderTable as ot
    on p.id=ot.person_id where ';




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
$records=queryReceive($sql);



if(count($records)>0)
{

    $displayRecord = '<h2 align="center">display records</h2>
            <div class="form-group row border mb-0 p-1">
                <label class="font-weight-bold col-form-label col-2">order Id</label>
                <label class="font-weight-bold col-form-label col-5">customer Name</label>
                <label class="font-weight-bold col-form-label col-3">destination Date</label>
                <label class="font-weight-bold col-form-label col-2">Detail</label>
            </div>';

    for ($j=0;$j<count($records);$j++)
    {
        $displayRecord .= ' <div class="form-group row border">
                <label class="col-form-label col-2">'.$records[$j][3].'</label>
                <label class="col-form-label col-5">'.$records[$j][1].'</label>
                <label class="col-form-label col-3">'.$records[$j][2].'</label>
                <a href="/order/PreviewOrder.php?order='.$records[$j][3].'" class="btn-primary col-2 form-control ">Detail</a>
            </div>';
    }
}
else
{
    $displayRecord = '<h2 align="center">Not Found</h2>';
}
echo $displayRecord




?>