function init() {
  var qd = JSON.parse(qDat);
  for(var i = 0; i < qd.length; i++) {
    console.log(qd[i]);
  }
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
      for(var i = 0; i < 4; i++)
        list.addCard(ASM.ABTripCancel);
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
