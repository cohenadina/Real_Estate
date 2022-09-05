<?
	Class Admin_users{
		
		
	function insert($info){
			global $db;
			$id=$db->insert('Admin_users',$info);
			self::update($id, $info);	
			return $id;
	}
	
	function update($id, $info){
		global $db;
		if(isset($info['password'])){ 
			$info['password']=md5(md5($id).$info['password'].$id);   
		}
		$db->update('Admin_users', $id, $info);
		
	}
	
	function delete($id){
		global $db;
		$db->delete('Admin_users', $id);
		
	}
	
	function login($email='', $password=''){
			if (!$email || !$password) return false;
			global $db;
			$Admin_users=$db->getOneByKey("Admin_users",$email,"email");
			if (!$Admin_users) return "no_user";
			if ($Admin_users['password']==md5(md5($Admin_users['id']).$password.$Admin_users['id'])){
		
				$_SESSION['id']=$Admin_users['id'];
				$_SESSION['logged']=true;
				return $Admin_users;
				
			}	
			else return "invalidpass";
		}
	
	function getOne($id=''){
		global $db;
		return $db->getOneByKey('Admin_users', $id);
		
	}
	
	function getOneByEmail($email=''){
		global $db;
		return $db->getOneByKey('Admin_users', $email, 'email');
		
	}
	
	function getAll($orderby='',$order_dir='ASC'){
		global $db;
		$sql="SELECT * FROM Admin_users ";
		if($orderby){
		  
		$sql .= " ORDER BY ".$orderby ." ". $order_dir; 	
		}
		return $db->query($sql);
	}
	
	function resetPassword($email){
		$user=self::getOneByEmail($email);
		if (!$user) return false;
		$char="1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()";
		$size=strlen($char);
		$temp_pass="";
		$pass_size=8;
		for($i=0;$i<$pass_size;$i++){
			$temp_pass .=$char[rand(0, $size-1)];
		}
		$info['password']=$temp_pass;
		self::update($user['id'], $info);
		mail($user['email'],"Your new password below", "Hi, ".$email." here's your new password ".$temp_pass .".");
		return true;
	}
	}
	?>
	