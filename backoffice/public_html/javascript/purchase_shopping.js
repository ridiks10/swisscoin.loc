function addToCart(product_id)
{
    var flash_html;
    var path_root = document.getElementById('base_url').value;
    var path_temp = document.getElementById('base_url').value;
    var product_qty = document.getElementById('product_qty').value;

    var user_type = document.getElementById('user_type').value;
    if (user_type == 'distributor') {
        user_type = 'user';
    }
    if(user_type=='employee'){
        user_type = 'admin';
    }
    var path = path_root + user_type + "/purchase/setShoppingCart";
    $.post(path, {product_id: product_id, product_qty: product_qty}, function (data)
    {

        data = trim(data);
        data = JSON.parse(data);
        var cart = data.cart;
        var productname = data.productname;

        var image = "<img src= " + path_temp + "public_html/images/package/" + data.image + " width='50px' height='50px'>";
        flash_html = "<a href='mycart' class='mfk_wrap'><div class='col-md-offset-9 col-md-3' style='position: fixed; top: 290px;right: 20px;' class='alert alert-success'><div  style='background-color: rgba(223, 240, 216, 0) !important;border color: rgba(214, 233, 198, 0) !important;'><div class='pdtitle'><p class='pdhd'>PRODUCT ADDED TO CART</p><button type='button' class='close' data-dismiss='alert'>×</button></div><div class='prdctdecout'><div class='col-md-4'><div class='prdctimg'>" + image + "</div></div><div class='col-md-8'><div class='prdctdec'>" + productname + " ADDED TO SHOPPING CART</div></div></div></div></div></a>";


        document.getElementById('mycart_list').innerHTML = cart;
        document.getElementById('flash_msg').innerHTML = flash_html;

    });
}
function clearCart()
{
    var path_root = document.getElementById('path_root').value;

    var path = path_root + "shopping/clearCart";
    $.post(path, {}, function (data)
    {

        //  document.location.href = path_root + "shopping/product";

    });
}
function removeCart(id)
{
    var path_root = document.getElementById('base_url').value;

    var user_type = document.getElementById('user_type').value;
    if (user_type == 'distributor') {
        user_type = 'user';
    }

    var path = path_root + user_type + "/purchase/removeCart";
    $.post(path, {id: id}, function (data)
    {
        document.location.href = path_root + user_type + "/purchase/mycart";
    });
}
function updateCart(id)
{
    
    var path_root = document.getElementById('base_url').value;
    var qty = document.getElementById('qty-' + id).value;
    if (qty > 0) {
        var user_type = document.getElementById('user_type').value;
        if (user_type == 'distributor') {
            user_type = 'user';
        }

        var path = path_root + user_type + "/purchase/updateCart";
        $.post(path, {id: id, qty: qty}, function (data)
        {
           
            document.location.href = path_root+ user_type +"/purchase/mycart";
        });
    }

}
function validateEmail()
{
    var path_root = document.getElementById('path_root').value;
    var path_temp = document.getElementById('path_temp').value;
    var email = document.getElementById('email').value;
    var emailRegex = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/;

    if (!email.match(emailRegex))
    {
        $("#errormsg11").fadeTo(200, 0.1, function () //start fading the messagebox

        {
            var msg;
            msg = 'Invalid Email..'

            $(this).removeClass();

            $(this).addClass('messageboxerror');

            $(this).html('<img align="absmiddle" src="' + path_temp + 'images/Error.png" />' + msg).show().fadeTo(1900, 1);

        });
        var msg = "";
        document.getElementById('email_error').innerHTML = msg
        document.getElementById("create").disabled = true;
    }
    else
    {
        var path = path_root + "shopping/validateEmail";
        $.post(path, {email: email}, function (data)
        {
            data = trim(data);
            if (data == 0)
            {
                $("#errormsg11").fadeTo(200, 0.1, function () //start fading the messagebox

                {
                    var msg;
                    msg = 'Valid email Id..'

                    //add message and change the class of the box and start fading

                    $(this).removeClass();

                    $(this).addClass('messageboxerror');

                    $(this).html('<img align="absmiddle" src="' + path_temp + 'images/accepted.png" />' + msg).show().fadeTo(1900, 1);

                });
                var msg = "";
                document.getElementById('email_error').innerHTML = msg
                document.getElementById("create").disabled = false;
            }
            else
            {
                $("#errormsg11").fadeTo(200, 0.1, function () //start fading the messagebox

                {
                    var msg;
                    msg = 'Email Id Already Registered....'

                    //add message and change the class of the box and start fading

                    $(this).removeClass();

                    $(this).addClass('messageboxerror');

                    $(this).html('<img align="absmiddle" src="' + path_temp + 'images/Error.png" />' + msg).show().fadeTo(1900, 1);

                });
                var msg = "";
                document.getElementById('email_error').innerHTML = msg
                document.getElementById("create").disabled = true;
            }

        });
    }
}
function trim(a)
{
    return a.replace(/^\s+|\s+$/, '');
}
function validateMobile()
{
    var path_root = document.getElementById('path_root').value;
    var path_temp = document.getElementById('path_temp').value;
    var mobile_no = document.getElementById('mobile_no').value;

//    if (!mobile_no.isNumeric)
//    {
//        var msg = "Digits Only";
//        document.getElementById('mobile_error').innerHTML = msg
//        document.getElementById("create").disabled = true;
//    }
//    else
//    {

    var path = path_root + "shopping/validateMobile";
    $.post(path, {mobile_no: mobile_no}, function (data)
    {
        data = trim(data);
        if (data == 0)
        {
            $("#errormsg10").fadeTo(200, 0.1, function () //start fading the messagebox

            {
                var msg;
                msg = 'Valid Mobile No..'

                //add message and change the class of the box and start fading

                $(this).removeClass();

                $(this).addClass('messageboxerror');

                $(this).html('<img align="absmiddle" src="' + path_temp + 'images/accepted.png" />' + msg).show().fadeTo(1900, 1);

            });
            var msg = "";
            document.getElementById('mobile_error').innerHTML = msg
            document.getElementById("create").disabled = false;
        }
        else
        {
            $("#errormsg10").fadeTo(200, 0.1, function () //start fading the messagebox

            {
                var msg;
                msg = 'Mobile No is Already Registered....'

                //add message and change the class of the box and start fading

                $(this).removeClass();

                $(this).addClass('messageboxerror');

                $(this).html('<img align="absmiddle" src="' + path_temp + 'images/Error.png" />' + msg).show().fadeTo(1900, 1);

            });
            var msg = "";
            document.getElementById('mobile_error').innerHTML = msg
            document.getElementById("create").disabled = true;
        }

    });
    //}
}
function validateUserName()
{
    var path_root = document.getElementById('path_root').value;
    var path_temp = document.getElementById('path_temp').value;
    var user_name = document.getElementById('user_name').value;

    var path = path_root + "shopping/validateUserName";
    $.post(path, {user_name: user_name}, function (data)
    {
        data = trim(data);
        if (data == 0)
        {
            $("#errormsg9").fadeTo(200, 0.1, function () //start fading the messagebox

            {
                var msg;
                msg = 'Valid User Name..'

                //add message and change the class of the box and start fading

                $(this).removeClass();

                $(this).addClass('messageboxerror');

                $(this).html('<img align="absmiddle" src="' + path_temp + 'images/accepted.png" />' + msg).show().fadeTo(1900, 1);

            });
            var msg = "";
            document.getElementById('user_error').innerHTML = msg
            document.getElementById("create").disabled = false;
        }
        else
        {
            $("#errormsg9").fadeTo(200, 0.1, function () //start fading the messagebox

            {
                var msg;
                msg = 'User Name is Already Registered....'

                //add message and change the class of the box and start fading

                $(this).removeClass();

                $(this).addClass('messageboxerror');

                $(this).html('<img align="absmiddle" src="' + path_temp + 'images/Error.png" />' + msg).show().fadeTo(1900, 1);

            });
            var msg = "";
            document.getElementById('user_error').innerHTML = msg
            document.getElementById("create").disabled = true;
        }

    });
}
function ValidateRegistration()
{

    var first_name = document.getElementById('first_name').value;
    var last_name = document.getElementById('last_name').value;
    var address = document.getElementById('address').value;
    var mobile_no = document.getElementById('mobile_no').value;
    var email = document.getElementById('email').value;
    var user_name = document.getElementById('user_name').value;
    var password = document.getElementById('password').value;
    var confirm_password = document.getElementById('confirm_password').value;
    var flag = 'yes';
    if (first_name == '')
    {
        var msg = "<font color='#ff0000'>Please Enter First Name..</font>";
        document.getElementById('first_error').innerHTML = msg
        flag = 'no';
    }
    else {
        var msg = "";
        document.getElementById('first_error').innerHTML = msg

    }
    if (last_name == '')
    {
        var msg = "<font color='#ff0000'>Please Enter Last Name..</font>";
        document.getElementById('last_error').innerHTML = msg
        flag = 'no';
    }
    else {
        var msg = "";
        document.getElementById('last_error').innerHTML = msg

    }
    if (address == '')
    {
        var msg = "<font color='#ff0000'>Please Enter Address..</font>";
        document.getElementById('address_error').innerHTML = msg
        flag = 'no';
    }
    else {
        var msg = "";
        document.getElementById('address_error').innerHTML = msg

    }
    if (mobile_no == '')
    {
        var msg = "<font color='#ff0000'>Please Enter Mobile No..</font>";
        document.getElementById('mobile_error').innerHTML = msg
        flag = 'no';
    }
    else {
        var msg = "";
        document.getElementById('mobile_error').innerHTML = msg

    }
    if (email == '')
    {
        var msg = "<font color='#ff0000'>Please Enter Email Id..</font>";
        document.getElementById('email_error').innerHTML = msg
        flag = 'no';
    }
    else {
        var msg = "";
        document.getElementById('email_error').innerHTML = msg

    }
    if (user_name == '')
    {
        var msg = "<font color='#ff0000'>Please Enter Email Id..</font>";
        document.getElementById('user_error').innerHTML = msg
        flag = 'no';
    }
    else {
        var msg = "";
        document.getElementById('user_error').innerHTML = msg

    }
    if (password == '')
    {
        var msg = "<font color='#ff0000'>Please Enter Password..</font>";
        document.getElementById('password_error').innerHTML = msg
        flag = 'no';
    }
    else {
        var msg = "";
        document.getElementById('password_error').innerHTML = msg

    }
    if (confirm_password == '')
    {
        var msg = "<font color='#ff0000'>Please Enter Password Again..</font>";
        document.getElementById('confirm_error').innerHTML = msg
        flag = 'no';
    }
    else {
        var msg = "";
        document.getElementById('confirm_error').innerHTML = msg

    }
    if (confirm_password != password)
    {
        var msg = "<font color='#ff0000'>Password mismatch..</font>";
        document.getElementById('confirm_error').innerHTML = msg
        flag = 'no';
    }
    else {
        var msg = "";
        document.getElementById('confirm_error').innerHTML = msg

    }
    if (flag == 'yes')
    {
        return true;
    }
    else
    {
        return false;
    }
}
