jQuery(document).ready(function() {
    jQuery("#user_name, #to_user_name, #new_user_name, .username-auto-ajax").autocomplete({
        source: document.getElementById('base_url').value + "admin/ajax/autocomplete",
        minLength: 3
    });
});