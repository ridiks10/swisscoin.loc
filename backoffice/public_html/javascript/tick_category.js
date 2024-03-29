function addNewStatus()
{

    var new_status = "<tr><td></td><td> <input type='text' name='status_name' id='status_name' maxlength='20'  class='form-control' />";
        new_status += "</td>";
        new_status += "<td style='text-align:center;'><input type='submit' name='status_button' id='status_button' class='btn btn-primary btn-xs' title='Submit' value='Submit' />";
        new_status += "</td></tr>";
        $( "tfoot#status" ).html(new_status);

}
function addNewTag()
{

    var new_status = "<tr><td></td><td> <input type='text' name='tag_name' id='tag_name' maxlength='20'  class='form-control' />";
        new_status += "</td>";
        new_status += "<td style='text-align:center;'><input type='submit' name='tag_button' id='tag_button' class='btn btn-primary btn-xs' title='Submit' value='Submit' />";
        new_status += "</td></tr>";      
        $( "tfoot#tag" ).html(new_status);

}
function addNewPriority()
{

    var new_status = "<tr><td></td><td> <input type='text' name='priority_name' id='priority_name' maxlength='20'  class='form-control' />";
        new_status += "</td>";
        new_status += "<td style='text-align:center;'><input type='submit' name='priority_button' id='priority_button' class='btn btn-primary btn-xs' title='Submit' value='Submit' />";
        new_status += "</td></tr>";
        $( "tfoot#priority" ).html(new_status);

}

function deletePriority(id)
{

    var ans = confirm('Do you want to inactivate this priority?');
    if (ans == true) {
        var base_url = $("#base_url").val();
        var current_url_full = 'admin/ticket_system/configuration/';
        var action = 'delete_prio'
        $(location).attr('href', base_url + current_url_full + action + '/' + id);
    }



}
function activatePriority(id)
{

    var ans = confirm('Do you want to activate this priority?');
    if (ans == true) {
        var base_url = $("#base_url").val();
        var current_url_full = 'admin/ticket_system/configuration/';
        var action = 'activate_prio'
        $(location).attr('href', base_url + current_url_full + action + '/' + id);
    }



}
function deleteTag(id)
{

    var ans = confirm('Do you want to inactivate this tag?');
    if (ans == true) {
        var base_url = $("#base_url").val();
        var current_url_full = 'admin/ticket_system/configuration/';
        var action = 'delete_tag'
        $(location).attr('href', base_url + current_url_full + action + '/' + id);
    }



}
function activateTag(id)
{

    var ans = confirm('Do you want to activate this tag?');
    if (ans == true) {
        var base_url = $("#base_url").val();
        var current_url_full = 'admin/ticket_system/configuration/';
        var action = 'activate_tag'
        $(location).attr('href', base_url + current_url_full + action + '/' + id);
    }



}

function deleteStatus(id)
{

    var ans = confirm('Do you want to inactivate this status?');
    if (ans == true) {
        var base_url = $("#base_url").val();
        var current_url_full = 'admin/ticket_system/configuration/';
        var action = 'delete'
        $(location).attr('href', base_url + current_url_full + action + '/' + id);
    }

}
function activateStatus(id)
{
    var ans = confirm('Do you want to activate this status?');
    if (ans == true) {
        var base_url = $("#base_url").val();
        var current_url_full = 'admin/ticket_system/configuration/';
        var action = 'activate'
        $(location).attr('href', base_url + current_url_full + action + '/' + id);
    }

}
function deleteCategory(id)
{
    var ans = confirm('Do you want to inactivate this category?');
    if (ans == true) {
        var base_url = $("#base_url").val();
//        var current_url_full = $("#current_url_full").val();
        var current_url_full = 'admin/ticket_system/category/';
        var action = 'delete'
        $(location).attr('href', base_url + current_url_full + action + '/' + id);
    }

}

function activateCategory(id)
{
    var ans = confirm('Do you want to activate this category?');
    if (ans == true) {
        var base_url = $("#base_url").val();
//        var current_url_full = $("#current_url_full").val();
        var current_url_full = 'admin/ticket_system/category/';
        var action = 'ativate'
        $(location).attr('href', base_url + current_url_full + action + '/' + id);
    }

}
function editCategory(id)
{
    var base_url = $("#base_url").val();
    var current_url_full = 'admin/ticket_system/category/';
    var action = 'edit'
    $(location).attr('href', base_url + current_url_full + action + '/' + id);

}

function addNewCategory()
{
    var base_url = $("#base_url").val();
    var current_url_full = 'admin/ticket_system/category/';
    var action = 'new'
    $(location).attr('href', base_url + current_url_full + action+'/');

}




var ValidateCtegory = function () {


    var Validatecategory = function () {
        var searchform = $('#category');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#category').validate({
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
                name: {
                    maxlength: 40,
                    required: true
                },
               employee: {
                    minlenth: 1,
                    required: true
               }

            },
            messages: {
                name: {required: 'Category name is required...',
                    maxlength: 'Exceeded maximum length...',
                },
                employee: "You should select an employee"
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

            Validatecategory();

        }
    };
}();


var ValidatePriority = function () {


    var Validatepririty = function () {
        var searchform = $('#new_priority');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#new_priority').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function (error, element) { // render error placement for each input type
                if ($(element).hasClass("date-picker")) {
                    error.insertAfter($(element).closest('.input-group'));
                }
                else
                {
                    error.insertAfter(element);
                };
              
            },
            ignore: ':hidden',
            rules: {
                priority_name: {
                    maxlength: 40,
                    required: true
                }


            },
            messages: {
                priority_name: {
                    required: 'Priority name is required...',
                    maxlength: 'Exceeded maximum length...',
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

            Validatepririty();

        }
    };
}();

var ValidateStatus = function () {

    var Validatestatus = function () {
        var searchform = $('#new_status');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#new_status').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function (error, element) { // render error placement for each input type
                if ($(element).hasClass("date-picker")) {
                    error.insertAfter($(element).closest('.input-group'));
                }
                else
                {
                    error.insertAfter(element);
                };
              
            },
            ignore: ':hidden',
            rules: {
                status_name: {
                    maxlength: 40,
                    required: true
                }


            },
            messages: {
                status_name: {
                    required: 'Status name is required...',
                    maxlength: 'Exceeded maximum length...',
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

            Validatestatus();

        }
    };
}();

var ValidateTag = function () {


    var Validatetag = function () {
        var searchform = $('#new_tag');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#new_tag').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function (error, element) { // render error placement for each input type
                if ($(element).hasClass("date-picker")) {
                    error.insertAfter($(element).closest('.input-group'));
                }
                else
                {
                    error.insertAfter(element);
                };
              
            },
            ignore: ':hidden',
            rules: {
                tag_name: {
                    maxlength: 40,
                    required: true
                }


            },
            messages: {
                tag_name: {
                    required: 'Tag name is required...',
                    maxlength: 'Exceeded maximum length...',
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

            Validatetag();

        }
    };
}();