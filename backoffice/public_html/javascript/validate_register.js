$('#epin_tab').click(function() {
    document.getElementById("active_tab").value = "epin_tab";

});

$('#credit_card_tab').click(function() {
    document.getElementById("active_tab").value = "credit_card_tab";

});

$('#ewallet_tab').click(function() {
    document.getElementById("active_tab").value = "ewallet_tab";

});

$('#free_join_tab').click(function() {
    document.getElementById("active_tab").value = "free_join_tab";

});

$('#paypal_tab').click(function() {
    document.getElementById("active_tab").value = "paypal_tab";

});

$('#epdq_tab').click(function() {
    document.getElementById("active_tab").value = "epdq_tab";

});

$('#authorize_tab').click(function() {
    document.getElementById("active_tab").value = "authorize_tab";

});

$('#myTab3 a').click(function(e) {
    e.preventDefault();
    $('#myTab a:first').tab('show')
});

function addNewraw()
{
    var scntDiv = $('#p_scents');
    var j = $('#p_scents p').size() + 1;
    $('<tr   align="center" id = "epin_raw' + j + '" ><td>' + j + '</td> <td><p><label for="p_scnts"><div class="col-md-12"><input type="text" id="epin' + j + '" size="13" name="epin' + j + '" value="" placeholder="PIN"  autocomplete="off" class="form-control" onblur="check_epin_submit();"/></div><span id ="pin_box_' + j + '"> </span></label></td><td><div class="col-md-12"><input type="text" id="pin_amount' + j + '" size="13" readonly="true" class="form-control"/></div></td><td><div class="col-md-12"><input type="text" id="remaining_amount' + j + '" size="13" readonly="true" class="form-control"/></div></td><div class="col-md-12"><td><div class="col-md-12"><input type="text" id="balance_amount' + j + '" size="13" readonly="true" class="form-control"/></div></div></td></tr>').appendTo(scntDiv);
    j++;
    return false;
}

function removeRaw(i)
{
    var epin_id = "#epin_raw" + i;
    $(epin_id).remove();
}

function addFinishButn()
{
    var finButtDiv = $('#finButtn');
    $(' <div class="col-sm-2 col-sm-offset-8"><button  tabindex="48" class="btn btn-blue btn-block" id ="pin_ok" name= "pin_ok"   style="float: right;" >Finish <i class="fa fa-arrow-circle-right"></i></button ></div></div>').appendTo(finButtDiv);

    return true;
}

function validate_page()
{
    ValidateUser.init();
}

function check_epin_submit() {
    document.getElementById("pin_btn").disabled = false;
    document.getElementById("epin_submit").disabled = true;
}

function disable_ewallet()
{
    document.form.ewallet_submit.disabled = true;
}

function enable_ewallet()
{
    document.form.ewallet_submit.disabled = false;
}

$('#user_name_ewallet').blur(function() {
    var ewallet_username = $('#user_name_ewallet').val();
    var ewallet_password = $('#tran_pass_ewallet').val();
    if (ewallet_username != "" && ewallet_password != "") {
        validate_ewallet();
    }
});

$('#tran_pass_ewallet').blur(function() {
    var ewallet_username = $('#user_name_ewallet').val();
    var ewallet_password = $('#tran_pass_ewallet').val();
    if (ewallet_username != "" && ewallet_password != "") {
        validate_ewallet();
    }
});

function validate_ewallet() {

    var path_temp = document.form.path_temp.value;
    var path_root = document.form.path_root.value;
    var ewallet_username = $('#user_name_ewallet').val();
    var ewallet_password = $('#tran_pass_ewallet').val();
    var product_id = $('#product_id').val();

    disable_ewallet();

    if (ewallet_username == "" || ewallet_password == "") {

        $("#tran_pass_ewallet_box").fadeTo("fast", 1, function() //start fading the messagebox
        {
            var msg37 = $("#validate_msg61").html();
            $(this).removeClass();
            $(this).addClass('messageboxerror');
            $(this).html('<img align="absmiddle" src="' + path_temp + 'images/Error.png" />' + msg37).show().fadeTo("fast", 1);
            disable_ewallet();
        });
    } else {
        var ewallet_available = path_root + "register/check_ewallet_balance";
        var msg = $("#validate_msg60").html();
        $("#tran_pass_ewallet_box").removeClass();
        $("#tran_pass_ewallet_box").addClass('messagebox');
        $("#tran_pass_ewallet_box").html('<img align="absmiddle" src="' + path_temp + 'images/loader.gif" /> ' + msg).show().fadeTo("fast", 1);

        $.post(ewallet_available, {
            user_name: ewallet_username,
            ewallet: ewallet_password,
            product_id: product_id
        }, function(data) {
            if (data == "yes") {
                $("#tran_pass_ewallet_box").fadeTo("fast", 1, function()
                {
                    var msg39 = $("#validate_msg62").html();
                    $(this).removeClass();
                    $(this).addClass('messageboxok');
                    $(this).html('<img align="absmiddle" src="' + path_temp + 'images/accepted.png" />' + msg39).show().fadeTo("fast", 1);
                    document.getElementById("check_ewallet_button").style.display = "none";
                    enable_ewallet();
                });
            } else if (data == "invalid") {
                $("#tran_pass_ewallet_box").fadeTo("fast", 1, function() {
                    var msg37 = $("#validate_msg61").html();
                    $(this).removeClass();
                    $(this).addClass('messageboxerror');
                    $(this).html('<img align="absmiddle" src="' + path_temp + 'images/Error.png" />' + msg37).show().fadeTo("fast", 1);
                    disable_ewallet();
                });
            } else {
                $("#tran_pass_ewallet_box").fadeTo("fast", 1, function() {
                    var msg37 = $("#validate_msg50").html();
                    $(this).removeClass();
                    $(this).addClass('messageboxerror');
                    $(this).html('<img align="absmiddle" src="' + path_temp + 'images/Error.png" />' + msg37).show().fadeTo("fast", 1);
                    disable_ewallet();
                });
            }
        });
    }
}