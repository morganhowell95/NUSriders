/**
Manages a list dom that creates and destroys entities
@param  domID:String    id in html to the div to be a list
@param  id:String       unique id for the list so as not to clash with other lists
@param  TODO make entityMaker Object that specifies fields/entity structure
*/
function makeList(domID, id) {

  // PROPERTIES================================================================

  /** reference to dom object of list */
  this.listDOM = document.getElementById(domID);
  /** array of entity doms */
  this.objs = [];

  // METHODS ==================================================================
  /** Creates a new entity */
  this.addEntity = function(){
    console.log("add");
    var curID = id + this.objs.length.toString();
    var entity = wrapEntity(makeEntity(curID, 2, "book"));
    this.listDOM.appendChild(entity.obj);
    //TODO temp 2

    this.objs.push(entity);
    entity.map = makeMap(curID);
    entity.service = loadService(entity.map);

    cascadeToPoint(entity, entity.A);
    cascadeToPoint(entity, entity.B);

    //TEMP
    updateFieldName(entity.obj, 0, "From");
    updateFieldName(entity.obj, 1, "To");
    updateDriverName(entity.obj, "driver"+ this.objs.length.toString());
    this.updateMarkers(this.objs.length - 1,
      "ChIJOdueMVIa2jERhE4TnhWtNpo",
      "ChIJSeUa7KcZ2jERNVg2CvmlVbk");
    //END OF TEMP
  }
  /** Remove the last entity created */
  this.removeLastEntity = function(){
    listDOM.removeChild(objs.pop());
  }
  /** declare dom object into entity wrapper */
  function wrapEntity(entity) {
    return {
      loaded: false,
      obj: entity,
      map: undefined,
      A: point(Alb),
      B: point(Blb),
      markersLoaded: 0
    };
  }
  /** create point object */
  function point(lbl) {
    return {
      marker: undefined,
      label: lbl,
      map: undefined,
      service: undefined,
      id: undefined,
      name: undefined,
    };
  }
  /** pass google map object references to point object */
  function cascadeToPoint(entity, point) {
    point.map = entity.map;
    point.service = entity.service;
  }
  /** change entity at index the marker's placeID
  @param  index:int   index of entity
  @param  idA:String  google API placeID
  @param  idB:String  google API placeID */
  this.updateMarkers = function(index, idA, idB) {
    var obj = this.objs[index];
    if(obj.A.marker != undefined) obj.A.marker.setMap(null);
    if(obj.B.marker != undefined) obj.B.marker.setMap(null);
    obj.markersLoaded = 0;
    obj.A.id = idA;
    obj.B.id = idB;
    queuePt(obj.A, obj);
    queuePt(obj.B, obj);
  }
}

/*
1.35, 103.82, 10
'ChIJOdueMVIa2jERhE4TnhWtNpo', 'ChIJSeUa7KcZ2jERNVg2CvmlVbk'
https://developers.google.com/places/place-id
*/
