<!-- /////////////////////  CODE EDITED BY JIJI  ////////////////////////// -->

{include file="user/layout/themes/{$USER_THEME_FOLDER}/header.tpl"  name=""}


<div id="span_js_messages" style="display: none;">
    <span id="errmsg">{lang('You_must_enter_keyword_to_search')}</span>
</div>

<innerdashes>
    <hdash>
        <img src="{$PUBLIC_URL}images/1335679062_customers.png" alt="" align="absmiddle" />
        &nbsp;&nbsp;&nbsp;&nbsp;{lang('search_member')}
		{if $HELP_STATUS}
			<a href="https://infinitemlmsoftware.com/help/" target="_blank"><buttons><img src="{$PUBLIC_URL}images/1359639504_help.png" /></buttons></a>
		{/if}
    </hdash>

    <cdash-inner>             
        {form_open('', 'class="niceform"  method="post"  name="search_mem" id="search_mem" onSubmit="return validate_search_member(this);"')}
            <table width="100%" border=0>
                <tr align='left' >
                    <td>&nbsp;&nbsp;<b>{lang('keyword')}</b></td>
                    <td>&nbsp;&nbsp;<input type="text" name="keyword" id="keyword" size="50" tabindex="1" autocomplete="off">&nbsp;&nbsp;
                         {if $error_count}<br>{$error_array['keyword']}{/if}
                        <input type="submit" name="search_member" id="search_member" value="{lang('search_member')}" tabindex="2" ></td>
                    
                </tr>
               
                <tr align='left' >
                    <td><input type="hidden" name="base_url" id="base_url" value="{$BASE_URL}user/"></td>
                    <td>&nbsp;&nbsp;({lang('Username_Name_Nominee_Address_MobileNo_City')})</td>
                </tr>
               
            </table>
        {form_close()}
                <br/> <br/>
        {if $flag}
        {if $search_member!=""}

            <table   id='grid'>
               
                    <tr>
                        <th>{lang('no')}</th>
                        <th>{lang('user_name')}</th>
                        <th>{lang('name')}</th>
                        <th>{lang('sponser_name')}</th>
                        <th>{lang('mobile_no')}</th>
                        <th>{lang('nominee')}</th>
                        <th>{lang('address')}</th>
                        <!--<th>{*$tran_town}</th>
                        <th>{$tran_country*}</th>-->
                        <th>{lang('status')}</th>
                        <th>{lang('action')}</th>
                        <th>{lang('view_profile')}</th>
                    </tr>
                
                    {if count($mem_arr)!=0}
                        {assign var="i" value=0 }
                        {assign var="class" value="" }

                        {foreach from=$mem_arr item=v}
                            {if $i%2==0}
                                {$class='tr1'}
                            {else}
                                {$class='tr2'}
                            {/if}
                            {assign var="id" value="{$v.user_id}" }
                            {assign var="user_name" value="{$v.user_name}" }
                            {assign var="user_detail_name" value="{$v.user_detail_name}" }
                            {assign var="user_detail_address" value="{$v.user_detail_address}" }
                            {assign var="user_detail_mobile" value="{$v.user_detail_mobile}" }
                            {assign var="user_detail_town" value="{$v.user_detail_town}" }
                            {assign var="user_detail_nominee" value="{$v.user_detail_nominee}"}
                            {assign var="user_detail_country" value="{$v.user_detail_country}"}
                            {*assign var="sponser" value="{$v.sponser}" *}
                            {assign var="active" value="{$v.active}" }
                            {assign var="sponser_name" value="{$v.sponser_name}" }
                            {assign var="status" value="" }

                            {if $active=='yes'}
                                {$status="{lang('active')}"}

                                {$title="Block"}
                            {else}
                                {$status="{lang('blocked')}"}
                                {$title="Activate"}
                            {/if}

                            <tr>
                                <td>{$i}</td>
                                <td>{$user_name}</td>
                                <td>{$user_detail_name}</td>
                                <td>{$sponser_name}</td>
                                <td>{$user_detail_mobile}</td>
                                <td>{$user_detail_nominee}</td>
                                <td>{$user_detail_address}</td>
                                <!-- <td>{*$user_detail_town}</td>
                                <td>{$user_detail_nominee*}</td>-->
                                <td>{$status}</td>
                                <td><a href="javascript:block_user({$id},'{$active}')">
                                        <img src="{$PUBLIC_URL}images/edit.png" title="{$title}{$user_name}" style="border:none;"></a>
                                </td>
                                <td><a href="{$PATH_TO_ROOT_DOMAIN}user/profile/profile_view/{$user_name}">{lang('view')}</a></td>
                            </tr>
                            {$i=$i+1}
                        {/foreach}
                        <tr><td>{$result_per_page}</td></tr>
                    {else}
                        <tr><td colspan="8" align="center"><h4>{lang('No_User_Found')}</h4></td></tr>

                    {/if}
            </table>

        {/if}
        {/if}

    </cdash-inner>
</innerdashes>
{include file="user/layout/themes/{$USER_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function() {
        Main.init();
        TableData.init();
      ValidateMember.init();
    });
</script>
{include file="user/layout/themes/{$USER_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}