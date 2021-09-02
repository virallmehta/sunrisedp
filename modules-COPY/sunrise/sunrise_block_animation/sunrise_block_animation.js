jQuery(document).ready(function($){
  $(".sab_animate").each(function(){
    var $this = $(this);
    var animate_class = $this.data('animate');
    var delay = ($this.attr('data-delay') ? $this.attr("data-delay") : 1);
    $this.appear(function(){
			setTimeout(function(){
        $this.addClass(animate_class);
				$this.addClass('animated');
			},delay);
    },{
      accX: 0,
      accY: 0,
      one:false
    });	
  });
})