<?

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
	$Assets=Assets::getAll();		
?>
   
	<table>
		<thead>
			<tr>
				<? foreach ($Assets[0] as $key=>$value){
					echo "<td>".$key."</td>";
				}?>
				<td>Action</td>
			</tr>
		</thead>
		<tbody>
		
		<? foreach ($Assets as $asset){
				echo "<tr>";
					foreach ($asset as $value){
						echo "<td>".$value."</td>";
					}
					echo "<td id='edit'><a href='".$_SERVER['REQUEST_URI']."?action=edit&id=".$asset['Asset_Id']."'>Edit</td>";
					echo "<td id='delete'><a onClick='confirm_delete(".$asset['Asset_Id'].");'>Delete</a></td>";				
				echo "</tr>";

		}?>		
		
		</tbody>
	</table>

	<br/>	
	<button><a href='<?$_SERVER['REQUEST_URI']?>?action=add'>Add New Asset</a></button>
		<br/><br/></br>
<?  }

function upload($id)
{		
global $config;

	$uploadOK = true;
	$imgType=$_FILES['assetImage']['type'];
	if($imgType!='image/gif' && $imgType!='image/jpeg' && $imgType!='image/jpg' && $imgType!='image/png'){
		echo "You can only upload an Image(.gif/.jpg/.png)";
		$uploadOK=false;				
	}
	
	switch ($imgType) 
	{
		case 'image/gif' : $imgtype='.gif';break;
		case 'image/jpg' : $imgtype='.jpg'; break;
		case 'image/png' : $imgtype='.png';break;
		case 'image/jpeg': $imgtype='.jpeg';break;
	}
	if(($_FILES['assetImage']['size']) > 500000000)
	{
		echo "You can only upload an Image with max size of 500000000 B";
		$uploadOK=false;	
	}
	if($uploadOK)
	{ 
      
        $newfilename=$config->asset_image_filepath.$id.$imgtype;
		move_uploaded_file($_FILES['assetImage']['tmp_name'], $newfilename);
		$info['Image_Name']=$id.$imgtype;
		Assets::update($id, $info);
		echo "Image succesfully uploaded";
	}
}





