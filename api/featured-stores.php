<?php

header('Content-Type: application/json');

$linklist=array();
$link=array();

include('db.php');

$qr=mysql_query("SELECT * FROM top_store_banners Where store_id > 0 ORDER BY rand() Limit 0,8 ") or die(mysql_error());

while($res=mysql_fetch_array($qr))
{
	
	$link['std']=$res['tsBid'];
	$link['store_image']= 'http://www.shoppingspout.com.au/files/banners/'.$res['bannerImage'];
	
	
	$url = $res['bannerUrl'];
	//$url = str_replace("http://www.shoppingspout.com.au/","",$url);

	//$url_temp = explode("-promo-codes",$url);
	//$url = $url_temp[0];
	//$url = str_replace("-promo-codes.html","",$url);
	//$url = str_replace("-"," ",$url);
	
	//$qr1=mysql_query("SELECT affliate_store_id FROM product_stores Where in_active = 0 AND store_name ='".$url."' ") or die(mysql_error());
	//while($res1=mysql_fetch_array($qr1))
	//{
	//	$link['store_id'] = $res1['affliate_store_id'];
	//}
	$link['store_id']=$res['store_id'];
	$link['store_url']=$res['bannerUrl'];

	array_push($linklist,$link);
}

//print_R($linklist);
echo json_encode($linklist);
?>