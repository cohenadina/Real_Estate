 <?
 include_once "includes/header.php";
 echo "<div class ='container'>";
 error_reporting(1);

 //ini_set('display_errors', '1');
//ini_set('display_startup_errors', '1');
//error_reporting(E_ALL);

?>

<!doctype HTML>
<html>
<head>
    <title>Contact us</title>
	<link rel="stylesheet" type="text/css" href="jquery-ui.min.css">
	

	<style>
	#preview{
		width:300px;
		border:2px solid;
		margin:auto;
		padding:20px;
	}
	.error{
		color:#f00;
		font-size:12px;
		font-weight:bold;
		display:inline;
	}
	
	</style>

	<meta name="NetsparkQuiltingResult" total-length="164" removed="0" rules-found="w2341" />
</head>
<body>
		<h1 class="h1">Contact us</h1>
		<form id="contact" >
		<!--
		<div>Do you want to submit?
		<input type="radio" name="submit" value="yes">Yes
		<input type="radio" name="submit" value="no">No
		</div>
		
		<div>Do you agree to the terms and conditions?
		<input type="radio" name="agree" value="yes">Yes
		<input type="radio" name="agree" value="no">No
		</div>
		<br></br>
		-->
		<label for="name">Write your name :</label>
		<input type="text" name="name" id="name" />
		<div id="missingFName" class="error"></div>
		<br></br>
		<label for="email">Write your email :</label>
		<input type="text" name="email" id="email"/>
		<div id="missingLName" class="error"></div>
		<br></br>
		<label for="phone">Write your phone :</label>
		<input type="text" name="phone" id="phone" />
		<div id="invalidemail" class="error"></div>
		<br></br>
		<!--
		<div>
			When would you like to meet with us:
			<input type="text" name="meeting_date" id="meeting_date">
		</div>
		-->
		<label for="message">Write a message :</label>
		<div><textarea name="message" rows="10" col="30" id="message"></textarea></div>
		<div id="missingmsg" class="error"></div>
		<br></br>
	
		<input type="submit" value="Submit" ><br></br>
		
		
		</form>
		
		<div id="response"></div>
		
		<script src="jquery.js"></script>
		<script src="jquery-ui.min.js"></script>
		
		<?
		echo"</div>";
	include_once "includes/footer.php";?>
		
			
			<script>
					 $( function() {
						    
						$("#contact").submit(function(e){
							e.preventDefault();
							var contact_data=$("#contact").serialize();
							$("#loading").show();
							$.ajax('ajax_save_contact.php',
							{
								data:contact_data,
								type:'post',
								success:function(result){
									$("#loading").hide();
 										alert("That worked");
									$("#response").html(result);
									$("#contact").trigger("reset");
								},
								error:function (xhr, status, error){
									$("#loading").hide();
									console.log(xhr.statusText);
									console.log(error);
									console.log(xhr.responseText);
									alert("someting went wrong");
								}
							}); 
						  });
					  });
					  
					  
					  
					  
			</script>
			
			
			

</body>
</html>