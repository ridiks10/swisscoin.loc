var ValidateTicket = function() {

    var runValidatorTicketStatus = function() {
        var searchform = $('#change_status_form');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#change_status_form').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function(error, element) { // render error placement for each input type
                if ($(element).hasClass("date-picker")) {
                    error.insertAfter($(element).closest('.input-group'));
                }
                else
                {
                    error.insertAfter(element);
                }
                ;
                //error.insertAfter(element);
                // for other inputs, just perform default behavior
            },
            ignore: ':hidden',
            rules: {
                status: {
                    minlength: 1,
                    required: true
                }


            },
            messages: {
                status: 'You must select status'


            },
            invalidHandler: function(event, validator) { //display error alert on form submit
                errorHandler1.show();
            },
            highlight: function(element) {
                $(element).closest('.help-block').removeClass('valid');
                // display OK icon
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error').find('.symbol').removeClass('ok').addClass('required');
                // add the Bootstrap error class to the control group
            },
            unhighlight: function(element) { // revert the change done by hightlight
                $(element).closest('.form-group').removeClass('has-error');
                // set error class to the control group
            },
            success: function(label, element) {
                label.addClass('help-block valid');
                // mark the current input as valid and display OK icon
                //$(element).closest('.form-group').removeClass('has-error').addClass('has-success').find('.symbol').removeClass('required').addClass('ok');
                $(element).closest('.form-group').removeClass('has-error').addClass('ok');
            }
        });
    };
     var runValidatorTicketPriority = function() {
        var searchform = $('#change_priority_form');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#change_priority_form').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function(error, element) { // render error placement for each input type
                if ($(element).hasClass("date-picker")) {
                    error.insertAfter($(element).closest('.input-group'));
                }
                else
                {
                    error.insertAfter(element);
                }
                ;
                //error.insertAfter(element);
                // for other inputs, just perform default behavior
            },
            ignore: ':hidden',
            rules: {
                priority: {
                    minlength: 1,
                    required: true
                }


            },
            messages: {
                priority: 'You must select priority'


            },
            invalidHandler: function(event, validator) { //display error alert on form submit
                errorHandler1.show();
            },
            highlight: function(element) {
                $(element).closest('.help-block').removeClass('valid');
                // display OK icon
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error').find('.symbol').removeClass('ok').addClass('required');
                // add the Bootstrap error class to the control group
            },
            unhighlight: function(element) { // revert the change done by hightlight
                $(element).closest('.form-group').removeClass('has-error');
                // set error class to the control group
            },
            success: function(label, element) {
                label.addClass('help-block valid');
                // mark the current input as valid and display OK icon
                //$(element).closest('.form-group').removeClass('has-error').addClass('has-success').find('.symbol').removeClass('required').addClass('ok');
                $(element).closest('.form-group').removeClass('has-error').addClass('ok');
            }
        });
    };
     var runValidatorTicketCategory = function() {
        var searchform = $('#change_category_form');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#change_category_form').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function(error, element) { // render error placement for each input type
                if ($(element).hasClass("date-picker")) {
                    error.insertAfter($(element).closest('.input-group'));
                }
                else
                {
                    error.insertAfter(element);
                }
                ;
                //error.insertAfter(element);
                // for other inputs, just perform default behavior
            },
            ignore: ':hidden',
            rules: {
                category: {
                    minlength: 1,
                    required: true
                }


            },
            messages: {
                category: 'You must select Category'


            },
            invalidHandler: function(event, validator) { //display error alert on form submit
                errorHandler1.show();
            },
            highlight: function(element) {
                $(element).closest('.help-block').removeClass('valid');
                // display OK icon
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error').find('.symbol').removeClass('ok').addClass('required');
                // add the Bootstrap error class to the control group
            },
            unhighlight: function(element) { // revert the change done by hightlight
                $(element).closest('.form-group').removeClass('has-error');
                // set error class to the control group
            },
            success: function(label, element) {
                label.addClass('help-block valid');
                // mark the current input as valid and display OK icon
                //$(element).closest('.form-group').removeClass('has-error').addClass('has-success').find('.symbol').removeClass('required').addClass('ok');
                $(element).closest('.form-group').removeClass('has-error').addClass('ok');
            }
        });
    };
  


    return {
        //main function to initiate template pages
        init: function() {
            runValidatorTicketStatus();
            runValidatorTicketPriority();
            runValidatorTicketCategory();

        }
    };
}();
function changeTicketStatus(id)
{

    var option = $('select#sel3').val();

    if (option != '') {
        var ans = confirm('Do you want to change this status?');
        if (ans == true) {

            var base_url_id = $("#base_url").val();
            var current_url = base_url_id + 'admin/employee/status_change';


            $.post(current_url, {id: id, option: option},
            function (data) {
              
                if(data != 'false')
                $('#status_name').text(data);

            }, "html");


        } else {
            $("select#sel3").val('');
        }
    }
}

function changeTicketCategory(id)
{

    var option = $('select#sel2').val();

    if (option != '') {
        var ans = confirm('Do you want to change this category?');
        if (ans == true) {

            var base_url_id = $("#base_url").val();
            var current_url = base_url_id + 'admin/employee/category_change';


            $.post(current_url, {id: id, option: option},
            function (data) {
                if(data != 'false')
                $('#category_name').text(data);

            }, "html");


        } else {
            $("select#sel2").val('');
        }
    }
}
function changeTicketPriority(id)
{

    var option = $('select#sel1').val();

    if (option != '') {
        var ans = confirm('Do you want to change this priority?');
        if (ans == true) {

            var base_url_id = $("#base_url").val();
            var current_url = base_url_id + 'admin/employee/priority_change';


            $.post(current_url, {id: id, option: option},
            function (data) {
                if(data != 'false')
                $('#priority_name').text(data);

            }, "html");


        } else {
            $("select#sel1").val('');
        }
    }
}

var ValidateMessage = function () {


    var Validatemess = function () {
        var searchform = $('#reply_form');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#reply_form').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function (error, element) { // render error placement for each input type
                if ($(element).hasClass("date-picker")) {
                    error.insertAfter($(element).closest('.input-group'));
                }
                else
                {
                    error.insertAfter(element);
                }
                ;
                //error.insertAfter(element);
                // for other inputs, just perform default behavior
            },
            ignore: ':hidden',
            rules: {
                message: {
//                    maxlength: 40,
                    required: true
                },
               
            },
            messages: {
                message: {
                    required: 'message field is empty..!',
                }
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

            Validatemess();

        }
    };
}();



