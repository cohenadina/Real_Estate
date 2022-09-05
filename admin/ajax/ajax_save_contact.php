<?
    include "application.php";
	if (!$_POST['logged'])
	//$contacts['subscribe']=$_POST['subscribe'];
	$contacts['name']=$_POST['name'];
	$contacts['email']=$_POST['email'];
	$contacts['phone']=$_POST['phone'];
	//$contacts['meet_date']=date( 'Y-m-d H:i:s', $_POST['meeting_date']);
	$contacts['message']=$_POST['message'];
    $id=Contact::insert($contacts);
	if (!$id) echo "There was an error. Please try again later";
	else 
	{	
		$message=Contact::getOne($id);
		$message['response']="We received your message. We will be in touch with you later";
		$result=json_encode($message);
		echo $result;
		
	}

?>