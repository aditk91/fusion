<?php 

Class Form {

	public function open($name, $method="", $attributes){
		$form = "<form name = '".$name."'  method = 'POST' ";
		foreach($attributes as $attribute => $value){
			$form.= $attribute." = '". $value. "' ";
		}		
		$form .= ">";
		echo $form;
	}
	
	public function close(){
		$form = "</form>";
		echo $form;
	}

	public function listData($data, $name="", $column = array(), $attributes=array(), $default_value = array()){
		$list = "<select name = '".$name."' ";
		foreach($attributes as $attribute => $value){
			$list.= $attribute." = '". $value. "' ";
		}		
		$list .= ">";
		
		if($default_value != null){
			$list .= "<option value = '".$default_value[0]."' >".$default_value[1]."</option>";
		}
		
		foreach($data as $data_){
			$selected = $attributes['selected'] == $data_[$column[0]] ? "selected" : "";
			$list .= "<option value = '".$data_[$column[0]]."' ".$selected.">".$data_[$column[1]]."</option>";
		}
		$list .= "</select>";
			
		echo $list;	
	}
}

/* $model[] = array('id'=>'1','type'=>'mobil','warna'=>'merah');
$model[] = array('id'=>'2','type'=>'motor','warna'=>'hijau');
$model[] = array('id'=>'3','type'=>'sepeda','warna'=>'kuning');
$model[] = array('id'=>'4','type'=>'becak','warna'=>'hitam');
 */
// foreach($model as $kendaraan){
	// echo $kendaraan['type']." ";
// }
     

	/* $form = new Form(); */
	 
/* ?>

<html>
	<head></head>
	<body>
		<?php 
		
			Form::open('frm_test', 'POST', array('id'=>'test','class'=>'form'));
			Form::listData($model, 'test_list', array('id','warna'), array('id'=>'test','class'=>'form'));
			Form::close();
		
		
		
		?>
	
	</body>


</html> */
