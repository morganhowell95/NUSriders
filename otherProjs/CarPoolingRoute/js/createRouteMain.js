
function init() {
  var origin_place_id = null;
  var destination_place_id = null;
  var origin_place_obj = null;
  var destination_place_obj = null;
  var travel_mode = google.maps.TravelMode.DRIVING;
  // declare route data

  // CONSTRUCTOR ==============================================================
  var map = makeMap("R");
  map.zoom = 12;
  map.disableDefaultUI =  false;
  map.keyboardShortcuts = true;
  map.scrollwheel = true;
  map.navigationControl = true;
  map.scaleControl = true;
  map.draggable = true;
  var directionsService = new google.maps.DirectionsService;
  var directionsDisplay = new google.maps.DirectionsRenderer;
  directionsDisplay.setMap(map);
  // initialize map

  var origin_input = document.getElementById('origin-input');
  var destination_input = document.getElementById('destination-input');
  var btn_input = document.getElementById('btn');
  map.controls[google.maps.ControlPosition.TOP_CENTER].push(document.getElementById('inputContainer'));
  map.controls[google.maps.ControlPosition.BOTTOM_CENTER].push(btn_input);
  // initialize fields

  var origin_autocomplete =
    new google.maps.places.Autocomplete(origin_input);
  origin_autocomplete.bindTo('bounds', map);
  var destination_autocomplete =
    new google.maps.places.Autocomplete(destination_input);
  destination_autocomplete.bindTo('bounds', map);
  origin_autocomplete.addListener('place_changed', function() {
    var place = origin_autocomplete.getPlace();
    if (!place.geometry) { return; }
    expandViewportToFitPlace(map, place);

    origin_place_id = place.place_id;
    origin_place_obj = place;
    route(origin_place_id, destination_place_id, travel_mode,
          directionsService, directionsDisplay);
  });
  destination_autocomplete.addListener('place_changed', function() {
    var place = destination_autocomplete.getPlace();
    if (!place.geometry) { return; }
    expandViewportToFitPlace(map, place);

    destination_place_id = place.place_id;
    destination_place_obj = place;
    route(origin_place_id, destination_place_id, travel_mode,
          directionsService, directionsDisplay);
  });
  // setup searchboxes

  btn_input.style.display  = "none";
  btn_input.onclick = function() {
    alert("From " + origin_place_obj.name + origin_place_obj.geometry.location + " to " + destination_place_obj.name + destination_place_obj.geometry.location);
  }
  // setup button

  // METHODS ==================================================================
  function expandViewportToFitPlace(map, place) {
    if (place.geometry.viewport) {
      map.fitBounds(place.geometry.viewport);
    } else {
      map.setCenter(place.geometry.location);
      map.setZoom(17);
    }
  }
  function route(origin_place_id, destination_place_id, travel_mode,
                 directionsService, directionsDisplay) {
    if (!origin_place_id || !destination_place_id) {
      btn_input.style.display = "none";
      return;
    }
    btn_input.style.display = "block";
    directionsService.route({
      origin: {'placeId': origin_place_id},
      destination: {'placeId': destination_place_id},
      travelMode: travel_mode
    }, function(response, status) {
      if (status === google.maps.DirectionsStatus.OK) {
        directionsDisplay.setDirections(response);
      } else {
        window.alert('Directions request failed due to ' + status);
      }
    });
  }
}
