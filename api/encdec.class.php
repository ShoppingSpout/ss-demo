<?php

class Crypter{

   var $key;


   /*----------------------------------------------------------------------
     Entrada: $clave => clave que va a utilizar el crypter
     Salida : nada
     Efecto : es el constructor de la clase.
     ----------------------------------------------------------------------*/
   function Crypter($clave){
      $this->key = $clave;
   }

   /*----------------------------------------------------------------------
     Entrada: $clave => clave que va a utilizar el crypter
     Salida : nada
     Efecto : actualiza la clave
     ----------------------------------------------------------------------*/
   function setKey($clave){
      $this->key = $clave;
   }
   
   function keyED($txt) { 
      $encrypt_key = md5($this->key); 
      $ctr=0; 
      $tmp = ""; 
      for ($i=0;$i<strlen($txt);$i++) { 
         if ($ctr==strlen($encrypt_key)) $ctr=0; 
         $tmp.= substr($txt,$i,1) ^ substr($encrypt_key,$ctr,1); 
         $ctr++; 
      } 
      return $tmp; 
   } 
   
   function encrypt($txt){ 
      //srand((double)microtime()*1000000); 
      $encrypt_key = md5('4ace'); 
      $ctr=0; 
      $tmp = ""; 
      for ($i=0;$i<strlen($txt);$i++){ 
         if ($ctr==strlen($encrypt_key)) $ctr=0; 
         $tmp.= substr($encrypt_key,$ctr,1) . 
             (substr($txt,$i,1) ^ substr($encrypt_key,$ctr,1)); 
         $ctr++; 
      } 
      return base64_encode($this->keyED($tmp)); 
   } 

   function decrypt($txt) { 
      $txt = $this->keyED(base64_decode($txt)); 
      $tmp = ""; 
      for ($i=0;$i<strlen($txt);$i++){ 
         $md5 = substr($txt,$i,1); 
         $i++; 
         $tmp.= (substr($txt,$i,1) ^ $md5); 
      } 
      return $tmp; 
   } 

}

?>