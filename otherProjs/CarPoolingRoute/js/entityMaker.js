
function makeEntity(id, fields, buttonLabel) {
  var card = document.createElement('div');
  card.setAttribute('class', "itemCard");

  card.appendChild(makeEntityHead());
  card.appendChild(makeEntityMap(id));
  card.appendChild(makeEntityDataCont(fields));
  card.appendChild(makeButton(buttonLabel));

  return card;
}

function makeEntityHead() {
  var cont = document.createElement('div');
  cont.setAttribute('class', "userIC");

  var icCn = document.createElement('div');
  icCn.setAttribute('class', "userIconIC");

  var icIm = document.createElement('img');
  icIm.src = "../img/userIcon3.png";
  //TODO load from db? else default

  var icNm = document.createElement('div');
  icNm.setAttribute('class', "userNameIC");
  icNm.appendChild(document.createTextNode("-"));

  icCn.appendChild(icIm);
  cont.appendChild(icCn);
  cont.appendChild(icNm);

  cont.onclick = function() {
    alert("go to user page");
  }
  return cont;
}

function makeEntityMap(id) {
  var cont = document.createElement('div');
  cont.setAttribute('class', "mapIC");
  cont.setAttribute('id', "map" + id);
  return cont;
}

function makeEntityDataCont(fields) {
  var cont = document.createElement('div');
  cont.setAttribute('class', "dataIC");
  for(var i = 0; i < fields; i++) {
    cont.appendChild(makeEntityDataRow());
  }
  return cont;
}

function makeEntityDataRow() {
  var cont = document.createElement('div');
  cont.setAttribute('class', "dataPartitionIC");

  var ficon = document.createElement('div');
  ficon.setAttribute('class', "iconDPIC pIC");
  ficon.appendChild(document.createTextNode("-"));

  var fvalu = document.createElement('div');
  fvalu.setAttribute('class', "valueDPIC pIC");
  fvalu.appendChild(document.createTextNode("-"));

  cont.appendChild(ficon);
  cont.appendChild(fvalu);
  return cont;
}

function makeButton(label) {
  var cont = document.createElement('div');
  cont.setAttribute('class', "btnIC");
  cont.appendChild(document.createTextNode(label));

  cont.onclick = function() {
    alert("do something");
  }

  return cont;
}

// DOM CREATOR ----------------------------------------------------------------

function updateDriverName(card, driver) {
  card.childNodes[0].childNodes[1].childNodes[0].nodeValue = driver;
}
function updateFieldName(card, row, field) {
  card.childNodes[2].childNodes[row].childNodes[0].childNodes[0].nodeValue = field;
}
function updateFieldValue(card, row, value) {
  card.childNodes[2].childNodes[row].childNodes[1].childNodes[0].nodeValue = value;
}

// DOM EDITOR -----------------------------------------------------------------
