$(document).ready(function ()
{
    var msg1 = $("#validate_msg4").html();
    var msg2 = $("#validate_msg13").html();
    var msg3 = $("#validate_msg12").html();
    var msg4 = $("#validate_msg14").html();

    if ($('#Dynamic').attr('checked')) {

        $("#user_type_div").show();
        $("#user_type_div1").show();

    }
    $("#Dynamic").click(function () {
        $("#user_type_div").show();
        $("#user_type_div1").show();

        if ($('#yes').attr('checked')) {

            var prefix_val = $('#user_name_config').html();

            var html;
            html = "<td>Username Prefix:<font color='#ff0000'>*</font></strong></td><td><input type='text' name ='prefix' id ='prefix' value='' maxlength='19' tabindex='8' title='This is the prefix of user name. It should contain 3 to 15 characters.'><span id='errmsg1'></span></td>";
            document.getElementById('prefix_div').innerHTML = html;
            $('#prefix').val(prefix_val);
            $("#prefix_div").show();
        }
    });
    $("#Static").click(function () {
        $("#user_type_div").hide("fast");
        $("#user_type_div1").hide("fast");
        $("#prefix_div").hide("fast");

    });

    if ($('#yes').attr('checked')) {

        var prefix_val = $('#user_name_config').html();

        var html;
        html = "<td>Username Prefix:<font color='#ff0000'>*</font></strong></td><td><input type='text' name ='prefix' id ='prefix' value='' maxlength='19' tabindex='8' title='This is the prefix of user name. It should contain 3 to 15 characters.'><span id='errmsg1'></span></td>";
        document.getElementById('prefix_div').innerHTML = html;
        $('#prefix').val(prefix_val);
        $("#prefix_div").show();


    }
    $("#yes").click(function () {
        var prefix_val = $('#user_name_config').html();
        html = "<td>Username Prefix:<font color='#ff0000'>*</font></strong></td><td><input type='text' name ='prefix' id ='prefix' value='' maxlength='19' tabindex='9' title='This is the prefix of user name. It should contain 3 to 15 characters.'><span id='errmsg1'></span></td>";
        document.getElementById('prefix_div').innerHTML = html;
        $('#prefix').val(prefix_val);
        $("#prefix_div").show();

    });
    $("#no").click(function () {
        $("#prefix_div").hide("fast");

    });


    $("#service").keypress(function (e)
    {
        var flag = 0;
        if (e.which == 46) {
            if ($(this).val().indexOf('.') != -1) {
                flag = 1;
            }
        }
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && e.which != 46)
        {
            flag = 1;
        }
        if (flag == 1) {
            //display error message
            $("#errmsg1").html(msg2).show().fadeOut(2200, 0);
            return false;
        }
    });
    $("#tds").keypress(function (e)
    {
        var flag = 0;
        if (e.which == 46) {
            if ($(this).val().indexOf('.') != -1) {
                flag = 1;
            }
        }
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && e.which != 46)
        {
            flag = 1;
        }
        if (flag == 1) {
            //display error message
            $("#errmsg2").html(msg2).show().fadeOut(1200, 0);
            return false;
        }
    });
    $("#pair").keypress(function (e)
    {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57))
        {
            //display error message
            $("#errmsg3").html(msg2).show().fadeOut(2200, 0);
            return false;
        }
    });
    $("#ceiling").keypress(function (e)
    {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57))
        {
            //display error message
            $("#errmsg4").html(msg2).show().fadeOut(2200, 0);
            return false;
        }
    });
    $("#referal_amount").keypress(function (e)
    {
        var flag = 0;
        if (e.which == 46) {
            if ($(this).val().indexOf('.') != -1) {
                flag = 1;
            }
        }
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && e.which != 46)
        {
            flag = 1;
        }
        if (flag == 1) {
            //display error message
            $("#errmsg6").html(msg2).show().fadeOut(1200, 0);
            return false;
        }

    });
    $("#reg_amount").keypress(function (e)
    {
        var flag = 0;
        if (e.which == 46) {
            if ($(this).val().indexOf('.') != -1) {
                flag = 1;
            }
        }
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && e.which != 46)
        {
            flag = 1;
        }
        if (flag == 1) {   //display error message
            $("#errmsg3").html(msg2).show().fadeOut(1200, 0);
            return false;
        }
    });

    $("#direct_bonus").keypress(function (e)
    {
        var flag = 0;
        if (e.which == 46) {
            if ($(this).val().indexOf('.') != -1) {
                flag = 1;
            }
        }
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && e.which != 46)
        {
            flag = 1;
        }
        if (flag == 1) {   //display error message
            $("#errmsg3").html(msg2).show().fadeOut(1200, 0);
            return false;
        }
    });



    $("#trans_fee").keypress(function (e)
    {
        var flag = 0;
        if (e.which == 46) {
            if ($(this).val().indexOf('.') != -1) {
                flag = 1;
            }
        }
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && e.which != 46)
        {
            flag = 1;
        }
        if (flag == 1) {
            //display error message
            $("#errmsg7").html(msg2).show().fadeOut(1200, 0);
            return false;
        }
    });
    $("#pair_ceiling").keypress(function (e)
    {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57))
        {
            //display error message
            $("#errmsg8").html(msg2).show().fadeOut(1200, 0);
            return false;
        }
    });
    $("#pair_value").keypress(function (e)
    {
        //if the letter is not digit then display error and don't type anything
        if (e.which == 46) {
            if ($(this).val().indexOf('.') != -1) {
                $("#errmsg9").html(msg2).show().fadeOut(1200, 0);
                return false;
            }
        }
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && e.which != 46)
        {
            //(event.which != 46 && $(this).val().indexOf('.') == 0)
            //display error message
            $("#errmsg9").html(msg2).show().fadeOut(1200, 0);
            return false;
        }
    });
    $("#depth_ceiling").keypress(function (e)
    {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57))
        {
            //display error message
            $("#errmsg10").html(msg2).show().fadeOut(1200, 0);
            return false;
        }
    });
    $("#pair_price").keypress(function (e)
    {
        if (e.which == 46) {
            if ($(this).val().indexOf('.') > 0) {
                $("#errmsg11").html(msg2).show().fadeOut(1200, 0);
                return false;
            }
        }
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && e.which != 46)
        {
            //display error message
            $("#errmsg11").html(msg2).show().fadeOut(1200, 0);
            return false;
        }
    });
    $("#width_ceiling").keypress(function (e)
    {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57))
        {
            //display error message
            $("#errmsg12").html(msg2).show().fadeOut(1200, 0);
            return false;
        }
    });
    $("#product_point_value").keypress(function (e)
    {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57))
        {
            //display error message
            $("#errmsg13").html(msg2).show().fadeOut(1200, 0);
            return false;
        }
    });
    $("#length").keypress(function (e)
    {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57))
        {
            //display error message
            $("#errmsg1").html(msg2).show().fadeOut(1200, 0);
            return false;
        }
    });
    $(".level_percentage").keypress(function (e)
    {
        if (e.which == 46) {
            if ($(this).val().indexOf('.') > 0) {
                $("#errmsg9").html(msg2).show().fadeOut(1200, 0);
                return false;
            }
        }

        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && e.which != 46)
        {
            return false;
        }
    });

    $("#board1_commission").keypress(function (e)
    {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57))
        {
            //display error message
            $("#errmsg4").html(msg2).show().fadeOut(1200, 0);
            return false;
        }
    });
    $("#board2_commission").keypress(function (e)
    {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57))
        {
            //display error message
            $("#errmsg5").html(msg2).show().fadeOut(1200, 0);
            return false;
        }
    });
    $("#payout_amount_min").keypress(function (e)
    {
        var flag = 0;
        if (e.which == 46) {
            if ($(this).val().indexOf('.') != -1) {
                flag = 1;
            }
        }
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && e.which != 46)
        {
            flag = 1;
        }
        if (flag == 1) {
            //display error message
            $("#errmsg6").html('Digits Only').show().fadeOut(1200, 0);
            return false;
        }
        return true;
    });
    $("#payout_amount_max").keypress(function (e)
    {
        var flag = 0;
        if (e.which == 46) {
            if ($(this).val().indexOf('.') != -1) {
                flag = 1;
            }
        }
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && e.which != 46)
        {
            flag = 1;
        }
        if (flag == 1) {
            //display error message
            $("#errmsg7").html('Digits Only').show().fadeOut(1200, 0);
            return false;
        }
        return true;
    });
    $("#fast_start_bonus").keypress(function (e)
    {
        var flag = 0;
        if (e.which == 46) {
            if ($(this).val().indexOf('.') != -1) {
                flag = 1;
            }
        }
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && e.which != 46)
        {
            flag = 1;
        }
        if (flag == 1) {   //display error message
            $("#errmsg4").html(msg2).show().fadeOut(1200, 0);
            return false;
        }
    });
    $("#accumulated_turn_over").keypress(function (e)
    {
        var flag = 0;
        if (e.which == 46) {
            if ($(this).val().indexOf('.') != -1) {
                flag = 1;
            }
        }
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && e.which != 46)
        {
            flag = 1;
        }
        if (flag == 1) {   //display error message
            $("#errmsg5").html(msg2).show().fadeOut(1200, 0);
            return false;
        }
    });
    $("#required_firstliners").keypress(function (e)
    {
        var flag = 0;
        if (e.which == 46) {
            if ($(this).val().indexOf('.') != -1) {
                flag = 1;
            }
        }
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && e.which != 46)
        {
            flag = 1;
        }
        if (flag == 1) {   //display error message
            $("#errmsg6").html(msg2).show().fadeOut(1200, 0);
            return false;
        }
    });
