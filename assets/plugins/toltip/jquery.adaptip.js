/*
jquery.adaptip.js
https://github.com/bertanyaman/AdapTip
Author Bertan Yaman (http://bertanyaman.com/)
jQuery 1.7+
*/

(function($) {

  $.fn.adapTip = function(options) {

    // Default options.
    var settings = $.extend({
      placement: 'auto', // auto (default), top, bottom, left, right, top right, top left, right bottom, left bottom
    }, options);

    var ww = $(window).width(),
      wh = $(window).height(),
      xpart = ww / 3,
      ypart = wh / 3,
      horizontal,
      vertical;

    $(window).resize(function() {
      ww = $(window).width(),
        wh = $(window).height(),
        xpart = ww / 3,
        ypart = wh / 3;
    });

    this.addClass("tp-tooltip-elem");

    $(document).on("mousemove", function(event) {

      // |''''''''|''''''''|''''''''|
      // |    1   |    2   |    3   |
      // |........|........|........|
      // |    4   |    5   |    6   |
      // |........|........|........|
      // |    7   |    8   |    9   |
      // |........|........|........|
      //
      // 1 Top Left
      // 2 Top Center
      // 3 Top Right
      // 4 Middle Left
      // 5 Middle Center
      // 6 Middle Right
      // 7 Bottom Left
      // 8 Bottom Center
      // 9 Bottom Right

      switch (true) {
        case (event.pageX < xpart):
          horizontal = "left";
          break;
        case (event.pageX >= xpart && event.pageX <= xpart * 2):
          horizontal = "center";
          break;
        default:
          horizontal = "right";
      }

      switch (true) {
        case (event.pageY < ypart):
          vertical = "top";
          break;
        case (event.pageY >= ypart && event.pageY <= ypart * 2):
          vertical = "middle";
          break;
        default:
          vertical = "bottom";
      }

    });
    
    this.on("mouseenter",function() {
      var $this = $(this),
        $thisw = $this.width(),
        $thish = $this.height(),
        $thistitle = $this.attr("data-tp-title"),
        $thisdesc = $this.attr("data-tp-desc");

      $this.append('<div class="tp-tooltip"><div class="tp-container"><div class="tp-arrow"></div><div class="tp-content"><h6>' + $thistitle + '</h6><p>' + $thisdesc + '</p></div></div></div>');

      $(".tp-tooltip").addClass("in " + horizontal + " " + vertical);

      // placement
      switch (true) {
        case (settings.placement == "right bottom"):
          $(".tp-tooltip").removeClass("top left right bottom middle center").addClass("in top left");
          $(".tp-tooltip").css({
            "top": "100%",
            "left": -(37 - $thisw / 2)
          });
          break;
        case (settings.placement == "bottom"):
          $(".tp-tooltip").removeClass("top left right bottom middle center").addClass("top center");
          $(".tp-tooltip").css({
            "top": "100%",
            "left": "50%",
            "-webkit-transform": "translate(-50%)",
            "-ms-transform": "translate(-50%)",
            "transform": "translate(-50%)"
          });
          break;
        case (settings.placement == "left bottom"):
          $(".tp-tooltip").removeClass("top left right bottom middle center").addClass("top right");
          $(".tp-tooltip").css({
            "top": "100%",
            "right": -(37 - $thisw / 2)
          });
          break;
        case (settings.placement == "right"):
          $(".tp-tooltip").removeClass("top left right bottom middle center").addClass("middle left");
          $(".tp-tooltip").css({
            "top": $thish / 2,
            "left": "100%",
            "-webkit-transform": "translateY(-50%)",
            "-ms-transform": "translateY(-50%)",
            "transform": "translateY(-50%)"
          });
          break;
        case (settings.placement == "left"):
          $(".tp-tooltip").removeClass("top left right bottom middle center").addClass("middle right");
          $(".tp-tooltip").css({
            "top": $thish / 2,
            "right": "100%",
            "-webkit-transform": "translateY(-50%)",
            "-ms-transform": "translateY(-50%)",
            "transform": "translateY(-50%)"
          });
          break;
        case (settings.placement == "top right"):
          $(".tp-tooltip").removeClass("top left right bottom middle center").addClass("bottom left");
          $(".tp-tooltip").css({
            "bottom": "100%",
            "left": -(37 - $thisw / 2)
          });
          break;
        case (settings.placement == "top"):
          $(".tp-tooltip").removeClass("top left right bottom middle center").addClass("bottom center");
          $(".tp-tooltip").css({
            "bottom": "100%",
            "left": "50%",
            "-webkit-transform": "translate(-50%)",
            "-ms-transform": "translate(-50%)",
            "transform": "translate(-50%)"
          });
          break;
        case (settings.placement == "top left"):
          $(".tp-tooltip").removeClass("top left right bottom middle center").addClass("bottom right");
          $(".tp-tooltip").css({
            "bottom": "100%",
            "right": -(37 - $thisw / 2)
          });
          break;
          //  auto
        case (vertical == "top" && horizontal == "left"):
          $(".tp-tooltip").css({
            "top": "100%",
            "left": -(37 - $thisw / 2)
          });
          break;
        case ((vertical == "top" && horizontal == "center") || (vertical == "middle" && horizontal == "center")):
          $(".tp-tooltip").css({
            "top": "100%",
            "left": "50%",
            "-webkit-transform": "translate(-50%)",
            "-ms-transform": "translate(-50%)",
            "transform": "translate(-50%)"
          });
          break;
        case (vertical == "top" && horizontal == "right"):
          $(".tp-tooltip").css({
            "top": "100%",
            "right": -(37 - $thisw / 2)
          });
          break;
        case (vertical == "middle" && horizontal == "left"):
          $(".tp-tooltip").css({
            "top": $thish / 2,
            "left": "100%",
            "-webkit-transform": "translateY(-50%)",
            "-ms-transform": "translateY(-50%)",
            "transform": "translateY(-50%)"
          });
          break;
        case (vertical == "middle" && horizontal == "right"):
          $(".tp-tooltip").css({
            "top": $thish / 2,
            "right": "100%",
            "-webkit-transform": "translateY(-50%)",
            "-ms-transform": "translateY(-50%)",
            "transform": "translateY(-50%)"
          });
          break;
        case (vertical == "bottom" && horizontal == "left"):
          $(".tp-tooltip").css({
            "bottom": "100%",
            "left": -(37 - $thisw / 2)
          });
          break;
        case (vertical == "bottom" && horizontal == "center"):
          $(".tp-tooltip").css({
            "bottom": "100%",
            "left": "50%",
            "-webkit-transform": "translate(-50%)",
            "-ms-transform": "translate(-50%)",
            "transform": "translate(-50%)"
          });
          break;
        case (vertical == "bottom" && horizontal == "right"):
          $(".tp-tooltip").css({
            "bottom": "100%",
            "right": -(37 - $thisw / 2)
          });
          break;
        default:
          console.log("Something went wrong during the positioning process on hover.");
          $(".tp-tooltip").removeClass("top left right bottom middle center").addClass("top center");
          $(".tp-tooltip").css({
            "top": "100%",
            "left": "50%",
            "-webkit-transform": "translate(-50%)",
            "-ms-transform": "translate(-50%)",
            "transform": "translate(-50%)"
          });
      }

    });
    
    this.on("mouseleave",function(){
      $(".tp-tooltip").remove();
    });

  };

}(jQuery));