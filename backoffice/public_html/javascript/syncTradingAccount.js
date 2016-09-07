$(document).ready(function(){
    var $run = $('#run');
    var $stop = $('#stop');
    var $state = $('#state');
    var $total = $('#total');


    data = {
        done: 0
    };
    stop = false;
    var success = function(response){
        if(response.total != undefined){
            total = response.total;
            $total.text(total);
        }
        process =  Math.round(response.done / total * 100 * 100) / 100 + '%';
        $('#done').text(response.done);
        $('.progress-bar').css('width', process);

        data.done = response.done;
        if(response.done >= total){
            $run.hide();
            $stop.hide();
            $stop.text('Stop script');
            $state.text('finished');
        }else if(!stop){
            $.get(ajaxurl, data, success , 'json');
        }else{
            $run.show();
            $stop.hide();
            $stop.text('Stop script');
            $state.text('stopped');
            setTimeout(function(){$('#state').text('waiting for action...')},1500);
        }
    };
    var process;
    $run.click(function(){
        stop = false;
        $run.hide();
        $stop.show().removeAttr('disabled');
        $state.text('in process...');
        $.get(ajaxurl, data, success , 'json');
    });
    $stop.click(function(){
        stop = true;
        $state.text('stopping...');
        $stop.text('Stopping script...').attr('disabled', 'disabled');
    });
    
});