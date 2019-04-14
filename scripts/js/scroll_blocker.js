function SetBlockers(BlockerId) {
	
	document.getElementById(BlockerId).onmouseover = function(e) {
															
		document.children[0].style.overflowY = 'hidden';
		document.body.style.overflowY = 'hidden';
	}
															
	document.getElementById(BlockerId).onmouseout = function(e) {
															
		document.children[0].style.overflowY = 'visible';
		document.body.style.overflowY = 'visible';
	}
}