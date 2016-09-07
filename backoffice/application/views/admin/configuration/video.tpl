{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}

<div class="panel panel-default">
    <div class="panel-heading">
        <i class="fa fa-external-link-square"></i>{lang('add video')}
    </div>

    <div class="panel-body">
        {form_open('','role="form" class="smart-wizard form-horizontal" name= "form_setting"  id="form_setting"')}
        <div class="form-group">
            <label class="col-sm-4 control-label" for="db_percentage" >{lang('title')} <span class="symbol required"></span>:</label>
            <div class="col-sm-8">
                <input tabindex="20" maxlength="50" type="text" name ="video[title]" id ="title" title="" class="form-control" value="{set_value('video[title]', $video_info['title'])}" >{form_error('video[title]')}
                <span id="errmsg_title"></span>
            </div>
        </div>
                
        <div class="form-group">
            <label class="col-sm-4 control-label" for="db_percentage" >{lang('url')} <span class="symbol required"></span>:</label>
            <div class="col-sm-8">
                <input tabindex="21" type="text" name ="video[url]" id ="url" title="" class="form-control" value="{set_value('video[url]', $video_info['url'])}" >{form_error('video[url]')}
                <span id="errmsg_url"></span>
            </div>
        </div>
                
        <div class="form-group">
            <label class="col-sm-4 control-label" for="db_percentage" >{lang('on_dashboard')}:</label>
            <div class="col-sm-8"><div class="checkbox">
                <label><input tabindex="22" type="checkbox" name ="video[on_dashboard]" id ="on_dashboard" title="" value="1" {if empty($video_info['on_dashboard']) }{else}checked="checked"{/if}></label></div>{form_error('video[on_dashboard]')}
                <span class="help-block">{lang('on_dashboard help', '', '')}</span>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-2 col-sm-offset-2">
                <button class="btn btn-bricky"  type="submit" value="{$update_button}" tabindex="32" name="setting" id="setting" style="margin-left:25%;" title="{$update_button}" >{$update_button}</button>
            </div>
        </div>
        {form_close()}
    </div>
</div>

{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function() {
        Main.init();
    });
</script>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}  
