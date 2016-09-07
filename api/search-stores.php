<?php

header('Content-Type: application/json');

$linklist=array();
$link=array();

include('db.php');


$qr=mysql_query("SELECT affliate_store_id,store_name FROM product_stores Where in_active = 0 order by store_name") or die(mysql_error());
while($res=mysql_fetch_array($qr))
{
 $link['store_id']=$res['affliate_store_id'];
 $link['store_name']=$res['store_name'];
 

 array_push($linklist,$link);
}
//print_R($linklist);
echo json_encode($linklist);
?>