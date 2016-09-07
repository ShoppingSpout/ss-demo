<?php

header('Content-Type: application/json');

$linklist=array();
$link=array();

include('db.php');

$qr=mysql_query("SELECT * FROM top_brand_banners ORDER BY rand() Limit 0,8 ") or die(mysql_error());

while($res=mysql_fetch_array($qr))
{
	$link['brand_id'] = $res['tbID'];
	$link['brand_image'] = 'http://www.shoppingspout.com.au/files/brands/'.$res['brandImage'];
	
	$url = $res['brandUrl'];
	$url = str_replace("http://www.shoppingspout.com.au",$url);
	$url = str_replace("-promo-codes.html","",$url);
	$url = str_replace("-"," ",$url);
	
	$qr1=mysql_query("SELECT affliate_store_id FROM product_stores Where in_active = 0 AND store_name ='".$url."' ") or die(mysql_error());
	while($res1=mysql_fetch_array($qr1))
	{
		$link['store_id'] = $res1['affliate_store_id'];
	}
	
	$link['brand_url'] = $res['brandUrl'];

	array_push($linklist,$link);
}
//print_R($linklist);
echo json_encode($linklist);

?>