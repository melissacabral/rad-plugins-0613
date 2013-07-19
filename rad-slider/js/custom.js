jQuery(document).ready(function(){ 
	jQuery.noConflict();
	
	//activate the slider container
	jQuery(".slides").responsiveSlides({
		maxwidth: 960,
		speed: 800,
		nav: true
	});	

});