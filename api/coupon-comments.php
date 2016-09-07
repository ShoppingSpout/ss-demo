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
		$store_name = $row->store_name;
		
	}
	
	
	$qr=mysql_query("SELECT * FROM coupon_comments WHERE dcID = ".$coupon_id." AND status = 'approved' ") or die(mysql_error());
	
	if(mysql_num_rows($qr))
	{
		while($res=mysql_fetch_array($qr))
		{
			$link['comment_id']=$res['cmtID'];
			$link['comment']=$res['comment'];
			$link['comment_by']=$res['user_name'];
			$link['comment_date']=$res['comment_date'];
			$link['store_name']=$store_name;
						
			array_push($linklist,$link);
		}
	}
	else
	{
		$link['store_name']=$store_name;
		array_push($linklist,$link);
	}	
//print_R($linklist);
echo json_encode($linklist);
}

?>