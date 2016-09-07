<?php

 header('Content-Type: application/json');

 $linklist=array();
 $link=array();

 include('db.php');

 $site_user_id = $_REQUEST['user_id'];
 
 if($site_user_id)
 {
	 $sql = "SELECT * from user_fav_coupon Where site_user_id =".$site_user_id;
	 $rs = mysql_query($sql) or die(mysql_error());
	 if(mysql_num_rows($rs))
	 {
		$cIDs = '';
		
		while($row = mysql_fetch_object($rs))
		{
			$cIDs .= $row->coupon_id.",";
		}
		
		$cIDs = rtrim($cIDs, ",");
	 }
 }
  
 if($cIDs)
 {
	$qr=mysql_query("SELECT D.*, DATE_FORMAT(deal_end_date,'%M %d, %Y') as deal_end_date, S.store_name FROM deals_coupons D, product_stores S WHERE D.sourceID = S.affliate_store_id AND dealFor = 'store_page'  AND dcID IN (".$cIDs.") order by position") or die(mysql_error());

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
					
		array_push($linklist,$link);
	}
 }  
 
 //print_R($linklist);
 echo json_encode($linklist);
 
?>