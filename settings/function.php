<?php
	$set['base_path'] 			= "http://10.40.108.153/";	
	$set['path'] 				= "tamara_new";  
	

	define("BASE_PATH", $set['base_path'] );
	define("ROOT", $_SERVER['DOCUMENT_ROOT']);
	define("DS", "/");
	define("PATH", $set['path']);
	
	$servername = "";
	$username = "";
	$password = "";
	$dbname = "";
	$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
	
	require("lib.php");

	function getAllData($conn,$table_name){
		$query_select = "SELECT * FROM ".$table_name;
		$stmt = $conn->query($query_select);
		$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $data;
	}

	function getAllDataWithCondition($conn,$table_name,$criteria){
		$condition = "";
		$criteria_value = array();
		foreach($criteria as $key => $value){
			$condition .= $key." = :".$key." AND ";
			$index_name = ":".$key;
			$criteria_value[$index_name] = $value;
		}
		$condition = substr($condition,0,-5);
		
		$query_select = "SELECT * FROM ".$table_name." WHERE ".$condition;
		$stmt = $conn->prepare($query_select);
		$stmt->execute($criteria_value);
		$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $data;
	}

	function getOneRowDataWithCondition($conn,$table_name,$criteria){
		$all_data = getAllDataWithCondition($conn,$table_name,$criteria);
		return $all_data[0];
	}

	function insertData($conn,$table_name,$data_value){
		$column_name = "";
		$column_value = "";
		$list_column_value = array();
		foreach($data_value as $key => $value){
			$column_name .= $key.",";
			$column_value .= ":".$key.",";
			$index_name = ":".$key;
			$list_column_value[$index_name] = $value;
		}
		$column_name = substr($column_name,0,-1);
		$column_value = substr($column_value,0,-1);
		
		$query_insert = "INSERT INTO ".$table_name." (".$column_name.") VALUES (".$column_value.")";
		$stmt = $conn->prepare($query_insert);
		$stmt->execute($list_column_value);
	}

	function updateData($conn,$table_name,$data_update,$criteria){
		$column_value = "";
		$condition = "";
		$list_column_value = array();
		
		foreach($data_update as $key => $value){
			$column_value .= $key." = :new_".$key.",";
			$index_name = ":new_".$key;
			$list_column_value[$index_name] = $value;
		}
		$column_value = substr($column_value,0,-1);
		
		foreach($criteria as $key_criteria => $value_criteria){
			$condition .= $key_criteria." = :criteria_".$key_criteria." AND ";
			$index_name = ":criteria_".$key_criteria;
			$list_column_value[$index_name] = $value_criteria;
		}
		$condition = substr($condition,0,-5);
		
		$query_update = "UPDATE ".$table_name." SET ".$column_value." WHERE ".$condition;
		$stmt = $conn->prepare($query_update);
		$stmt->execute($list_column_value);
	}

	function deleteData($conn,$table_name,$criteria){
		$condition = "";
		$criteria_value = array();
		foreach($criteria as $key => $value){
			$condition .= $key." = :".$key." AND ";
			$index_name = ":".$key;
			$criteria_value[$index_name] = $value;
		}
		$condition = substr($condition,0,-5);

		$query_delete = "DELETE FROM ".$table_name." WHERE ".$condition;
		$stmt = $conn->prepare($query_delete);
		$stmt->execute($criteria_value);
	}

	function getCountAll($conn,$table_name){
		$query_count_all = "SELECT count(*) AS value FROM ".$table_name;
		$stmt = $conn->query($query_count_all);
		$data = $stmt->fetch(PDO::FETCH_ASSOC);
		return $data['value'];
	}

	function getCountWithCondition($conn,$table_name,$criteria){
		$condition = "";
		$criteria_value = array();
		foreach($criteria as $key => $value){
			$condition .= $key." = :".$key." AND ";
			$index_name = ":".$key;
			$criteria_value[$index_name] = $value;
		}
		$condition = substr($condition,0,-5);

		$query_count = "SELECT count(*) AS value FROM ".$table_name." WHERE ".$condition;
		$stmt = $conn->prepare($query_count);
		$stmt->execute($criteria_value);
		$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $data[0]['value'];
	}
	
	function getMax($conn,$table_name,$column_name){
		$query_max = "SELECT max(".$column_name.") AS value FROM ".$table_name;
		$stmt = $conn->query($query_max);
		$data = $stmt->fetch(PDO::FETCH_ASSOC);
		return $data['value'];
	}
	
	function getAllDataWithConditionOrdered($conn,$table_name,$criteria,$order,$order_type){
		$condition = "";
		$criteria_value = array();
		foreach($criteria as $key => $value){
			$condition .= $key." = :".$key." AND ";
			$index_name = ":".$key;
			$criteria_value[$index_name] = $value;
		}
		$condition = substr($condition,0,-5);
		
		$query_select = "SELECT * FROM ".$table_name." WHERE ".$condition." ORDER BY ".$order." ".$order_type;
		$stmt = $conn->prepare($query_select);
		$stmt->execute($criteria_value);
		$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $data;
	}
	
	function konversi($tanggal){
		$format = array(
			'Sun' => 'Minggu',
			'Mon' => 'Senin',
			'Tue' => 'Selasa',
			'Wed' => 'Rabu',
			'Thu' => 'Kamis',
			'Fri' => 'Jumat',
			'Sat' => 'Sabtu',
			'Jan' => 'Januari',
			'Feb' => 'Februari',
			'Mar' => 'Maret',
			'Apr' => 'April',
			'May' => 'Mei',
			'Jun' => 'Juni',
			'Jul' => 'Juli',
			'Aug' => 'Agustus',
			'Sep' => 'September',
			'Oct' => 'Oktober',
			'Nov' => 'November',
			'Dec' => 'Desember'
		);
		return strtr($tanggal, $format);
	}
	
	
	function get_api($url, $content='', $method = 'POST'){
		if (!empty($content) || $content != ''){
			foreach($content as $content_ => $v){
				$c[] =   $content_."=".$v;
			}
			$data = implode("&",$c);
		}else{
			$data = '';
		}

		$opts = array('http' =>
								array(
								  'method'  => $method,
								  'header'  => 'Content-type: application/x-www-form-urlencoded',
								  'content' => $data
								)
				);
	  $context  = stream_context_create($opts);
	  $result = file_get_contents($url, false, $context);
	  
	  $decode = json_decode($result, true);
	  
	  return $decode;
	}

	function select($conn, $q) {

		// $conn = connect();
		$query 	= $conn->prepare($q);
		$query->execute();
		
		$result = array();
		$table = array();
		$field = array();
		$tempResults = array();

		if(substr_count(strtoupper($q),"SELECT")>0) {
		
			$numOfFields =  $query->columnCount();
			for ($i = 0; $i < $numOfFields; ++$i) {
				$columnMeta = $query->getColumnMeta($i);
				array_push($table,$columnMeta['table']);
				array_push($field,$columnMeta['name']);
			}
			
			while ($row = $query->fetch(PDO::FETCH_NUM)) {
				for ($i = 0;$i < $numOfFields; ++$i) {
					$tempResults[$field[$i]] = $row[$i];
				}
				array_push($result,$tempResults);
			}
	
			$query->closeCursor();
		}	
		
		return($result);
	}
	
	function insert($conn, $table, $data) {
		$fields = '';
		$values = '';
		$_table = $table;
		//$conn = connect();
		
		foreach ($data as $field => $value) {
			$fields .= '`'.$field.'`,';
			$values .= '\''.$value.'\',';
		}
		$values = substr($values,0,-1);
		$fields = substr($fields,0,-1);
		
	
		$prepare = $conn->prepare('INSERT INTO '.$_table.' ('.$fields.') VALUES ('.$values.')');
		
		$prepare->execute();
		return $prepare;
	}
	
	function update($conn, $table, $data, $condition) {
		$fields = '';
		//$values = '';
		$_table = $table;
		//$conn = connect();
		
		foreach ($data as $field => $value) {
			$fields .= "".$field." = '".$value."',";
		}
		$fields = substr($fields,0,-1);
	
		$query = $conn->prepare("UPDATE ".$_table." SET ".$fields." WHERE ".$condition."");
		
		$_result = $query->execute();
		if ($_result == 0) {
			return -1;
        }
		return 1;
		//return $query;
	}
?>