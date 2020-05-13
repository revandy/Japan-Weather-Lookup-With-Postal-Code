<!DOCTYPE html>
<html>
<head>
	<title>JAPAN WEATHER LOOKUP</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body>
<div class="loading"></div>

	<div class="container-bg">
	<div class="container">
			<div style="background:white !important" class="jumbotron">
			<div class="form-inline">
			    <label for="postal_code" class="mb-2 mr-sm-2">Post Code </label>
			    <input name="postal_code" id="postal_code" type="text" class="form-control mb-2 mr-sm-2" placeholder="160-0022">
			    <button onclick="processLookUp()" class="btn btn-primary mb-2">Submit</button>
			</div>	
			  <br>
<h3 id="location"></h3>
<h6>3-day forecast</h6>
		<div class="card-deck weather">
		
		</div>
<h6>MAP</h6>
<div class="card-deck">
 			<div class="card">
			    <div id="map"></div>
			    <img id="imgMap" src="https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcTcG6O0Qzvu-LtC6YSCX0Kf3Ka62_m5AzVaPdRwk3tHujnoLT59&usqp=CAU" class="card-img-top" alt="...">
			  </div>
			   <div class="card">
			    <img id="flag" src="https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcTcG6O0Qzvu-LtC6YSCX0Kf3Ka62_m5AzVaPdRwk3tHujnoLT59&usqp=CAU" class="card-img-top" alt="...">
			    <div class="form-group">
			    	<p class="text-center ip"></p>
			    	<p class="text-center country"></p>
			    	<p class="text-center city"></p>
			    	<p class="text-center lat"></p>
			    	<p class="text-center lon"></p>
			    	<p class="text-center isp"></p>
			    </div>
			  </div>
		</div>
		</div>
	</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyASru7_maCZXu7MpXtukjWWV6JbnTbPnPM&callback=initMap" async defer></script>
<script src="js/main.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$.ajax({
	  url: "http://ip-api.com/json",
	  success: function(response){
	  	console.log(response)
	  	initMap(parseFloat(response.lat), parseFloat(response.lon))
	  	$('#imgMap').remove()
	  	$('#postal_code').val(response.zip)
	  	$('#flag').attr('src', 'https://www.countryflags.io/'+response.countryCode+'/shiny/64.png');
	  	$('.ip').text("IP: "+response.query)
	  	$('.country').text("Country: "+response.country)
	  	$('.city').text("City: "+response.city)
	  	$('.lat').text("LAT: "+response.lat)
	  	$('.lon').text("LNG: "+response.lon)
	  	$('.isp').text("ISP: "+response.isp)
	  	$('#location').text(response.city);
	  	processLookUp()
	  },
	});
})
</script>
</body>
</html>

