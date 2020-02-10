<!DOCTYPE html>
<html lang="en">
	<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> {{getcong('site_name')}} Admin</title>

	<link href="{{ URL::asset('upload/'.getcong('site_favicon')) }}" rel="shortcut icon" type="image/x-icon" />
	<link rel="stylesheet" href="{{ URL::asset('admin_assets/css/style.css') }}">
	
	<script src="{{ URL::asset('admin_assets/js/jquery.js') }}"></script>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

</head>

<body class="sidebar-push  sticky-footer">
     
     	<!-- BEGIN TOPBAR -->
         
         @include("admin.topbar")
         
        <!-- END TOPBAR -->

	      <!-- BEGIN SIDEBAR -->
	       
	       @include("admin.sidebar")
	      
	      <!-- END SIDEBAR -->
  		<div class="container-fluid">
  		
 		   @yield("content")
 		   
	 		<div class="footer">
				<a href="{{ URL::to('admin/dashboard') }}" class="brand">
					{{getcong('site_name')}}
				</a>
				<ul>
					 
				</ul>
			</div>
  		</div>


  <div class="overlay-disabled"></div>


  <!-- Plugins -->
  <script src="{{ URL::asset('admin_assets/js/plugins.min.js') }}"></script>

  
  <!-- Loaded only in index.html for demographic vector map-->
  <script src="{{ URL::asset('admin_assets/js/jvectormap.js') }}"></script>
  
  <!-- App Scripts -->
  <script src="{{ URL::asset('admin_assets/js/scripts.js') }}"></script>
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


</body>
 
</html>   
     		   
     		    