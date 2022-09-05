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

function theForm($asset=''){

		$Agents=Agents::getAll();

?>
								
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
					<br/><input type="decimal" name="Rent_Price" value="<? echo $asset['Rent_Price']?>"/>
					<br/><label>Buy Price </label>
					<br/><input type="decimal" name="Buy_Price" value="<? echo $asset['Buy_Price']?>"/>					
					<br/><label>Sale Price </label>
					<br/><input type="decimal" name="Sale_Price" value="<? echo $asset['Sale_Price']?>"/>
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
					<br/><input type="number" name="Living_Room" value="<? echo $asset['LivingRoom']?>"/>
					<br/><label>Description </label>
					<br/><textarea name="Description" class="textara"><? echo $asset['Description']?></textarea>
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
<?   }	



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
				$message .="<br/><a href='http://www.adelebengershon.com/Adina_Cohen/final_project/forms/text.php'>return to list</a>";
				
			}
		
		?>
			<h2>Add an asset</h2>
				<form method="post" action = "http://www.adelebengershon.com/Adina_Cohen/final_project/forms/text.php"  enctype="multipart/form-data">
					
					<input type ="hidden" name="action" value="add"/>
					<?theForm();?>
				
			<?
					echo $message;
					
	}
	
	function edit($id){ 
		 $entry=Assets::getOne($id);
		 
		 ?>
		 
		 <form id="edit" method="post" action="http://www.adelebengershon.com/Adina_Cohen/final_project/forms/text.php" enctype="multipart/form-data">
		 <h4>Edit Agent Info</h4>
			<input type="hidden" name="action" value="save"/>
			<input type="hidden" name="Asset_Id" value="<?  echo $entry['Asset_Id']?>"/>
			<?theForm($entry);?>
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
		echo "</br><a href='http://www.adelebengershon.com/Adina_Cohen/final_project/forms/text.php'>return to list</a>";
	}
	
	function delete($id){
		Assets::delete($id);
		echo "<br/>The entry was deleted";
		echo "</br><a href='http://www.adelebengershon.com/Adina_Cohen/final_project/forms/text.php'>return to list</a>";
		
	}
?>	

<script>
	function confirm_delete(id)
	{
		var confirm_it=confirm("Are you sure to delete this entry?");
		if(confirm_it)
			window.location.href="http://www.adelebengershon.com/Adina_Cohen/final_project/forms/text.php?action=delete&id="+id
		
		else return false;	
	}
	
</script>



















