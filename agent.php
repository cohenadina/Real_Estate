<?
error_reporting(1);

 include_once "includes/header.php";
echo "<div class ='container'>";
//ini_set('display_errors', '1');
//ini_set('display_startup_errors', '1');
//error_reporting(E_ALL);
	$agent=Agents::getOnebyURL($_GET['Url_Name']);
	
	echo "<h3>".$agent['Agent_Name']."</h3></br>";
	echo "Description : ".$agent['Agent_Description']."</br>";
	
	$assets=Assets::getAll('','','','','','','','',$agent['Agent_Id']);
	foreach ($assets as $asset){
		echo "<a href='".$config->url.'assets/'.$asset['Url_Name']."'>";
			echo "<h3>".$asset['Name']."</h3></a>";
	}

?>
</div>
</div>
<? include "includes/footer.php";	?>