<?
	global $config;
	global $db;
	include_once "setting.php"	;

	include_once $config->filepath."/apps/dblib.php";
	include_once $config->filepath."/apps/agent.php";
	include_once $config->filepath."/apps/assets.php";
	include_once $config->filepath."/apps/contacts.php";


	$db = new DB($config->servername, $config->dbname,$config->dbUsername,$config->dbPassword);



?>	