$(function() {

// select all desired input fields and attach tooltips to them
$("#upload :input").tooltip({

	// place tooltip on the right edge
	position: "center right",

	// a little tweaking of the position
	offset: [-2, 10],

	// use the built-in fadeIn/fadeOut effect
	effect: "fade",

	// custom opacity setting
	opacity: .9,

	// use this single tooltip element
	tip: '.tooltip'

});
});



