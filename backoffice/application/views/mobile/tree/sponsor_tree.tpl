<script>
    function getGenologyTree(id, event)
    {
        $.ajax({
            type: "POST",
            url: '{$BASE_URL}mobile/tree/tree_view_sponsor',
            data: { user_id: id, {$CSRF_TOKEN_NAME}: 'f6f7369316c4928fdceaaed397356f5b', from_mobile: true, admin_username: '{$ADMIN_USER_NAME}', user_name: '{$LOG_USER_NAME}'},
            beforeSend: function() {
                var x = "50%";     // Get the horizontal coordinate
                var y = "75%";     // Get the vertical coordinate  
                var position = "fixed";
                if (event) {
                    x = event.clientX;     // Get the horizontal coordinate
                    y = event.clientY;     // Get the vertical coordinate
                }

                var d = document.getElementById('loader-div');
                d.style.position = position;
                d.style.left = x;
                d.style.top = y;
                $('#loader-div').show();
            },
            success: function(data) {
                // data is ur summary
                $('#summary').html(data);
                $('#loader-div').hide();

                 //Uncomment the following code to Focus on ROOT USER OF THE TREE//
               /* var tree_window_size = $("#tree_div").width();
                var box_size = $("#summary").width();

                var x = tree_window_size / 2 - box_size / 2; 
                var y = 0;

                $("#summary").scrollTo(x, y);

                $('#summary').animate({
                    'scrollTop': $("#chart").position().top
                }, '100');*/
            }
        });
    }
</script>
{include file="mobile/layout/themes/default/header.tpl"}

<div id="span_js_messages" style="display:none">
    <span id="error_msg">{lang('you_must_select_user')}</span>
</div>


<!-- start: GENOLOGY TREE-->                                         
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-sitemap"></i>
                {lang('sponsor_tree')}
            </div>
            <div class="panel-body" style="overflow: auto;">
                <button class="zoomIn"><span class="glyphicon glyphicon-zoom-in" style="font-size:20px"></span></button>
                <button class="zoomOut"><span class="glyphicon glyphicon-zoom-out" style="font-size:20px"></span></button>
                <button class="zoomOff"><span class="glyphicon glyphicon-off" style="font-size:20px"></span></button>

                <div class="row">
                    <div class="col-sm-8">
                        <img src='{$PUBLIC_URL}images/active.gif' style="border:hidden" title="Paid" align="absmiddle" width="40px" height="40px"/><b>{lang('active')}</b>&nbsp;&nbsp;&nbsp;
                        <img src='{$PUBLIC_URL}images/inactive.png' style="border:hidden" title="Not Paid" align="absmiddle" width="40px" height="40px"/><b>{lang('inactive')}</b>&nbsp;&nbsp;&nbsp;

                        <img src="{$PUBLIC_URL}images/add.png" style="border:hidden" title="New One" align="absmiddle" width="24px" height="24px"/>&nbsp;<b>{lang('vacant')}</b>&nbsp; <font color="#000000"><strong></strong></font>

                    </div>
                </div>

                <div id="loader-div" style="z-index:9999;text-align: center;display: none;"><img src="{$PUBLIC_URL}images/loader.gif" style="margin-left: 10px;"/></div>

                <div id="summary" class="panel-body tree-container1" style="height:100%;margin: auto;width: 100%;top: 0px;"></div>
            </div>
        </div>
    </div>
</div>

<!-- end: GENOLOGY TREE-->


{include file="mobile/layout/themes/default/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function() {
        Main.init();
        getGenologyTree('{$user_id}', null);
        ValidateUser.init();
    });
</script>
{include file="mobile/layout/themes/default/page_footer.tpl" title="Example Smarty Page" name=""}