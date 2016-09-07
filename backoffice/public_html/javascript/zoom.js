jQuery(window).load(function() {
   
    jQuery('#dsply_tree_zoomable').css(
            {
            });

    var currZoom = 1;

    jQuery(".zoomIn").click(function() {
        currZoom += 0.1;
        jQuery('#dsply_tree_zoomable').css(
                {
                    'width': $(window).width() - 40,
                    'zoom': currZoom,
                    'MozTransform':'scale(' + currZoom + ','+ currZoom + ')',
                    'transform-origin':'0 0'
                });
    });
    jQuery(".zoomOff").click(function() {
     
      currZoom = 1;
        jQuery("#dsply_tree_zoomable").css(
                {
                    'width': $(window).width()-40,
                    'zoom': currZoom,
                    'MozTransform':'scale(' + currZoom + ','+ currZoom + ')',
                    'transform-origin':'0 0'
                });
    });
    jQuery(".zoomOut").click(function() {
        currZoom -= 0.1;
        jQuery('#dsply_tree_zoomable').css(
                {
                    'width': $(window).width() - 40,
                    'zoom': currZoom,
                    'MozTransform':'scale(' + currZoom + ','+ currZoom + ')',
                    'transform-origin':'0 0'
                });
    });

});

