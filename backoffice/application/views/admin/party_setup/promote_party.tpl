<!-- code for facebook share a link ////start -->   
<div id="fb-root"></div>
<script>(function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id))
            return;
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
<!-- code for facebook share a link // end-->

<!-- code for twitter share a link // start-->
<script>!function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (!d.getElementById(id)) {
            js = d.createElement(s);
            js.id = id;
            js.src = "https://platform.twitter.com/widgets.js";
            fjs.parentNode.insertBefore(js, fjs);
        }
    }(document, "script", "twitter-wjs");
</script>
<!-- code for twitter share a link // end-->

<!-- code for pinterest share a link // start--><!-- Please call pinit.js only once per page -->
<script type="text/javascript" async src="//assets.pinterest.com/js/pinit.js"></script>
<!-- code for pinterest share a link // end-->

{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i> {lang('promote_your_party')}
                <div class="panel-tools">
                    <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                    </a>
                    <a class="btn btn-xs btn-link panel-refresh" href="#">
                        <i class="fa fa-refresh"></i>
                    </a>
                    <a class="btn btn-xs btn-link panel-expand" href="#">
                        <i class="fa fa-resize-full"></i>
                    </a>
                    <a class="btn btn-xs btn-link panel-close" href="#">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel-body">
                            <div>
                                <table>
                                    <tr>                                      
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td><br>
                                            <img src="{$PUBLIC_URL}images/party_image/{$details['party_image']}" width="200" height="200" >
                                            <br><br> 
                                </table>
                                <table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">                                   
                                    <tr>
                                        <td>{$details['status']}</td>
                                    </tr>
                                    <tr>
                                        <th>{lang('party_name')}</th>
                                        <td>{$details['party_name']}</td>
                                    </tr>
                                    <tr>
                                        <th>{lang('host')}</th>
                                        <td>{$details['host_name']}</td>
                                    </tr>
                                    <tr>
                                        <th>{lang('address')}</th>
                                        <td>
                                            {$details['address']}<br>
                                            {$details['city']}<br>
                                            {$details['state']}<br>
                                            {$details['country']}<br>
                                            {$details['zip']}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>{lang('contact_info')}</th>
                                        <td>
                                            {$details['phone']}<br>
                                            {$details['email']}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>{lang('start_date')}</th>
                                        <td>
                                            {$details['from_date']}<br>
                                            {$details['from_time']}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>{lang('end_date')}</th>
                                        <td>{$details['to_date']}<br>
                                            {$details['to_time']}
                                        </td>
                                    </tr>
                                </table>
                                {* <br><br><br>
                                {lang('promote_party')}
                                <br> <br>*}
                                {*    <table>
                                <tr>
                                <td style="width:150px;">
                                <div class="fb-share-button" data-href="{$party_url}" data-type="button_count"></div> <!-- facebook button -->
                                </td>
                                <td style="width:130px;">
                                <a href="https://twitter.com/share" class="twitter-share-button" data-text="My Party " data-url="{$party_url}" data-lang="en" data-related="anywhereTheJavascriptAPI" data-count="horizontal">Tweet</a>
                                </td>
                                <td style="width:150px;">*}
                                {*                               <a target="_blank" href="//www.pinterest.com/pin/create/button/?url=http%3A%2F%2Fhotmesscosmetics.com%2FHMC_new%2Fhot-mess%2Fparty_details.php%3Fpid%3D1&media=http%3A%2F%2Fhotmesscosmetics.com%2FHMC_new%2Fsoft%2Fpublic_html%2Fimages%2Flogo.png&description=HotMessCosmetics" data-pin-do="buttonPin" data-pin-config="beside"><img src="//assets.pinterest.com/images/pidgets/pinit_fg_en_rect_gray_20.png" /></a><!-- pinterest button -->*}{*
                                <a target="_blank" href="//www.pinterest.com/pin/create/button/?url={$party_url}" data-pin-do="buttonPin" data-pin-config="beside"><img src="//assets.pinterest.com/images/pidgets/pinit_fg_en_rect_gray_20.png" /></a><!-- pinterest button -->
                                </td>

                                </tr>
                                </table>*}
                                <br><br>
                                <a href="../create_party"><input class="btn btn-bricky" type="button" value="{lang(set_up_another_party)}" tabindex="2"></a> <br><br> 
                                <a href="../../myparty/party_portal"><input class="btn btn-bricky" type="button" value="{lang(go_to_party_portal)}" tabindex="2"></a>  
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function () {
        Main.init();
        TableData.init();
    });
</script>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}