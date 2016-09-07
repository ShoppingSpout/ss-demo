<?php

header('Content-Type: application/json');

$linklist=array();
$link=array();

include('db.php');


//pagging start//  

$Limit = 1000; //Number of results per page

$page = $_GET["page"]; //Get the page number to show

if($page == "") $page=1; //If no page number is set, the default page is 1

//Get the number of results
$storeCount = mysql_query("Select * from coupon_categories Where in_active = 0") or die('Error getting count query.');
$NumberOfResults=mysql_num_rows($storeCount);

//Get the number of pages
$NumberOfPages=ceil($NumberOfResults/$Limit);


$qr=mysql_query("SELECT category_id,category_name,category_url FROM coupon_categories Where in_active = 0 Order By category_name LIMIT " . ($page-1)*$Limit . ",".$Limit) or die(mysql_error());
while($res=mysql_fetch_array($qr))
{
 $link['category_id']=$res['category_id'];
 $link['category_name']=$res['category_name'];
 
 $url = 'http://www.shoppingspout.com.au/'.str_replace(" ","-", $res['category_url']).'-coupon-codes.html';
 $link['category_url']= $url;
 $link['category_image']= 'http://www.shoppingspout.com.au/files/category_icon/accessories.png';
 
 
// if(strlen($res['c_store_logo']))
//	$logo =  'http://www.shoppingspout.com.au/files/'.$res['c_store_logo'];
// else
//	$logo = '-';
// $link['store_logo']= $logo;
 array_push($linklist,$link);
}
//print_R($linklist);
echo json_encode($linklist);
?>