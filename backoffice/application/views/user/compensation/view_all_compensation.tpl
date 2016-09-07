{include file="user/layout/themes/{$USER_THEME_FOLDER}/header.tpl" name=""}

<div id="span_js_messages" style="display:none;">
    <span id="error_msg">{lang('you_must_enter_compensation_title')}</span>
    <span id="error_msg1">{lang('you_must_enter_compensation')}</span>
    <span id="confirm_msg1">{lang('sure_you_want_to_edit_this_compensation_there_is_no_undo')}</span>
    <span id="confirm_msg2">{lang('sure_you_want_to_delete_this_compensation_there_is_no_undo')}</span>
</div>
  <div class="row">
    <div class="col-sm-12" >
        
            <div class="panel-body" >
               
               
                <table class="table table-striped  table-hover table-bordered table-full-width" id="">
                        <thead>
                            
                          
                            <tr   style = "background-color:lightyellow;border-color:white;">
                                <th><center>  {$details['title']}</center></th>
                            </tr>
                            <tr   style = "background-color:white;">
                                <th><center> </center></th>
                            </tr>
                            {if $details['compensation_image']!=""}
                            <tr   style = "background-color:lightyellow;border-color:white;">
                                <th><center>  <img src="{$PUBLIC_URL}images/compensation/{$details['compensation_image']}" border="0"  height="300" width="auto"/></center></th>
                               
                            </tr>
                           
                            <tr class="th"  style = "background-color:white;">
                                <th><center> </center></th>
                            </tr>
                             {/if}
                            {if $details['compensation_desc']!=""}
                            <tr class="th"  style = "background-color:lightyellow;border-color:white;">
                                <th><center>  {$details['compensation_desc']}</center></th>
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
  {include file="user/layout/themes/{$USER_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function() {
        Main.init();
    });
</script>
{include file="user/layout/themes/{$USER_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}