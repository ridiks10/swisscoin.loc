var ValidateCareer = function() {

    var runValidateLetterConfig = function() {

        var searchform = $('#add_careers');
        var errorHandler1 = $('.errorHandler', searchform);
        //  var successHandler1 = $('.successHandler', form_setting);

        $('#add_careers').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function(error, element) { // render error placement for each input type

                error.insertAfter(element);
                // for other inputs, just perform default behavior
            },
            ignore: ':hidden',
            rules: {
                leadership_rank: {
                    minlength: 1,
                    required: true
                },
                leadership_award: {
                    minlength: 1,
                    required: true
                },
                userfile: {
                    required: true
                },
                qualifying_terms: {
                    minlength: 3,
                    required: true
                },
                qualifying_weaker_leg_bv: {
                    number: true
                },
                qualifying_personal_pv: {
                    number: true
                }
            },
            messages: {
                leadership_rank: 'you should enter leadership rank',
                leadership_award: 'you should enter leadership award',
                userfile: 'you should select an image',
                qualifying_weaker_leg_bv: 'invalid bv entered..',
                qualifying_personal_pv: 'invalid bv entered..',
                qualifying_terms: 'you should enter Qualifying term'

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
            runValidateLetterConfig();

        }
    };

}();



function edit_career(id)
{
    var confirm_msg = $("#confirm_msg_edit").html();
    var path_root = $("#base_url").val();
    if (confirm(confirm_msg))
    {

        document.location.href = path_root + 'admin/career/add_careers/edit/' + id;

    }
}

