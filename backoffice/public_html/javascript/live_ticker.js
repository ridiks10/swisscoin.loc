var LiveTicker = {
    notification: function () {
        var base_url = $('#base_url').val();
        var user_type = $('#user_type').val();
        if (user_type == 'distributor') {
            user_type = 'user';
        }
        if (user_type == 'employee') {
            user_type = 'admin';
        }
        var get_details = base_url +user_type+ '/home/live_ticker';
        $.post(get_details, {}, function (data) {

            if (data)
                $('#live_ticker').html(data);
            else
                $('#live_ticker').html('<h4>No Registration Found</h4>');

        });

    },
    init: function () {
        this.notification();
    }
}
function call_init() {
    LiveTicker.init();
}