function SetScrolls() {
	
	let boxes = document.getElementsByClassName("box");
	
	for(let box of boxes) {
		
		box.style.overflow = 'visible';
	}
}