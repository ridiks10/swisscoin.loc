var stop = false;
$(document).ready(function(){

    var $run = $('#run');
    var $stop = $('#stop');
    var $state = $('#state');
    var $total = $('#total');
    var $restart = $('#restart');
    var $done = $('#done');


    data = {
        done: 0,
        total: null,
        force_finish: false
    };
    var success = function(response){
        if(response.total != data.total){
            data.total = response.total;
            $total.text(data.total);
        }
        data.done = response.done;
        data.force_finish = response.force_finish;

        var process =  Math.round(data.done / data.total * 100 * 100) / 100 + '%';
        console.log(process);
        $done.text(data.done);
        $('.progress-bar').css('width', process);
        if(data.done >= data.total || data.force_finish){
            $run.hide();
            $stop.hide();
            $stop.text('Stop script');
            $state.text('finished');
            $restart.removeAttr('disabled');
        }else if(stop){
            $run.show();
            $stop.hide();
            $stop.text('Stop script');
            $state.text('stopped');
            $restart.removeAttr('disabled');
            setTimeout(function () {
                $('#state').text('waiting for action...');
            }, 1000);
        }else{
            $.get(ajaxurl, data, success , 'json');
        }
    };
    $run.click(function(){
        stop = false;
        $run.hide();
        $restart.attr('disabled', 'disabled');
        $stop.show().removeAttr('disabled');
        $state.text('in process...');
        $.get(ajaxurl, data, success , 'json');
    });
    $stop.click(function(){
        stop = true;
        $state.text('stopping...');
        $stop.text('Stopping script...').attr('disabled', 'disabled');
    });
    $restart.click(function(){
        return; //Avoid HARD Resseting
        $run.attr('disabled', 'disabled');
        $stop.attr('disabled', 'disabled');
        $.get(restarturl, {}, function(){
            data = {
                done: 0,
                total: null,
                force_finish: false
            };
            $done.text(data.done);
            $total.text(0);
            $('.progress-bar').css('width', '0%');
            $run.show().removeAttr('disabled');
            $stop.hide().removeAttr('disabled');
        } , 'json');
    });

});