<? include_once "includes/header.php";
?>
  <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="true">
	  
	  <div class="carousel-indicators">
		<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
		<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
		<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
		<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3" aria-label="Slide 4"></button>
		<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="4" aria-label="Slide 5"></button>
	  </div>
	  
	  
	 
	  <div class="carousel-inner">
		
		<div class="carousel-item active">
		  <img src="images/1.jpg" class="d-block w-100" alt="..." >
			  <div class="container">
				<div class="carousel-caption">
					<a href="#"><h2>2 Bed Rooms and 1 Dinning Room Apartment on Sale</h2></a>
					<blockquote>
					<p class="location">1890 Syndey, Australia</p>
					<p>Until he extends the circle of his compassion to all living things, man will not himself find peace.</p>
					<button type="button" class="btn btn-success">$ 20,000,000</button>
					</blockquote>
				</div>
		  </div>
		</div>
		<div class="carousel-item">
		  <img src="images/2.jpg" class="d-block w-100" alt="...">
		  	<div class="container">
				<div class="carousel-caption">
					<a href="#"><h2>2 Bed Rooms and 1 Dinning Room Apartment on Sale</h2></a>
					<blockquote>
					<p class="location">1890 Syndey, Australia</p>
					<p>Until he extends the circle of his compassion to all living things, man will not himself find peace.</p>
					<button type="button" class="btn btn-success">$ 20,000,000</button>
					</blockquote>
				</div>
			</div>
		</div>
		<div class="carousel-item">
		  <img src="images/3.jpg" class="d-block w-100" alt="...">
		  	<div class="container">
				<div class="carousel-caption">
					<a href="#"><h2>2 Bed Rooms and 1 Dinning Room Apartment on Sale</h2></a>
					<blockquote>
					<p class="location">1890 Syndey, Australia</p>
					<p>Until he extends the circle of his compassion to all living things, man will not himself find peace.</p>
					<button type="button" class="btn btn-success">$ 20,000,000</button>
					</blockquote>
				</div>
			</div>
		</div>
		<div class="carousel-item">
		  <img src="images/4.jpg" class="d-block w-100" alt="...">
		  	<div class="container">
				<div class="carousel-caption">
					<a href="#"><h2>2 Bed Rooms and 1 Dinning Room Apartment on Sale</h2></a>
					<blockquote>
					<p class="location">1890 Syndey, Australia</p>
					<p>Until he extends the circle of his compassion to all living things, man will not himself find peace.</p>
					<button type="button" class="btn btn-success">$ 20,000,000</button>
					</blockquote>
				</div>
			</div>
		</div>
		<div class="carousel-item">
		  <img src="images/5.jpg" class="d-block w-100" alt="...">
		  	<div class="container">
				<div class="carousel-caption">
					<a href="#"><h2>2 Bed Rooms and 1 Dinning Room Apartment on Sale</h2></a>
					<blockquote>
					<p class="location">1890 Syndey, Australia</p>
					<p>Until he extends the circle of his compassion to all living things, man will not himself find peace.</p>
					<button type="button" class="btn btn-success">$ 20,000,000</button>
					</blockquote>
				</div>
			</div>
		</div>  
	</div>
 </div>

 
  <div class="buy">
	<div class="container">
		<div class="searchbar">
			<h3>Buy, Sale & Rent</h3>
			
			<input type="text" class="form-control" placeholder="Search of properties">
			
			<p class="join">Join now and get updated with all the properties deals.</p>


			<select class="form-select" aria-label="Default select example">
				 <option value="1">Buy</option>
				 <option value="2">Rent</option>
				 <option value="3">Sale</option>
			</select>


			<select class="form-select" aria-label="Default select example">
				 <option value="1">Price</option>
				 <option value="1">$150,000 - $200,000</option>
				 <option value="2">$200,000 - $250,000</option>
				 <option value="3">$250,000 - $300,000</option>
				 <option value="3">$300,000 - above</option>
			</select>


			<select class="form-select" aria-label="Default select example">
				 <option value="1">Property</option>
				 <option value="2">Apartment</option>
				 <option value="3">Building</option>
				 <option value="3">Office Space</option>
			</select>


			<button type="button" class="btn btn-success">Find Now</button>
			
			<button type="button" class="btn btn-info">Login</button>
			
			</div>
		</div>
	</div>
	
	<div class="container">
		<div class="featured-properties">
			<h3>Features Properties</h3>
			<div class="your-class">
			
				
			<?
			$assets = Assets::getAll('','','Y');
			print_r($assets);
			foreach ($assets as $asset)
			{
			?>
		 
		
				
		
				<div class="propertie">
					<div class="image"><img src="images/assets_images/<?=$asset['Image_name']?>'"/>
					</div>
					<h4><a href="#"><?=$asset['Name']?></a></h4>
					<div class="price"><p >Price: $<?=$asset['Buy_price']?></p></div>
					<div class="details" >
						<span data-toggle="tooltip" data-placement="bottom" data-original-title="Bed Room"><?=$asset['Bedroom']?></span>
						<span data-toggle="tooltip" data-placement="bottom" data-original-title="linving_room"><?=$asset['Living_room']?></span>
						<span data-toggle="tooltip" data-placement="bottom" data-original-title="parking"><?=$asset['Parking']?></span>
						<span data-toggle="tooltip" data-placement="bottom" data-original-title="kitchen"><?=$asset['Kitchen']?></span>
					</div>
					<a class="btn btn-primary">View Details</a>
				</div> 
				<?}?>
				
				
			</div>
		</div>
	</div>
	
	<? include_once "includes/footer.php";?>
	
	<script type="text/javascript">
		$(document).ready(function(){
			$('.your-class').slick({
			  slidesToShow: 5,
			  slidesToScroll: 5,
			  autoplay: true,
			  autoplaySpeed: 2000,
			  dots:true,
			  responsive:[
			  {
				  breakpoint:1200,
				  settings:{
					  slidesToShow: 4,
					  slidesToScroll: 4,
				  }
			  },
			  {
				  breakpoint:1024,
				  settings:{
					  slidesToShow: 3,
					  slidesToScroll: 3,
				  }
			  },
			  {
				  breakpoint:600,
				  settings:{
					  slidesToShow: 2,
					  slidesToScroll: 2,
				  }
			  },
			  {
				  breakpoint:400,
				  settings:{
					  slidesToShow: 1,
					  slidesToScroll: 1,
				  }
			  }
			  ]
			});
		});

	</script>
	
	
	
	
	
	
	
	
	
	
	
	
	
	function getAll($orderby='', $orderDir='ASC', $featured='', $slider='', $category='', $priceRange='', $type='', $keyword=''){
			global $db;
			$sql="SELECT * FROM Assets WHERE 1";
			if($featured){
				$sql.=" AND Assets.Featured='".$featured."'";
			}
			if($slider){
				$sql.=" AND Assets.Show_On_Slider='".$slider."'";
			}
			if($category){
				$sql.=" AND Assets.CatId='".$category."'";
			}
			if($priceRange){
				if($priceRange=='$150,000-$200,000')
					$sql.=" AND Assets.Rent_Price IS BETWEEN 150000 AND 200000";
				if($priceRange=='$200,000-$250,000')
					$sql.=" AND Assets.Rent_Price IS BETWEEN 2000000 AND 250000";
				if($priceRange=='$250,000-$300,000')
					$sql.=" AND Assets.Rent_Price IS BETWEEN 250000 AND 300000";
				if($priceRange=='$350,000-above')
					$sql.=" AND Assets.Rent_Price IS > 300000";
			}
			if($type){
				$sql.=" AND Assets.Type='".$type."'";
			}
			if($keyword){
				$sql.=" AND Assets.Name %LIKE% '".$keyword." OR Assets.Location %LIKE% '".$keyword."'";
			}
			if ($orderby){
				$sql.=" ORDER BY ".$orderby." ".$orderDir;
			}
			return $db->query($sql);
		}
		
		
		
		
		
		
		
		
		
		<?

		
	$assts=Assets::getAll('','','',$_GET['category'],$_GET['price'],$_GET['type'],$_GET['keyword'])
	
	
	foreach ($assets as $asset){
		echo "<a href='".$config->siteurl."/assets/".$asset['url_name']."'>";
			echo $asset['name'];
			echo "<img src ='".$asset['img']."'>";
		echo "</a>";
	}
	
	?>