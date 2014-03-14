$.fn.fileUpload = function(data){
	var element = $(this);
	var offset = element.position();
	var width = element.outerWidth();
	var height = element.outerHeight();
	var parent = element.parent();
	var input_id = 'file__' + (new Date().getTime());
	var form_id = 'form__' + (new Date().getTime());
	parent.append("<form id='" + form_id + "' style='position:absolute;opacity:0;cursor:pointer;overflow:hidden;top:" + offset.top + "px;left:" + offset.left + "px;width:" + width + "px;" + height + "px'><input id='" + input_id + "' style='cursor:pointer' type='file' id='file' name='file' title=''/></form>");
	$('#' + input_id).change(function(){
		start_upload(this);
	});
	
	var start_upload = function(input){
		show_loading();
		fileUpload(document.getElementById(form_id), data.url);
		$(input).val('');
		hide_loading();
	}
	
	var fileUpload = function (form, action_url) {
		// Create the iframe...
		var iframe = document.createElement("iframe");
		iframe.setAttribute("id", "upload_iframe");
		iframe.setAttribute("name", "upload_iframe");
		iframe.setAttribute("width", "0");
		iframe.setAttribute("height", "0");
		iframe.setAttribute("border", "0");
		iframe.setAttribute("style", "width: 0; height: 0; border: none;");
	 
		// Add to document...
		form.parentNode.appendChild(iframe);
		window.frames['upload_iframe'].name = "upload_iframe";
	 
		iframeId = document.getElementById("upload_iframe");
	 
		// Add event...
		var eventHandler = function () {
	 
				if (iframeId.detachEvent) iframeId.detachEvent("onload", eventHandler);
				else iframeId.removeEventListener("load", eventHandler, false);
	 
				// Message from server...
				if (iframeId.contentDocument) {
					content = iframeId.contentDocument.body.innerHTML;
				} else if (iframeId.contentWindow) {
					content = iframeId.contentWindow.document.body.innerHTML;
				} else if (iframeId.document) {
					content = iframeId.document.body.innerHTML;
				}
				
				//document.getElementById(div_id).innerHTML = content;
	 
				// Del the iframe...
				setTimeout('iframeId.parentNode.removeChild(iframeId)', 250);
				if (data.done){
					data.done($.parseJSON(content));
				}
			}
	 
		if (iframeId.addEventListener) iframeId.addEventListener("load", eventHandler, true);
		if (iframeId.attachEvent) iframeId.attachEvent("onload", eventHandler);
	 
		// Set properties of form...
		form.setAttribute("target", "upload_iframe");
		form.setAttribute("action", action_url);
		form.setAttribute("method", "post");
		form.setAttribute("enctype", "multipart/form-data");
		form.setAttribute("encoding", "multipart/form-data");
	 
		// Submit the form...
		form.submit();
	 
		//document.getElementById(div_id).innerHTML = "Uploading...";
	} 
};