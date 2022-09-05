
<!doctype HTML>
	
	<? include "../application.php";
	
	?>
	
	<html>
	<head>
		  <title>Admin Area</title>
		  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
		  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
		 
			  
	</head>
	<body>
	<div class="container">
	
	
	<?	
	$contacts=Contacts::getAll();

	print_r($_SESSION);
	
	if ($_SESSION['logged']) 
	{ 
	include "navigation.php";
	?>
		<h3>Admin Area</h3>
		<h4>Add an Admin User</h4>
		<form id="addUserForm">
		        <input type="hidden" name="action" value="add"/>
				<label>Email</label>
				<input type="email" name="email"/>
				<br/><br/><label>Password</label>
				<input type="password" name="password"/>
				<br/><br/><input type="submit" id="addUser" value="Add a User"/>
		</form>
		
	<? } ?>	
		
		<h4>Login</h4>
		<form id="loginUserForm">
				<input type="hidden" name="action" value="login"/>
				<label>Email</label>
				<input type="email" name="email"/>
				<br/><br/><label>Password</label>
				<input type="password" name="password"/>
				<br/><br/><input type="submit" id="login" value="Login"/>
				<a href="forgotPass.php">Forgot Password</a>
		</form>
		
		<a href="logout.php">Click here to logout</a>
		
		
		<? include "footer.php" ?>


		