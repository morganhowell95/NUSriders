function init() {
  var qd = JSON.parse(qDat);
  console.log(qd);
  var list = new List("list");
  if(tpe == 10 || tpe == 11) {
    for(var i = 0; i < qd.length; i++) {
      list.addCard(tpe == 10 ? ASM.ABRoute : ASM.AB);
      list.cards[i].updateAB(qd[i].placeida, qd[i].placeidb);
      if(tpe == 10) list.cards[i].segs[2].updateBSeg("offer.php?rid="+qd[i].routeid);
    }
    if(tpe == 10) list.addSpecialCard(ASM.makeAddRouteBtnCard);
  }else if(tpe == 20 || tpe == 21) {
    for(var i = 0; i < qd.length; i++) {
      list.addCard(tpe == 20 ? ASM.ABTripCancel : ASM.ABTripBook);
      list.cards[i].updateABTQuery(qd[i]);
      if(tpe == 20) list.cards[i].segs[3].updateBSeg("user.php?user="+uid+"&pg_view=2&cancelid="+qd[i].rideid);
      else if(uid == qd[i].driverid || qd[i].capacity == qd[i].passengers) list.cards[i].removeSegment(3);
      else list.cards[i].segs[3].updateBSeg("book.php?pID="+uid+"&rID="+qd[i].rideid);
    }
    if(!qd && tpe == 20) list.addSpecialCard(ASM.makeTextBox);
  }else if(tpe == 3) {
    for(var i = 0; i < 4; i++) {
      list.addCard(ASM.ABTripHistory);
      list.cards[i].addPassenger("admin", "admin@gmail.com");
    }
    list.cards[2].addPassenger("AHaliq", "haliq@nus.edu.sg");
  }
  //TEMP MAKE FAKE DATA RATHER THAN PULL FROM DB
}
