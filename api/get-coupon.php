<?php

header('Content-Type: application/json');

$linklist=array();
$link=array();

include('db.php');

$coupon_id = $_REQUEST['coupon_id'];

if($coupon_id)
{

$qr=mysql_query("SELECT D.*, DATE_FORMAT(deal_end_date,'%M %d, %Y') as deal_end_date, S.store_name FROM deals_coupons D, product_stores S WHERE D.sourceID = S.affliate_store_id AND dealFor = 'store_page'  AND dcID IN (".$coupon_id.") order by position") or die(mysql_error());

while($res=mysql_fetch_array($qr))
{
	$link['coupon_id']=$res['dcID'];
	$link['coupon_title']=$res['deal_name'];
	$link['coupon_description']=$res['dateCaption'];
	$link['coupon_code']=$res['couponCode'];
	$link['coupon_site_redirect_url']=$res['redirect_url'];
	$link['coupon_expiry_date']=$res['deal_end_date'];

	$url = 'http://www.shoppingspout.com.au/'. str_replace(" ","-", $res['store_name']).'-coupon-codes-c-'.$res['dcID'].'.html';
	$link['coupon_url']= $url;
	$link['coupon_store_image']= 'http://www.shoppingspout.com.au/files/store_logos/dummy-store.jpg';
	
	$link['total_vote'] = $res['down_vote'] + $res['up_vote'];

	if($link['total_vote'] > 0)
				$link['success_ration'] = round(($res['up_vote']/($res['down_vote'] + $res['up_vote'])) * 100);
				
	array_push($linklist,$link);
}
//print_R($linklist);
echo json_encode($linklist);
}

?>