<? include_once "includes/header.php";
error_reporting(1);

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
			<form action="search.php" method="get"/>
				<input type="text" class="form-control" placeholder="Search of properties" name="keyword">
				
				<p class="join">Join now and get updated with all the properties deals.</p>

				<select class="form-select" name="category">
					 <option>Category</option>
					 <option value="1">Buy</option>
					 <option value="2">Rent</option>
					 <option value="3">Sale</option>
				</select>


				<select class="form-select" name="price">
					 <option>Price</option>
					 <option value="$150,000-$200,000">$150,000 - $200,000</option>
					 <option value="$200,000-$250,000">$200,000 - $250,000</option>
					 <option value="$250,000-$300,000">$250,000 - $300,000</option>
					 <option value="$350,000-above">$300,000 - above</option>
				</select>


				<select class="form-select" name="type">
					 <option>Property</option>
					 <option value="1">Apartment</option>
					 <option value="2">Building</option>
					 <option value="3">Office Space</option>
				</select>


				 <button onclick="search()" method="get" type="button" class="btn btn-success">Find Now</button>

				<a><button type="button" class="btn btn-info" href="#" onclick="popupfunction()"> Login</button></a>
			</form>
			</div>
		</div>
	</div>
	<script>
	function search(){
		var url= "http://www.adelebengershon.com/Adina_Cohen/final_project/search.php"; 
		window.location = url; 
	}
	
	
		function popupfunction() {
		  let person = prompt("Please enter your email", "");
		  if (person != null) {
			document.getElementById("popup").innerHTML =
			"Hello " + person + "!";
		  }
		}
	</script>
	
	<div class="container">
		<div class="featured-properties">
			<h3>Features Properties</h3>
			<div class="your-class">
		
		
			<?$assets =Assets::getAll1('','','Y');

			foreach ($assets as $asset)
			{
			?>
			  <div class = "propertie">
				<div class="image"><img src="<? echo $config->url?>/images/assets_images/<?=$asset['Image_Name']?>"/></div>

				<div><h4><a href="property-detail.php"><?=$asset['Name']?></a></h4></div>
				<div><p class="price">Price: <?=$asset['Buy_Price']?></p></div>
				<div class="details">
					<span data-toggle="tooltip" data-placement="bottom" data-original-title="Bed Room"><?=$asset['Bedroom']?></span> 
					<span data-toggle="tooltip" data-placement="bottom" data-original-title="Living Room"><?=$asset['Living_Room']?></span> 
					<span data-toggle="tooltip" data-placement="bottom" data-original-title="Parking"><?=$asset['Parking']?></span> 
					<span data-toggle="tooltip" data-placement="bottom" data-original-title="Kitchen"><?=$asset['Kitchen']?></span> 
				</div>
				
				
				<a class="btn btn-primary" href="property-detail.php">View Details</a>
			  </div>
			<?}?>
				
				
			</div>
		</div>
	</div>
	
	
	
	

	
	
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
	
	
	
	 <?
	include_once "includes/footer.php";?>