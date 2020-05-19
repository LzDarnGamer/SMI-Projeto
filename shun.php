<!DOCTYPE html>
<html>

<style>
	#map {
  height: 100%;
}

html,
body {
  height: 100%;
  margin: 0;
  padding: 0;
}

#my-input-searchbox {
  box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.16), 0 0 0 1px rgba(0, 0, 0, 0.08);
  font-size: 15px;
  border-radius: 3px;
  border: 0;
  margin-top: 10px;
  width: 270px;
  height: 40px;
  text-overflow: ellipsis;
  padding: 0 1em;
}
</style>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBHfVOvuyvRGhi41p2KHLbSEbUHPg1buKk&libraries=places"></script>
<script>
		function initAutocomplete() {
  var map = new google.maps.Map(document.getElementById('map'), {
    center: {
      lat: 48,
      lng: 4
    },
    zoom: 4,
    disableDefaultUI: true
  });

  // Create the search box and link it to the UI element.
  var input = document.getElementById('my-input-searchbox');
  var autocomplete = new google.maps.places.Autocomplete(input);
  map.controls[google.maps.ControlPosition.TOP_CENTER].push(input);
  var marker = new google.maps.Marker({
    map: map
  });

  // Bias the SearchBox results towards current map's viewport.
  autocomplete.bindTo('bounds', map);
  // Set the data fields to return when the user selects a place.
  autocomplete.setFields(
    ['address_components', 'geometry', 'name']);

  // Listen for the event fired when the user selects a prediction and retrieve
  // more details for that place.
  autocomplete.addListener('place_changed', function() {
    var place = autocomplete.getPlace();
    if (!place.geometry) {
      console.log("Returned place contains no geometry");
      return;
    }
    var bounds = new google.maps.LatLngBounds();
    marker.setPosition(place.geometry.location);

    if (place.geometry.viewport) {
      // Only geocodes have viewport.
      bounds.union(place.geometry.viewport);
    } else {
      bounds.extend(place.geometry.location);
    }
    map.fitBounds(bounds);
    var lat = marker.getPosition().lat();
	var lng = marker.getPosition().lng();
	console.log(lat);
	console.log(lng);
  });
}
document.addEventListener("DOMContentLoaded", function(event) {
  initAutocomplete();
});
</script>
<body>
	<input id="my-input-searchbox" type="text" placeholder="Autocomplete Widget">
	<div id="map"></div>
</body>
</html>