//     $("#accumulated_turn_over").keypress(function(e)
//    {
//        var flag=0;
//        if(e.which == 46){
//            if($(this).val().indexOf('.') != -1){
//                flag=1;
//            }
//        }
//        //if the letter is not digit then display error and don't type anything
//        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && e.which != 46)
//        {
//            flag=1;
//        }
//        if(flag==1){   //display error message
//            $("#errmsg7").html(msg2).show().fadeOut(1200, 0);
//            return false;
//        }
//    });




    return true;

});

function trim(a)
{
    return a.replace(/^\s+|\s+$/, '');
}

function show_prefix()
{
    var html;
    html = "<td>Username Prefix:<font color='#ff0000'>*</font></strong></td><td><input type='text' name ='prefix' id ='prefix' maxlength='19' tabindex='6' title='This is the prefix of user name. It should contain 3 to 15 characters.'><span id='errmsg1'></span></td>";
    document.getElementById('prefix_div').innerHTML = html;
    document.getElementById('prefix_div').style.display = "";
}

function hide_prefix()
{
    document.getElementById('prefix_div').style.display = "none";
}

function change_module_status(path_temp, path_root, module_name, module_status)
{
    var set_module_status = path_root + "configuration/change_module_status";
    var msg = " Loading....";
    $("#" + module_name).removeClass();
    $("#" + module_name).addClass('messagebox');
    $("#" + module_name).html('<img align="absmiddle" src="' + path_temp + 'images/loader.gif" />' + msg).show().fadeTo(1900, 1);
    $.post(set_module_status, {module_name: module_name, module_status: module_status}, function (data)
    {
        location.reload();
    });
}

