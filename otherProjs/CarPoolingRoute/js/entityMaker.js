function makeWeird(id) {
  var fields = 2;
  var buttonLabel = "boop";
}
makeWeird.prototype = new makeEntity();
makeWeird.prototype.constructor = makeWeird;

function makeEntity(id, fields, buttonLabel) {
  this.card = document.createElement('div');
  this.card.setAttribute('class', "itemCard");

  this.card.appendChild(makeEntityHead());
  this.card.appendChild(makeEntityMap(id));
  this.card.appendChild(makeEntityDataCont(fields));
  this.card.appendChild(makeButton(buttonLabel));

  this.updateDriverName = function (driver) {
    this.card.childNodes[0].childNodes[1].childNodes[0].nodeValue = driver;
  };

  /** ensure row index exists otherwise it will fuck up */
  this.updateFieldName = function(row, field) {
    this.card.childNodes[2].childNodes[row].childNodes[0].childNodes[0].nodeValue = field;
  }

  this.updateFieldValue = function(row, value) {
    this.card.childNodes[2].childNodes[row].childNodes[1].childNodes[0].nodeValue = value;
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
}

// DOM CREATOR ----------------------------------------------------------------


// DOM EDITOR -----------------------------------------------------------------
