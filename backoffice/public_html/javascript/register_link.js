function trim(a)
{
    return a.replace(/^\s+|\s+$/, '');
}

function disable_next1()
{
    document.form.next_1.disabled = true;
}

function enable_next1()
{
    document.form.next_1.disabled = false;
}
function disable_next2()
{
    document.form.next_2.disabled = true;
}

function enable_next2()
{
    document.form.next_2.disabled = false;
}

function check_step1(a, b, c)
{
    if (a == 1 && b == 1 && c == 1)
    {
        enable_next1();
    } else
    {
        disable_next1();
    }
}

$(document).ready(function()
{
    var path_temp = document.form.path_temp.value;
    var path_root = document.form.path_root.value;
    var product_status = document.form.product_status.value;
    var mlm_plan = document.form.mlm_plan.value;
    var reg_from_tree = document.form.reg_from_tree.value;
    var username_type = document.form.username_type.value;

    var sponsor_ok = 0;
    var position_ok = 0;
    var product_ok = 0;

    if (mlm_plan != "Binary" || reg_from_tree) {
        position_ok = 1;
    }
    if (product_status == "no") {
        product_ok = 1;
    }

//    disable_next1();

//    $("#sponsor_user_name").blur(function()
//    {
//        disable_next1();
//        var error = 0;
//        var referral_name = $('#sponsor_user_name').val();
//        if (referral_name == '') {
//            error = 1;
//            $("#referral_box").fadeTo(2200, 0.1, function() //start fading the messagebox
//            {
//                //add message and change the class of the box and start fading
//                var msg = $("#validate_msg8").html();
//                $(this).removeClass();
//                $(this).addClass('messageboxerror');
//                $(this).html('<img align="absmiddle" src="' + path_temp + 'images/Error.png" />' + msg).show().fadeTo(2200, 1);
//                document.getElementById('referal_div').style.display = "none";
//                sponsor_ok = 0;
//                check_step1(sponsor_ok, position_ok, product_ok);
//            });
//
//            $("#errormsg2").fadeTo(2200, 0.1, function() //start fading the messagebox
//            {
//                var msg = $("#validate_msg5").html();
//                //add message and change the class of the box and start fading
//
//                $(this).removeClass();
//
//                $(this).addClass('messageboxerror');
//
//                $(this).html('<img align="absmiddle" src="' + path_temp + 'images/Error.png" />' + msg).show().fadeTo(2200, 1);
//            });
//
//        }
//
//        if (error != 1)
//        {
//            var ref_user_availability = path_root + "register/validate_username";
//            var msg = $("#validate_msg7").html();
//            $("#referral_box").removeClass();
//
//            $("#referral_box").addClass('messagebox');
//
//            $("#referral_box").html('<img align="absmiddle" src="' + path_temp + 'images/loader.gif" /> ' + msg).show().fadeTo(2200, 1);
//
//            //check the username exists or not from ajax
//
//            $.post(ref_user_availability, {username: $('#sponsor_user_name').val()}, function(data)
//            {
//                if (trim(data) == 'no') //if username not avaiable
//                {
//                    $("#referral_box").fadeTo(2200, 0.1, function() //start fading the messagebox
//                    {
//                        //add message and change the class of the box and start fading
//                        msg = $("#validate_msg8").html();
//                        $(this).removeClass();
//                        $(this).addClass('messageboxerror');
//                        $(this).html('<img align="absmiddle" src="' + path_temp + 'images/Error.png" />' + msg).show().fadeTo(2200, 1);
//                        document.getElementById('referal_div').style.display = "none";
//                        sponsor_ok = 0;
//                        check_step1(sponsor_ok, position_ok, product_ok);
//                    });
//
//                    $("#errormsg2").fadeTo(2200, 0.1, function() //start fading the messagebox
//                    {
//                        var msg = $("#validate_msg5").html();
//                        //add message and change the class of the box and start fading
//
//                        $(this).removeClass();
//
//                        $(this).addClass('messageboxerror');
//
//                        $(this).html('<img align="absmiddle" src="' + path_temp + 'images/Error.png" />' + msg).show().fadeTo(2200, 1);
//
//                    });
//
//
//                } else {
//                    $("#referral_box").fadeTo(2200, 0.1, function()  //start fading the messagebox
//                    {
//                        //add message and change the class of the box and start fading
//                        msg = $("#validate_msg6").html();
//                        $(this).removeClass();
//                        $(this).addClass('messageboxok');
//                        $(this).html('<img align="absmiddle" src="' + path_temp + 'images/accepted.png" />' + msg).show().fadeTo(2200, 1);
//                        get_referral_name(referral_name);
//                        sponsor_ok = 1;
//                        check_step1(sponsor_ok, position_ok, product_ok);
//                    });
//
//                }
//            });
//        }
//    });

//    $("#position").change(function()
//    {
//        if (mlm_plan == "Binary") {
//            var error = 0;
//
//            if ($('#position').val() == '' || $('#sponsor_user_name').val() == '') {
//                error = 1;
//
//                $("#errormsg2").fadeTo(2200, 0.1, function() //start fading the messagebox
//
//                {
//                    var msg = $("#validate_msg5").html();
//                    //add message and change the class of the box and start fading
//
//                    $(this).removeClass();
//
//                    $(this).addClass('messageboxerror');
//
//                    $(this).html('<img align="absmiddle" src="' + path_temp + 'images/Error.png" />' + msg).show().fadeTo(2200, 1);
//
//                    position_ok = 0;
//                    check_step1(sponsor_ok, position_ok, product_ok);
//                });
//
//            }
//
//            if (error != 1)
//            {
//
//                var leg_availability = path_root + "register/check_leg_availability";
//
//                var msg = $("#validate_msg3").html();
//
//                //remove all the class add the messagebox classes and start fading
//
//                $("#errormsg2").removeClass();
//
//                $("#errormsg2").addClass('messagebox');
//
//                $("#errormsg2").html('<img align="absmiddle" src="' + path_temp + 'images/loader.gif" /> ' + msg).show().fadeTo(2200, 1);
//
//                //check the username exists or not from ajax
//
//                $.post(leg_availability, {
//                    sponsor_leg: $('#position').val(),
//                    sponsor_user_name: $('#sponsor_user_name').val()
//                }, function(data)
//
//                {
//
//                    if (trim(data) == 'no') //if username not avaiable
//
//                    {
//
//                        $("#errormsg2").fadeTo(2200, 0.1, function() //start fading the messagebox
//
//                        {
//                            var msg = $("#validate_msg5").html();
//                            //add message and change the class of the box and start fading
//
//                            $(this).removeClass();
//
//                            $(this).addClass('messageboxerror');
//
//                            $(this).html('<img align="absmiddle" src="' + path_temp + 'images/Error.png" />' + msg).show().fadeTo(2200, 1);
//
//                            position_ok = 0;
//                            check_step1(sponsor_ok, position_ok, product_ok);
//                        });
//
//                    }
//
//                    else
//
//                    {
//                        $("#errormsg2").fadeTo(2200, 0.1, function()
//                        {
//                            var msg = $("#validate_msg4").html();
//
//                            $(this).removeClass();
//
//                            $(this).addClass('messageboxok');
//
//                            $(this).html('<img align="absmiddle" src="' + path_temp + 'images/accepted.png" />' + msg).show().fadeTo(2200, 1);
//
//                            position_ok = 1;
//                            check_step1(sponsor_ok, position_ok, product_ok);
//                        });
//                    }
//                });
//            }
//        } else {
//            position_ok = 1;
//            check_step1(sponsor_ok, position_ok, product_ok);
//        }
//    });

//    $("#product_id").change(function()
//    {
//
//        var currency_symbol_left = $("#DEFAULT_SYMBOL_LEFT").val();
//        var currency_symbol_right = $("#DEFAULT_SYMBOL_RIGHT").val();
//
//        if (product_status == "yes") {
//
//            var error = 0;
//
//            if ($('#product_id').val() == '') {
//                error = 1;
//
//                $("#error_product").fadeTo(2200, 0.1, function() //start fading the messagebox
//
//                {
//                    var msg = "Invalid Product";
//                    //add message and change the class of the box and start fading
//
//                    $(this).removeClass();
//
//                    $(this).addClass('messageboxerror');
//
//                    $(this).html('<img align="absmiddle" src="' + path_temp + 'images/Error.png" />' + msg).show().fadeTo(2200, 1);
//
//                    product_ok = 0;
//                    check_step1(sponsor_ok, position_ok, product_ok);
//                });
//
//            }
//
//            if (error != 1)
//            {
//
//                $("#error_product").removeClass();
//                $("#error_product").html("");
//
//                var product_id = document.getElementById('product_id').value;
//                var total_reg_fee = path_root + "register/get_total_registration_fee";
//                $.post(total_reg_fee, {product_id: product_id}, function(data) {
//                    var split_array = data.split("==");
//                    var reg_amount = split_array[0];
//                    var product_amount = split_array[1];
//                    var total_reg_amount = split_array[2];
//
//                    $('span#total_product_amount').html("<b>" + currency_symbol_left + total_reg_amount + currency_symbol_right + "</b>");
//                    document.getElementById('registration_fee').value = reg_amount;
//                    document.getElementById('product_amount').value = product_amount;
//                    document.getElementById('total_reg_amount').value = total_reg_amount;
//                    document.getElementById('total_product_amount').value = total_reg_amount;
//                });
//                product_ok = 1;
//                check_step1(sponsor_ok, position_ok, product_ok);
//            }
//        } else {
//            product_ok = 1;
//            check_step1(sponsor_ok, position_ok, product_ok);
//        }
//    });

    $("#user_name_entry").blur(function()
    {
        $('#form_submit').prop("disabled",true);
        if (username_type == "static") {
            var error = 0;

            if ($("#user_name_entry").val() == '') {
                error = 1;

                $("#errormsg3").fadeTo(2200, 0.1, function() //start fading the messagebox

                {
                    var msg;
                    msg = $("#validate_msg72").html();

                    //add message and change the class of the box and start fading

                    $(this).removeClass();

                    $(this).addClass('messageboxerror');

                    $(this).html('<img align="absmiddle" src="' + path_temp + 'images/Error.png" />' + msg).show().fadeTo(2200, 1);

//                    disable_next2();

                });
            }

            if (error != 1)

            {
                var length = $('#user_name_entry').val().length;

                if (length >= 6)
                {
                    var user_name_availability = path_root + "register/check_username_availability"
                    var msg = $("#validate_msg27").html();

                    //remove all the class add the messagebox classes and start fading

                    $("#errormsg3").removeClass();

                    $("#errormsg3").addClass('messagebox');

                    $("#errormsg3").html('<img align="absmiddle" src="' + path_temp + 'images/loader.gif" /> ' + msg).show().fadeTo(2200, 1);

                    //check the username exists or not from ajax

                    $.post(user_name_availability, {user_name: $('#user_name_entry').val()}, function(data)

                    {

                        if (trim(data) == 'no') //if username not avaiable

                        {

                            $("#errormsg3").fadeTo(2200, 0.1, function() //start fading the messagebox

                            {
                                var msg;
                                msg = $("#validate_msg28").html();

                                //add message and change the class of the box and start fading

                                $(this).removeClass();

                                $(this).addClass('messageboxerror');

                                $(this).html('<img align="absmiddle" src="' + path_temp + 'images/Error.png" />' + msg).show().fadeTo(2200, 1);

//                                disable_next2();

                            });

                        }

                        else

                        {

                            $("#errormsg3").fadeTo(2200, 0.1, function()  //start fading the messagebox

                            {
                                var msg = $("#validate_msg29").html();


                                $(this).removeClass();

                                $(this).addClass('messageboxok');

                                $(this).html('<img align="absmiddle" src="' + path_temp + 'images/accepted.png" />' + msg).show().fadeTo(2200, 1);

//                                enable_next2();
$('#form_submit').prop("disabled",false);


                            });

                        }

                    });
                }
                else {
                    $("#errormsg3").fadeTo(2200, 0.1, function()  //start fading the messagebox

                    {
                        msg = $("#validate_msg63").html();

                        $(this).removeClass();

                        $(this).addClass('messageboxerror');

                        $(this).html('<img align="absmiddle" src="' + path_temp + 'images/Error.png" />' + msg).show().fadeTo(2200, 1);

//                        disable_next2();
                    });
                }
            }
        }
    });

//    $("#sponsor_user_name").keypress(function(e)
//    {
//        //if the letter is not digit then display error and don't type anything
//        var msg = $("#validate_msg75").html();
//        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && (e.which < 65 || e.which > 90) && (e.which < 97 || e.which > 122))
//
//        {
//            //display error message            
//
//            $("#errormsg4").html(msg).show().fadeOut(2200, 0);
//
//            return false;
//        }
//
//    });

    $("#user_name_entry").keypress(function(e)
    {
        var msg = $("#validate_msg75").html();
        //if the letter is not digit then display error and don't type anything

        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && (e.which < 65 || e.which > 90) && (e.which < 97 || e.which > 122))

        {
            //display error message            

            $("#errmsg33").html(msg).show().fadeOut(2200, 0);

            return false;
        }

    });
    $("#pswd").keypress(function(e)
    {
//        var msg = $("#validate_msg75").html();
        //if the letter is not digit then display error and don't type anything
        if (e.which == 32)
        {           
//            $("#errmsg33").html(msg).show().fadeOut(2200, 0);
            return false;
        }

    });
    $("#cpswd").keypress(function(e)
    {
//      var msg = $("#validate_msg75").html();
        //if the letter is not digit then display error and don't type anything
        if (e.which == 32)
        {           
//            $("#errmsg33").html(msg).show().fadeOut(2200, 0);
            return false;
        }

    });

//    $("#pin").keypress(function(e)
//    {
//        //if the letter is not digit then display error and don't type anything
//
//        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57))
//
//        {
//            //display error message
//
//            $("#errmsg2").html("Digits Only ").show().fadeOut(2200, 0);
//
//            return false;
//
//        }
//
//    });

//    $("#mobile").keypress(function(e)
//    {
//        var msg20 = $("#validate_msg37").html();
//
//        //if the letter is not digit then display error and don't type anything
//
//        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57))
//
//        {
//
//            //display error message
//
//            $("#errmsg5").html(msg20).show().fadeOut(2200, 0);
//
//            return false;
//
//        }
//
//    });
//
//    $("#land_line").keypress(function(e)
//    {
//        //if the letter is not digit then display error and don't type anything
//        var msg = $("#validate_msg37").html();
//        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57))
//
//        {
//
//            //display error message
//
//            $("#errmsg4").html(msg).show().fadeOut(2200, 0);
//
//            return false;
//
//        }
//
//    });
//
//    function get_referral_name(referral_name)
//    {
//        var html;
//        var msg = $("#validate_msg68").html();
//        var get_referral_name_url = path_root + "register/get_sponsor_full_name";
//        $.post(get_referral_name_url, {sponsor_user_name: referral_name}, function(data)
//        {
//            data = trim(data);
//            html = "<div class='form-group'>  <label class='col-sm-3 control-label' for='sponsor_full_name'>" + msg + ":<font color='#ff0000'>*</font></label> <div class='col-sm-7'><input tabindex='2' type='text' name='sponsor_full_name' id='sponsor_full_name' autocomplete='Off' value='" + data + "' readonly='true' class='form-control'/></div></div>";
//            document.getElementById('referal_div').innerHTML = html;
//            document.getElementById('referal_div').style.display = "";
//        });
//    }
});