function change_payment_status(path_root, id, module_status)
{
    var set_module_status = path_root + "configuration/change_payment_status";
    $.post(set_module_status, {id: id, module_status: module_status}, function (data)
    {
        location.reload();
    });
}

function change_credit_card_status(path_root, id, module_status)

{
    var set_module_status = path_root + "configuration/change_credit_card_status";
    $.post(set_module_status, {id: id, module_status: module_status}, function (data)
    {
        location.reload();
    });
}

function getUsernamePrefix()
{
    var html;
    var path_root = document.username_config_form.path_root.value;
    var getUsernamePrefix = path_root + "admin/configuration/getUsernamePrefix";
    $.post(getUsernamePrefix, function (data)
    {
        data = trim(data);
        if (data != "")
        {
            html = "<td>Username Prefix:<font color='#ff0000'>*</font></strong></td><td><input type='text' name ='prefix' id ='prefix' maxlength='19' value='" + data + "'title='This is the prefix of user name. It should contain 3 to 15 characters.'><span id='errmsg1'></span></td>";
            document.getElementById('prefix_div').innerHTML = html;
            document.getElementById('prefix_div').style.display = "";
        }
    });
}
function edit_cat(id)
{
    //var confirm_msg=$("#confirm_msg_edit").html();
    var confirm_msg = "Sure you want to edit";
    var path_root = $("#path_root").val();
    if (confirm(confirm_msg))
    {
        document.location.href = path_root + 'admin/configuration/category/edit/' + id;
    }
}

