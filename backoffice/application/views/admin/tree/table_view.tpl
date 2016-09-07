<link href="{$PUBLIC_URL}css/tree/style_board.css" rel="stylesheet" type="text/css" />
<link href="{$PUBLIC_URL}css/tree/style_tooltip.css" rel="stylesheet" type="text/css" />
<script type = "text/javascript" src = "{$PUBLIC_URL}javascript/tree/easyTooltip.js"></script>
<script type = "text/javascript" src = "{$PUBLIC_URL}javascript/tree/zoom.js"></script>

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

<div id="tooltip_div" style="display:none;">
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

{assign var="board_depth" value=$user_board_details['board_depth']}
{assign var="board_width" value=$user_board_details['board_width']}
{assign var="board_users" value=$user_board_details['board_users']}


<div class="tableview_container" id="tree_div" >
    {assign var="user_level" value={$board_depth}}
  
    {for $level= 0 to {$board_depth} step +1  }

        {assign var="colspan" value={pow($board_width,$level)}}
        {assign var="total_columns" value={pow($board_width,$user_level)}}
        {assign var="row_width" value={$total_columns * $colspan * 100}}

        <div class="row" style="margin:0px auto; width: {$row_width}px!important ;">
				{foreach from=$board_users[$level] item=v }
					{$class = "table_active"}
					{if {$v.user_name}=="NA"}
						{$class = "table_inactive"}
					{/if}

					<div  class="table-div" style="width: {$colspan*100}px !important ;">
						<a href="javascript:void(0);" id="userlink{$v.id}">   
							<div  class="{$class}"> 
								{$v.user_name}
							</div>   
						</a>
					</div>
				{/foreach} 
				<br clear="all" />
        </div>    
				{$user_level = $user_level-1}
    {/for}            
</div> 