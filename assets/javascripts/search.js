var fromBox;
var toBox;
var dtBox = document.getElementById("pac-input-DT");
var oldVal = dtBox.value;
function init() {
  var qd = JSON.parse(qDat);
  fromBox = GUTIL.makeSearchBox("pac-input-A");
  toBox = GUTIL.makeSearchBox("pac-input-B");
  fromBox.addListener('places_changed', refineSearch);
  toBox.addListener('places_changed', refineSearch);
  window.addEventListener("focus", function() {
    var newVal = dtBox.value;
    if(newVal != oldVal) {
      oldVal = newVal;
      refineSearch();
    }
  });

  var list = new List("list");
  for(var i = 0; i < qd.length; i++) {
    list.addCard(ASM.ABTripBook);
    list.cards[i].updateABTQuery(qd[i]);
    if(uid == qd[i].driverid) list.cards[i].removeSegment(3);
    else list.cards[i].segs[3].updateBSeg("book.php?pID="+uid+"&rID="+qd[i].rideid);
    //list.cards[i].segs[3].updateBSeg("user.php?user="+uid+"&pg_view=2&cancelid="+qd[i].rideid);
  }
}

function refineSearch() {
  if(fromBox.getPlaces() == undefined || fromBox.getPlaces().length == 0 ||
  toBox.getPlaces() == undefined || toBox.getPlaces().length == 0) return;
  var latA = fromBox.getPlaces()[0].geometry.location.lat();
  var lngA = fromBox.getPlaces()[0].geometry.location.lng();
  var latB = toBox.getPlaces()[0].geometry.location.lat();
  var lngB = toBox.getPlaces()[0].geometry.location.lng();
  var rawDt = dtBox.value;
  var navURL = "search.php?latA="+latA+"&lngA="+lngA+"&latB="+latB+"&lngB="+lngB;
  if(rawDt != "") {
    var dt = moment(rawDt, "DD-MMM-YYYY HH:mm:ss").format("YYYY-MM-DD HH:mm:ss");
    navURL += "&dt="+dt;
  }
  window.location.href = navURL;
  // time deviation*/
}
//TOCONSIDER there is no transaction, there is no ride complete, there is no currency alteration