function delete_cat(id)
{
    var confirm_msg = $("#confirm_msg_edit").html();
    var confirm_msg = "Sure you want to delete";
    var path_root = $("#path_root").val();
    if (confirm(confirm_msg))
    {
        document.location.href = path_root + 'admin/configuration/category/delete/' + id;
    }
}
function add_cat(id)
{
    var confirm_msg = $("#confirm_msg_edit").html();
    var confirm_msg = "Sure you want to add";
    var path_root = $("#path_root").val();
    if (confirm(confirm_msg))
    {
        document.location.href = path_root + 'admin/configuration/category/add/' + id;
    }
}
function edit_rank(id)
{
    //var confirm_msg=$("#confirm_msg_edit").html();
    var confirm_msg = "Sure you want to edit";
    var path_root = $("#path_root").val();
    if (confirm(confirm_msg))
    {
        document.location.href = path_root + 'admin/configuration/rank/edit/' + id;
    }
}
function delete_rank(id)
{
    var confirm_msg = $("#confirm_msg_edit").html();
    var confirm_msg = "Sure you want to delete";
    var path_root = $("#path_root").val();
    if (confirm(confirm_msg))
    {
        document.location.href = path_root + 'admin/configuration/rank/delete/' + id;
    }
}
function add_rank(id)
{
    var confirm_msg = $("#confirm_msg_edit").html();
    var confirm_msg = "Sure you want to add";
    var path_root = $("#path_root").val();
    if (confirm(confirm_msg))
    {
        document.location.href = path_root + 'admin/configuration/rank/add/' + id;
    }
}
function edit_timer(id)
{
    //var confirm_msg=$("#confirm_msg_edit").html();
    var confirm_msg = "Sure you want to edit";
    var path_root = $("#path_root").val();
    if (confirm(confirm_msg))
    {
        document.location.href = path_root + 'admin/configuration/timer/edit/' + id;
    }
}
function delete_timer(id)
{
    var confirm_msg = $("#confirm_msg_edit").html();
    var confirm_msg = "Sure you want to delete";

    var path_root = $("#path_root").val();
    if (confirm(confirm_msg))
    {
        document.location.href = path_root + 'admin/configuration/timer/delete/' + id;
    }
}
//=====================================================================//
//$(document).ready(function() {
//    var msg1 = $("#validate_msg1").html();
//    var msg2 = $("#validate_msg2").html();
//    var msg3 = $("#validate_msg3").html();
//    var msg4 = $("#validate_msg4").html();
//    var msg5 = $("#validate_msg5").html();
//    var msg6 = $("#validate_msg6").html();
//    $("#form_setting").validate({
//        submitHandler: function(form) {
//            SubmittingForm();
//        },
//        rules: { 
//
//             direct_bonus: {
//                minlength: 1,
//                maxlength: 10,
//                required: true,
//                range: [0, 100]
//            }  , 
////            fast_start_bonus: {
////                minlength: 1,
////                maxlength: 10,
////                required: true,
////                range: [0, 100]
////            }  , 
////            accumulated_turn_over: {
////                minlength: 1,
////                maxlength: 10,
////                required: true
////                
////            }  , 
////            required_firstliners: {
////                minlength: 1,
////                maxlength: 10,
////                required: true
////                
////            }   
//        },
//        messages: {
//            direct_bonus:{
//                range:'Value must be less than 100',
//            }
//        }
//    });
//});

