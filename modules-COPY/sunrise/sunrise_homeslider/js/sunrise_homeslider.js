(function($)  {
  Drupal.behaviors.sunrise_homeslider = {
    attach: function(context)  {

$(window).load(function(){
  $('.slider').fractionSlider({
    'fullWidth':      true,
    'controls':       false, 
    'pager':        false,
    'responsive':       true,
    'dimensions':       "1000,400",
    'increase':       false,
    'pauseOnHover':     true,
    'slideEndAnimation':  true
  });

});
    
    }
  }
})(jQuery);