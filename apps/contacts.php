<?	
	Class Contacts{
		
	function insert($info){
			global $db;
			$id=$db->insert('Contacts',$info);
			return $id;
	}
	
	function update($id, $info){
		global $db;
		$db->update('Contacts', $id, $info);
		
	}
	
	function delete($id){
		global $db;
		$db->delete('Contacts', $id);
		
	}
	
	function getOne($id=''){
		global $db;
		return $db->getOneByKey('Contacts', $id);
		
	}
	static function getOnebyURL($urlname=''){
		global $db;
		return $db->getOneByKey('Contacts', $urlname, 'Url_Name');
	}
	
	
	function getAll($orderby='',$order_dir='ASC'){
		global $db;
		$sql="SELECT * FROM Contacts ";

		if($orderby){
		  
		$sql .= " ORDER BY ".$orderby ." ". $order_dir; 	
			
		}
		return $db->query($sql);
		
	}
	
}

?>