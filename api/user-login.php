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
 
 if($email && $password)
 {
	$pwd = encryption($password);
	 
	$sql = " SELECT * from site_users Where email = '".$email."' AND password = '".$pwd."' ";
	$rs = mysql_query($sql) or die(mysql_error());
	if(mysql_num_rows($rs))
	{
		$row = mysql_fetch_array($rs);
		//print_r($row);
		$link['user_id'] = $row['site_user_id'];
	}
 }
 else
	$link['user_id'] = 0;
  
 array_push($linklist,$link);

 //print_R($linklist);
 echo json_encode($linklist);
 
?>