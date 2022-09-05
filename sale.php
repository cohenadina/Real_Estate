

<?
//error_reporting(1);

 include_once "includes/header.php";
echo "<div class ='container'>";
//ini_set('display_errors', '1');
//ini_set('display_startup_errors', '1');
//error_reporting(E_ALL);
	$sale=Assets::getAll1('','');	
	foreach ($sale as $asset){
		if($asset['Sale_Price']>0){
			echo "<a href='".$config->url.'assets/'.$asset['Url_Name']."'>";
			echo "<h3>".$asset['Name']."</h3></a>";
			echo "Sale_Price : ".$asset['Sale_Price']."</br></br>";
		}
			
	
	}
	
	
?>
</div>
</div>
<? include "includes/footer.php";	?>

