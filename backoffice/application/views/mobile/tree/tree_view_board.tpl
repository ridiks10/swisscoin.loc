<link href="{$PUBLIC_URL}css/style_tree.css" rel="stylesheet" type="text/css" />
<link href="{$PUBLIC_URL}css/style_board.css" rel="stylesheet" type="text/css" />
<script type = "text/javascript" src = "{$PUBLIC_URL}javascript/easyTooltip.js"></script>

{assign var="div_class" value=""}
{assign var="board_title" value="{$board_config['board_name']}"}

<style type="text/css">   
    {foreach from= $tooltip_array item=v}
        {assign var="id" value=$v.user_id}
        #user{$id}{literal}{display:none;}{/literal}
    {/foreach}
</style>

<script type="text/javascript">
    $(document).ready(function()
    {
    {foreach from= $tooltip_array item=v}
        {assign var="user_id" value=$v.user_id}
        $("a#userlink{$user_id}").easyTooltip(
                {literal} {{/literal}
                    useElement: "user{$user_id}"
        {literal}}{/literal})
    {/foreach}
            });
</script>

<div id="content" style="height:100%;margin: auto;width: 100%;">


    <div id="tooltip_div">
        {foreach from= $tooltip_array item=v}
            <div id= "user{$v.user_id}">
                <img width="100px" height="100px" src="{$PUBLIC_URL}images/profile_picture/{$v.user_photo}" alt="{$v.user_photo}" align="absmiddle" /></br>
                <b>{$v.user_name}</b></br>
                <b>{lang('name')}:</b>{$v.full_name}</br>
                <b>{lang('joining')}:</b>{$v.date_of_joining}<br/>
                <b>{lang('referral_count')}:</b>{$v.referral_count}<br/>
                {if $MODULE_STATUS['rank_status'] == 'yes'}
                    <br/><b>{lang('rank')}:</b>{$v.user_rank}
                {/if}
            </div>
        {/foreach}
    </div>

    <div class="bord-box">

        {assign var="board_depth" value=$user_board_details['board_depth']}
        {assign var="board_width" value=$user_board_details['board_width']}
        {assign var="board_users" value=$user_board_details['board_users']}
        {assign var="level" value=0}
        {assign var="i" value=1}

        {for $level={$board_depth} to 0 step -1  }
            <div class="bor-box" >

                {if $i <=3}
                    <h3 style="color: #38a036">Level {$i-1}</h3>
                {/if}

                {assign var="total_user" value=0}
                {assign var="free_count" value=0}
                {assign var="level_user" value=0}
                {assign var="level_user_count" value={count($board_users[$level])}}
                {$md_class="col-md-12"}
                {$margin_left="50"}
                {if $level_user_count==2}
                    {$md_class="col-md-6"}
                    {$margin_left="50"}
                {elseif $level_user_count==3}
                    {$md_class="col-md-4"}
                    {$margin_left="50"}
                {elseif $level_user_count==4}
                    {$md_class="col-md-3"}
                    {$margin_left="50"}
                {elseif $level_user_count==9}
                    {$md_class="col-md-1"}
                    {$margin_left="100"}
                {/if}
                {foreach from=$board_users[$level] item=v }
                    {$level_user=$level_user+1}

                    {if $v.user_name=="NA"}
                        {$div_class="level-{$i}-vacant"}
                        {$free_count = $free_count+1}
                    {else} 
                        {$div_class="level-{$i}"}
                        {$total_user = $total_user+1}
                    {/if}
                    {if $i <=3}
                        <a href="javascript:void(0);" id="userlink{$v.id}">
                            <div class="{$md_class}">                            
                                <div class="{$div_class}" style="margin-left: {$margin_left}%;"> 
                                    {$v.user_name}
                                </div>                        
                            </div> 
                        </a>
                        {if $i==3 && $board_width ==3 && $level_user%$board_width == 0}
                            <div class="col-md-1"></div>
                        {/if}
                    {/if}
                {/foreach}
                {if $i > 3}
                    <h3 style="color: #38a036">Level {$i-1}</h3>
                    {lang('total_users')} : {$total_user}
                    {if $free_count}
                        <br/>
                        {lang('free_positions')} : {$free_count}
                    {/if}
                {/if}
            </div>
            {$i = $i+1}
        {/for}                   
    </div>
</div>