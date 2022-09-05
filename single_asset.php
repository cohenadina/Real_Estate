<?
 include_once "includes/header.php";
echo "<div class ='container'>";
	$asset=Assets::getOnebyURL($_GET['Url_Name']);
	
	echo "<h3>".$asset['Name']."</h3></br>";
	echo "Location : ".$asset['Location']."</br>";
	echo "Buy price : ".$asset['Buy_Price']."</br>";
	echo "Type : ".$asset['Type']."</br>";
	echo "Number of kitchen : ".$asset['Kitchen']."</br>";
	echo "Number of bedroom : ".$asset['Bedroom']."</br>";
	echo "Number of parking : ".$asset['Parking']."</br>";
	echo "Number of linving room : ".$asset['Living_Room']."</br>";


	echo "<p>Description : </p>".$asset['Description']."</br>";
	echo "<img src ='../images/assets_images/".$asset['Image_Name']."'></br></br></br>";
	

	
	
?>	