function add()
	{
		print_R($_POST);
		print_R($_POST['Asset_Id']);
		echo "id";
		if($_POST["Name"])
			$info["Name"]=$_POST["Name"];
		if($_POST["Location"])
			$info["Location"]=$_POST["Location"];
		if($_POST["Agent_Id"])
			$info["Agent_Id"]=$_POST["Agent_Id"];
		if($_POST["Buy_Price"])
			$info["Buy_Price"]=$_POST["Buy_Price"];
		if($_POST["Rent_Price"])
			$info["Rent_Price"]=$_POST["Rent_Price"];
		if($_POST["Sale_Price"])
			$info["Sale_Price"]=$_POST["Sale_Price"];
		if($_POST["Type"])
			$info["Type"]=$_POST["Type"];
		if($_POST["Kitchen"])
			$info["Kitchen"]=$_POST["Kitchen"];
		if($_POST["Bedroom"])
			$info["Bedroom"]=$_POST["Bedroom"];
		if($_POST["Parking"])
			$info["Parking"]=$_POST["Parking"];
		if($_POST["Living_Room"])
			$info["Living_Room"]=$_POST["Living_Room"];
		if($_POST["Description"])
			$info["Description"]=$_POST["Description"];
		if($_POST["Show_On_Slider"])
			$info["Show_On_Slider"]=$_POST["Show_On_Slider"];
		if($_POST["Featured"])
			$info["Featured"]=$_POST["Featured"];
		if($_POST["Tag"])
			$info["Tag"]=$_POST["Tag"];
			
			if($info) $id = Assets::insert($info);
			
			if($id)
			{
				$message = "Succesfully added another asset ";
				upload($id);
				$message .="<br/><a href='http://www.adelebengershon.com/Adina_Cohen/final_project/forms/assets.php'>return to list</a>";
				
			}
		
		?>
			<h2>Add an asset</h2>
				<form method="post" action = "http://www.adelebengershon.com/Adina_Cohen/final_project/forms/assets.php"  enctype="multipart/form-data">
					
					<input type ="hidden" name="action" value="add"/>
					
					<?
					$Agents=Agents::getAll();?>
										<br/><label>Name </label>
					<br/><input type="text" name="Name" value=""/>
					<br/><label>Location </label>
					<br/><input type="text" name="Location" value=""/>
					<br/><label>Agent </label>
					<br/><select name="Agent_Id" value="">
						<?foreach($Agents as $agent)
						{
							
							?>
							<option id="agentid" value="<?=$agent['Agent_Id']?>">
							<?echo $agent['Agent_Name'];?>
							</option>
							
							<script>
								if(<?=$agent['Agent_Id']?> == <?=$asset['Agent_Id']?>)
								{
									document.GetElementById('agentid').setAttribute("selected");
								}
							</script>
							
							
						<?}?>
					</select>
					<br/><label>Rent Price </label>
					<br/><input type="decimal" name="Rent_Price" value=""/>
					<br/><label>Buy Price </label>
					<br/><input type="decimal" name="Buy_Price" value=""/>					
					<br/><label>Sale Price </label>
					<br/><input type="decimal" name="Sale_Price" value=""/>
					<br/><label>Type </label>
					<br/><select name="Type" value="">
					  <option value="Apartment">Apartment</option>
					  <option value="Building">Building</option>
					  <option value="Office Space">Office Space</option>
					</select>
					<br/><label>Amount of Kitchens </label>
					<br/><input type="number" name="Kitchen" value=""/>
					<br/><label>Amount of Bedrooms </label>
					<br/><input type="number" name="Bedroom" value=""/>
					<br/><label>Amount of Parking </label>
					<br/><input type="number" name="Parking" value=""/>
					<br/><label>Amount of Living Rooms </label>
					<br/><input type="number" name="Living_Room" value=""/>
					<br/><label>Description </label>
					<br/><textarea name="Description" class="textara"></textarea>
					<br/><label>Show on slider: </label>
					<input type="radio" name="Show_On_Slider" value="Y" <?if ($asset['Show_On_Slider'] == 'Y') echo 'checked';?>>Yes
					<input type="radio" name="Show_On_Slider" value="N" <?if ($asset['Show_On_Slider'] == 'N') echo 'checked';?> >No
					<br/><label>Show in Featured: </label>
					<input type="radio" name="Featured" value="Y" <?if ($asset['Featured'] == 'Y') echo 'checked';?> >Yes
					<input type="radio" name="Featured" value="N" <?if ($asset['Featured'] == 'N') echo 'checked';?> >No
					<br/><label>Tag</label>
					<br/><select name="Asset_Tag">
						<option value="Null"></option>
						<option value="New">New</option>
						<option value="Sold">Sold</option>
					</select>
					<br/>Upload a file:<br/><input type="file" name="assetImage"/>
					<br/><br/>
					<br/><input type="submit" value="Save">
				</form> 		 
				
			<?
					echo $message;
					
	}
	
	function edit($id){ 
		 $entry=Assets::getOne($id);
		 
		 ?>
		 
		 <form id="edit" method="post" action="http://www.adelebengershon.com/Adina_Cohen/final_project/forms/assets.php" enctype="multipart/form-data">
		 <h4>Edit Agent Info</h4>
			<input type="hidden" name="action" value="save"/>
			<input type="hidden" name="Asset_Id" value="<?  echo $entry['Asset_Id']?>"/>
			<?
					$Agents=Agents::getAll();?>
			<br/><label>Name </label>
					<br/><input type="text" name="Name" value="<? echo $asset['Name']?>"/>
					<br/><label>Location </label>
					<br/><input type="text" name="Location" value="<? echo $asset['Location']?>"/>
					<br/><label>Agent </label>
					<br/><select name="Agent_Id" value="<? echo $asset['Agent_Id']?>">
						<?foreach($Agents as $agent)
						{
							
							?>
							<option id="agentid" value="<?=$agent['Agent_Id']?>">
							<?echo $agent['Agent_First_Name']." ".$agent['Agent_Last_Name'];?>
							</option>
							
							<script>
								if(<?=$agent['Agent_Id']?> == <?=$asset['Agent_Id']?>)
								{
									document.GetElementById('agentid').setAttribute("selected");
								}
							</script>
							
							
						<?}?>
					</select>
					<br/><label>Rent Price </label>
					<br/><input type="decimal" name="Rent_price" value="<? echo $asset['Rent_price']?>"/>
					<br/><label>Buy Price </label>
					<br/><input type="decimal" name="Buy_Price" value="<? echo $asset['Buy_price']?>"/>					
					<br/><label>Sale Price </label>
					<br/><input type="decimal" name="Sale_Price" value="<? echo $asset['Sale_price']?>"/>
					<br/><label>Type </label>
					<br/><select name="Type" value="<? echo $asset['Type']?>">
					  <option value="Apartment">Apartment</option>
					  <option value="Building">Building</option>
					  <option value="Office Space">Office Space</option>
					</select>
					<br/><label>Amount of Kitchens </label>
					<br/><input type="number" name="Kitchen" value="<? echo $asset['Kitchen']?>"/>
					<br/><label>Amount of Bedrooms </label>
					<br/><input type="number" name="Bedroom" value="<? echo $asset['Bedroom']?>"/>
					<br/><label>Amount of Parking </label>
					<br/><input type="number" name="Parking" value="<? echo $asset['Parking']?>"/>
					<br/><label>Amount of Living Rooms </label>
					<br/><input type="number" name="Living_Room" value="<? echo $asset['Living_room']?>"/>
					<br/><label>Description </label>
					<br/><textarea name="Description" class="textara"><? echo $asset['Description']?></textarea>
					<br/><label>Show on slider: </label>
					<input type="radio" name="Show_On_Slider" value="Y" <?if ($asset['Show_on_slider'] == 'Y') echo 'checked';?>>Yes
					<input type="radio" name="Show_On_Slider" value="N" <?if ($asset['Show_on_slider'] == 'N') echo 'checked';?> >No
					<br/><label>Show in Featured: </label>
					<input type="radio" name="Featured" value="Y" <?if ($asset['Featured'] == 'Y') echo 'checked';?> >Yes
					<input type="radio" name="Featured" value="N" <?if ($asset['Featured'] == 'N') echo 'checked';?> >No
					<br/><label>Tag</label>
					<br/><select name="Asset_Tag">
						<option value="Null"></option>
						<option value="New">New</option>
						<option value="Sold">Sold</option>
					</select>
					<br/>Upload a file:<br/><input type="file" name="assetImage"/>
					<br/><br/>
					<br/><input type="submit" value="Save">
				</form> 	
		 <?	
	}
	
	function save($data)
	{	
		$arr['Asset_Id']=$data['Asset_Id'];
		$arr['Name']=$data['Name'];
		$arr['Location']=$data['Location'];
		$arr['Buy_Price']=$data['Buy_Price'];
		$arr['Rent_Price']=$data['Rent_Price'];
		$arr['Sale_Price']=$data['Sale_Price'];
		$arr['Type']=$data['Type'];
		$arr['Kitchen']=$data['Kitchen'];
		$arr['Bedroom']=$data['Bedroom'];
		$arr['Parking']=$data['Parking'];
		$arr['Living_room']=$data['Living_room'];
		$arr['Description']=$data['Description'];
		$arr['Show_On_Slider']=$data['Show_On_Slider'];
		$arr['Featured']=$data['Featured'];
		$arr['Tag']=$data['Tag'];
		
		if(Assets::update($data['Asset_Id'], $arr))
		{
			echo"</br><h3>The changes were updated</h3>";
			upload($data['Asset_Id']);
		}
		echo "</br><a href='http://www.adelebengershon.com/Adina_Cohen/final_project/forms/assets.php'>return to list</a>";
	}
	
	function delete($id){
		Assets::delete($id);
		echo "<br/>The entry was deleted";
		echo "</br><a href='http://www.adelebengershon.com/Adina_Cohen/final_project/forms/assets.php'>return to list</a>";
		
	}
?>	

<script>
	function confirm_delete(id)
	{
		var confirm_it=confirm("Are you sure to delete this entry?");
		if(confirm_it)
			window.location.href="http://www.adelebengershon.com/Adina_Cohen/final_project/forms/assets.php?action=delete&id="+id
		
		else return false;	
	}
	
</script>

