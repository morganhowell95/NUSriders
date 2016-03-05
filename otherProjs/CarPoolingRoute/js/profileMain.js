function init() {
  var rList = new List("rList", "rl", makeRTP);
  var pList = new List("pList", "pl", makeAB);
  for(i = 0; i < 3; i++) {
  rList.addEntity();
  pList.addEntity();
}
}
