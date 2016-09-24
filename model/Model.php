<?php
class Model{
	function __construct($conn){
      $this->conn = $conn;
	}
	
	// public function tableName(){
		// return 'delivery_order';
	// }
	
	function getAll(){
		$q = "SELECT * FROM  ".$this->tableName()." ";
		return select($this->conn, $q);
	}
	
	function getByAttributes($attributes){
		foreach($attributes as $attribute => $value){
			$conditions[] = $attribute." = '".$value."'";
		}
		$condition = implode(" AND ", $conditions);
		$q = "SELECT * FROM  ".$this->tableName()." WHERE ". $condition;
		$data = select($this->conn, $q);
		return $data[0];
	}
	
	function getAllByAttributes($attributes){
		foreach($attributes as $attribute => $value){
			$conditions[] = $attribute." = '".$value."'";
		}
		$condition = implode(" AND ", $conditions);
		$q = "SELECT * FROM  ".$this->tableName()." WHERE ". $condition;
		return select($this->conn, $q);
		// return $q;
	}
	
	function insert($data) {
		$fields = '';
		$values = '';
		$_table = $this->tableName();
		//$conn = connect();
		
		foreach ($data as $field => $value) {
			$fields .= '`'.$field.'`,';
			$values .= '\''.$value.'\',';
		}
		$values = substr($values,0,-1);
		$fields = substr($fields,0,-1);
		
	
		$prepare = $this->conn->prepare('INSERT INTO '.$_table.' ('.$fields.') VALUES ('.$values.')');
		
		$prepare->execute();
		return $prepare;
	}
	
	function update($data, $condition) {
		$fields = '';
		//$values = '';
		// $_table = $this->tableName();
		//$conn = connect();
		
		foreach ($data as $field => $value) {
			$fields .= "".$field." = '".$value."',";
		}
		$fields = substr($fields,0,-1);
	
		$query = $this->conn->prepare("UPDATE ".$this->tableName()." SET ".$fields." WHERE ".$condition."");
		
		$this->_result = $query->execute();
		if ($this->_result == 0) {
			return -1;
        }
		return 1;
		// return $query;
	}

}





