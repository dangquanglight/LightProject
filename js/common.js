var emailRegxp = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
var numberRegxp = /^\d+(\.\d+)?$/;
var dateFormatPopup = 'mm-dd-yy';
$(function(){	
	bindKeyEnter("keywords", do_search);
	$("#dialog-wrapper-popup").find(".dialog-close").click(function () {close_wrapper_popup();});
	$('.history-back').click(function(){
		history.back(1);
	});	
	/*** language ***/
    $("#d-languages").click(function(){
        var offset = $(this).position();                
        $('#languages-popup').css({left: (offset.left + $(this).outerWidth() - $('#languages-popup').outerWidth()) + "px", 
            top: ($(this).outerHeight() + offset.top + 5) + "px"}).slideDown(); 
    });
    $('#d-languages,#languages-popup').click(function(event){	
        event.stopPropagation();
    });
    $('#languages-popup li').click(function(){
        $('#languages-popup li').removeClass("checked");
        $(this).addClass("checked");
        $('#languages-popup').slideUp();                
                
        $.post(base_url + controller_name + 'change_language'
			,{language: $(this).attr("lang")}
			,function(e){
				//alert(e);
				window.location = window.location.href;
			}
		);
    });
    $('html').click(function() {
        //alert(2);
        $("#languages-popup").slideUp();	
    });
	init_scroll();
});
function init_scroll(){
	var scroll_top = $('#scroll-top');
	if (scroll_top.length){
		var min_distance_scroll = -1;
		if (scroll_top.val()){			
			$(window).scrollTop(scroll_top.val());
			if (scroll_top.val() > min_distance_scroll){			
				$('.scroll-icon').fadeIn();			
			}
		}
		$(window).scroll(function(){			
			var scroll = $(window).scrollTop();
			$('#scroll-top').val(scroll);
			if (scroll > min_distance_scroll){
				$('.scroll-icon').fadeIn();
			}
			else{
				$('.scroll-icon').fadeOut();
			}
		});		
	}	
	
	var func_check_scroll_visible = function(){
		if ($('body').height() > $(window).height() + 80){
			$('.scroll-icon').fadeIn();
		}
		else{
			$('.scroll-icon').fadeOut();
		}
	}
	var document_height = $(this).height();
    var document_width  = $(this).width();
	$(document).bind('DOMSubtreeModified', function() {
		if($(this).height() != document_height || $(this).width() != document_width) {
			document_height = $(this).height();
			document_width = $(this).width();
			func_check_scroll_visible();
		}
	});

	//check the first time
	func_check_scroll_visible();
	$('body').resize(function() {
		func_check_scroll_visible();
	});
	$('#nav_down').click(
		function (e) {
			$('html, body').animate({scrollTop: $('body').height()}, 1200);
		}
	);
	$('#nav_up').click(
		function (e) {
			$('html, body').animate({scrollTop: '0px'}, 1200);
		}
	);
}
//create clock
function create_clock(){		
	var m_names = new Array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Se", "Oct", "Nov", "Dec");	
	var d_names = new Array("Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat");	
	$('#header-page').append("<span class='clock'>" + format(current_timestamp) + "</span>");
	setInterval(function(){
		current_timestamp += 1000;
		$('.clock').text(format(current_timestamp));
	}, 1000);
	
	function format(timestamp){			
		var d = new Date(timestamp);
		var day = d_names[d.getDay()];
		var curr_date = d.getDate();
		var curr_month = d.getMonth();
		var curr_year = d.getFullYear();
		var hours = d.getHours();
		var minutes = d.getMinutes();
		var seconds = d.getSeconds();
		if (hours < 10){ hours = "0" + hours;}
		if (minutes < 10){ minutes = "0" + minutes;}
		if (seconds < 10){ seconds = "0" + seconds;}
		var result = day + ', ' + curr_date + " " + m_names[curr_month] + " " + curr_year + " " + hours + ":" + minutes + ":" + seconds;
		return result;
	}
};
function text_to_title(text){	
	var result = text.toLowerCase().replace(/\s\s+/gm, " ");
	result = result.replace(/\s/gm, "-");	
	return result;
}

