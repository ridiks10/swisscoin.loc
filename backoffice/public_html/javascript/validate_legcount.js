function validate_profile_report(searchform)

 {


  var msg = "";
  var user_name = searchform.user_name.value;

  if(user_name == "") {
      
      msg = $("#error_msg").html();
      
     inlineMsg('user_name',msg,4);

  return false;

  }

    return true;



}

var ValidateUser = function () {
    
    // function to initiate Validation Sample 1
    var msg=$("#error_msg").html();

    var runValidatorweeklySelection = function () {
        var searchform = $('#legcount');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#legcount').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function (error, element) { // render error placement for each input type
             
                error.insertAfter(element);
                error.insertAfter($(element).closest('.input-group'));
            // for other inputs, just perform default behavior
            },
            ignore: ':hidden',
            rules: {
                
               user_name: {
                    minlength: 1,
                    required: true
                }
            },
            messages: {                
               
                 user_name: msg
                
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