//===================for username configuration
$(document).ready(function () {
    var msg1 = $("#validate_msg4").html();
    $("#username_config_form").validate({
        submitHandler: function (form) {
            SubmittingForm();
        },
        rules: {
            prefix: {
                minlength: 1,
                required: true
            }
        },
        messages: {
            prefix: msg1,
        }
    });
});
/*======================================================================*/
//===================for tab redirection
function setHiddenValue(tab)
{
    $("#active_tab").val(tab);
    $("div.tab-pane active").removeClass("tab-pane active");
}
//====================
var ValidateEpdqConfig = function () {
    var msg1 = $("#validate_msg1").html();
    var msg2 = $("#validate_msg2").html();
    var msg3 = $("#validate_msg3").html();
    var msg4 = $("#validate_msg4").html();
    var msg5 = $("#validate_msg5").html();
    var msg6 = $("#validate_msg6").html();
    var msg7 = $("#validate_msg7").html();
    var msg8 = $("#validate_msg8").html();
    var msg9 = $("#validate_msg9").html();
    var runValidatorweeklySelection = function () {
        var searchform = $('#payment_status_form');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#payment_status_form').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function (error, element) { // render error placement for each input type
                error.insertAfter(element);
                // for other inputs, just perform default behavior
            },
            ignore: ':hidden',
            rules: {
                api_pspid: {
                    minlength: 1,
                    required: true
                },
                api_password: {
                    minlength: 1,
                    required: true
                },
                language: {
                    minlength: 1,
                    required: true
                },
                currency: {
                    minlength: 1,
                    required: true
                },
                accept_url: {
                    minlength: 1,
                    required: true
                },
                decline_url: {
                    minlength: 1,
                    required: true
                },
                exception_url: {
                    minlength: 1,
                    required: true
                },
                cancel_url: {
                    minlength: 1,
                    required: true
                },
                api_url: {
                    minlength: 1,
                    required: true
                }
            },
            messages: {
                api_pspid: msg1,
                news_desc: msg2,
                language: msg3,
                currency: msg4,
                accept_url: msg5,
                decline_url: msg6,
                exception_url: msg7,
                cancel_url: msg8,
                api_url: msg9
            },
            invalidHandler: function (event, validator) { //display error alert on form submit
                errorHandler1.show();
            },
            highlight: function (element) {
                $(element).closest('.help-block').removeClass('valid');
                // display OK icon
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error').find('.symbol').removeClass('ok').addClass('required');
                // add the Bootstrap error class to the control group
            },
            unhighlight: function (element) { // revert the change done by hightlight
                $(element).closest('.form-group').removeClass('has-error');
                // set error class to the control group
            },
            success: function (label, element) {
                label.addClass('help-block valid');
                // mark the current input as valid and display OK icon
                //$(element).closest('.form-group').removeClass('has-error').addClass('has-success').find('.symbol').removeClass('required').addClass('ok');
                $(element).closest('.form-group').removeClass('has-error').addClass('ok');
            }
        });
    };
    return {
        //main function to initiate template pages
        init: function () {
            runValidatorweeklySelection();

        }
    };
}();

