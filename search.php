<?
include_once "includes/header.php";
echo "<div class ='container'>";
echo "<h2 class='forms_title'>Assets</h2>";
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
		
	$assets=Assets::getAll('','','','',$_GET['category'],$_GET['price'],$_GET['type'],$_GET['keyword'],'');
	
	
	foreach ($assets as $asset){
		echo "<a href='".$config->url.'assets/'.$asset['Url_Name']."'>";
			echo "<h3>".$asset['Name']."</h3></a>";
			echo "<h3>".$asset['Location']."</h3>";
			echo "<p>Description : </p>".$asset['Description']."</br>";
			echo "<img src ='images/assets_images/".$asset['Image_Name']."'></br></br></br>";
			"</br>";
	} 
	 

	?>
	</div> </div>
	 <?include_once "includes/footer.php";?>
