<?php

 header('Content-Type: application/json');

 $linklist=array();
 $link=array();

 include_once('db.php');
 include_once('encdec.class.php');
 
 function decryption($data)
 { 
	$crypter = new Crypter('dsdadmin');
	$str = $crypter->decrypt($data);
	return $str;
 }

 function encryption($data)
 {
	$crypter = new Crypter('dsdadmin');
	$str = $crypter->encrypt($data);
	return $str;			
 }

 $email = $_REQUEST['email'];
 $password = $_REQUEST['password'];
 
 if(strlen($email) > 0  && strlen($password) > 0)
 {
	 $pwd = encryption($password);
	 
	 $sql = " SELECT * from site_users Where email = '".$email."' ";
	 $rs = mysql_query($sql) or die(mysql_error());
	 if(mysql_num_rows($rs))
	 {
		$link['user_id'] = 0;
	 }
	 else
	 {
		$qry = " INSERT INTO site_users (email, password) values ('".$email."','".$pwd."') ";
		 mysql_query($qry) or die(mysql_error());
		 
		 $id = mysql_insert_id();
		 
		 if($id > 0)
			$link['user_id'] = $id;
		 else	
			$link['user_id'] = 0;
	 }		
 }
 else
	$link['user_id'] = 0;
  
 array_push($linklist,$link);

 //print_R($linklist);
 echo json_encode($linklist);
 
?>