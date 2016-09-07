<script>
    $(window).bind('focus', function()
    {
        idleSessout();
    });

    function idleSessout()
    {
       var base_url = $("#base_url").val();
        //get the last page load time and current server time
        var post_path = base_url + "time/check_time_out";
        jQuery.post(post_path, { {$CSRF_TOKEN_NAME}: '{$CSRF_TOKEN_VALUE}'}, function(data)
        {
            if (data == "expired") {
                document.location.href = base_url + "login/logout";
            }
        }); 
    }
</script>