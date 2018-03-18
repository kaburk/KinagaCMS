<?php
$last_modified = gmdate('D, d M Y H:i:s T', filemtime(__FILE__));

header('Content-Type: application/javascript');
header('Last-Modified: ' . $last_modified);

if (filter_input(INPUT_SERVER, 'HTTP_IF_MODIFIED_SINCE') === $last_modified)
	header('HTTP/1.1 304 Not Modified');

echo
file_get_contents('jquery.min.js'),
file_get_contents('popper.min.js'),PHP_EOL,
file_get_contents('bootstrap.min.js'),PHP_EOL,
file_get_contents('jquery.magnific-popup.min.js'),
'$("a[href=\"#TOP\"]").click(function(){$("body, html").animate({scrollTop:0},100);return false});var scroll_delay=0;$(window).on("scroll",function(){clearTimeout(scroll_delay);scroll_delay=setTimeout(function(){if($(this).scrollTop()>200){$("#top").slideDown()}else{$("#top").slideUp()}},400)});$(".gallery").each(function(){$(this).magnificPopup({delegate:"a",type:"image",gallery:{enabled:true,preload:[1,1]}})});$(".expand").magnificPopup({type:"image"});$(".nav-tabs a").click(function(e){e.preventDefault();$(this).tab("show")});$(".note").tooltip();$("[data-toggle=\"popover\"]").popover()';
