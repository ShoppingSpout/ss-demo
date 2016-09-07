<?php

header('Content-Type: application/json');

$linklist=array();
$link=array();

include('db.php');

$store_id = $_REQUEST['store_id'];


function fav_coupon_users($coupon_id)
{
	$fav_user = '';
	$i = 0;

	$qr1=mysql_query("SELECT site_user_id FROM user_fav_coupon WHERE coupon_id = ".$coupon_id);
	
	if(mysql_num_rows($qr1))
	{
		while($res1=mysql_fetch_array($qr1))
		{
			$fav_user .= $res1['site_user_id'].'|';
		}
		return $fav_user;
	}
}	


$qr=mysql_query("SELECT D.*, DATE_FORMAT(deal_end_date,'%M %d, %Y') as deal_end_date, S.store_name, c_store_logo FROM deals_coupons D, product_stores S WHERE D.sourceID = S.affliate_store_id AND dealFor = 'store_page'  AND (deal_end_date >= now() OR  deal_end_date = '0000-00-00 00:00:00') AND approved = 1 AND D.sourceID = ".$store_id." order by position") or die("store not found. please send correct store_id");

while($res=mysql_fetch_array($qr))
{
	$link['coupon_id']=$res['dcID'];
	$link['coupon_title']=$res['deal_name'];
	$link['coupon_description']=$res['dateCaption'];
	$link['coupon_code']=$res['couponCode'];
	$link['coupon_site_redirect_url']=$res['redirect_url'];
	$link['coupon_expiry_date']=$res['deal_end_date'];
	$link['store_name']=$res['store_name'];

	$url = 'http://www.shoppingspout.com.au/'. str_replace(" ","-", $res['store_name']).'-coupon-codes-c-'.$res['dcID'].'.html';
	$link['coupon_url']= $url;
	
	$link['coupon_store_image']= 'http://www.shoppingspout.com.au/files/store_logos/dummy-store.jpg';

	$link['total_vote'] = $res['down_vote'] + $res['up_vote'];

	if($link['total_vote'] > 0)
				$link['success_ration'] = round(($res['up_vote']/($res['down_vote'] + $res['up_vote'])) * 100);
				
	if(strlen($res['c_store_logo']))
	$logo =  'http://www.shoppingspout.com.au/files/store_logos/'.$res['c_store_logo'];
	else
	$logo = '-';
	$link['store_logo']= $logo;	

	$link['fav_users']= fav_coupon_users($res['dcID']);		
				
	array_push($linklist,$link);
}
//print_R($linklist);
echo json_encode($linklist);
?>