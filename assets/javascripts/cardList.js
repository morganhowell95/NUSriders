function List(id) {
  this.id = id;
  this.dom = document.getElementById(id);
  this.cards = [];
  this._ri = 0;
}
List.prototype.addCard = function(assembler) {
  var card = ASM.makeCardBase();
  assembler(card, this.id + (this._ri++));
  this.cards.push(card);
  this.dom.appendChild(card);
}
List.prototype.addSpecialCard = function(specialCardConstr) {
  var card = specialCardConstr();
  this.cards.push(card);
  this.dom.appendChild(card);
}
List.prototype.removeCard = function(index) {
  this.dom.removeChild(this.cards[index]);
  this.cards.splice(index,1);
}

var ASM = {
  makeDiv : function(className, idName) {
    var obj = document.createElement("div");
    obj.setAttribute("class", className);
    if(idName != undefined) obj.setAttribute("id", idName);
    return obj;
  },
  makeDivText : function(className, txt, idName) {
    var obj = ASM.makeDiv(className, idName);
    obj.txtNode = document.createTextNode(txt);
    obj.appendChild(obj.txtNode);
    obj.updateTxt = ASM._updateTxt;
    return obj;
  },
  _updateTxt  : function(val) {
    this.txtNode.nodeValue = val;
  },
  makeImg : function(src) {
    var obj = document.createElement("img");
    obj.src = src;
    return obj;
  },
  // PRIMITIVE DIV MAKERS =======================
  makeCardBase  : function() {
    var card = ASM.makeDiv("itemCard");
    card.segs = [];
    card.appendSegment = ASM._appendSegment;
    card.removeSegment = ASM._removeSegment;
    return card;
  },
  _appendSegment : function(seg) {
    this.segs.push(seg);
    this.appendChild(seg);
  },
  _removeSegment : function(index) {
    this.removeChild(this.segs[index]);
    this.segs.splice(index,1);
  },
  makeUserSegment : function() {
    var seg = ASM.makeDiv("userIC");
    var imgCont = ASM.makeDiv("userIconIC");
    imgCont.appendChild(ASM.makeImg("assets/images/userIcon.png"));
    seg._nmeCont = ASM.makeDivText("userNameIC", "-");
    seg.appendChild(imgCont);
    seg.appendChild(seg._nmeCont);
    seg.updateUSeg = ASM._updateUSeg;
    return seg;
  },
  _updateUSeg : function(name, email) {
    this._nmeCont.updateTxt(name);
    this.onclick = function() {
      window.location.href = "./userprofile.php?user="+email;
    }
  },
  makeMapSegment : function(mapID) {
    return ASM.makeDiv("mapIC", "map" + mapID);
  },
  makeDataSegment : function() {
    var seg = ASM.makeDiv("dataIC");
    seg.rows = [];
    seg.makeDataRowSegment = ASM._makeDataRowSegment;
    seg.removeDataRowSegment = ASM._removeDataRowSegment;
    for(var i = 0; i < arguments.length; i++) {
      seg.makeDataRowSegment(arguments[i]);
    }
    return seg;
  },
  _removeDataRowSegment : function(index) {
    this.removeChild(this.rows[index]);
    this.rows.splice(index,1);
  },
  _makeDataRowSegment : function(fnme, fval) {
    var seg = ASM.makeDiv("dataPartitionIC");
    seg._fnm = ASM.makeDivText("iconDPIC pIC", fnme == undefined ? "-" : fnme);
    seg._fva = ASM.makeDivText("valueDPIC pIC", fval == undefined ? "-" : fval);
    seg.appendChild(seg._fnm);
    seg.appendChild(seg._fva);
    seg.updateDRSeg = ASM._updateDRSeg;
    this.appendChild(seg);
    this.rows.push(seg);
  },
  _updateDRSeg : function(fname, fvalue) {
    if(fname != undefined) this._fnm.updateTxt(fname);
    if(fvalue != undefined) this._fva.updateTxt(fvalue);
  },
  makeButtonSegment : function(label, cdat) {
    var seg = ASM.makeDivText("btnIC", label);
    seg.clickdata = cdat;
    seg.updateBSeg = ASM._updateBSeg;
    seg.onclick = ASM._BSegClick;
    return seg;
  },
  _updateBSeg : function(cdat) {
    this.clickdata = cdat;
  },
  _BSegClick : function() {
    window.location.href = this.clickdata;
  },
  makeAddBtnCard : function(label, action) {
    var seg = ASM.makeDiv("btnCard");
    var imgCont = ASM.makeDiv("btnIconIC");
    imgCont.appendChild(ASM.makeImg("assets/images/addIcon.png"));
    seg.appendChild(imgCont);
    var lbl = ASM.makeDivText("btnLabelCont", label);
    seg.appendChild(lbl);
    seg.onclick = action;
    return seg;
  },
  makeAddRouteBtnCard : function() {
    return ASM.makeAddBtnCard("ADD NEW ROUTE", ASM._AddRouteNav);
  },
  _AddRouteNav : function() {
    window.location.href = "./create.php";
  },
  makeTextBox : function() {
    return ASM.makeDivText("txtBoxCard", "no rides to show, why not book or create one from your routes?");
  },
  // CARD FACTORY ===============================
  AB : function(card, id) {
    var mseg = ASM.makeMapSegment(id);
    var dseg = ASM.makeDataSegment("From", "To");
    card.appendSegment(mseg);
    card.appendSegment(dseg);
    // assemble
    card.dseg = dseg;
    card.dsegA = dseg.rows[0];
    card.dsegB = dseg.rows[1];
    // keep references to data fields
    card.gMapObj = GUTIL.makeMap(mseg);
    card.gSerObj = GUTIL.makeService(card.gMapObj);
    card.gMarkers = [
      GUTIL.makeMarker(card.gMapObj, "A"),
      GUTIL.makeMarker(card.gMapObj, "B")];
    // create and keep references to google objects
    card.mLoaded = [false, false];
    // flag to track marker loaded states
    for(var i = 0; i < card.gMarkers.length; i++)
      card.gMarkers[i].card = card;
    // give markers reference to parent for callback processing
    card.updateAB = ASM._updateAB;
  },
  _updateAB : function() {
    for(var i = 0; i < arguments.length && this.gMarkers.length; i++) {
      this.mLoaded[i] = false;
      if(arguments[i] == undefined) continue;
      this.gMarkers[i].id = arguments[i];
      GUTIL.resolveIDtoPlace(this.gSerObj, arguments[i], this.gMarkers[i], ASM._ABresCallback);
    }
  },
  _ABresCallback : function(gMarker) {
    switch(gMarker.getLabel()) {
      case "A" :
        gMarker.card.dsegA.updateDRSeg(undefined, gMarker.placeName);
        gMarker.card.mLoaded[0] = true;
      break;
      case "B" :
        gMarker.card.dsegB.updateDRSeg(undefined, gMarker.placeName);
        gMarker.card.mLoaded[1] = true;
      break;
    }
    //* potential error if same marker gets updated twice and latest update
    // arrives before old update
    // update placename
    if(gMarker.card.mLoaded[0] && gMarker.card.mLoaded[1])
      GUTIL.setMapBounds(
        gMarker.card.gMapObj,
        gMarker.card.gMarkers[0],
        gMarker.card.gMarkers[1]);
    // update map bounds and zoom onall loaded
  },
  ABTrip : function(card, id, label) {
    card.appendSegment(ASM.makeUserSegment());
    ASM.AB(card, id);
    var apFl = ["Trip Start", "Capacity", "Cost to Join"];
    for(var i = 0; i< apFl.length; i++)
      card.dseg.makeDataRowSegment(apFl[i]);
    if(label != undefined) card.appendSegment(ASM.makeButtonSegment(label));
    card.updateABTQuery = ASM._updateABTQuery;
  },
  _updateABTQuery : function(qd) {
    this.updateAB(qd.placeida, qd.placeidb);
    this.segs[0].updateUSeg(qd.first_name + " " + qd.last_name, qd.driverid);
    this.dseg.rows[2].updateDRSeg(undefined, qd.startdt);
    var capa = parseInt(qd.capacity);
    var pass = parseInt(qd.passengers);
    this.dseg.rows[3].updateDRSeg(undefined, (capa - pass) + " seats left out of " + capa);
    this.dseg.rows[4].updateDRSeg(undefined, "$"+qd.cost);
  },
  ABTripBook : function(card, id) {
    ASM.ABTrip(card, id, "Book");
  },
  ABTripCancel : function(card, id) {
    ASM.ABTrip(card, id, "Cancel");
  },
  ABTripHistory : function(card, id) {
    ASM.ABTrip(card, id);
    card.addPassenger = ASM._addPassenger;
  },
  _addPassenger : function(passenger, email) {
    var uSeg = ASM.makeUserSegment();
    uSeg.updateUSeg(passenger, email);
    this.appendSegment(uSeg);
  },
  ABRoute : function(card, id) {
    ASM.AB(card,id);
    card.appendSegment(ASM.makeButtonSegment("Offer"));
  }
  // ASSEMBLERS =================================
};
