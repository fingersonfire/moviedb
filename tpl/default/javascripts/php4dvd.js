/**
 * All JavaScript functionality is placed here.
 */

// Only 1 search at the time
var ajaxSearchLock = false;
var loadingTimer;

/**
 * Search movies
 */
function search() {
	if(!ajaxSearchLock) {
		ajaxSearchLock = true;
		
		// Make url
		var location = "./#!/";
		var url = "./?go=movies";
		
		// Query
		var q = $("#q").val();
		if(q == $("#dq").val()) {
			q = false;
		}
		if(q) {
			url += "&q=" + encodeURIComponent(q);
			location += "search/" + encodeURIComponent(q) + "/";
			$.cookie("search", q, { expires: 365 });
		} else {
			$.cookie("search", null);
		}
		
		// Category
		var c = $("#category").val();
		if(c) {
			url += "&c=" + encodeURIComponent(c);
			location += "category/" + encodeURIComponent(c) + "/";
			$.cookie("category", c, { expires: 365 });
		} else {
			$.cookie("category", null);
		}
		
		// Sort
		var s = $("#sort").val();
		if(s) {
			url += "&s=" + encodeURIComponent(s);
			location += "sort/" + encodeURIComponent(s) + "/";
			$.cookie("sort", s, { expires: 365 });
		} else {
			$.cookie("sort", null);
		}
		
		// Page
		var p = $("#p").val();
		if(p && p > 0) {
			url += "&p=" + encodeURIComponent(p);
			location += "page/" + encodeURIComponent(p) + "/";
			$.cookie("page", p, { expires: 365 });
		} else {
			$.cookie("page", 0);
		}
		
		// Number of resutls
		var n = $("#n").val();
		if(n && n > 0) {
			url += "&n=" + encodeURIComponent(n);
			location += "results/" + encodeURIComponent(n) + "/";
			$.cookie("results", n, { expires: 365 });
		} else {
			$.cookie("results", null);
		}
		
		// Start loading
		loadingTimer = setTimeout(function() { $("#results").hide(); $("#loading").show(); }, 500);
		
		// Make request
		$.ajax({
			url: url,
			success: function(data) {
				$("#results").html(data);
				$("#results").show();
				clearTimeout(loadingTimer);
				$("#loading").hide();
			},
			complete: function() {
				// Save search parameters to url
				window.location.href = location;
				
				// Release lock
				ajaxSearchLock = false;
			}
		});
	}
}

function setPage(p) {
	$("#p").val(p);
	search();
}

/**
 * Get the parameters from the query string that follow the '#!/' part of the url.
 */
function getQueryStringParameters() {
	// Get query string from url
	var queryString = new RegExp("#!/(.*?)/?$").exec(window.location.href);
	
	// Split parameters
	if(queryString && queryString.length > 0) {
		var parameters = new Array();
		var parts = queryString[1].split("/");
		for(var i = 0; i < parts.length; i++) {
			parameters[decodeURIComponent(parts[i])] = decodeURIComponent(parts[++i]);
		}
		return parameters;
	}
	else {
		return false;
	}
}