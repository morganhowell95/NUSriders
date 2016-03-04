
function init() {

  var fromBox = makeSearchBox("pac-input-A");
  var toBox = makeSearchBox("pac-input-B");

  var list = new makeList("searchList", "sl", makerTest);

  for(var i = 0; i < 13; i++) {
    var ent = list.addEntity();
    // create entity
    ent.intf.updateFieldName(0, "From");
    ent.intf.updateFieldName(1, "To");
    ent.intf.updateDriverName("driver"+ i.toString());
    list.updateMarkers(i,
      "ChIJOdueMVIa2jERhE4TnhWtNpo",
      "ChIJSeUa7KcZ2jERNVg2CvmlVbk");
    // concrete implementation of post initializing entities
  }
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

  var makerTest = function(id) {
    makeEntity.call(id, 2, "book");
  }
}
