/* =========================================================
 * SunriseGrid v1.0
 * =========================================================
 * Copyright 2013 drupalexp.com.
 * Author: nguyencongt3@gmail.com
 * ========================================================= */
!(function ($) {
  var sunriseGridOptions = [];
  $.fn.sunriseGrid = function (options) {
    var opt = null;
    if(options != null && typeof options == 'object'){
      var defaultVal = {
        cols: 3,
        item: '.sunrise-grid-item',
        hiddenClass: 'sunrise-grid-hidden',
        itemWidth: 250,
        itemHeight: 150,
        margin: 10,
        phoneWidth: 768
      };
      opt = $.extend(defaultVal, options);
      opt._cols = opt.cols;
    }
    return this.each(function () {
      var $this = $(this);
      if(opt==null){
        var optionIndex = $this.attr('data-grid-id');
        opt = sunriseGridOptions[optionIndex];
      }else{
        $this.attr('data-grid-id',sunriseGridOptions.length);
        sunriseGridOptions[sunriseGridOptions.length] = opt;
      }
      init($this, opt);
      $(window).resize(function () {
        sunriseWaitForFinalEvent(function () {
          init($this, opt);
        }, 100, "some unique string");
      })

    })

    function init(obj, opt) {
      if ($(window).width() < opt.phoneWidth) {
        opt.cols = 1
      } else {
        opt.cols = opt._cols
      }
      var itemWidth = (obj.width() - opt.margin * (opt.cols - 1)) / opt.cols;
      var itemHeight = itemWidth * opt.itemHeight / opt.itemWidth;
      var $items = obj.find(opt.item).not('.' + opt.hiddenClass);
      var rows = Math.ceil($items.length/opt.cols);
      var wrapHeight = itemHeight * rows + (rows-1) * opt.margin;
      obj.height(wrapHeight).css({position:'relative'});
      $items.css({
        position: 'absolute'
      }).width(itemWidth).height(itemHeight);
      $items.each(function (index) {
        var $item = $(this);
        var col = index % opt.cols;
        var row = Math.floor(index / opt.cols);
        var top = row * (itemHeight + opt.margin);
        var left = col * itemWidth + col * opt.margin;
        $item.css({
          top: top,
          left: left
        });
      });
    }
  };
  var sunriseWaitForFinalEvent = (function () {
    var d = {};
    return function (a, b, c) {
      if (!c) {
        c = "Don't call this twice without a uniqueId"
      }
      if (d[c]) {
        clearTimeout(d[c])
      }
      d[c] = setTimeout(a, b)
    }
  })();
})(jQuery);