var ValidateConfiguration = function () {
//    var msg1 = $("#validate_msg1").html();
//    var msg2 = $("#validate_msg2").html();
//    var msg3 = $("#validate_msg3").html();
//    var msg4 = $("#validate_msg4").html();
//    var msg5 = $("#validate_msg5").html();
//    var msg6 = $("#validate_msg6").html();
//    var msg7 = $("#validate_msg7").html();
//    var msg8 = $("#validate_msg8").html();
//    var msg9 = $("#validate_msg9").html();
    var runValidatoBonusConfiguration = function () {
        var searchform = $('#form_setting');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#form_setting').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function (error, element) { // render error placement for each input type
                error.insertAfter(element);
                // for other inputs, just perform default behavior
            },
            ignore: ':hidden',
            rules: {
                db_percentage: {
                    range: [0, 100],
                    required: true
                },
                dp_percentage: {
                   range: [0, 100],
                    required: true
                },
                fsb_percentage: {
                    range: [0, 100],
                    required: true
                },
                fsb_required_firstliners: {
                    range: [0, 100],
                    required: true
                },
                fsb_accumulated_turn_over_1: {
//                    minlength: 1,
//                    range: [0, 100],
                    required: true,
                    min: 0,
                },
                fsb_accumulated_turn_over_2: {
                    required: true,
                    min: 0,
                },
                tb_required_firstliners: {
                    required: true,
                    min: 0,
                },
                tb_1000: {
                    required: true,
                    min: 0,
                },
                tb_5000: {
                    required: true,
                    min: 0,
                },
                tb_10000: {
                    required: true,
                    min: 0,
                },
                tb_25000: {
                    required: true,
                    min: 0,
                },
                tb_50000: {
                    required: true,
                    min: 0,
                },
                tb_100000: {
                    required: true,
                    min: 0,
                },
                tb_250000: {
                    required: true,
                    min: 0,
                },
                tb_500000: {
                    required: true,
                    min: 0,
                },
                tb_1000000: {
                    required: true,
                    min: 0,
                },
                tb_5000000: {
                    required: true,
                    min: 0,
                },
                b_10000000: {
                    required: true,
                    min: 0,
                },
                level_percentage1: {
                    required: true,
                    min: 0,
                },
                level_percentage2: {
                    required: true,
                    min: 0,
                },
                level_percentage3: {
                    required: true,
                    min: 0,
                },
                level_percentage4: {
                    required: true,
                    min: 0,
                },
                level_percentage5: {
                    required: true,
                    min: 0,
                },
                level_percentage6: {
                    required: true,
                    min: 0,
                },
                level_percentage7: {
                    required: true,
                    min: 0,
                },
                level_percentage8: {
                    required: true,
                    min: 0,
                },
                level_percentage9: {
                    required: true,
                    min: 0,
                },
                level_percentage10: {
                    required: true,
                    min: 0,
                },
                level_percentage11: {
                    required: true,
                    min: 0,
                },
                 mb_required_firstliners: {
                     required: true,
                    min: 0,
                },
               

            },
            messages: {
                db_percentage:{required: 'direct bonus percentage required',
                               range: 'invalid direct bonus percentage'},
                fsb_percentage:{
                    required: 'fast start bonus percentage required',
                    range: 'invalid fast start bonus percentage'
                },
                dp_percentage:{ range:'invalid diamond pool bonus percentage',
                                required:'diamond pool bonus percentage required'},
                fsb_required_firstliners:{
                   required: 'fast start bonus first line number required',
                   range: 'invalid fast start bonus first line number'
                },
                fsb_accumulated_turn_over_1: {
                    required:'Accumulated Turnover 5000 BV required',
                    min:'inalid accumulated turnover'},
                fsb_accumulated_turn_over_2: {
                    required:'Accumulated Turnover 10000 BV required',
                    min:'inalid accumulated turnover',
                },
                tb_required_firstliners: {
                    required: 'team bonus first liners required',
                    min:'invalid team bonus first liners',
                },
                tb_1000: {
                    required: 'team bonus require',
                    min:'invalid team bonus ',
                },
                tb_5000: {
                    required: 'team bonus require',
                    min:'invalid team bonus',
                },
                tb_10000: {
                    required: 'team bonus require',
                    min:'invalid team bonus',
                },
                tb_25000: {
                    required: 'team bonus require',
                    min:'invalid team bonus',
                },
                tb_50000: {
                    required: 'team bonus require',
                    min:'invalid team bonus',
                },
                tb_100000: {
                    required: 'team bonus require',
                    min:'invalid team bonus',
                },
                tb_250000: {
                    required: 'team bonus require',
                    min:'invalid team bonus',
                },
                tb_500000: {
                    required: 'team bonus require',
                    min:'invalid team bonus',
                },
                tb_1000000: {
                    required: 'team bonus require',
                    min:'invalid team bonus',
                },
                tb_5000000: {
                    required: 'team bonus require',
                    min:'invalid team bonus',
                },
                b_10000000: {
                    required: 'team bonus require',
                    min:'invalid team bonus',
                },
                level_percentage11: {
                    required: 'matching bonus require',
                    min:'invalid matching bonus',
                },
                level_percentage10: {
                    required: 'matching bonus require',
                    min:'invalid matching bonus',
                },
                level_percentage9: {
                    required: 'matching bonus require',
                    min:'invalid matching bonus',
                },
                level_percentage8: {
                    required: 'matching bonus require',
                    min:'invalid matching bonus',
                },
                level_percentage7: {
                    required: 'matching bonus require',
                     min:'invalid matching bonus',
                },
                level_percentage6: {
                    required: 'matching bonus require',
                     min:'invalid matching bonus',
                },
                level_percentage5: {
                    required: 'matching bonus require',
                     min:'invalid matching bonus',
                },
                level_percentage4: {
                    required: 'matching bonus require',
                     min:'invalid matching bonus',
                },
                level_percentage3: {
                    required: 'matching bonus require',
                     min:'invalid matching bonus',
                },
                level_percentage2: {
                    required: 'matching bonus require',
                     min:'invalid matching bonus',
                },
                level_percentage1: {
                    required: 'matching bonus require',
                     min:'invalid matching bonus',
                },
                mb_required_firstliners: {
                    required: 'matching bonus required first line required',
                     min:'invalid matching bonus required first line',
                },

            },
            invalidHandler: function (event, validator) { //display error alert on form submit
                errorHandler1.show();
            },
            highlight: function (element) {
                $(element).closest('.help-block').removeClass('valid');
                // display OK icon
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error').find('.symbol').removeClass('ok').addClass('required');
                // add the Bootstrap error class to the control group
            },
            unhighlight: function (element) { // revert the change done by hightlight
                $(element).closest('.form-group').removeClass('has-error');
                // set error class to the control group
            },
            success: function (label, element) {
                label.addClass('help-block valid');
                // mark the current input as valid and display OK icon
                //$(element).closest('.form-group').removeClass('has-error').addClass('has-success').find('.symbol').removeClass('required').addClass('ok');
                $(element).closest('.form-group').removeClass('has-error').addClass('ok');
            }
        });
    };
    return {
        //main function to initiate template pages
        init: function () {
            runValidatoBonusConfiguration();

        }
    };
}();

