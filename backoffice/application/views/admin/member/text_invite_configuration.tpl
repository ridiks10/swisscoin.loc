{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl" name=""}
<div id="span_js_messages" style="display: none;"> 
    <span id="row_msg">{lang('rows')}</span>
    <span id="show_msg">{lang('shows')}</span>
    <span id="validate_msg1">{lang('enter_subject')}</span>
    <span id="validate_msg2">{lang('enter_message')}</span>

</div>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>
                {lang('text_invite_configuration')}
            </div>
            <div class="panel-body">
                {form_open('','role="form" class="smart-wizard form-horizontal" method="post"  name="invite_text_form" id="invite_text_form"')}
                    <input type="hidden" id="path_root" name="path_root" value="{$PATH_TO_ROOT_DOMAIN}admin/">
                    <div class="col-md-12">
                        <div class="errorHandler alert alert-danger no-display">
                            <i class="fa fa-times-sign"></i> {lang('errors_check')}
                        </div>
                    </div>

                    <div class="form-group"> 
                        <label class="col-sm-2 control-label" >{lang('subject')} :<span class="symbol required"></span></label>
                        <div class="col-sm-6">
                            <input class="form-control"  type="text"  name ="subject" id ="subject" value=''  autocomplete="Off" tabindex="2">
                        </div>
                        {form_error('subject')}
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="mail_content">
                            {lang('message')} :<span class="symbol required"></span>
                        </label>
                        <div class="col-sm-9">
                            <textarea id="mail_content"  name="mail_content"   class="ckeditor form-control"  tabindex="3"  rows='10' >                              
                            </textarea>{form_error('mail_content')}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                        </label>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2 col-sm-offset-2">
                            <button class="btn btn-bricky" tabindex="5"   type="submit"  value="Update" name="update" id="update" >{lang('add_item')}</button>                                
                        </div>
                    </div>
                {form_close()}
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i> 
                {lang('text_invite_configuration')}
                <div class="panel-tools">
                    <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                    </a>
                    <a class="btn btn-xs btn-link panel-refresh" href="#">
                        <i class="fa fa-refresh"></i>
                    </a>
                    <a class="btn btn-xs btn-link panel-expand" href="#">
                        <i class="fa fa-resize-full"></i>
                    </a>
                </div>
            </div>

            <div class="panel-body">
                <table class="table table-striped table-bordered table-hover table-full-width" id="">
                    <thead>
                        <tr class="th" >
                            <th>{lang('no')}</th>                            
                            <th>{lang('subject')}</th>                          
                            <th>{lang('action')}</th>
                        </tr>
                    </thead>
                    {if count($mail_data)>0}
                        <tbody>
                            {assign var="i" value="0"}
                            {assign var="class" value=""}
                            {foreach from=$mail_data item=v}
                                <tr>    {$i=$i+1}                                
                                    <td>{$i}</td>
                                    <td width="50%">{$v.subject}</td>
                                    <td >
                                        <div class="col-md-12">
                                            <div class="col-sm-3">
                                                {form_open('admin/member/edit_invite_text','method="post"')}
                                                    <input type='hidden' id='invite_text_id' name='invite_text_id' value='{$v.id}'>
                                                    <button title="{lang('edit')}" type='submit'  id='edit' name='edit' value="edit" class="btn btn-primary tooltips"><i class="fa fa-edit"></i></button>

                                                {form_close()}
                                            </div>                                   
                                            <div class="col-sm-3" style="margin-left: 20px;">
                                                {form_open('admin/member/delete_invite_text', 'method="post"')}
                                                    <input type='hidden' id='invite_text_id' name='invite_text_id' value='{$v.id}'>
                                                    
  <button title="{lang('delete')}" type='submit'  id='delete'  name='delete' value="delete" class="btn btn-bricky tooltips"><i class="fa fa-times fa fa-white "></i></button>
                                                {form_close()}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                               
                            {/foreach}
                        </tbody>
                    {else}
                        <tbody>
                            <tr><td colspan="8" align="center"><h4 align="center"> {lang('no_data')}</h4></td></tr>
                        </tbody>
                    {/if}
                </table>
            </div>
        </div>
    </div>
</div>

{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function() {
        Main.init();
        TableData.init();
        validate_invite_config.init();
    });
</script>

{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}  