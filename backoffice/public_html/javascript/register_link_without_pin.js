window.onload = function(){
   $("#ref_username").blur();
}

// form validation function //

function trim(a)

{



    return a.replace(/^\s+|\s+$/, '');

}

function disable_next1()

{
    document.form.next_1.disabled=true;
}


function enable_next1()

{

    document.form.next_1.disabled=false;

}
function disable_next2()

{
    document.form.next_2.disabled=true;
}

function enable_next2()
{
    document.form.next_2.disabled=false;

}
function disable_finish()

{
    document.form.ewallet.disabled=true;
}

function enable_finish()
{
    document.form.ewallet.disabled=false;

}

function disable()

{

    //alert("ggggggggggggggggggggg");

    //  document.form.register.disabled=true;

}





function enable()

{

    //document.form.register.disabled=false;

}

function check(b, c)

{

    // alert("zzzzggggggggggggggggggggg3333333333333"+b+":"+c);

    if (b == 1 && c == 1)

    {

        enable();

    }

    else

    {

        disable();

    }

}





function pageLoad()
{

}

$(document).ready(function()
{


    var b = 0;

    var c = 0;

    var d = 0;


    //document.form.register.disabled=false;

    var path_temp = document.form.path_temp.value;
    var path_root = document.form.path_root.value;
//alert(path_temp);

    $("#product_id").blur(function() {

         
        var prdct_id = document.getElementById('product_id').value;
        var register_amount = null;
        var prdct_amount = path_root + "register/getPrdctAmount";
        $.post(prdct_amount, {p_id: prdct_id}, function(data) {

            if (data != 'no') {
		$('span#total_product_amount').html(data);
                var register_amount_path = path_root + "register/getRegisterAmount";
                $.post(register_amount_path, function(data2) {

                    if (data2 != 'no_data') {
                    register_amount = data2;


                    var hidden = document.getElementById('product_amount');
                    //$('span.reg_total-title').html(register_amount);
                    var total_reg_amount = parseFloat(data, 10) + parseFloat(data2, 10);
                    hidden.value = total_reg_amount;
                    $('span.total-title').html(total_reg_amount);
                    }
                    else{
                        
                        var hidden = document.getElementById('product_amount');
                        hidden.value = data;
                        $('span.total-title').html(data);
                        
                    }
                });


                // document.getElementById("epin_total_amount").value = data;


            }
            else
                // document.getElementById("epin_total_amount").value = '';
                $('span.total-title').html('data');
        });
    });



    $("#cpswd").blur(function()
    {
        $("#sponser_user_name").trigger('blur');
    });


    /*$("#sponser_user_name").blur(function()
     {
     
     
     var newusername = document.form.sponser_user_name.value; 
     
     var user_null = trim(newusername);
     
     var emailRegex = /^[""]+/;
     
     var error=0;
     
     
     
     
     if(newusername.match(emailRegex) || user_null=="") 
     
     {
     
     
     
     $("#msgboxsponsor").removeClass();
     
     $("#msgboxsponsor").addClass('messageboxsponsorerror');
     
     $("#msgboxsponsor").html('<img align="absmiddle" src="'+path_temp+'images/Error.png" /> Invalid sponsor code or sponsor office name...').show().fadeTo(1900,1);
     
     error=1;
     
     disable();
     
     }
     
     
     
     if(error!=1)
     
     {
     
     disable();
     var sponsor_availability=path_root+"register/sponsor_availability";
     //remove all the class add the messagebox classes and start fading
     
     $("#errormsg1").removeClass();
     
     $("#errormsg1").addClass('messagebox');
     
     $("#errormsg1").html('<img align="absmiddle" src="'+path_temp+'images/loader.gif" /> Checking Placement data...').show().fadeTo(1900,1);
     
     //check the username exists or not from ajax
     
     $.post(sponsor_availability,{user_id:$('#sponser_user_name').val()} ,function(data)
     
     {
     
     if(trim(data)=='no') //if username not avaiable
     
     {
     
     $("#errormsg1").fadeTo(200,0.1,function() //start fading the messagebox
     
     { 
     
     //add message and change the class of the box and start fading
     
     $(this).removeClass();
     
     $(this).addClass('messageboxsponsorerror');
     
     $(this).html('<img align="absmiddle" src="'+path_temp+'images/Error.png" /> Invalid Placement data...').show().fadeTo(1900,1);
     
     disable();
     
     });		
     
     }
     
     else
     
     {
     
     $("#errormsg1").fadeTo(200,0.1,function()  //start fading the messagebox
     
     { 
     
     //add message and change the class of the box and start fading
     
     $(this).removeClass();
     
     $(this).addClass('messageboxok');
     
     $(this).html('<img align="absmiddle" src="'+path_temp+'images/accepted.png" /> Placement data validated...').show().fadeTo(1900,1);
     
     //enable();	
     
     b=1;	
     c=1;
     check(b,c);
     
     //  check(b,c);
     
     });
     
     }
     
     
     
     });
     
     }
     
     //$("#position").trigger('blur');
     
     
     
     });*/



    $("#position").blur(function()

    {

        var error = 0;
        if (error != 1)

        {
            $("#ref_username").blur();
            
//            var leg_availability = path_root + "register/checkLegAvailability"
//            //remove all the class add the messagebox classes and start fading
//
//            $("#errormsg2").removeClass();
//
//            $("#errormsg2").addClass('messagebox');
//
//            $("#errormsg2").html('<img align="absmiddle" src="' + path_temp + 'images/loader.gif" /> Checking Your Position...').show().fadeTo(1900, 1);
//
//            //check the username exists or not from ajax
//
//            $.post(leg_availability, {sponserleg: $('#position').val(), sponser_user_name: $('#sponser_user_name').val()}, function(data)
//
//            {
//
//                if (trim(data) == 'no') //if username not avaiable
//
//                {
//
//                    $("#errormsg2").fadeTo(200, 0.1, function() //start fading the messagebox
//
//                    {
//
//                        //add message and change the class of the box and start fading
//
//                        $(this).removeClass();
//
//                        $(this).addClass('messageboxerror');
//
//                        $(this).html('<img align="absmiddle" src="' + path_temp + 'images/Error.png" />This Position is not Usable ...').show().fadeTo(1900, 1);
//
//                        disable_next1();
//
//                    });
//
//                }
//
//                else
//
//                {
//
//                    $("#errormsg2").fadeTo(200, 0.1, function()  //start fading the messagebox
//
//                    {
//
//                        //add message and change the class of the box and start fading
//
//                        $(this).removeClass();
//
//                        $(this).addClass('messageboxok');
//
//                        $(this).html('<img align="absmiddle" src="' + path_temp + 'images/accepted.png" />Position Available...').show().fadeTo(1900, 1);
//
//                        enable_next1();
//
//                        c = 1;
//
//                       // check(b, c);
//
//                    });
//
//                }
//
//
//
//            });

        }



    });







    $("#user_name_entry").blur(function()
    {
        var error = 0;

        if (error != 1)

        {
            var user_name_availability = path_root + "register/checkUserNameAvailability"
            var msg;
            msg = $("#validate_msg27").html();

            //remove all the class add the messagebox classes and start fading

            $("#errormsg3").removeClass();

            $("#errormsg3").addClass('messagebox');

            $("#errormsg3").html('<img align="absmiddle" src="' + path_temp + 'images/loader.gif" /> ' + msg).show().fadeTo(1900, 1);

            //check the username exists or not from ajax

            $.post(user_name_availability, {user_name: $('#user_name_entry').val()}, function(data)

            {

                if (trim(data) == 'no') //if username not avaiable

                {

                    $("#errormsg3").fadeTo(200, 0.1, function() //start fading the messagebox

                    {
                        var msg;
                        msg = $("#validate_msg28").html();

                        //add message and change the class of the box and start fading

                        $(this).removeClass();

                        $(this).addClass('messageboxerror');

                        $(this).html('<img align="absmiddle" src="' + path_temp + 'images/Error.png" />' + msg).show().fadeTo(1900, 1);

                        disable_next2();

                    });

                }

                else

                {

                    $("#errormsg3").fadeTo(200, 0.1, function()  //start fading the messagebox

                    {
                         var msg;
                        msg = $("#validate_msg29").html();

                        //add message and change the class of the box and start fading
                         length=$('#user_name_entry').val().length;
                          var username_type = document.form.username_type.value;
                          
                        if(username_type=='static')
                       {
                        if(length>=6)
                        {
                            
                        $(this).removeClass();

                        $(this).addClass('messageboxok');

                        $(this).html('<img align="absmiddle" src="' + path_temp + 'images/accepted.png" />' + msg).show().fadeTo(1900, 1);

                       enable_next2();

                        c = 1;

//check(a,b,c);
                        }
                            
                          else
                        {   
                        msg = $("#validate_msg63").html();
                        
                             $(this).removeClass();

                        $(this).addClass('messageboxok');

                        $(this).html('<img align="absmiddle" src="' + path_temp + 'images/Error.png" />'+msg).show().fadeTo(1900, 1);
                            return false;
                        //enable();

                        //c = 1;
                        }
                       }
                       else
                           {
                                $(this).removeClass();

                        $(this).addClass('messageboxok');

                        $(this).html('<img align="absmiddle" src="' + path_temp + 'images/accepted.png" />' + msg).show().fadeTo(1900, 1);

                        enable_next2();

                        c = 1;
                           }

                    });

                }



            });

        }

    });







    $("#father_id").keypress(function(e)

    {



        //if the letter is not digit then display error and don't type anything

        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57))

        {

            //display error message

            $("#errmsg1").html("Digits Only ").show().fadeOut(1200, 0);

            return false;

        }

    });
    $("#user_name_entry").keypress(function(e)

    {



        //if the letter is not digit then display error and don't type anything

        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && (e.which < 65 || e.which > 90) && (e.which < 97 || e.which > 122))

        {

            //display error message

            $("#errmsg33").html("Alpha numeric values only").show().fadeOut(1200, 0);

            return false;

        }

    });

    $("#pin").keypress(function(e)

    {



        //if the letter is not digit then display error and don't type anything

        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57))

        {

            //display error message

            $("#errmsg2").html("Digits Only ").show().fadeOut(1200, 0);

            return false;

        }

    });







    $("#ref_username").blur(function()
    {

        var error = 0;
        var referral_name = $('#ref_username').val();
        if (error != 1)

        {

            var ref_user_availability = path_root + "register/checkRefUserAvailability"
            //remove all the class add the messagebox classes and start fading

            $("#referral_box").removeClass();

            $("#referral_box").addClass('messagebox');

            $("#referral_box").html('<img align="absmiddle" src="' + path_temp + 'images/loader.gif" /> Checking sponsor username...').show().fadeTo(1900, 1);

            //check the username exists or not from ajax

            $.post(ref_user_availability, {username: $('#ref_username').val()}, function(data)

            {

                if (trim(data) == 'no') //if username not avaiable

                {

                    $("#referral_box").fadeTo(200, 0.1, function() //start fading the messagebox

                    {

                        //add message and change the class of the box and start fading

                        $(this).removeClass();

                        $(this).addClass('messageboxerror');

                        $(this).html('<img align="absmiddle" src="' + path_temp + 'images/Error.png" /> Invalid Sponsor username ...').show().fadeTo(1900, 1);
                        document.getElementById('referal_div').style.display = "none";
                         disable_next1();

                    });

                }

                else

                {

                    $("#referral_box").fadeTo(200, 0.1, function()  //start fading the messagebox

                    {

                        //add message and change the class of the box and start fading

                        $(this).removeClass();

                        $(this).addClass('messageboxok');

                        $(this).html('<img align="absmiddle" src="' + path_temp + 'images/accepted.png" />Sponsor username validated...').show().fadeTo(1900, 1);
                        getreferralname(referral_name);
                        enable_next1();


                    });

                }



            });

        }

    });


    function getreferralname(referral_name)
    {
        var html;

        var get_referral_name = path_root + "register/getReferralName";
        $.post(get_referral_name, {username: $('#ref_username').val()}, function(data)
        {
            data = trim(data);
            html = "<div class='form-group'>  <label class='col-sm-3 control-label' for='ref_username'>Sponsor Full Name:<font color='#ff0000'>*</font></label> <div class='col-sm-7'><input type='text' name='referal_name' id='reeral_name' autocomplete='Off' value='" + data + "' readonly='true' class='form-control'/></div></div>";
            document.getElementById('referal_div').innerHTML = html;
            document.getElementById('referal_div').style.display = "";
        });
    }


    function change_pin()
    {
        document.getElementById('passcode').value = "";
        document.getElementById('passbox').style.display = "none";
        disable();
    }

    function change_product()
    {
        document.getElementById('passcode').value = "";
        document.getElementById('passbox').style.display = "none";
        disable();
    }






    $("#land_line").keypress(function(e)

    {



        //if the letter is not digit then display error and don't type anything

        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57))

        {

            //display error message

            $("#errmsg4").html("Digits Only ").show().fadeOut(1200, 0);

            return false;

        }

    });

