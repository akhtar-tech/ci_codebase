function format_number(n, c, d, t) {
	var c = isNaN(c = Math.abs(c)) ? 2 : c,
	d = d == undefined ? "." : d,
    t = t == undefined ? "," : t,
    s = n < 0 ? "-" : "",
    i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
    j = (j = i.length) > 3 ? j % 3 : 0;
	
	return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
};

function searchFilter(key, value = null, noReload) {
	
    var loc = window.location;
    //  //console.log(loc);
	
    var url = loc.origin + loc.pathname + '?';
    if (loc.search !== '') {
        // //console.log(loc.search.replace('?', ''));
        var q = loc.search.replace('?', '');
        var q_array = q.split('&');
        //console.log(q_array);
		
        var pkey = [];
        var pkeyObj = {};
        var comma = '';
        for (i = 0; i < q_array.length; i++) {
            if (i != 0) {
                comma = ',';
			}
            var skey = key + "=" + value;
            var p_key = q_array[i].split("=");
            p_key.pop();
            var p_value = q_array[i].split("=").pop();
            pkeyObj[p_key[0]] = p_value;
			
			
            //pkey.push(pkeyObj);
            // pkey.push({p_key[0]:p_value});
			
            ////console.log(p_key[0]);
		}
		
		
        delete pkeyObj[key];
        var objCheckEmpty = $.map(pkeyObj, function (el) {
            return el;
		});
        //  var objCheckEmpty =  $.isEmptyObject(pkeyObj);
        // //console.log(pkeyObj);
        // //console.log(objCheckEmpty.length);
        var keystring = '';
        //  //console.log(pkeyObj);
        if (objCheckEmpty.length) {
            //pkey = $.unique(pkey);
            pkeyObj = JSON.stringify(pkeyObj);
            pkeyObj = pkeyObj.replace('}', '');
            pkeyObj = pkeyObj.replace('{', '');
            var count = (pkeyObj.match(/"/g) || []).length;
            for (i = 0; i < count; i++) {
                pkeyObj = pkeyObj.replace('"', '');
			}
			
			
            pkeyObj = pkeyObj.split(',');
			
			
            var sap = '?';
			
            for (i = 0; i < pkeyObj.length; i++) {
                if (i != 0) {
                    sap = '&';
				}
                var s = pkeyObj[i];
                var r = s.split(':');
                //   //console.log(r);
                if (r.length != 0) {
                    keystring += sap + r[0] + '=' + r[1];
				}
				
			}
            keystring = keystring + '&';
			} else {
			
            keystring = '?';
		}
        // //console.log(keystring);
        url = loc.origin + loc.pathname + keystring;
        //  //console.log(url);
	}
    var targetTitle = 'Search Result';
    if (value !== '') {
        // //console.log(url + key + '=' + value);
        var targetUrl = url + key + '=' + value;
        window.history.pushState({url: "" + targetUrl + ""}, targetTitle, targetUrl);
		
		
        //window.location=url+key+'='+value;
		} else {
		
        if(keystring.length){
            var keystring = keystring.substring(0, keystring.length - 1);
            var targetUrl = loc.origin + loc.pathname + keystring;
            window.history.pushState({url: "" + targetUrl + ""}, targetTitle, targetUrl);
			
		}
        // window.location=loc.origin + loc.pathname+keystring;
	}
	
    if (noReload == null || noReload == false) {
        window.location.reload();
	}
}

/**
	* Checks if value is empty. Deep-checks arrays and objects
	* Note: isEmpty([]) == true, isEmpty({}) == true, isEmpty([{0:false},"",0]) == true, isEmpty({0:1}) == false
	* @param value
	* @returns {boolean}
*/
function isEmpty(value){
	var isEmptyObject = function(a) {
		if (typeof a.length === 'undefined') { // it's an Object, not an Array
			var hasNonempty = Object.keys(a).some(function nonEmpty(element){
				return !isEmpty(a[element]);
			});
			return hasNonempty ? false : isEmptyObject(Object.keys(a));
		}
		
		return !a.some(function nonEmpty(element) { // check if array is really not empty as JS thinks
			return !isEmpty(element); // at least one element should be non-empty
		});
	};
	return (
    value == false
    || typeof value === 'undefined'
    || value == null
    || (typeof value === 'object' && isEmptyObject(value))
	);
}

function selected(key,value){
	$("#"+key+" option").each(function(){
		if($(this).val().trim() == value){
			$(this).attr('selected', true);
		}
	});
}

/*
	function login(e,email,password){
	e.preventDefault();
	$('.error-help').empty();
	$.ajax({
	type:'post',
	data:{
	email:email,
	password:password
	},
	url:info.base_url+'user/login',
	success:function(data, textStatus, response){
	
	try{
	window.location = (info.http_referer) ? info.http_referer : info.base_url;
	$('.login_msg').html(data.msg).css('color', '#4ba54e');
	}
	catch(err){
	console.log(err);
	console.log(data.responseText);
	}
	
	
	},
	error:function(error, textStatus, response){
	try{
	var err = JSON.parse(error.responseText);
	console.log(err);
	if(err.data.email!=null){
	$('.error-email').html(err.data.email).css('color', '#f00');
	}
	if(err.data.password!=null){
	$('.error-password').html(err.data.password).css('color', '#f00');
	}
	$('.login_msg').html(err.msg).css('color', '#f00');
	}
	catch(err){
	console.log(err);
	console.log(error.responseText);
	}
	
	}
	});
	
} */

try{
    if(js_obj){  }
}
catch(e){
    js_obj = {};
}

//var js_obj = {};

js_obj.format_number = function(n, c, d, t) {
    var c = isNaN(c = Math.abs(c)) ? 2 : c,
	d = d == undefined ? "." : d,
	t = t == undefined ? "," : t,
	s = n < 0 ? "-" : "",
	i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
	j = (j = i.length) > 3 ? j % 3 : 0;
	
    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
};

js_obj.searchFilter = function(key, value = null, noReload) {
	
    var loc = window.location;
    //  //console.log(loc);
	
    var url = loc.origin + loc.pathname + '?';
    if (loc.search !== '') {
        // //console.log(loc.search.replace('?', ''));
        var q = loc.search.replace('?', '');
        var q_array = q.split('&');
        //console.log(q_array);
		
        var pkey = [];
        var pkeyObj = {};
        var comma = '';
        for (i = 0; i < q_array.length; i++) {
            if (i != 0) {
                comma = ',';
			}
            var skey = key + "=" + value;
            var p_key = q_array[i].split("=");
            p_key.pop();
            var p_value = q_array[i].split("=").pop();
            pkeyObj[p_key[0]] = p_value;
			
			
            //pkey.push(pkeyObj);
            // pkey.push({p_key[0]:p_value});
			
            ////console.log(p_key[0]);
		}
		
		
        delete pkeyObj[key];
        var objCheckEmpty = $.map(pkeyObj, function (el) {
            return el;
		});
        //  var objCheckEmpty =  $.isEmptyObject(pkeyObj);
        // //console.log(pkeyObj);
        // //console.log(objCheckEmpty.length);
        var keystring = '';
        //  //console.log(pkeyObj);
        if (objCheckEmpty.length) {
            //pkey = $.unique(pkey);
            pkeyObj = JSON.stringify(pkeyObj);
            pkeyObj = pkeyObj.replace('}', '');
            pkeyObj = pkeyObj.replace('{', '');
            var count = (pkeyObj.match(/"/g) || []).length;
            for (i = 0; i < count; i++) {
                pkeyObj = pkeyObj.replace('"', '');
			}
			
			
            pkeyObj = pkeyObj.split(',');
			
			
            var sap = '?';
			
            for (i = 0; i < pkeyObj.length; i++) {
                if (i != 0) {
                    sap = '&';
				}
                var s = pkeyObj[i];
                var r = s.split(':');
                //   //console.log(r);
                if (r.length != 0) {
                    keystring += sap + r[0] + '=' + r[1];
				}
				
			}
            keystring = keystring + '&';
			} else {
			
            keystring = '?';
		}
        // //console.log(keystring);
        url = loc.origin + loc.pathname + keystring;
        //  //console.log(url);
	}
    var targetTitle = 'Search Result';
    if (value !== '') {
        // //console.log(url + key + '=' + value);
        var targetUrl = url + key + '=' + value;
        window.history.pushState({url: "" + targetUrl + ""}, targetTitle, targetUrl);
		
        if (noReload == null || noReload == false) {
            window.location.reload();
		}
        //window.location=url+key+'='+value;
		} else {
        try {
            if (keystring.length) {
                var keystring = keystring.substring(0, keystring.length - 1);
                var targetUrl = loc.origin + loc.pathname + keystring;
                window.history.pushState({url: "" + targetUrl + ""}, targetTitle, targetUrl);
				
                if (noReload == null || noReload == false) {
                    window.location.reload();
				}
			}
		}
        catch(err){}
        // window.location=loc.origin + loc.pathname+keystring;
	}
	
	
};

js_obj.isEmpty = function(value){
    var isEmptyObject = function(a) {
        if (typeof a.length === 'undefined') { // it's an Object, not an Array
            var hasNonempty = Object.keys(a).some(function nonEmpty(element){
                return !isEmpty(a[element]);
			});
            return hasNonempty ? false : isEmptyObject(Object.keys(a));
		}
		
        return !a.some(function nonEmpty(element) { // check if array is really not empty as JS thinks
            return !isEmpty(element); // at least one element should be non-empty
		});
	};
    return (
	value == false
	|| typeof value === 'undefined'
	|| value == null
	|| (typeof value === 'object' && isEmptyObject(value))
    );
};

js_obj.selected = function(key,value){
    $("#"+key+" option").each(function(){
        if($(this).val().trim() == value){
            $(this).attr('selected', true);
		}
	});
};

