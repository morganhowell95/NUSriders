
function init() {
  // make map using AB<<<

  var list = new List("listoffer");
  list.addCard(ASM.AB);
  var qd = JSON.parse(qDat);
  list.cards[0].updateAB(qd.placeida, qd.placeidb);
}
