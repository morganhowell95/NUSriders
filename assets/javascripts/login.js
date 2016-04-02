
var getDom = function(id) { return document.getElementById(id); }
var forEch = function(arr, func) {
	for(var i = 0; i < arr.length; i++) func(arr[i]);
}
var setf = function(fld) {
	fld.required = false;
	fld.classList.add("hidden");
}
var unsetf = function(fld) {
	fld.required = true;
	fld.classList.remove("hidden");
}
var tog = getDom("reglogToggle");
var regisFields = [getDom("f1"), getDom("f2"), getDom("f5")];
var loginFields = [getDom("f3"), getDom("f4")];
tog.ste = false;
var togFunc = function() {
	if(!tog.ste) {
		forEch(regisFields, setf);
		getDom("forget-pass").classList.remove("hidden");
		getDom("loginBox-button").setAttribute("value", "Login");
		getDom("reglogToggle").innerHTML = "Register";
	}else {
		forEch(regisFields, unsetf);
		getDom("forget-pass").classList.add("hidden");
		getDom("loginBox-button").setAttribute("value", "Register");
		getDom("reglogToggle").innerHTML = "Take me back";
	}
	tog.ste = !tog.ste;
}
tog.onclick = togFunc;
togFunc();
