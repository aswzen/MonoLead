
	function showMessage (string,type) {
		$.notify(string, 
		{ 
			globalPosition: 'bottom right',
			className: type
		});
	}

	function slideMessage (message) {
	    w2popup.message({ 
	        width   : 400, 
	        height  : 180,
	        html    : '<div style="padding: 60px; text-align: center">'+message+'</div>'+
	                  '<div style="text-align: center"><button class="btn" onclick="w2popup.message()">Close</button>'
	    });
	}
	
	function openInNewTab(url) {

	  var win = window.open(url, '_blank');
	  win.focus();
	  
	}
	    
	
	function openInSameTab(url) {

	  var win = window.open(url, '_self');
	  win.focus();
	  
	}
	    
