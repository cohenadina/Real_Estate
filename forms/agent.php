<?
error_reporting(1);
//ini_set('display_errors', '1');
//ini_set('display_startup_errors', '1');
//error_reporting(E_ALL);
include_once "../application.php";
include_once "../includes/header.php";
echo "<div class ='container'>";
	echo "<h2 class='forms_title'>Assets</h2>";
	
	switch ($_REQUEST['action'])
	{
		case 'add'  : add(); break;
		case 'edit'	  : edit($_REQUEST['id']); break;
		case 'save'	  : save($_REQUEST); break;
		case 'delete'	  :	delete($_REQUEST['id']); break;
        default           : show_list(); break;
	}
?>

<?	
	function show_list() {
	$Agents=Agents::getAll();		
?>
   
	<table>
		<thead>
			<tr>
				<? foreach ($Agents[0] as $key=>$value){
					echo "<td>".$key."</td>";
				}?>
				<td>Action</td>
			</tr>
		</thead>
		<tbody>
		
		<? foreach ($Agents as $agent){
				echo "<tr>";
					foreach ($agent as $value){
						echo "<td>".$value."</td>";
					}
					echo "<td id='edit'><a href='".$_SERVER['REQUEST_URI']."?action=edit&id=".$agent['Agent_Id']."'>Edit</td>";
					echo "<td id='delete'><a onClick='confirm_delete(".$agent['Agent_Id'].");'>Delete</a></td>";				
				echo "</tr>";

		}?>		
		
		</tbody>
	</table>

	<br/>	
	<button><a href='<?$_SERVER['REQUEST_URI']?>?action=add'>Add New Agent</a></button>
		<br/><br/></br>
<?  }



function theForm($entry=''){

?>
								
					<br/><label>Agent_Name </label>
					<br/><input type="text" name="Agent_Name" value="<? echo $entry['Agent_Name']?>"/>
					<br/><label>Agent_Number </label>
					<br/><input type="text" name="Agent_Number" value="<? echo $entry['Agent_Number']?>"/>
					<br/><label>Agent_Description </label>
				<br/><textarea name="Agent_Description" class="textara"><? echo $entry['Agent_Description'] ?></textarea>
						<br/>
			<br/><input type="submit" value="Save"/>	
							
						
					
				</form> 		 
<?   }	



function add()
	{
		print_R($_POST);
		print_R($_POST['Agent_Id']);
		echo "id";
		if($_POST["Agent_Name"])
			$info["Agent_Name"]=$_POST["Agent_Name"];
		if($_POST["Agent_Number"])
			$info["Agent_Number"]=$_POST["Agent_Number"];
		if($_POST["Agent_Description"])
			$info["Agent_Description"]=$_POST["Agent_Description"];
		
			if($info) $id = Agents::insert($info);
			
			if($id)
			{
				$message = "Succesfully added another asset ";
				$message .="<br/><a href='http://www.adelebengershon.com/Adina_Cohen/final_project/forms/agent.php'>return to list</a>";
				
			}
		
		?>
			<h2>Add an asset</h2>
				<form method="post" action = "http://www.adelebengershon.com/Adina_Cohen/final_project/forms/agent.php"  enctype="multipart/form-data">
					
					<input type ="hidden" name="action" value="add"/>
					<?theForm();?>
				
			<?
					echo $message;
					
	} 
	
	function edit($id){ 
		 $entry=Agents::getOne($id);
		 
		 ?>
		 
		 <form id="edit" method="post" action="http://www.adelebengershon.com/Adina_Cohen/final_project/forms/agent.php" enctype="multipart/form-data">
		 <h4>Edit Agent Info</h4>
			<input type="hidden" name="action" value="save"/>
			<input type="hidden" name="Agent_Id" value="<?  echo $entry['Agent_Id']?>"/>
			<?theForm($entry);?>
		 <?	
	}
	
	function save($data)
	{	
		$arr['Agent_Id']=$data['Agent_Id'];
		$arr['Agent_Name']=$data['Agent_Name'];
		$arr['Agent_Number']=$data['Agent_Number'];
		$arr['Agent_Description']=$data['Agent_Description'];
		
		if(Agents::update($data['Agent_Id'], $arr))
		{
			echo"</br><h3>The changes were updated</h3>";
		}
		echo "</br><a href='http://www.adelebengershon.com/Adina_Cohen/final_project/forms/agent.php'>return to list</a>";
	}
	
	function delete($id){
		Agents::delete($id);
		echo "<br/>The entry was deleted";
		echo "</br><a href='http://www.adelebengershon.com/Adina_Cohen/final_project/forms/agent.php'>return to list</a>";
		
	}
?>	

<script>
	function confirm_delete(id)
	{
		var confirm_it=confirm("Are you sure to delete this entry?");
		if(confirm_it)
			window.location.href="http://www.adelebengershon.com/Adina_Cohen/final_project/forms/agent.php?action=delete&id="+id
		
		else return false;	
	}
	
</script>