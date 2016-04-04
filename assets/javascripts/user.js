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
  }else if(tpe == 20 || tpe == 21 || tpe == 3) {
    for(var i = 0; i < qd.length; i++) {
      list.addCard(tpe == 20 ? ASM.ABTripCancel : (tpe == 21 ? ASM.ABTripBook : ASM.ABTripHistory));
      list.cards[i].updateABTQuery(qd[i]);
      if(tpe == 20) list.cards[i].segs[3].updateBSeg("user.php?user="+uid+"&pg_view=2&cancelid="+qd[i].rideid);
      else if(tpe == 21 && (uid == qd[i].driverid || qd[i].capacity == qd[i].passengers)) list.cards[i].removeSegment(3);
      else if(tpe == 21) list.cards[i].segs[3].updateBSeg("book.php?pID="+uid+"&rID="+qd[i].rideid);
      else {
        qd[i].riderfnames = qd[i].riderfnames.replace(/[{}]/g, "").split(",");
        qd[i].riderlnames = qd[i].riderlnames.replace(/[{}]/g, "").split(",");
        qd[i].riderids = qd[i].riderids.replace(/[{}]/g, "").split(",");
        for(var j = 0; j < qd[i].riderfnames.length; j++) {
          if(qd[i].riderfnames[j] == "NULL") continue;
          list.cards[i].addPassenger(qd[i].riderfnames[j]+" "+qd[i].riderlnames[j], qd[i].riderids[j]);
        }
      }
    }
    if(!qd && tpe == 20) list.addSpecialCard(ASM.makeTextBox);
    if(tpe == 3) {

    }
  }
  //TEMP MAKE FAKE DATA RATHER THAN PULL FROM DB
}
