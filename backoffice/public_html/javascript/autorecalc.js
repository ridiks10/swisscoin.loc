$(document).ready(function(){
    
    console.log('start');
    
    var btn = $('#run'),
        el = $('#result-container'),
        frame = null,
        count = 0;
    
    var f_success = function (data, textStatus, jqXHR) {
        frame.find('.panel-body').html(data);
        frame.prev('.panel').find('.panel-body').hide();
        if (frame.find('.recalculate-complete').length) {
            frame = null;
            el.append('<div class="alert alert-success" role="alert">Calculation complete</div>');
        } else {
            frame = null;
            e_click(false);
        }
    };
    
    var f_error = function(jqXHR, textStatus, errorThrown) {
        frame.find('.panel-body').html('<div class="alert alert-danger" role="alert">There was an error. You can safely start script again. If error persists please notify? with detailed information</div>');
        frame = null;
        btn.on('click', e_click);
    };
    
    var e_click = function (e) {
        if (e) {
            e.preventDefault();
            e.stopPropagation();
        }
        
        btn.off('click');
        count++;
        frame = $('<div class="panel panel-default"><div class="panel-heading"><h3 class="panel-title">' + count + '. Script start at ' + (new Date()).toString() + '</h3></div><div class="panel-body">WORKING...</div></div>');
        el.append(frame);
        
        $.ajax({
            url: ajaxurl,
            data: {},
            success: f_success,
            dataType: "html",
            error: f_error
        });

    };
    
    el.on('click', '.panel-heading', function(e){
        e.preventDefault();
        e.stopPropagation();
        $(this).next('.panel-body').toggle();
    });
    
    if (!ajaxurl) {
        el.append('<div class="alert alert-danger" role="alert">We cannot find ajax url. Please fix this</div>');
    } else {
        btn.on('click', e_click);
    }
    
});