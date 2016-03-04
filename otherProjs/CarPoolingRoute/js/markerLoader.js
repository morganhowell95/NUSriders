var ptArr = [];
var loading = false;

// GLOBAL VARIABLES ===========================================================

function queuePt(pt, parent) {
  ptArr.push({pt: pt, pr: parent});
  if(!loading) {
    loading = true;
    startLoading();
  }
}

function startLoading() {
  var dat = ptArr.shift();
  var pt = dat.pt;
  var pr = dat.pr;
  loadMarker(pt.service, pt.map, pt.label, pt.id, function(marker,name) {
    if(name == undefined) {
      loading = false;
      setTimeout(function() {
        queuePt(pt, pr);
      }, 0);
    } else{
      pt.name = name;
      pt.marker = marker;
      pr.markersLoaded++;
      if(pr.markersLoaded == 2) {
        pr.loaded = true;
        markerLoadComplete(pr);
      }
      if(ptArr.length > 0) {
        setTimeout(function(){
          startLoading();
        }, 0);
      }else {
        loading = false;
      }
    }
  });
}

function markerLoadComplete(obj) {
  updateMapBounds(
    obj.A.marker.getPosition(),
    obj.B.marker.getPosition(),
    obj.map);
  updateFieldValue(obj.obj, 0, obj.A.name);
  updateFieldValue(obj.obj, 1, obj.B.name);
}
