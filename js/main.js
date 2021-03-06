	function processLookUp(){
		$('.loading').show()
		data = {
			'postal_code': $('#postal_code').val()			
		}
		console.log(data)
		$.ajax({
		  type: "POST",
		  url: 'function.php',
		  data: data,
		  success: function(response){
		  	var data = JSON.parse(response)
		  	for (var i = 0; i < data.length; i++) {
		  		$('.weather-'+i).remove()
		  		 	$( ".weather" ).append(
		  		'<div class="card weather-'+i+'">'+
'			    <img src="https://www.metaweather.com/static/img/weather/'+data[i].weather_state_abbr+'.svg" class="card-img-top" alt="...">'+
'			    <div class="card-body">'+
'			      <h6 class="text-center">'+data[i].detail.dmy+'</h6>'+
'			      <h1 class="text-center">'+data[i].weather_state_name+'</h1>'+
'			    </div>'+
'			     <p class="text-center" style="font-weight: bold;">Max: '+data[i].max_temp+'° Min: '+data[i].min_temp+'°</p>'+
'			  </div>');
		  	}
		  	$('#location').text(data[0].detail.state+', '+data[0].detail.place);
		  	initMap(parseFloat(data[0].detail.latitude), parseFloat(data[0].detail.longitude))
		  	console.log('long',data[0].detail.longitude)
		  	console.log('lat',data[0].detail.latitude)
		  	$('.loading').hide()
		  	$('#flag').attr('src', 'https://www.countryflags.io/'+data[0].detail.country_code+'/shiny/64.png')
		  },
		  error: function(response){
		  	alert(response.responseText)
		  	console.log(response)
		  	$('.loading').hide()
		  }
		});
	}
	function refreshLocation(){
		location.reload()
	}
var map;
function initMap(lat = 35.6915, lng = 139.7081) {
  map = new google.maps.Map(document.getElementById('map'), {
    center: {lat: lat, lng: lng},
    zoom: 20
  });
}
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