var ValidateUser = function () {

    var runValidatorAuthorizeSelection = function () {

        var msg4 = $("#validate_msg1").html();
        var msg5 = $("#validate_msg2").html();
        var searchform = $('#authorize_status_form');
        var errorHandler1 = $('.errorHandler', searchform);

        $('#authorize_status_form').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function (error, element) { // render error placement for each input type
                error.insertAfter(element);
                // for other inputs, just perform default behavior
            },
            ignore: ':hidden',
            rules: {
                merchant_log_id: {
                    minlength: 1,
                    required: true
                },
                transaction_key: {
                    minlength: 1,
                    required: true
                }
            },
            messages: {
                merchant_log_id: msg5,
                transaction_key: msg4
            },
            invalidHandler: function (event, validator) { //display error alert on form submit
                errorHandler1.show();
            },
            highlight: function (element) {
                $(element).closest('.help-block').removeClass('valid');
                // display OK icon
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error').find('.symbol').removeClass('ok').addClass('required');
                // add the Bootstrap error class to the control group
            },
            unhighlight: function (element) { // revert the change done by hightlight
                $(element).closest('.form-group').removeClass('has-error');
                // set error class to the control group
            },
            success: function (label, element) {
                label.addClass('help-block valid');
                // mark the current input as valid and display OK icon
                //$(element).closest('.form-group').removeClass('has-error').addClass('has-success').find('.symbol').removeClass('required').addClass('ok');
                $(element).closest('.form-group').removeClass('has-error').addClass('ok');
            }
        });
    };
    return {
        //main function to initiate template pages
        init: function () {
            runValidatorAuthorizeSelection();
        }
    };
}();
var ValidateUpation = function () {

    var runValidatorUpdation = function () {

        var msg4 = $("#validate_msg1").html();
        var msg5 = $("#validate_msg2").html();
        var searchform = $('#payment_status_form');
        var errorHandler1 = $('.errorHandler', searchform);

        $('#payment_status_form').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function (error, element) { // render error placement for each input type
                error.insertAfter(element);
                // for other inputs, just perform default behavior
            },
            ignore: ':hidden',
            rules: {
                sort_order: {
                    minlength: 1,
                    required: true
                },
                transaction_key: {
                    minlength: 1,
                    required: true
                }
            },
            messages: {
                merchant_log_id: msg5,
                transaction_key: msg4
            },
            invalidHandler: function (event, validator) { //display error alert on form submit
                errorHandler1.show();
            },
            highlight: function (element) {
                $(element).closest('.help-block').removeClass('valid');
                // display OK icon
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error').find('.symbol').removeClass('ok').addClass('required');
                // add the Bootstrap error class to the control group
            },
            unhighlight: function (element) { // revert the change done by hightlight
                $(element).closest('.form-group').removeClass('has-error');
                // set error class to the control group
            },
            success: function (label, element) {
                label.addClass('help-block valid');
                // mark the current input as valid and display OK icon
                //$(element).closest('.form-group').removeClass('has-error').addClass('has-success').find('.symbol').removeClass('required').addClass('ok');
                $(element).closest('.form-group').removeClass('has-error').addClass('ok');
            }
        });
    };
    return {
        //main function to initiate template pages
        init: function () {
            runValidatorAuthorizeSelection();
        }
    };
}();
//-------------------
$(document).ready(function ()
{
    $("#sort_order").keypress(function (e)
    {
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57))
        {
            var msg = $("#validate_msg13").html();
            $("#errmsg1").html(msg).show().fadeOut(1200, 0);
            return false;
        }
    });
});

