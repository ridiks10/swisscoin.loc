


function validate_epin(total) {

    var path_temp = document.form.path_temp.value;
    var path_root = document.form.path_root.value;

    var validity = 0;
    var is_invalid_pin = 0;
    var valid_index = 0;
    var invalid_index = 0;
    var pin_amount = 0;
    var valid_codes = new Array();
    var invalid_codes = new Array();
    var limit = $('#p_scents p').size();
    //alert(limit);
    var epin_name = "";

    var pass_arr = new Array();
    var usd_pin = new Array();
    var index = 0;
    var flag = true;
    var epin_valid = path_root + "register_board/isEpinValid";
    var pin_ok_button = 0;
    var data1 = new Array();

    for (var i = 1; i <= limit; i++)
    {
        epin_name = '#epin' + i;
        var id = $(epin_name).val();
        var res = " ";
        res = getId(pass_arr, id);
        var pass_str = {'pin': res, 'amount': 0};
        pass_arr.push(pass_str);
    }
    function getId(pass_arr, id) {
        var i = 0;
        var j = 1;
        var arr_len = pass_arr.length;

        if (arr_len == 0)
            j = 1;
        if (arr_len > 0)
            j = 0;
        var pin = id;
        for (var i = j; i < arr_len; i++) {

            if (pass_arr[i].pin == id) {
                pin = 'nopin';


            }
            else
            {
                pin = id;
            }

        }
        return pin;
    }

    if (flag)
    {
        var epin_available = path_root + "register_board/isEpinValid/";
        var JSON_data = JSON.stringify(pass_arr);
        var epin = "";
        var amount = "";
        var toat_amount = 0;
        var i = 1;

        $.ajax({
            url: epin_available,
            type: 'POST',
            data: JSON.stringify({
                json: pass_arr
            }),
            dataType: "json",
            contentType: "application/json",
            success: function(data) {
                $.each(data, function(k, v) {

                    amount = v.amount;
                    epin = v.pin;


                    if (epin == "nopin")
                    {
                        $("#pin_box_" + i).fadeTo(2000, 0.1, function() //start fading the messagebox

                        {

                            var msg36 = "InValid epin..";
                            //var msg37 = $("#error_msg37").html();
                            //add message and change the class of the box and start fading

                            $(this).removeClass();

                            $(this).addClass('messageboxok');


                            $(this).html('<img align="absmiddle" src="' + path_temp + 'images/Error.png" />' + msg36).show().fadeTo(1900, 1);

                        });
                    }
                    else {
                        toat_amount += parseFloat(amount);

                        document.getElementById("pin_amount" + i).value = amount;
                        document.getElementById("balance_amount" + i).value = 0;
                        document.getElementById("remaining_amount" + i).value = 0;
                        $("#pin_box_" + i).fadeTo(2000, 0.1, function() //start fading the messagebox

                        {

                            var msg37 = " Valid epin..";
                            //var msg37 = $("#error_msg37").html();
                            //add message and change the class of the box and start fading

                            $(this).removeClass();

                            $(this).addClass('messageboxok');


                            $(this).html('<img align="absmiddle" src="' + path_temp + 'images/accepted.png" />' + msg37).show().fadeTo(1900, 1);

                        });
                        var product_amount = Math.round($('#product_amount').val() * 100) / 100;
                        if (toat_amount > $('#product_amount').val())
                        {
                            bal_amount = toat_amount - product_amount;
                            bal_amount = Math.round(bal_amount * 100) / 100;
                            new_amount = toat_amount - bal_amount;
                            new_amount = Math.round(new_amount * 100) / 100;
                            document.getElementById('epin_total_amount').value = new_amount;
                            toat_amount = new_amount;
                            document.getElementById("remaining_amount" + i).value = bal_amount;
                        }
                        req_amount = product_amount - toat_amount;
                        req_amount = Math.round(req_amount * 100) / 100;
                        document.getElementById("balance_amount" + i).value = req_amount;








                    }
                    i++;

                });

                if ((epin != 'nopin') || (is_invalid_pin != " ")) {
                    if ($('#product_amount').val() > toat_amount)
                    {
                        addNewraw();

                    }

                    else
                    {
                        $('#validate_epin_div').remove();
                        var pin_ok_button = "";
                        var usd_pin = new Array();

                        addFinishButn();


                        for (var j = 1; j <= limit; j++)
                        {
                            var epin_name = '#epin' + j;
                            var id = $(epin_name).val();
                            var pin_bal = $('#remaining_amount' + j).val();
                            var pin_amount = $('#pin_amount' + j).val();

                            if ($('#p_scents p').size() == j)
                                pin_ok_button = 1;
                            else
                                pin_ok_button = 0;

                            var used_pin_det = {'used_pin': id, 'bal_amount': pin_bal, pin_ok: pin_ok_button, pin_amount: pin_amount};

                            usd_pin.push(used_pin_det);


                        }

                        data1 = JSON.stringify(usd_pin);

                        var hidden_pin = document.getElementById('is_pin_ok');
                        hidden_pin.value = data1;
//                        
                        //  document.getElementById("pin_btn").disabled = true; 
                    }
                    document.getElementById('epin_total_amount').value = toat_amount;

                }


            }
//            error: function(request, errorType, errorThrown) {
//                alert('Error Type: ' + errorType + '  Request: ' + request + '  Error ' + errorThrown);

//            }
        });



    }

}

function addNewraw()
{
    var scntDiv = $('#p_scents');
    var j = $('#p_scents p').size() + 1;
    $('<tr   align="center" ><td>' + j + '</td> <td><p><label for="p_scnts"><div class="col-md-12"><input type="text" id="epin' + j + '" size="13" name="epin' + j + '" value="" placeholder="PIN"  autocomplete="off" class="form-control"/></div><span id ="pin_box_' + j + '"> </span></label></td><td><div class="col-md-12"><input type="text" id="pin_amount' + j + '" size="13" readonly="true" class="form-control"/></div></td><td><div class="col-md-12"><input type="text" id="remaining_amount' + j + '" size="13" readonly="true" class="form-control"/></div></td><div class="col-md-12"><td><div class="col-md-12"><input type="text" id="balance_amount' + j + '" size="13" readonly="true" class="form-control"/></div></div></td></tr>').appendTo(scntDiv);
    j++;
    return false;
}
function addFinishButn()
{
    var finButtDiv = $('#finButtn');

     $(' <div class="col-sm-2 col-sm-offset-8"><button  tabindex="48" class="btn btn-blue btn-block" id ="pin_ok" name= "pin_ok"   style="float: right;" >Finish <i class="fa fa-arrow-circle-right"></i></button ></div></div>').appendTo(finButtDiv);


    return true;
}

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
    $('#myTab3 a:first').tab('show');
});

$(document).ready(function()
{
    var path_temp = document.form.path_temp.value;
    var path_root = document.form.path_root.value;
    var product_status = document.getElementById("check_product_status").value;

    if (product_status == 'no') {
        var register_amount = path_root + "register/register_amount";
        $.post(register_amount, function(data) {
            if (data != 'no_data') {
                $('span.total-title').html(data);
                document.getElementById('product_amount').value = data;
            }

        });

    }
});
