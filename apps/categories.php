<?	
	Class Categories{
		
	function insert($info){
			global $db;
			$id=$db->insert('Categories',$info);
			return $id;
	}
	
	function update($id, $info){
		global $db;
		$db->update('Categories', $id, $info);
		
	}
	
	function delete($id){
		global $db;
		$db->delete('Categories', $id);
		
	}
	
	function getOne($id=''){
		global $db;
		return $db->getOneByKey('Categories', $id);
		
	}
	
	function getAll($orderby='',$order_dir='ASC'){
		global $db;
		$sql="SELECT * FROM Categories ";

		if($orderby){
		  
		$sql .= " ORDER BY ".$orderby ." ". $order_dir; 	
			
		}
		return $db->query($sql);
		
	}
	
}

?>