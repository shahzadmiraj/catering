<?php
/**
 * Created by PhpStorm.
 * User: shahzadmiraj
 * Date: 2019-09-08
 * Time: 01:51
 */

$sql='SELECT * FROM person as p INNER join number as n on p.id=n.person_id
    INNER join orderTable as ot
    on p.id=ot.person_id
    INNER join change_status as cs
    on ot.id=cs.orderTable_id';

//$arrayColumName=array("p.name","p.cnic","n.number","ot.booking_date","ot.destination_date","cs.order_status_id");

echo $_POST['p_name'];
if(isset($_POST['p_name']))
{
    echo "sdsd";
}

?>