function show_loading(){
	$("#loading").fadeIn();
}
function hide_loading(){
	$("#loading").fadeOut();
}
function show_wrapper_popup(options) {
    url = base_url + options.url;
    show_loading();
    $.post(url, options.data, function (e) {
        hide_loading();
        $("#dialog-wrapper-popup .title").text(options.title);
        $("#dialog-wrapper-popup .dialog-body").html(e);
        var body = $(document);
        var wrapper_popup = $("#dialog-wrapper-popup");
        var top = "80px";
        if (options.css) {
            if (options.css.top) {
                top = options.css.top;
            }
            if (options.css.width) {
                wrapper_popup.find(".dialog-window").width(options.css.width);
            }
        }
        wrapper_popup.css({ top: top });
        wrapper_popup.css({ left: ((body.width() - wrapper_popup.width()) / 2) + "px" }).fadeIn();
        if (options && options.func) {
            options.func(e);
        }
    });
}
function show_wrapper_popup_by_text(options) {
    $("#dialog-wrapper-popup .title").text(options.title);
    $("#dialog-wrapper-popup .dialog-body").html(options.text);
    var body = $(document);
    var wrapper_popup = $("#dialog-wrapper-popup");
    var top = "100px";    
    if (options.top) {
        top = options.top;
    }    
	if (options.css) {
		if (options.css.top) {
			top = options.css.top;
		}
		if (options.css.width) {
			wrapper_popup.find(".dialog-window").width(options.css.width);
		}
	}
    wrapper_popup.css({ left: ((body.width() - wrapper_popup.width()) / 2) + "px", top: top }).fadeIn().find(".dialog-close").click(function () {
        $("#dialog-wrapper-popup-temp").fadeOut();
    });
}
function close_wrapper_popup(){
	$("#dialog-wrapper-popup").hide();
}

var geocoder;
var map;
var mapTagID;
function load_map(tagID, address){	
	initialize(tagID);
	codeAddress(address);
}

var marker = null;
function load_map_longitude_and_latitude(tagID, latitude, longitude, ip_address){
	geocoder = new google.maps.Geocoder();	
    var latlng = new google.maps.LatLng(parseFloat(latitude), parseFloat(longitude));
    var mapOptions = {
      zoom: 8,
      center: latlng,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    }
	if (marker){
		marker.setMap(null);
	}
    map = new google.maps.Map(document.getElementById(tagID), mapOptions);	
	marker = new google.maps.Marker({
		position: latlng,
		title: ip_address ? ip_address : "Vị trí"
	});

	// To add the marker to the map, call setMap();
	marker.setMap(map)
	mapTagID = tagID;
}

function initialize(tagID) {
	geocoder = new google.maps.Geocoder();
	var latlng = new google.maps.LatLng(-34.397, 150.644);
	var mapOptions = {
		zoom: 15,
		center: latlng,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	}
	map = new google.maps.Map(document.getElementById(tagID), mapOptions);
	mapTagID = tagID;
}

function codeAddress(address) {        
	geocoder.geocode( { 'address': address}, function(results, status) {
		if (status == google.maps.GeocoderStatus.OK) {
			map.setCenter(results[0].geometry.location);
			var marker = new google.maps.Marker({
				map: map,
				position: results[0].geometry.location
			});
		} else {
			//alert('Geocode was not successful for the following reason: ' + status);
			//$('#' + mapTagID).hide();
		}
	});
}
jQuery.validator.addMethod("emails", function (value, element) {
    var result = true;
    var email_invalid = new Array();
    if (value) {
        //plit by comma
        var ar_emails = $.trim(value).split(',');
        var validator = this;
        if (ar_emails.length > 0) {
            for (var i = 0; i < ar_emails.length; i++) {
                var email = $.trim(ar_emails[i]);
                if (email && !emailRegxp.test(email)) {
                    result = false;
                    email_invalid[email_invalid.length] = email;
                }
            }
        }
    }
    if (!result) {
        var message = email_invalid.join(',') + " " + 'không phải là email hợp lệ' + ".";
        setTimeout(function () {            
            $(element).parent().find(".error").text(message);
        }, 10);
    }
    return result;
}, "Emails is not valid");
function set_center_screen(tag){
	var fwidth = tag.outerWidth();
	var wwidth = $(window).width();
	var left = (wwidth - fwidth) / 2;	
	tag.css({left: left + 'px'});
}
function skip_enter(id){
	$("#" + id).keydown(function(event){
		if(event.keyCode == 13){
			return false;
		}
	});
}
function format_number(number)
{
	number += '';
	x = number.split('.');
	x1 = x[0];
	x2 = x.length > 1 ? '.' + x[1] : '';
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(x1)) {
		x1 = x1.replace(rgx, '$1' + ',' + '$2');
	}
	return x1 + x2;
}

function series_std(name, data, animation){
	this.name = name;
	this.data = data;
	if (!animation){
		animation = false;
	}
	this.animation = animation;
	this.marker = {enabled : false};
}
function setTextboxNumeric(selector){
	$(selector).keydown(function(event) {
		// Allow: backspace, delete, tab, escape, and enter
		if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 || 
			 // Allow: Ctrl+A
			(event.keyCode == 65 && event.ctrlKey === true) || 
			 // Allow: home, end, left, right
			(event.keyCode >= 35 && event.keyCode <= 39)) {
				 // let it happen, don't do anything
				 return;
		}
		else {
			// Ensure that it is a number and stop the keypress
			if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
				event.preventDefault(); 
			}   
		}
	});
}
$(function(){
	//ADD VALIDATE WITH NO SPACE
	var usernameRegex = /^[a-zA-Z0-9]+$/;
	jQuery.validator.addMethod("required_user_name", function(value, element) { 
		return usernameRegex.test(value);
	}, "Space doesn't allow");
});
