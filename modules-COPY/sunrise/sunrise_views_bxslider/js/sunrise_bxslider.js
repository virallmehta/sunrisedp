(function($){
	// Responsive Slideshow
	Drupal.behaviors.sunrise_bxslider = {
		attach: function(context,settings) {
			$('.sunrise-bxslider').each(function(index){
        
				var $this = $(this), responsiveID = $(this).attr('id');
				var options = jmbxAdjustOptions(settings.sunrisebxsliders[responsiveID],$(this).innerWidth());
			    $(this).attr({
			      'data-item-width': options.slideWidth
			    });
				var slide = $(this).bxSlider(options);
        		var windowW = $(window).width();
        		$(window).resize(function(){
          			waitForFinalEvent(function () {
            		if(windowW == $(window).width()) return;
            		windowW = $(window).width();
            		slide.destroySlider();
            		options = jmbxAdjustOptions(settings.sunrisebxsliders[responsiveID],$this.innerWidth());
            		slide = $this.bxSlider(options);
          		}, 500, responsiveID)
        		})
			});
		}
	};
	
	/*Adjust bxslider options to fix on any screen*/
	function jmbxAdjustOptions(options, container_width){
		var _options = {};
		$.extend(_options, options);
		
		if((_options.slideWidth*_options.maxSlides + (_options.slideMargin*(_options.maxSlides-1))) < container_width){
			_options.slideWidth = (container_width-(_options.slideMargin*(_options.maxSlides-1)))/_options.maxSlides;
		}else{
			_options.maxSlides = Math.floor((container_width-(_options.slideMargin*(_options.maxSlides-1)))/_options.slideWidth);
			_options.maxSlides = _options.maxSlides == 0?1:_options.maxSlides;
			_options.slideWidth = (container_width-(_options.slideMargin*(_options.maxSlides-1)))/_options.maxSlides;
		}
		tmpwidth = _options.slideWidth;
		_options.slideWidth = tmpwidth + 120;
		return _options;
	}
  //
	var waitForFinalEvent = (function () {
    var d = {};
    return function (a, b, c) {
      if (!c) {
        c = "Don't call this twice without a uniqueId"
      }
      if (d[c]) {
        clearTimeout(d[c]);
      }
      d[c] = setTimeout(a, b);
    }
  })();
})(jQuery);