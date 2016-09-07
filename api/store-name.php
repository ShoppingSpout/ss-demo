<?php

header('Content-Type: application/json');

$linklist=array();
$link=array();

include('db.php');

$coupon_id = $_REQUEST['coupon_id'];

if($coupon_id)
{
	$sql = "SELECT S.store_name from deals_coupons D, product_stores S WHERE D.sourceID = S.affliate_store_id AND dcID = ".$coupon_id;
	$rs = mysql_query($sql) or die(mysql_error());
	
	if(mysql_num_rows($rs))	
	{
		$row = mysql_fetch_object($rs);
		
		$link['store_name']=$row->store_name;
		array_push($linklist,$link);
	}
//print_R($linklist);
echo json_encode($linklist);
}

?>