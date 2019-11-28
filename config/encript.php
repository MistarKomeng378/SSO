<?php
	// $input = "SmackFactory";

	// $encrypted = encryptIt( $nopost );
	// $decrypted = decryptIt( $encrypted );

	// echo $encrypted . '<br />' . $decrypted;

	// function encryptIt( $q ) {
		// $cryptKey  = 'qJB0rGtIn5UB1xG03efyCp';
		// $qEncoded      = base64_encode( mcrypt_encrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), $q, MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ) );
		// return( $qEncoded );
	// }

	// function decryptIt( $q ) {
		// $cryptKey  = 'qJB0rGtIn5UB1xG03efyCp';
		// $qDecoded      = rtrim( mcrypt_decrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), base64_decode( $q ), MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ), "\0");
		// return( $qDecoded );
	// }
	
	function ec($string) {
  $key = "MAL_979805"; //key to encrypt and decrypts.
  $result = '';
  $test = "";
   for($i=0; $i<strlen($string); $i++) {
     $char = substr($string, $i, 1);
     $keychar = substr($key, ($i % strlen($key))-1, 1);
     $char = chr(ord($char)+ord($keychar));

     $test[$char]= ord($char)+ord($keychar);
     $result.=$char;
   }

	   return urlencode(base64_encode($result));
	}

	function dc($string) {
		$key = "MAL_979805"; //key to encrypt and decrypts.
		$result = '';
		$string = base64_decode(urldecode($string));
	   for($i=0; $i<strlen($string); $i++) {
		 $char = substr($string, $i, 1);
		 $keychar = substr($key, ($i % strlen($key))-1, 1);
		 $char = chr(ord($char)-ord($keychar));
		 $result.=$char;
	   }
	   return $result;
	}
?>