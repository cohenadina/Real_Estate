<?	
	Class Agents{
		
		
	function insert($info)
	{
			global $db;
			$id=$db->insert('Agents',$info);
			return $id;
	}
	
	function update($id, $info){
		global $db;
		return $db->update('Agents', $id, $info, 'Agent_Id');
		
	}
	
	function delete($id){
		global $db;
		$db->delete('Agents', $id, 'Agent_Id');
		
	}
	
	function getOne($id=''){
		global $db;
		return $db->getOneByKey('Agents', $id, 'Agent_Id');

	}

	function getOnebyURL($urlname=''){
		global $db;
		return $db->getOneByKey('Agents', $urlname, 'Url_Name');
	}
	
	function getAll($orderby='',$order_dir='ASC'){
		global $db;
		$sql="SELECT * FROM Agents WHERE 1 ";

		if($orderby){
		  
		$sql .= " ORDER BY ".$orderby ." ". $order_dir; 	
			
		}
		return $db->query($sql);
		
	}
	
}

?>