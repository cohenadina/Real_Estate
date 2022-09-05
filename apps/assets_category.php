<?	
	Class Assets_category{
		
	function insert($info){
			global $db;
			$id=$db->insert('Assets_category',$info);
			return $id;
	}
	
	function update($id, $info){
		global $db;
		$db->update('Assets_category', $id, $info);
		
	} 
	
	function delete($id){
		global $db;
		$db->delete('Assets_category', $id);
		
	}
	
	function getOne($id=''){
		global $db;
		return $db->getOneByKey('Assets_category', $id);
		
	}
	
	function getAll($orderby='',$order_dir='ASC'){
		global $db;
		$sql="SELECT * FROM Assets_category ";

		if($orderby){
		  
		$sql .= " ORDER BY ".$orderby ." ". $order_dir; 	
			
		}
		return $db->query($sql);
		
	}
	
}

?>