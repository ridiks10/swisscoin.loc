$(document).ready(function()

{

    $.post("toolTip/validate_tooltip", {user_details: $('#user_details')}, function(data) {
	$(this).html(data);
    });


});
