<?php 
	function loadModel($model){
		if(is_array($model)){
			foreach($model as $m){
				require_once(ROOT. DS . PATH . DS . "model" . DS . $m."Model.php");
			}
		}else{
			return require_once(ROOT. DS . PATH . DS . "model" . DS . $model."Model.php");
		}
	}
	
	function loadLibrary($lib){
		if(is_array($lib)){
			foreach($lib as $l){
				require(ROOT. DS . PATH . DS . "lib" . DS . $l.".php");
			}
		}else{
			return require_once(ROOT. DS . PATH . DS . "lib" . DS . $lib.".php");
		}
	}
	
	function site_url($uri = '', $protocol = NULL){
		return BASE_PATH . PATH . DS . $uri;
	}
	
	function redirect($uri = '', $method = 'auto', $code = NULL){
		$uri = site_url($uri);
		
		if ($method === 'auto' && isset($_SERVER['SERVER_SOFTWARE']) && strpos($_SERVER['SERVER_SOFTWARE'], 'Microsoft-IIS') !== FALSE)
		{
			$method = 'refresh';
		}
		elseif ($method !== 'refresh' && (empty($code) OR ! is_numeric($code)))
		{
			if (isset($_SERVER['SERVER_PROTOCOL'], $_SERVER['REQUEST_METHOD']) && $_SERVER['SERVER_PROTOCOL'] === 'HTTP/1.1')
			{
				$code = ($_SERVER['REQUEST_METHOD'] !== 'GET')
					? 303	
					: 307;
			}
			else
			{
				$code = 302;
			}
		}

		switch ($method)
		{
			case 'refresh':
				header('Refresh:0;url='.$uri);
				break;
			default:
				header('Location: '.$uri, TRUE, $code);
				break;
		}
		exit;
	}
	
	function alert($text="", $redirect = NULL){
		 echo  "<script language='JavaScript'>alert('".$text."')</script>";
		 if($redirect!=NULL){
		//	$uri = site_url($uri);
			 echo "<script language=javascript> 
                      document.location.href='".$redirect."';
                  </script>";
		 }
	}
	
	function selected($val1, $val2, $o = "selected"){
		$selected = $val1 == $val2 ? $o : "";
		return $selected;
	}
	
	function random($panjang){
		$pengacak = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghjklmnopqrstuvwxyz1234567890';
		$string = '';
		for($i = 0; $i < $panjang; $i++) {
		   $pos = rand(0, strlen($pengacak)-1);
		   $string .= $pengacak{$pos};
		}
		return $string;
	}