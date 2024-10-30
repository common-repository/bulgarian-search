function form_submit(word){
	document.getElementById('search').value = word;
	document.search_eng.submit();
}

function google_search(qry){
	window.location.href = "http://napred.bg/search/google_search/"+qry;
}