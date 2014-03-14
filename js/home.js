var current_page = null;
var key_count_message = null;
var alarms_func = new Array();
$(function(){	
	$('#logout').click(function(){window.location = base_url + 'logout';});
	$('#login-short-form').submit(function(){
		var form = $(this);
		$.post(base_url + 'user-login', form.serialize(), function(e){
			if (e && e.length > 0){
				var err_login_tag = form.find('#login-fail');
				if (err_login_tag.length == 0){
					form.append("<div id='login-fail'></div>");
					err_login_tag = form.find('#login-fail');
				}
				err_login_tag.html(e);
			}
			else{
				window.location = window.location;
			}
		});
		return false;
	});
	$(".table-list").each(function(){
		var table = $(this);
		if (table.attr('no-default-event') != 'true'){
			table.find("tbody :checkbox").live("click", function(e){		
				if (!$(this).attr("checked")){
					table.find("thead :checkbox").attr("checked", false);
				}else
				{
					if (table.find("tbody :checked").length == table.find("tbody :checkbox").length){
						table.find("thead :checkbox").attr("checked", true);
					}
				}		
			});
		}		
	});	
	
	$('.table-list thead a').live("click", function(){		
		if($(this).attr("sort")){
			$("#sort_by").val($(this).attr('sort'));
			if ($("#ascending").val() == "asc"){
				$("#ascending").val("desc");
			}
			else{
				$("#ascending").val("asc");
			}			
			reload_data();
		}
	});
	
	var mouse_is_inside_popup_context = false;
	$('.popup-context').hover(function(){ 
		mouse_is_inside_popup_context=true; 
	}, function(){ 
		mouse_is_inside_popup_context=false; 
	});
	$("body").mouseup(function(){ 
		if(!mouse_is_inside_popup_context){$('.popup-context').hide();}
	});
	
	$("#menu-wrapper ul ul").bind("mouseout", function(){
		//$(this).parent().removeClass('active');
	});
	var flash_message = $("#flash-message");
	var has_flash_message = false;
	if ($.trim(flash_message.find("span").text())){
		has_flash_message = true;				
		setTimeout(function(){
			set_center_screen(flash_message);
			flash_message.slideDown(function(){
				setTimeout(function(){
					flash_message.slideUp();
					has_flash_message = false;
				}, 8000);
			});		
		}, 1000);
		$(window).resize(function(){
			set_center_screen(flash_message);
		});		
	}
	//MENU EVENTS	
	$('#navigation li.top').each(function(){
		var li = $(this);
		var timeID = null;
		var ul = $(this).find('ul');
		var funcHide = function(){
			timeID = setTimeout(function(){
				ul.hide();
			}, 100);
		}
		ul.hover(function(){
				clearTimeout(timeID);				
			}, function(){
				funcHide();
		});
		li.hover(function(){			
			if (ul.length > 0){
				clearTimeout(timeID);
				ul.show();
			}
		}, function(){
			funcHide();
		});
	});
	
	load_alarms();
	setInterval(function(){
		load_alarms();
	}, 5000);
	window.alarms_func[0] = active_alarm_flash_text;
	function load_alarms(){
		if (is_login){
			$.get(base_url + 'alarms-info', function(e){
				if (e){
					data = $.parseJSON(e);
					for(var i = 0; i < window.alarms_func.length; i++){
						window.alarms_func[i](data);
					}
				}
			});
		}
	}
	
	var on_status = false;
	var alarm_flash_key_text = null;
	function active_alarm_flash_text(data){
		clearInterval(alarm_flash_key_text);
		if (data.device_ids.length > 0){
			$('.alarm-icon').text(data.device_ids.length + ' ' + (data.device_ids.length > 1 ? alarms_text : alarm_text)).addClass('alarm-red').show();			
			alarm_flash_key_text = setInterval(function(){
				if (on_status == false){
					$('.alarm-icon').addClass('alarm-red').show();
				}
				else{
					$('.alarm-icon').removeClass('alarm-red').hide();
				}
				on_status = !on_status;
			}, 500);
		}
		else{
			$('.alarm-icon').text(0 + ' ' + alarm_text).show();
		}
	}
	if (is_login){
		tracking_favorites_menu();
	}
});

