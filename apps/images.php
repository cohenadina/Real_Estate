<?	
	Class Images{
		
	function insert($info){
			global $db;
			$id=$db->insert('Images',$info);
			return $id;
	}
	
	function update($id, $info){
		global $db;
		$db->update('Images', $id, $info);
		
	}
	
	function delete($id){
		global $db;
		$db->delete('Images', $id);
		
	}
	
	function getOne($id=''){
		global $db;
		return $db->getOneByKey('Images', $id);
		
	}
	
	function getAll($orderby='',$order_dir='ASC'){
		global $db;
		$sql="SELECT * FROM Images ";

		if($orderby){
		  
		$sql .= " ORDER BY ".$orderby ." ". $order_dir; 	
			
		}
		return $db->query($sql);
		
	}
	
}

?>