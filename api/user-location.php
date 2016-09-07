<?php

 header('Content-Type: application/json');

 $linklist=array();
 $link=array();

 include('db.php');

 $site_user_id = $_REQUEST['user_id'];
 $user_location = $_REQUEST['user_location'];
 
 if($site_user_id && $user_location)
 {
	 $qry = "UPDATE site_users SET user_location = '".$user_location."' WHERE site_user_id = ".$site_user_id;
	 $id = mysql_query($qry) or die(mysql_error());
	 
	 if($id > 0)
		$link['updated'] = 1;
	 else	
		$link['updated'] = 0;
  }
  else
	$link['updated'] = 0;
  
 array_push($linklist,$link);

 //print_R($linklist);
 echo json_encode($linklist);
 
?>