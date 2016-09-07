{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}

<div id="span_js_messages" style="display: none;">
    <span id="errmsg">{lang('You_must_enter_keyword_to_search')}</span>
    <span id="row_msg">{lang('rows')}</span>
    <span id="show_msg">{lang('shows')}</span>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>   {lang('search_member')}
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
                {form_open('','role="form" class="smart-wizard form-horizontal" method="post"  name="search_mem" id="search_mem"')}

                    <div class="col-md-12">
                        <div class="errorHandler alert alert-danger no-display">
                            <i class="fa fa-times-sign"></i> {lang('errors_check')}.
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="keyword">{lang('keyword')}: </label>
                        <div class="col-sm-3">
                            <input placeholder="{lang('Username_Name_Address_MobileNo')}.."type="text" name="keyword" id="keyword" size="50"  autocomplete="Off" tabindex="1">
                            <br>{if $error_count}{$error_array['keyword']}{/if}
                            <span id="username_box" style="display:none;"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2 col-sm-offset-2">

                            <input type="hidden" name="base_url" id="base_url" value="{$BASE_URL}admin/">

                            <button class="btn btn-bricky"  type="submit" name="search_member" id="search_member" value="{lang('search_member')}" tabindex="2" > {lang('search_member')} </button>
                        </div>
                    </div>
                    <input type="hidden" id="path_temp" name="path_temp" value="{$PUBLIC_URL}">
                {form_close()}
            </div>
        </div>

    </div>

</div>    



{if $flag}       
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-external-link-square"></i>  {lang('member_details')} 
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
                        <br />


                        <table class="table table-striped table-bordered table-hover table-full-width" id=""> 
                            <thead>
                                <tr class="th">
                                    <th >{lang('no')}</th>
                                    <th >{lang('user_name')}</th>
                                    <th  >{lang('name')}</th>
                                    <th class="hidden-xs">{lang('sponser_name')}</th>
                                    <th >{lang('mobile_no')}</th>
                                        {*  <th class="hidden-xs" >{lang('nominee')}</th>*}
                                    <th class="hidden-xs" >{lang('address')}</th>                            
                                    <th  >{lang('status')}</th>
                                    <th  >{lang('view_profile')}</th>
                                </tr>
                            </thead>

                            {if count($mem_arr)>0}
                                {assign var="i" value=0}
                                {assign var="class" value=""}
                                <tbody>
                                    {foreach from=$mem_arr item=v}
                                        {if $i%2==0}
                                            {$class='tr1'}
                                        {else}
                                            {$class='tr2'}
                                        {/if}

                                        {assign var="id" value="{$v.user_id}"}
                                        {assign var="user_name" value="{$v.user_name}"}
                                        {assign var="user_detail_name" value="{$v.user_detail_name}"}
                                        {assign var="user_detail_address" value="{$v.user_detail_address}"}
                                        {assign var="user_detail_mobile" value="{$v.user_detail_mobile}"}
                                        {assign var="user_detail_town" value="{$v.user_detail_town}"}
                                        {assign var="user_detail_nominee" value="{$v.user_detail_nominee}"}
                                        {assign var="user_detail_country" value="{$v.user_detail_country}"}
                                        {assign var="encrypt_id" value="{$v.user_id_en}"}

                                        {assign var="active" value="{$v.active}"}
                                        {assign var="sponser_name" value="{$v.sponser_name}"}
                                        {assign var="status" value=""}

                                        {if $active=='yes'}
                                            {$status="{lang('active')}"}

                                            {$title="Block"}
                                        {else}
                                            {$status="{lang('blocked')}"}
                                            {$title="Activate"}
                                        {/if}

                                        <tr>    {$i=$i+1}  
                                            <td>{$i}</td>
                                            <td  >{$user_name}</td>
                                            <td  >{$user_detail_name}</td>
                                            <td class="hidden-xs" >{$sponser_name}</td>
                                            <td  >{$user_detail_mobile}</td>
                                            {*   <td class="hidden-xs" >{$user_detail_nominee}</td>*}
                                            <td class="hidden-xs" >{$user_detail_address}</td>                             
                                            <td >{$status}</td>
                                            <td><center> 
                                        <a href="{$PATH_TO_ROOT_DOMAIN}admin/profile/profile_view/{$encrypt_id}" class="btn btn-green">

                                            {* <img src="{$PATH_TO_ROOT_DOMAIN}public_html/images/view.png" width="30">*}
                                            <i class="glyphicon glyphicon-camera"></i> 
                                        </a>
                                    </center>
                                    </td>
                                    </tr>
                                    
                                {/foreach}
                                </tbody>
                            {else}
                                <tbody>
                                    <tr><td colspan="8" align="center"><h4 align="center"> {lang('No_User_Found')}</h4></td></tr>
                                </tbody>
                            {/if}
                        </table>
                        {$result_per_page}
                    </div>
                </div>
            </div>   
        </div>  
{/if}
   <!-- 
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-external-link-square"></i>  {lang('member_details')} 
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
                        <tbody>
                            <tr><td colspan="10" align="center"><h4>{lang('No_User_Found')}</h4></td></tr>
                        </tbody>    
                        </table>
                    </div>
                </div>
            </div>   
        </div>  
-->

{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""} 
<script>
    jQuery(document).ready(function() {
        Main.init();
        TableData.init();
        ValidateMember.init();
    });
</script>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}