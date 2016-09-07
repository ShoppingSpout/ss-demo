<?php

 header('Content-Type: application/json');

 $linklist=array();
 $link=array();

 include('db.php');

 $report = $_REQUEST['report'];
 $coupon_id = $_REQUEST['coupon_id'];
 
 if($report && $coupon_id)
 {
	 $qry = "INSERT INTO report_coupon (coupon_id, report, report_date) values ('".$coupon_id."','".$report."',now())";
	 mysql_query($qry) or die(mysql_error());
	 
	 $id = mysql_insert_id();
	 
	 if($id > 0)
		$link['reported'] = 1;
	 else	
		$link['reported'] = 0;
 }
else
	$link['reported'] = 0;
  
 array_push($linklist,$link);

 //print_R($linklist);
 echo json_encode($linklist);
 
?>