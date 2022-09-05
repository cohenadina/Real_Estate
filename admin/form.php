<?
 include_once "../application.php";
    include "header.php";
    	
	
	//print_r($_REQUEST);
	
	switch ($_REQUEST['action']){
	
		case 'add_entry' : add($_REQUEST); break;
		case 'edit'		  :	edit_agent($_REQUEST['id']); break;
		case 'delete'	  :	delete_agent($_REQUEST['id']); break;
        default           : show_list(); break;
	}
	
	
	
	function show_list() {
		
	$admin_users=Admin_users::getAll();		
		?>
   
	<table>
		<thead><tr>
		<? foreach ($Admin_users[0] as $key=>$value){
			echo "<td>".$key."</td>";
		}?>
		<td>Action</td></tr></thead>
		<tbody>
		
		<? foreach ($Admin_users as $Admin_users){
				echo "<tr>";
				foreach ($Admin_users as $value){
					echo "<td>".$value."</td>";
				}
				echo "<td><a href='".$_SERVER['REQUEST_URI']."?action=edit&id=".$Admin_users['id']."'>Edit</td><td><a onclick='confirm_delete(".$Admin_users['id'].");'>Delete</a></td></tr>";
		}?>
		
		</tbody>
		
		
<?  } 

	function edit_agent($id){ 
		 $entry=Admin_users::getOne($id);
		 
		 ?>
		 
		 <form id="admin_users" method="post" action="http://www.adelebengershon.com/Adina_Cohen/final_project/forms/Admin_users.php">
				<input type="hidden" name="action" value="save_entry"/>
				<input type="hidden" name="id" value="<?  echo $entry['id']?>"/>
		 
				<br/><label>Name</label><input type="text" name="name" value="<? echo $entry['name'] ?>">
				
				<br/><label>Phone</label><input type="text" name="phone" value="<? echo $entry['phone'] ?>">

				
				
				
				<br/><label>Description</label>
				<textarea disabled name="description">
				<? echo $entry['Agent'];?>
				</textarea>
				
				<input type="submit" value="Save"/>
				
		 </form>
		 <?
	
	}


	function add($data){
		
		$info['name']=$data['name'];
		$info['phone']=$data['phone'];	
		if (Agent::insert($data['agent_id'],$info))
			echo "<br>The entry was updated<br/>";
		show_list();
		
	}	
	
	function delete_contact($id){
		Agent::delete($id);
		echo "<br>The entry was deleted<br/>";
		show_list();
	}
	if(root==null)
		return
	insertvalue(root.getleft,stack)
	stack.push(root.getkey)
	insertvalue(root.getright,stack)
	
?>

		<script>
				function confirm_delete(id){
					var confirm_this=confirm("Are you sure?");
					if (confirm_this)
						window.location.href="http://www.adelebengershon.com/Adina_Cohen/final_project/admin/form.php?action=delete&id="+id;
					else return false;	
				}
		</script>

		