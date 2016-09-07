/*
Title: Simple and easy Cookie based jQuery Tabs Plugin
Author: Amol Nirmala Waman
URL: https://amolnw.wordpress.com/
Relese: Version 1.0, Wednesday, 13 April 2011
Location: https://cookie-based-jquery-tabs.googlecode.com/files/cookie-based-jquery-tabs-1.0.js
*/

$(function(){
	// added multi usable standard javascript nyHashTabs()
	function nyHashTabs(){
		var Cookie = $.cookie("nyacord"); // this will set the cookie 'nyacord'
		var activeTab = '';
		var navIndex = '';
		//$('.tab_content').hide(); // hides all content



		$(".tabs > a").click(function() {
			$(".tabs a").removeClass("active"); // removes 'active' class from all anchors in '.tabs'
			$(this).addClass("active"); // current tab will be 'active'
			navIndex = $('.tabs > a').index(this); // check the index
			$.cookie("nyacord", navIndex); // set the index for cookie

			$('.tab_content').hide();
			activeTab = $(this).attr("href"); // the active tab + content
			$(activeTab).fadeIn(0);
			return false;
		});
	}

	$('#profileTabList').each(function(){
		return nyHashTabs(); // applies to this ID only
	});
}); // jquery ends