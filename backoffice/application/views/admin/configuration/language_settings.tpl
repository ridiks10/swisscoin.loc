{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>
                {lang('set_language_status')}
            </div>
            <div class="panel-body">
                <div class="col-md-12">
                    <div class="errorHandler alert alert-danger no-display">
                        <i class="fa fa-times-sign"></i> {lang('errors_check')}
                    </div>
                </div>

                {form_open('', 'name="language_settings_form" id="module_status_form" method="post"')}

                    <table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
                        <thead>
                            <tr class="th" align="center">
                                <th>{lang('no')}</th>
                                <th>{lang('language')}</th>
                                <th>{lang('action')}</th>
                                <th>{lang('default_language')}</th>
                            </tr>
                        </thead>
                        <tbody>{assign var="i" value="0"}
                            {foreach from=$language_array item=v}{$i=$i+1}
                                <tr>
                                    <td>{$i}</td> 
                                    <td>
                                        <img src="{$PUBLIC_URL}images/flags/{$v.lang_code}.png" /> 
                                        {$v.lang_name}
                                    </td>
                                    <td>
                                        <div class="make-switch" data-on="success" data-off="warning">
                                            <input type="checkbox" name="module_status" id="set_eng_status"  value="yes" {if $v.status=="no"} onChange="change_language_status('{$v.lang_id}', 'yes')" {else} checked onChange="change_language_status('{$v.lang_id}', 'no')"{/if}>
                                        </div>
                                        <span id="{$v.lang_id}_status_message"></span>
                                    </td>
                                    <td>
                                        <div class="visible-md visible-lg hidden-sm hidden-xs">
                                            <!--Default Language start-->  
                                            {if $v.status=="yes"}
                                                {if $v.default_id}
                                                    <a href="javascript:void();" class="btn btn-green tooltips" data-placement="top" data-original-title="Default">
                                                        <i class="glyphicon glyphicon-ok-sign"></i>
                                                    </a>
                                                {else}
                                                    <a href="javascript:set_default_language({$v.lang_id})" class="btn btn-green tooltips" data-placement="top" data-original-title="Set {$v.lang_name} as default">
                                                        <i class="glyphicon glyphicon-remove-circle"></i>
                                                    </a>
                                                    <span id="{$v.lang_id}_message"></span>
                                                {/if}
                                            {else}
                                                <a href="javascript:void();" class="btn btn-yellow tooltips" data-placement="top" data-original-title="Not Available" style="cursor: default;" >
                                                    <i class="glyphicon glyphicon-remove-circle"></i>
                                                </a>
                                            {/if}                                            
                                        </div>
                                    </td>
                                </tr> 
                            {/foreach}
                        </tbody>     
                    </table>
                {form_close()}
            </div>
        </div>
    </div>
</div>

{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function() {
        Main.init();
    });
</script>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}  
