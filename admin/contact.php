<?
include "../application.php";

    include "../includes/header.php";
    	error_reporting(1);
echo "<div class ='container'>";
echo "<h2 class='forms_title'>Contacts</h2>";
	
	//print_r($_REQUEST);
	
	switch ($_REQUEST['action']){
	
		case 'save_entry' : save($_REQUEST); break;
		case 'edit'		  :	edit_contact($_REQUEST['id']); break;
		case 'delete'	  :	delete_contact($_REQUEST['id']); break;
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
		
		<? foreach ($contacts as $contact){
				echo "<tr>";
				foreach ($contact as $value){
					echo "<td>".$value."</td>";
				}
				echo "<td><a href='".$_SERVER['REQUEST_URI']."?action=edit&id=".$contact['id']."'>Edit</td><td><a onclick='confirm_delete(".$contact['id'].");'>Delete</a></td></tr>";
		}?>
		
		</tbody>
		
		
<?  } 

	function edit_contact($id){ 
		 $entry=Contacts::getOne($id);
		 
		 ?>
		 
		 <form id="edit_contact" method="post" action="http://www.adelebengershon.com/Adina_Cohen/cakes/admin/contact.php">
				<input type="hidden" name="action" value="save_entry"/>
				<input type="hidden" name="id" value="<?  echo $entry['id']?>"/>
		 
				<br/><label>First Name</label><input type="text" name="first_name" value="<? echo $entry['first_name'] ?>">
				
				<br/><label>Last Name</label><input type="text" name="last_name" value="<? echo $entry['last_name'] ?>">

				
				<br/><label>Subscribe</label>
				<input type="radio" name="subscribe" value="yes" <? if ($entry['subscribe']=='yes') echo "checked"; ?>/>Yes
				<input type="radio" name="subscribe" value="no" <? if ($entry['subscribe']=='no') echo "checked"; ?>/>No
				
				<br/><label>Message</label>
				<textarea disabled name="message">
				<? echo $entry['message'];?>
				</textarea>
				
				<input type="submit" value="Save"/>
				
		 </form>
		 <?
	
	}


	function save($data){
		
		$info['first_name']=$data['first_name'];
		$info['last_name']=$data['last_name'];	
        $info['subscribe']=$data['subscribe'];	
		if (Contacts::update($data['id'],$info))
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
						window.location.href="http://www.adelebengershon.com/Adina_Cohen/final_project/admin/contact.php?action=delete&id="+id;
					else return false;	
				}
		</script>

		