function init() {
  var rList = new List("rList", "rl");
  var pList = new List("pList", "pl");
  for(i = 0; i < 3; i++) {
    rList.addEntity(makeRTP);
    pList.addEntity(makeAB);
  }
  rList.addEntity(makeAddRouteBtn, false);
}
