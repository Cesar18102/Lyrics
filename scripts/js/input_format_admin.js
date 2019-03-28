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