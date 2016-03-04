var objs = [];
var Alb = 'A';
var Blb = 'B';

// GLOBAL VARIABLES ===========================================================

function init() {

  var fromBox = makeSearchBox("pac-input-A");
  var toBox = makeSearchBox("pac-input-B");
  
  var listDOM = document.getElementById("searchList");
  for(var i = 0; i < 12; i++) {
    objs[i] = wrapEntity(makeEntity(i, 2, "book"));

    listDOM.appendChild(objs[i].obj);

    objs[i].map = makeMap(i);
    objs[i].service = loadService(objs[i].map);

    cascadeToPoint(objs[i], objs[i].A);
    cascadeToPoint(objs[i], objs[i].B);

    updateFieldName(objs[i].obj, 0, "From");
    updateFieldName(objs[i].obj, 1, "To");
    // ----------------------------------------------------
    updateDriverName(objs[i].obj, "driver "+i);
    updateMarkers(objs[i],
      "ChIJOdueMVIa2jERhE4TnhWtNpo",
      "ChIJSeUa7KcZ2jERNVg2CvmlVbk");
    //TESTING HARDCODED VALUES ---------------------------
  }
  //-----------------------------------------------------
  setTimeout(function() {
    updateMarkers(objs[2],
      "ChIJHSrGJ5EZ2jERTzbUyme7KuQ",
      "ChIJFQYC8YwZ2jERDRaSlDO1Q0k");
    updateMarkers(objs[4],
      "ChIJb-ErmBYX2jERBl1gF7cPIj4",
      "ChIJVVRNg0oX2jERxH0FUCJhoz4");
}, 10000);
  // TESTING OVERRIDE UPDATE ---------------------------
}

function wrapEntity(entity) {
  return {
    loaded: false,
    obj: entity,
    map: undefined,
    A: point(Alb),
    B: point(Blb),
    markersLoaded: 0
  };
}

function point(lbl) {
  return {
    marker: undefined,
    label: lbl,
    map: undefined,
    service: undefined,
    id: undefined,
    name: undefined,
  };
}

function cascadeToPoint(entity, point) {
  point.map = entity.map;
  point.service = entity.service;
}

// WRAPPER METHODS ------------------------------------------------------------

function updateMarkers(obj, idA, idB) {
  if(obj.A.marker != undefined) obj.A.marker.setMap(null);
  if(obj.B.marker != undefined) obj.B.marker.setMap(null);
  obj.markersLoaded = 0;
  obj.A.id = idA;
  obj.B.id = idB;
  queuePt(obj.A, obj);
  queuePt(obj.B, obj);
}

function markerLoadComplete(obj) {
  updateMapBounds(
    obj.A.marker.getPosition(),
    obj.B.marker.getPosition(),
    obj.map);
  updateFieldValue(obj.obj, 0, obj.A.name);
  updateFieldValue(obj.obj, 1, obj.B.name);
}

// MARKER SETUP METHODS -------------------------------------------------------

/*
1.35, 103.82, 10
'ChIJOdueMVIa2jERhE4TnhWtNpo', 'ChIJSeUa7KcZ2jERNVg2CvmlVbk'
https://developers.google.com/places/place-id
*/
