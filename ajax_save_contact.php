

<?
include "application.php";
	 error_reporting(1);
	if (!$_POST['logged'])
	//$contacts['subscribe']=$_POST['subscribe'];
	$contacts['name']=$_POST['name'];
	$contacts['email']=$_POST['email'];
	$contacts['phone']=$_POST['phone'];
	//$contacts['meet_date']=date( 'Y-m-d H:i:s', $_POST['meeting_date']);
	$contacts['message']=$_POST['message'];
    $id=Contacts::insert($contacts);
	if ($id){?>
		<h1>Thank you for filling this form, we will be in touch with you shortly</h1>
	<?}

	  else {?>
		  <h1>There was a problem saving your entry please try again later</h1>
	 <? }
?>	
