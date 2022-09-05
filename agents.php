<?
 include_once "includes/header.php";
echo "<div class ='container'>";
echo "<h2 class='forms_title'>Assets</h2>";
error_reporting(1);



		//$agent=Agents::getOnebyURL($_GET['Url_Name']);
		
		$agents=Agents::getAll('','','','','','','',$agent['Agent_Id']);
		foreach ($agents as $agent){
		echo "<a href='".$config->url.'agents/'.$agent['Url_Name']."'>";
			echo "<h3>".$agent['Agent_Name']."</h3></a>";
			echo "<p>Description : </p>".$agent['Agent_Description']."</br>";
			
			
			"</br>";
		
		
	} 
		
		
?>		</div>
</div>
<? include "includes/footer.php";	?>



		
		