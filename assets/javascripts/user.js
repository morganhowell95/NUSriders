function init() {
  var qd = JSON.parse(qDat);
  var list = new List("list");
  switch(tpe) {
    case 10:
      for(var i = 0; i < qd.length; i++) {
        list.addCard(ASM.ABRoute);
        list.cards[i].updateAB(qd[i].placeida, qd[i].placeidb);
        list.cards[i].segs[2].updateBSeg("offer.php?rid="+qd[i].routeid);
      }
      list.addSpecialCard(ASM.makeAddRouteBtnCard);
    break;
    case 11:
      for(var i = 0; i < 4; i++)
        list.addCard(ASM.AB);
    break;
    case 20:
      for(var i = 0; i < qd.length; i++) {
        list.addCard(ASM.ABTripCancel);
        list.cards[i].updateAB(qd[i].placeida, qd[i].placeidb);
        list.cards[i].segs[0].updateUSeg(qd[i].first_name + " " + qd[i].last_name, qd[i].driverid);
        list.cards[i].dseg.rows[2].updateDRSeg(undefined, qd[i].startdt);
        var capa = parseInt(qd[i].capacity);
        var pass = parseInt(qd[i].passengers);
        list.cards[i].dseg.rows[3].updateDRSeg(undefined, (capa - pass) + " seats left out of " + capa);
        list.cards[i].dseg.rows[4].updateDRSeg(undefined, "$"+qd[i].cost);
        list.cards[i].segs[3].updateBSeg("user.php?user="+uid+"&pg_view=2&cancelid="+qd[i].rideid);
      }
      if(!qd) {
        list.addSpecialCard(ASM.makeTextBox);
      }
    break;
    case 21:
      for(var i = 0; i < 4; i++)
        list.addCard(ASM.ABTripBook);
      //TODO IF CAPACITY IS FULL, make without book button
    break;
    case 3:
      for(var i = 0; i < 4; i++) {
        list.addCard(ASM.ABTripHistory);
        list.cards[i].addPassenger("admin", "admin@gmail.com");
      }
      list.cards[2].addPassenger("AHaliq", "haliq@nus.edu.sg");
    break;
  }
  //TEMP MAKE FAKE DATA RATHER THAN PULL FROM DB
}
