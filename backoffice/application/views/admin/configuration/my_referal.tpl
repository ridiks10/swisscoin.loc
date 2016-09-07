{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}
<div id="span_js_messages" style="display: none;">
    <span id="errmsg1">{lang('you_must_enter_user_name')}</span>
    <span id="row_msg">{lang('rows')}</span>
    <span id="show_msg">{lang('shows')}</span>
</div>
<div id="page_path" style="display:none;">{$PATH_TO_ROOT_DOMAIN}admin/</div>
{if !isset($smarty.post.referral_view)}
    <div class="row" >
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-external-link-square"></i>{lang('users_referal_details')} 
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
                    {form_open('', 'role="form" class="smart-wizard form-horizontal" name="admin_referal_form" id="admin_referal_form" method="post"')}
                        <div class="col-md-12">
                            <div class="errorHandler alert alert-danger no-display">
                                <i class="fa fa-times-sign"></i> {lang('errors_check')}.
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="user_name">{lang('user_name')}<font color="#ff0000">*</font> </label>
                            <div class="col-sm-3">
                                <input type="text" name="user_name" id="user_name" autocomplete="Off" tabindex="1" />
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-2 col-sm-offset-2">                         

                                <button class="btn btn-bricky" type="submit" name="referal_details"  id="referal_details" value="{lang('view_refferal_details')}"  tabindex="4">{lang('view_refferal_details')}</button>
                            </div>
                        </div>
                        <input type="hidden" id="path_temp" name="path_temp" value="{$PUBLIC_URL}">
                    {form_close()}
                </div>
            </div>
        </div>
    </div>
{/if}
{if isset($smarty.post) && $is_valid_username}
    <div id="user_account"></div>
    <div id="username_val" style="display:none;">{$user_name}</div>
{/if}
{if $count>0}
    {if $view!='yes'}
        <div class="row">
            <div class="col-sm-12">
                <div id="referal_det">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-external-link-square"></i> {lang('referal_details')} : {$user_name}
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
                                        <th>{lang('user_name')}</th>
                                        <th>{lang('full_name')}</th>
                                        <th>{lang('joinig_date')}</th>
                                        <th>{lang('email')}</th>
                                        <th>{lang('country')}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {assign var="i" value="0"}
                                    {assign var="class" value=""}
                                    {foreach from=$arr item=v}
                                        <tr>  {$i=$i+1}
                                            <td>{$i}</td>
                                            <td>{$v.user_name}</td>
                                            <td>{$v.name}</td>
                                            <td>{$v.join_date}</td>
                                            <td> {$v.email}</td>
                                            <td>{$v.country}</td>
                                        </tr>
                                        
                                    {/foreach}
                                </tbody>
                            </table>
                            {$result_per_page}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    {/if}
{elseif isset($smarty.post.user_name) || isset($smarty.post.referral_view)} 
    <div class="row">
        <div class="col-sm-12">
            <div id="referal_det">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-external-link-square"></i> {lang('referal_details')}
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
                        <table border="0" align="center" width="100%" class="table table-striped table-bordered table-hover table-full-width" id="sample_1" >
                            {if !$is_valid_username}
                                <tbody>
                                    <tr colspan="3"> <td><h3>{lang('Username_not_Exists')}</h3></td> </tr>
                                </tbody>
                            {else}   
                                <tbody>
                                    <tr colspan="3"><td><h3><center>{lang('no_referels')}</center></h3></td></tr>
                                </tbody>
                            {/if}
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
{/if}
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
{if $count>0}
    <script>
        jQuery(document).ready(function() {
            //document.getElementById('referal_det').style.display = 'none';
            Main.init();
            TableData.init();
        });
    </script>
{else}
    <script>
        jQuery(document).ready(function() {
            Main.init();

        });
    </script>
{/if}
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}