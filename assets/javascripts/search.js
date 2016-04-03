function init() {
  var qd = JSON.parse(qDat);
  var fromBox = GUTIL.makeSearchBox("pac-input-A");
  var toBox = GUTIL.makeSearchBox("pac-input-B");

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
//TODO pull latLngAB from searchboxes and dt from field
//TODO make DOM for refine search button and send GET variables on click
//TODO book button should insert proposal to DB
//TODO user page 3 should generate cards based on DB of advertizement that has passed currentDT
//TOCONSIDER there is no transaction, there is no ride complete, there is no currency alteration