function change_pair_ceiling_visibility(val) {
    if (val == 'none') {
        document.getElementById('pair_ceiling_div').style.display = "none";
    } else {
        document.getElementById('pair_ceiling_div').style.display = "block";
    }
}

function change_pair_value_visibility(val) {
    var default_symbol = document.getElementById('project_default_symbol').value;
    if (val == 'percentage') {
        document.getElementById('pair_value_div').style.display = "none";
        document.getElementById('pair_ceiling_pv_label').style.display = "block";
        document.getElementById('pair_ceiling_count_label').style.display = "none";
        $(".span_pair_commission").html("%");
    } else {
        document.getElementById('pair_value_div').style.display = "block";
        document.getElementById('pair_ceiling_pv_label').style.display = "none";
        document.getElementById('pair_ceiling_count_label').style.display = "block";
        $(".span_pair_commission").html(default_symbol);
    }
}

function change_level_commission_type(val) {
    var default_symbol = document.getElementById('project_default_symbol').value;
    if (val == 'percentage') {
        $(".span_level_commission").html("%");
    } else {
        $(".span_level_commission").html(default_symbol);
    }
}

function changeBoardVisibility(status, num) {
    var board_count = $("#board_count").val();
    if (status == 'no') {
        for (var i = num + 1; i < board_count; i++) {
            document.getElementById('board' + i).style.display = "none";
        }
    } else {
        num += 1;
        document.getElementById('board' + num).style.display = "block";
    }
}

function checkPlanVariables() {
    var form = document.getElementById('form_setting');
    if (document.getElementById('cleanup_flag').value == 1) {
        if (confirm($("#update_plan_confirm_msg").html())) {
            $("#cleanup_flag").val("do_clean");
            form.submit();
        }
    } else {
        form.submit();
    }
}

function set_cleanup_flag(current_value, new_value) {
    var cleanup_flag = document.getElementById('cleanup_flag').value;
    if (current_value != new_value && cleanup_flag != 1) {
        $("#cleanup_flag").val("1");
    }
}