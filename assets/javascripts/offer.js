
function init() {
  var list = new List("listoffer");
  list.addCard(ASM.AB);
  var qd = JSON.parse(qDat);
  list.cards[0].updateAB(qd.placeida, qd.placeidb);

  document.getElementById("createBtn").onclick = function() {
    var cost = parseFloat(getVal("f1"));
    var capa = parseInt(getVal("f2"));
    var dt = getVal("f3");
    var mdt = moment(dt, "DD-MMM-YYYY HH:mm:ss");
    if(moment().diff(mdt) < 0 &&
    !isNaN(cost) && !isNaN(capa) &&
    cost*100 % 1 == 0 && capa % 1 == 0 && cost > 0 && capa > 0) {
      window.location.href =
        'offer.php?rid=' + rid +
        '&cost=' + cost +
        '&capacity=' + capa +
        '&datetime=' + mdt.format("YYYY-MM-DD HH:mm:ss");
    }else {
      window.location.href =
        'offer.php?rid=' + rid +
        '&err=true';
    }
  }
}
function getVal(id) {
  return document.getElementById(id).value;
}
