<?	
	Class Newsletter{
		
	function insert($info){
			global $db;
			$id=$db->insert('Newsletter',$info);
			return $id;
	}
	
	function update($id, $info){
		global $db;
		$db->update('Newsletter', $id, $info);
		
	}
	
	function delete($id){
		global $db;
		$db->delete('Newsletter', $id);
		
	}
	
	function getOne($id=''){
		global $db;
		return $db->getOneByKey('Newsletter', $id);
		
	}
	
	function getAll($orderby='',$order_dir='ASC'){
		global $db;
		$sql="SELECT * FROM Newsletter ";

		if($orderby){
		  
		$sql .= " ORDER BY ".$orderby ." ". $order_dir; 	
			
		}
		return $db->query($sql);
		
	}
	
}

?>