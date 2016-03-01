function makeMap(id) {
  var mapDiv = document.getElementById("map" + id);
  // get map DOM div object

  return new google.maps.Map(mapDiv, {
    center: {lat: 1.35, lng: 103.82},
    zoom: 10,
    disableDefaultUI: true,
    keyboardShortcuts: false,
    scrollwheel: false,
    navigationControl: false,
    mapTypeControl: false,
    scaleControl: false,
    draggable: false
  });
}

function loadService(map) {
  return new google.maps.places.PlacesService(map);
}

function loadMarker(service, map, label, placeId, callback) {
  service.getDetails({
    placeId: placeId
  }, function(place, status) {
    if(status == "OK") {
      var marker = new google.maps.Marker({
        map: map,
        position: place.geometry.location,
        label: label
      });
      callback(marker, place.name);
    }else {
      callback(undefined, undefined);
    }
  });
}

function updateMapBounds(posA, posB, map) {
  var bounds = new google.maps.LatLngBounds();
  bounds.extend(posA);
  bounds.extend(posB);
  map.fitBounds(bounds);
}
