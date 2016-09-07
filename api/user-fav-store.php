<?php

 header('Content-Type: application/json');

 $linklist=array();
 $link=array();

 include('db.php');

 $site_user_id = $_REQUEST['user_id'];
 $store_id = $_REQUEST['store_id'];
 
 if($site_user_id && $store_id)
 {
	 $sql = "SELECT * from user_fav_store Where site_user_id =".$site_user_id." AND store_id =".$store_id;
	 $rs = mysql_query($sql) or die(mysql_error());
	 if(mysql_num_rows($rs))
	 {
		$link['inserted'] = 0;
	 }
	 else
	 {
		 $qry = "INSERT INTO user_fav_store (site_user_id, store_id) values (".$site_user_id.",".$store_id.")";
		 mysql_query($qry) or die(mysql_error());
		 
		 $id = mysql_insert_id();
		 
		 if($id > 0)
			$link['inserted'] = 1;
		 else	
			$link['inserted'] = 0;
	 }		
  }
  else
	$link['inserted'] = 0;
  
 array_push($linklist,$link);

 //print_R($linklist);
 echo json_encode($linklist);
 
?>