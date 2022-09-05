<?	
	Class Assets{
		
		
	function insert($info)
	{
			global $db;
			$url=str_replace("","-",$info['Location']);
			$info['Url_Name']=$url;
			$id=$db->insert('Assets',$info);
			
			return $id;
	}
	
	function update($id, $info)
	{
		global $db;
		return $db->update('Assets', $id, $info, 'Asset_Id');	
	}
	
	function delete($id){
		global $db;
		$db->delete('Assets', $id, 'Asset_Id');
		
	}
	static function getOnebyURL($urlname=''){
		global $db;
		return $db->getOneByKey('Assets', $urlname, 'Url_Name');//public function getOneByKey($table_name, $id = 0, $p_key = 'id', $column_name= '*')
	}
	
	
	function getOne($id=''){
		global $db;
		return $db->getOneByKey('Assets', $id, 'Asset_Id');

	}
	
	static function getAll($orderby='', $orderDir='ASC', $featured='', $slider='', $category='', $priceRange='', $type='', $keyword='', $agent_id=''){
			global $db;
			$sql="SELECT *, C.Category_Id FROM Assets as A JOIN Assets_category as C WHERE 1 ";
			if ($orderby){
				$sql.=" ORDER BY ".$orderby." ".$orderDir;
			}
			if($featured){
				$sql.=" AND Featured='".$featured."'";
			}
			if($slider){
				$sql.=" AND Show_On_Slider='".$slider."'";
			}
			if($category){
				$sql.=" AND Category_Id='".$category."'";
			}
			
			if($priceRange){
				if($priceRange=='$150,000-$200,000')
					$sql.=" AND Rent_Price BETWEEN 150000 AND 200000";
				if($priceRange=='$200,000-$250,000')
					$sql.=" AND Rent_Price BETWEEN 2000000 AND 250000";
				if($priceRange=='$250,000-$300,000')
					$sql.=" AND Rent_Price BETWEEN 250000 AND 300000";
				if($priceRange=='$350,000-above')
					$sql.=" AND Rent_Price IS > 300000";
			}
			if($type){
				$sql.=" AND Type='".$type."'";
			}
			if($keyword){

				$sql.=" AND Location LIKE '%".$keyword."%' OR Name LIKE '%".$keyword."%'";
			}
			if($agent_id){
				$sql .= " AND Agent_Id = ".$agent_id;
			}
			
			
			return $db->query($sql);
		}
		
		
		

	function getAll1($orderby='',$order_dir='ASC'){
		global $db;
		$sql="SELECT * FROM Assets WHERE 1 ";

		if($orderby){
		  
		$sql .= " ORDER BY ".$orderby ." ". $order_dir; 	
			
		}
		return $db->query($sql);
		
	}
	
}

?>