function tracking_favorites_menu(){
	var post_favorite_menu = function(id, is_menu){	
		$.ajax({
			type:'POST', 
			url: base_url + 'favorite-menu', 
			data: {'id': id, is_menu : (is_menu ? '1' : '0')}
		});
	}
	$('#navigation a.top').click(function(){
		if ($(this).attr('href') != 'javascript:void(0)'){
			post_favorite_menu($(this).attr('ref_id'), true);
		}
		//return false;
	});
	$('#navigation .submenu a').click(function(){
		if ($(this).attr('href') != 'javascript:void(0)'){
			post_favorite_menu($(this).attr('ref_id'), true);
		}
		//return false;
	});
}

function check_all(is_check)
{
	$(".table-list thead :checkbox").attr("checked", is_check);
	$(".table-list :checkbox").attr("checked", is_check);
}

function delete_1_data(name, action, id){	
	var ids = get_selected_id();
	if(confirm("Do you want to delete this " + name + "?"))
	{
		$.post(base_url + controller_name + action
			,{ ids: id }
			, function(e){
				reload_data();
		});
	}
}

function delete_data(name, action){	
	var ids = get_selected_id();	
	if (ids)
	{
		var length = ids.split(',').length;
		if (confirm("Do you want to delete " + name + "?"))
		{
			$.post(base_url + controller_name + action,
				{ ids: ids }
				, function(e){
				{
					reload_data();
				}				
			});
		}		
	}
	else
	{
		alert("Please select " + name + " to delete!");
	}
}

function active_data(name, active_name, action, is_active){		
	var ids = get_selected_id();	
	if (ids)
	{		
		var length = ids.split(',').length;
		if (confirm("Do you want to " + active_name.toLowerCase() + " these " + name + "?")) {
			$.post(base_url + controller_name + action,
				{
					active : (is_active ? 1 : 0)
					,ids: ids
				}
				, function(e){
				{
					reload_data();
				}				
			});
		}		
	}
	else
	{
		alert("Please select " + name);
	}
}

function edit_data(name, action){	
	var items = $('.table-list tbody :checked');
	if (items.length == 0)
	{
		alert("Please choose at least one " + name + "!!!");
	}
	else
	{		
		var page = '';
		var page_size = '';		
		if (!page && $("#ddl_page").length > 0)
		{
			page = $("#ddl_page").val();
		}
		if (!page_size && $("#ddl_page_size").length > 0)
		{
			page_size = $("#ddl_page_size").val();
		}
		window.location = base_url + action + "/" + $(items[0]).attr("key") + "?page=" + page + "&page_size=" + page_size;		
	}
}

function get_selected_id(){
	var keys = "";
	var items = $('.table-list tbody :checked');
	items.each(function(){
		keys += $(this).attr("key") + ",";
	});
	if (keys != "")
	{
		keys = keys.substr(0, keys.length - 1);
	}
	return keys;
}

function reload_data(page, page_size){	
	var view = $("#ajax_view").val();
	//var page = '';
	//var page_size = '';
	var query = '';
	if (!page){
		if ($("#ddl_page").length > 0)
		{
			query += '&page=' + $("#ddl_page").val();
		}
	}
	else{
		query += '&page=' + page;
	}
	
	if (!page_size){
		if ($("#ddl_page_size").length > 0){
			query += '&page_size=' + escape($("#ddl_page_size").val());
		}
		else if ($(".table-list").attr("page_size")){
			query += '&page_size=' + escape($(".table-list").attr("page_size"));
		}
	}
	else{
		query += '&page_size=' + escape(page_size);
	}
	if ($("#h_search_type").val()){
		query += '&search_type=' + escape($("#h_search_type").val());
	}
	if ($("#h_keywords").val()){
		query += '&keywords=' + escape($("#h_keywords").val());
	}
	if ($("#device_id").length > 0){		
		query += "&device_id=" + escape($("#device_id").val());
	}
	if ($("#site_id").length > 0){		
		query += "&site_id=" + escape($("#site_id").val());
	}
	if ($("#type_id").length > 0){		
		query += "&type_id=" + escape($("#type_id").val());
	}
	if ($("#menu_id").length > 0){		
		query += "&menu_id=" + escape($("#menu_id").val());
	}
	if ($("#sort_by").length > 0)
	{
		query += "&sort_by=" + escape($("#sort_by").val());
		
		if ($("#ascending").length > 0)
		{
			query += "&ascending=" + escape($("#ascending").val());
		}
	}	
	var url = base_url + controller_name + view + '?t=' + new Date().getTime();
	if (query != ''){
		url += query;
	}
	
	if (window.extend_load_data){
		url = window.extend_load_data(url);
	}
	show_loading();
	$.get(url, function(args){
		hide_loading();
		$("#d-list-data").html(args);
		if (window.extend_finish_load_data){
			url = window.extend_finish_load_data();
		}
	});	
}

