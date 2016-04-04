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
    list.cards[i].updateAB(qd[i].placeida, qd[i].placeidb);
    list.cards[i].segs[0].updateUSeg(qd[i].first_name + " " + qd[i].last_name, qd[i].driverid);
    list.cards[i].dseg.rows[2].updateDRSeg(undefined, qd[i].startdt);
    var capa = parseInt(qd[i].capacity);
    var pass = parseInt(qd[i].passengers);
    list.cards[i].dseg.rows[3].updateDRSeg(undefined, (capa - pass) + " seats left out of " + capa);
    list.cards[i].dseg.rows[4].updateDRSeg(undefined, "$"+qd[i].cost);
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
  if(rawDt == "") {
    // no time deviation
  }else {
    var dt = moment(rawDt, "DD-MMM-YYYY HH:mm:ss").format("YYYY-MM-DD HH:mm:ss");
  }
  // time deviation*/
}
//TODO book button should insert proposal to DB
//TODO user page 3 should generate cards based on DB of advertizement that has passed currentDT
//TOCONSIDER there is no transaction, there is no ride complete, there is no currency alteration
