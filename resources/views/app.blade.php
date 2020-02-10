<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>@yield('head_title', getcong('site_name'))</title>
<meta name="viewport"content="width=device-width, initial-scale=1.0">
<meta name="description" content="@yield('head_description', getcong('site_description'))" />

<meta property="og:type" content="article" />
<meta property="og:title" content="@yield('head_title',  getcong('site_name'))" />
<meta property="og:description" content="@yield('head_description', getcong('site_description'))" />
<meta property="og:image" content="@yield('head_image', url('/upload/logo.png'))" />
<meta property="og:url" content="@yield('head_url', url('/'))" />
<!-- Favicons-->
	<link rel="shortcut icon" href="{{ URL::asset('upload/'.getcong('site_favicon')) }}" type="image/x-icon">
<!--MAIN STYLE-->
<link href="{{ URL::asset('site_assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ URL::asset('site_assets/css/main.css') }}" rel="stylesheet" type="text/css">
<link href="{{ URL::asset('site_assets/css/style.css') }}" rel="stylesheet" type="text/css">
<link href="{{ URL::asset('site_assets/css/animate.css') }}" rel="stylesheet" type="text/css">
<link href="{{ URL::asset('site_assets/css/responsive.css') }}" rel="stylesheet" type="text/css">
<link href="{{ URL::asset('site_assets/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">

{!!getcong('site_header_code')!!}

</head>
<body> 
	<div id="wrap" class="home-1">
	 	@include("_particles.header")  
	 	
	 	@yield("content")
	 	
	 	@include("_particles.footer")
	 	
	 
	 
  <div class="rights">
    <div class="container">
      <p class="font-montserrat">
	  </p>
    </div>
  </div>

<script src="{{ URL::asset('site_assets/js/jquery-1.11.0.min.js') }}"></script>
<script src="{{ URL::asset('site_assets/js/bootstrap.min.js') }}"></script>
 
<script src="{{ URL::asset('site_assets/js/jquery.flexslider-min.js') }}"></script> 
<script src="{{ URL::asset('site_assets/js/jquery.nouislider.min.js') }}"></script>
<script src="{{ URL::asset('site_assets/js/jquery.sticky.js') }}"></script> 
<script src="{{ URL::asset('site_assets/js/jquery.stellar.js') }}"></script> 
<script src="{{ URL::asset('site_assets/js/owl.carousel.min.js') }}"></script> 
<script src="{{ URL::asset('site_assets/js/wow.min.js') }}"></script> 
<script src="{{ URL::asset('site_assets/js/own-menu.js') }}"></script>  
<script src="{{ URL::asset('site_assets/js/main.js') }}"></script> 
<script src="{{ URL::asset('site_assets/js/nav_menu.js') }}"></script>
<script src="{{ URL::asset('site_assets/js/functions.js') }}"></script> 
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDIyS6WVbba8xmi0b67B08rGte5DJBTjKE&libraries=places&callback=initialize" async defer></script>
  <script>
	 function initialize() {

$('form').on('keyup keypress', function(e) {
  var keyCode = e.keyCode || e.which;
  if (keyCode === 13) {
	  e.preventDefault();
	  return false;
  }
});
const locationInputs = document.getElementsByClassName("map-input");

const autocompletes = [];
const geocoder = new google.maps.Geocoder;
for (let i = 0; i < locationInputs.length; i++) {

  const input = locationInputs[i];
  const fieldKey = input.id.replace("-input", "");
  const isEdit = document.getElementById(fieldKey + "-latitude").value != '' && document.getElementById(fieldKey + "-longitude").value != '';

  const latitude = parseFloat(document.getElementById(fieldKey + "-latitude").value) || -33.8688;
  const longitude = parseFloat(document.getElementById(fieldKey + "-longitude").value) || 151.2195;

  const map = new google.maps.Map(document.getElementById(fieldKey + '-map'), {
	  center: {lat: latitude, lng: longitude},
	  zoom: 13
  });
  const marker = new google.maps.Marker({
	  map: map,
	  position: {lat: latitude, lng: longitude},
  });

  marker.setVisible(isEdit);

  const autocomplete = new google.maps.places.Autocomplete(input);
  autocomplete.key = fieldKey;
  autocompletes.push({input: input, map: map, marker: marker, autocomplete: autocomplete});
}

for (let i = 0; i < autocompletes.length; i++) {
  const input = autocompletes[i].input;
  const autocomplete = autocompletes[i].autocomplete;
  const map = autocompletes[i].map;
  const marker = autocompletes[i].marker;

  google.maps.event.addListener(autocomplete, 'place_changed', function () {
	  marker.setVisible(false);
	  const place = autocomplete.getPlace();

	  geocoder.geocode({'placeId': place.place_id}, function (results, status) {
		  if (status === google.maps.GeocoderStatus.OK) {
			  const lat = results[0].geometry.location.lat();
			  const lng = results[0].geometry.location.lng();
			  setLocationCoordinates(autocomplete.key, lat, lng);
		  }
	  });

	  if (!place.geometry) {
		  window.alert("No details available for input: '" + place.name + "'");
		  input.value = "";
		  return;
	  }

	  if (place.geometry.viewport) {
		  map.fitBounds(place.geometry.viewport);
	  } else {
		  map.setCenter(place.geometry.location);
		  map.setZoom(17);
	  }
	  marker.setPosition(place.geometry.location);
	  marker.setVisible(true);

  });
}
}

function setLocationCoordinates(key, lat, lng) {
const latitudeField = document.getElementById(key + "-" + "latitude");
const longitudeField = document.getElementById(key + "-" + "longitude");
latitudeField.value = lat;
longitudeField.value = lng;
}
</script>
 
</div>
</body>
</html>