function textFormatPreview(inputId, previewId, deflt) {
				
	let input = RemoveUniteQuotes(inputId);
	document.getElementById(previewId).innerHTML = input.value == ""? deflt : input.value;
	return input;
}
			
function RemoveUniteQuotes(id) {
				
	let item = document.getElementById(id);
	item.value = item.value.replace("'", '"');
	return item;
}

function VideoFormat(inputId, previewId) {
	
	let input = document.getElementById(inputId);
	let preview = document.getElementById(previewId);
	
	input.value = input.value.replace('watch', 'embed').replace('?v=', '/');
	let amp_ind = input.value.indexOf('&');
	
	if(amp_ind != -1)
		input.value = input.value.substring(0, amp_ind);
	
	preview.innerHTML = '<div class = \'video_wrapper\'><iframe class = \'video\' frameborder = \'1\' allow = \'accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\' allowfullscreen src = \'' + input.value + '\'></iframe></div>';
}