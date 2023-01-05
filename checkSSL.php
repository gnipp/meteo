 <?PHP 

function checkIsSSL( $redirect = false ){ 
	if(isset($_SERVER['HTTPS'])){
	return true; 
	} elseif ($_SERVER['HTTPS'] == 'on'){
	 return true; 
	} elseif ($_SERVER['SERVER_PORT'] == 443){
	 return true; 
	} else { 
		if ( $redirect ){
			$urlredirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
			header("Location: " . $urlredirect);
			exit;
		} else {
			return false;
		}
	} 
}

?>
