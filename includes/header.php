<!doctype HTML>
<? 
include "application.php";
   global $config;
?>


<html> 
<head>
	
	<script src="<? echo $config->url ?>js/jquery.js"></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">

	<link rel="stylesheet" type="text/css" href="<? echo $config->url ?>css/style.css">
	<link rel="stylesheet" type="text/css" href="<? echo $config->url?>/slick/slick-theme.css">
	<link rel="stylesheet" type="text/css" href="<? echo $config->url?>/slick/slick.css">


</head>
<body>

	<ul class="nav justify-content-end">
	  <li class="nav-item">
	  
		<a class="nav-link active" aria-current="page" href="http://www.adelebengershon.com/Adina_Cohen/final_project/">HOME</a>
		
	  </li>
	  <li class="nav-item">
		<a class="nav-link" href="about.php">ABOUT</a>
	  </li>
	  <li class="nav-item">
		<a class="nav-link" href="agents.php">AGENTS</a>
	  </li>
	  <li class="nav-item">
		<a class="nav-link " href="contact_us.php">CONTACT</a>
	  </li>
	</ul>
	
	
	
	<nav class="navbar navbar-dark bg-dark">
	  <div class="container-fluid">
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
		  <span class="navbar-toggler-icon"></span>
		</button>
	  </div>
	</nav>
	
	
	
	
	
	<div class="container">
	<div class="header">
	<a href="http://www.adelebengershon.com/Adina_Cohen/final_project/"><img src="<? echo $config->url?>/images/logo.png"></a>	
	<ul class="pull-right">
		<li class="buyli"><a href="buy.php">BUY</a></li>
		<li><a href="sale.php">SALE</a></li>
		<li><a href="rent.php">RENT</a></li>
	</ul>
	</div>
  
  
</div>






