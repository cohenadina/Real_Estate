<?
	 include_once "../../application.php";
	 
	 switch ($_POST['action']){
		 case 'add' : addUser();break;
		 case 'login' : loginUser();break;
		 case 'forgot' :resetPassword(); break;
	 }
	 
	 function addUser(){
		 $info['email']=$_POST['email'];
		 $info['password']=$_POST['password'];
		 $id=Admin_users::insert($info);
		 if ($id) echo "User was inserted";
	 }
	 
	 function loginUser(){
		 $result=Admin_users::login($_POST['email'], $_POST['password']);
		 if ($result=='no_user') echo "There is no admin with this email address";
		 else if ($result=='invalidpass') echo "Incorrect Password";
		 else echo "Welcome ".$result['email'];
	 }
	 
	 function resetPassword(){
		 $result=Admin_users::resetPassword($_POST['email']);
		 if(!$result) echo "There is no user with this email";
		 else echo "please check your email and login with the new temp password that was sent to you";

	 }

?>