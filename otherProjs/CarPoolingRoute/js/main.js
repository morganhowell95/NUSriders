var objs = [];
var Alb = 'A';
var Blb = 'B';

// GLOBAL VARIABLES ===========================================================

function init() {

  var fromBox = makeSearchBox("pac-input-A");
  var toBox = makeSearchBox("pac-input-B");

  var list = new makeList("searchList", "sl");

  for(var i = 0; i < 13; i++) {
    list.addEntity();
  }
  console.log(list.objs);
  //-----------------------------------------------------
  setTimeout(function() {
    list.updateMarkers(2,
      "ChIJHSrGJ5EZ2jERTzbUyme7KuQ",
      "ChIJFQYC8YwZ2jERDRaSlDO1Q0k");
    list.updateMarkers(4,
      "ChIJb-ErmBYX2jERBl1gF7cPIj4",
      "ChIJVVRNg0oX2jERxH0FUCJhoz4");
  }, 10000);
  // TESTING OVERRIDE UPDATE ---------------------------
}
