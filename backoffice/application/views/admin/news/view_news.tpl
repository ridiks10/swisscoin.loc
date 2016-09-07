{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl" name=""}

<div id="span_js_messages" style="display:none;">
    <span id="error_msg">{lang('you_must_enter_news_title')}</span>
    <span id="error_msg1">{lang('you_must_enter_news')}</span>
    <span id="confirm_msg1">{lang('sure_you_want_to_edit_this_news_there_is_no_undo')}</span>
    <span id="confirm_msg2">{lang('sure_you_want_to_delete_this_news_there_is_no_undo')}</span>
</div>
  <div class="row">
    <div class="col-sm-12" >
        
            <div class="panel-body" >
                {*<div class="col-sm-6" >
                   {$details['title']} 
                </div>
                <br><br>
                <div class="col-sm-6">
                   <img src="{$PUBLIC_URL}images/news/{$details['news_image']}" border="0" />
                </div>
                 <br><br><br><br><br><br>
                <div class="col-sm-6" style = "boarder-color:red";>
                   {$details['news_desc']}
                </div>*}
               
                <table class="table table-striped  table-hover table-bordered table-full-width" id="">
                        <thead>
                            
                          
                            <tr   style = "background-color:lightyellow;border-color:white;">
                                <th><center>  {$details['title']}</center></th>
                            </tr>
                            <tr   style = "background-color:white;">
                                <th><center> </center></th>
                            </tr>
                            {if $details['news_image']!=""}
                            <tr   style = "background-color:lightyellow;border-color:white;">
                                <th><center>  <img src="{$PUBLIC_URL}images/news/{$details['news_image']}" border="0" style="height:25%;width:25%;"/></center></th>
                               
                            </tr>
                           
                            <tr class="th"  style = "background-color:white;">
                                <th><center> </center></th>
                            </tr>
                             {/if}
                            {if $details['news_desc']!=""}
                            <tr class="th"  style = "background-color:lightyellow;border-color:white;">
                                <th><center>  {$details['news_desc']}</center></th>
                            </tr>
                            <tr class="th"  style = "background-color:white;">
                                <th><center> </center></th>
                            </tr>
                                                        {/if}

                            {if $details['link']!=""}
                            <tr class="th"  style = "background-color:lightyellow;border-color:white;">
                                <th><center> <a href='{$details['link']}' target="_blank">{$details['link']}</a></center></th>
                            </tr>
                            {/if}

                        </thead>
                        </table>
            </div>
        </div>
   </div>
  </div>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function() {
        Main.init();
        ValidateUser.init();

    });
</script>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}