//    $("#user_name_ewallet").blur(function()
//    {
//        var balance_available = path_root + "register/checkBalanceAvailable";
//        var msg;
//        msg = $("#validate_msg49").html();
//
//        //remove all the class add the messagebox classes and start fading
//
//        $("#errormsg2").removeClass();
//
//        $("#errormsg2").addClass('messagebox');
//
//        $("#errormsg2").html('<img align="absmiddle" src="' + path_temp + 'images/loader.gif" /> ' + msg).show().fadeTo(1900, 1);
////              
//        //check the username exists or not from ajax
//
//        $.post(balance_available, {
//            user_name: $('#user_name_ewallet').val(),
//            balance: $('#product_amount').val()
//        }, function(data) {
//
//            if (data != "")
//            {
//                $("#user_name_ewallet_box").fadeTo(1900, 0.1, function() //start fading the messagebox
//
//                {
//
//                    var msg36 = $("#validate_msg51").html();
//                    //var msg37 = $("#error_msg37").html();
//                    //add message and change the class of the box and start fading
//
//                    $(this).removeClass();
//
//                    $(this).addClass('messageboxok');
//
//
//                    $(this).html('<img align="absmiddle" src="' + path_temp + 'images/accepted.png" />' + msg36).show().fadeTo(1900, 1);
//
//                });
//            }
//            else
//            {
//                $("#user_name_ewallet_box").fadeTo(1900, 0.1, function() //start fading the messagebox
//
//                {
//
//                    var msg37 = $("#validate_msg50").html();
//                    //var msg37 = $("#error_msg37").html();
//                    //add message and change the class of the box and start fading
//
//                    $(this).removeClass();
//
//                    $(this).addClass('messageboxok');
//
//
//                    $(this).html('<img align="absmiddle" src="' + path_temp + 'images/Error.png" />' + msg37).show().fadeTo(1900, 1);
//
//                });
//
//            }
//        });
//    });

     $("#tran_pass_ewallet").blur(function ()
    {
        var ewallet_available = path_root + "register/checkEwalletAvailable";
        var msg;
        msg = $("#validate_msg60").html();

        //remove all the class add the messagebox classes and start fading

        $("#errormsg2").removeClass();

        $("#errormsg2").addClass('messagebox');

        $("#errormsg2").html('<img align="absmiddle" src="' + path_temp + 'images/loader.gif" /> ' + msg).show().fadeTo("fast", 1);
//              
        //check the username exists or not from ajax

        $.post(ewallet_available, {
            user_name: $('#user_name_ewallet').val(),
            ewallet: $('#tran_pass_ewallet').val()
        }, function (data) {
            if (data != '')
            {
                var ewallet_balnce = $('#product_amount').val();
                document.getElementById('ewallet_bal').value = data - ewallet_balnce;

                if (document.getElementById('ewallet_bal').value > 0) {

                    $("#tran_pass_ewallet_box").fadeTo("fast", 1, function () //start fading the messagebox

                    {
                        var msg39 = $("#validate_msg62").html();
                        //var msg37 = $("#error_msg37").html();
                        //add message and change the class of the box and start fading

                        $(this).removeClass();

                        $(this).addClass('messageboxok');


                        $(this).html('<img align="absmiddle" src="' + path_temp + 'images/accepted.png" />' + msg39).show().fadeTo("fast", 1);
                        enable_finish();

                    });
                }
                else
                {
                    $("#tran_pass_ewallet_box").fadeTo("fast", 1, function () //start fading the messagebox

                    {


                        var msg37 = $("#validate_msg50").html();
//                    add message and change the class of the box and start fading

                        $(this).removeClass();

                        $(this).addClass('messageboxok');


                        $(this).html('<img align="absmiddle" src="' + path_temp + 'images/Error.png" />' + msg37).show().fadeTo("fast", 1);
                        disable_finish();
                    });

                }
            }
            else
            {
                $("#tran_pass_ewallet_box").fadeTo("fast", 1, function () //start fading the messagebox

                {

                    var msg38 = $("#validate_msg61").html();

                    //add message and change the class of the box and start fading

                    $(this).removeClass();

                    $(this).addClass('messageboxok');


                    $(this).html('<img align="absmiddle" src="' + path_temp + 'images/Error.png" />' + msg38).show().fadeTo("fast", 1);
                    disable_finish();
                });

            }
        });
    });
});