function change_page_size(item){		
	var parent = item.parentNode.parentNode;
	var ddl_page = $("#ddl_page", parent)[0];
	if (ddl_page.length > 0)
	{
		ddl_page.selectedIndex = 0;
	}
	
	reload_data($(ddl_page).val(), $("#ddl_page_size", parent).val());
}

function change_page(item){	
	var parent = item.parentNode.parentNode;
	var ddl_page = $("#ddl_page", parent);
	reload_data($(ddl_page).val());
}

function change_paging(url){	
	show_loading();
	$.get(url, function(args){
		hide_loading();
		$("#d-list-data").html(args);
	});
}

function do_search(){
	$("#h_search_type").val($("#search_type").val());
	$("#h_keywords").val($("#keywords").val());
	$("#ddl_page").val(1);
	reload_data();
	return false;
}

function reload_search(){
	if ($("#device_id").length > 0)
	{
		$("#device_id").val("");
	}
	if ($("#menu_id").length > 0)
	{
		$("#menu_id").val("");
	}
	if ($("#site_id").length > 0)
	{
		$("#site_id").val("");
	}
	if ($("#type_id").length > 0)
	{
		$("#type_id").val("");
	}
	$("#h_keywords").val($("#keywords").val(""));
	do_search();
}

function sort_data(column_name){
	$("#sort_by").val(column_name);
	$("#ascending").val($("#ascending").val() == "desc" ? "" : "desc");
	reload_data();
}
function bindKeyEnter(tagID, func)
{
	$("#" + tagID).keypress(function(e){
		if (!e)
			e = window.event;
		if (e.keyCode == 13)
		{
			func();
			return false;
		}
	});
}

function bindKeyEsc(tagID, func)
{
	if (typeof(tagID) == "string")
	{
		$("#" + tagID).keyup(function(e){
			if (!e)
				e = window.event;			
			if (e.keyCode == 27)
			{
				func();
			}
		});
	}
	else
	{
		$(tagID).keyup(function(e){
			if (!e)
				e = window.event;			
			if (e.keyCode == 27)
			{
				func();
			}
		});
	}	
}
function write_content_into_iframe(id, content){
	var ifrm = document.getElementById(id);
	ifrm = (ifrm.contentWindow) ? ifrm.contentWindow : (ifrm.contentDocument.document) ? ifrm.contentDocument.document : ifrm.contentDocument;
	ifrm.document.open();
	ifrm.document.write(content);
	ifrm.document.close();
}
function show_user_opts(item, id){		
	var popup = $(".user-view-opts");
	popup.find("#id").val(id);		
	popup.find("#email").val($(item).attr('email'));		
	popup.find(".title").text($.trim($(item).text()));
	show_popup_context(item, popup);		
}
function show_popup_context(item, popup){
	var offset = $(item).position();
	var left = offset.left + $(item).outerWidth() + 10;
	var top = offset.top - $(item).outerHeight() - 30;
	var max_width = $(window).width();
	var max_height = $(window).width();
	var popup_width = popup.outerWidth();
	if (left > max_width - popup_width){
		left = offset.left - popup_width - 10;
	}
	popup.css({left: (left) + "px", top: (top) + "px"}).show();;
}
function convert_timestamp_to_text(timestamp){
	var hours = 0;
	var minutes = 0;
	var seconds = 0;
	var remaining = timestamp;
	if(remaining > 3600){
		hours = Math.floor(remaining / 3600);
		remaining = remaining % 3600;
	}
	if(remaining > 60){
		minutes = Math.floor(remaining / 60);
		remaining = remaining % 60;
	}
	seconds = remaining;
	var format = (hours < 10 ? "0": "") + hours + ":" + (minutes < 10 ? "0": "") + minutes + ":" + (seconds < 10 ? "0": "") + seconds;
	return format;
}