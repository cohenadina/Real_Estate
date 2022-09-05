<?
include_once "../application.php";
include_once "../includes/header.php";
echo "<div class ='container'>";
	echo "<h2 class='forms_title'>Contacts</h2>";
    	
	
	//print_r($_REQUEST);
	
	switch ($_REQUEST['action']){
		case 'add'  : add_Agent(); break;
		case 'save_entry' : save($_REQUEST); break;
		case 'edit'		  :	edit_contact($_REQUEST['contact_id']); break;
		case 'delete'	  :	delete_contact($_REQUEST['contact_id']); break;
        default           : show_list(); break;
	}
	
	
	
	function show_list() {
		
	$contacts=Contacts::getAll();		
		?>
   
	<table>
		<thead><tr>
		<? foreach ($contacts[0] as $key=>$value){
			echo "<td>".$key."</td>";
		}?>
		<td>Action</td></tr></thead>
		<tbody>
		
		<? foreach ($contacts as $agent){
				echo "<tr>";
				foreach ($contacts as $value){
					echo "<td>".$value."</td>";
				}
				echo "<td><a href='".$_SERVER['REQUEST_URI']."?action=edit&id=".$contacts['contact_id']."'>Edit</td><td><a onclick='confirm_delete(".$agent['contact_id'].");'>Delete</a></td></tr>";
		}?>
		
			</tbody>
		</table>
		<br/>	
	<button><a href='<?$_SERVER['REQUEST_URI']?>?action=add'>Add New contact</a></button>
		<br/><br/></br>
		
<?  } 

function add_Agent()
	{
		if($_REQUEST['action'] == 'add')
		{
			if($_POST["contact_id"])
				$info["contact_id"]=$_POST["contact_id"];
			
			if($_POST["name"])
				$info["name"]=$_POST["name"];
			if($_POST["email"])
				$info["email"]=$_POST["email"];
			if($_POST["phone"])
				$info["phone"]=$_POST["phone"];
			if($_POST["message"])
				$info["message"]=$_POST["message"];
			
			if($info) $id = Contacts::insert($info);
			
			if($id)
			{
				$message = "Succesfully added another agent ";
				$message .="<br/><a href='http://www.adelebengershon.com/Adina_Cohen/final_project/forms/contacts.php'>return to list</a>";
			}
		}
	?>
			<h2>Add a contact</h2>
				<form method="post" action = "http://www.adelebengershon.com/Adina_Cohen/final_project/forms/contacts.php">
					
					<input type ="hidden" name="action" value="add">
					<br/><label>name </label>
					<br/><input type="text" name="name" value="">
					<br/><label>email</label>
					<br/><input type="text" name="email" value="">
					<br/><label>phone</label>
					<br/><input type="text" name="phone" value="">
					<br/><label>message</label>
					<br/><textarea name="message"></textarea>
					<br/>
					<br/>
					<br/><input type="submit" value="Save">			
				 </form>				
			<?
					echo $message;					
	}


	function edit_contact($id){ 
		 $entry=Contacts::getOne($id);
		 
		 ?>
		 
		 <form id="edit_contact" method="post" action="http://www.adelebengershon.com/Adina_Cohen/final_project/forms/contacts.php">
				<input type="hidden" name="action" value="save_entry"/>
				
		 
				<br/><label>name</label><input type="text" name="name" value="<? echo $entry['name'] ?>">
				
				<br/><label>email</label><input type="text" name="email" value="<? echo $entry['email'] ?>">
				<br/><label>phone</label><input type="text" name="phone" value="<? echo $entry['phone'] ?>">

				<br/><label>message</label>
				<br/><textarea name="message" class="textarea"><? echo $entry['message'] ?></textarea>

				<input type="submit" value="Save"/>
				
		 </form>
		 <?
	
	}


	function save($data){
		$info['contact_id']=$data['contact_id'];
		$info['name']=$data['name'];
		$info['email']=$data['email'];
		$info['phone']=$data['phone'];		
        $info['message']=$data['message'];	
		if (Contacts::update($data['contact_id'],$info))
			echo "<br>The entry was updated<br/>";
		show_list();
		
	}	
	
	function delete_contact($id){
		Contacts::delete($id);
		echo "<br>The entry was deleted<br/>";
		show_list();
	}
	
?>

		<script>
				function confirm_delete(id){
					var confirm_this=confirm("Are you sure?");
					if (confirm_this)
						window.location.href="http://www.adelebengershon.com/Adina_Cohen/final_project/forms/contacts.php?action=delete&id="+id;
					else return false;	
				}
		</script>

		