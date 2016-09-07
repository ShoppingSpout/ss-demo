<?php

header('Content-Type: application/json');

$linklist=array();
$link=array();

include('db.php');


$qr=mysql_query("SELECT affliate_store_id,store_name,c_store_logo FROM product_stores Where in_active = 0 AND show_on_coupon_home_page = '1' ") or die(mysql_error());
while($res=mysql_fetch_array($qr))
{
 $link['store_id']=$res['affliate_store_id'];
 $link['store_name']=$res['store_name'];
 
 $url = 'http://www.shoppingspout.com.au/'.str_replace(" ","-", $res['store_name']).'-coupon-codes.html';
 $link['store_url']= $url;
 
 if(strlen($res['c_store_logo']))
	$logo =  'http://www.shoppingspout.com.au/files/store_logos/'.$res['c_store_logo'];
 else
	$logo = '-';
 $link['store_logo']= $logo;
 array_push($linklist,$link);
}
//print_R($linklist);
echo json_encode($linklist);
?>