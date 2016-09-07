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
 
 if(strlen($email))
 {
	$sql = " SELECT * from site_users Where email = '".$email."' ";
	$rs = mysql_query($sql) or die(mysql_error());
	if(mysql_num_rows($rs))
	{
		$row = mysql_fetch_array($rs);
		//print_r($row);
		$pwd = decryption($row['password']);
		$link['password'] = $pwd;
	}
 }
 else
	$link['password'] = 0;
  
 array_push($linklist,$link);

 //print_R($linklist);
 echo json_encode($linklist);
 
?>