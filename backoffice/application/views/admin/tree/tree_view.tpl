<link rel="stylesheet" href="{$PUBLIC_URL}css/tree/styles-tree.css"/>
<link rel="stylesheet" href="{$PUBLIC_URL}css/tree/custom-tree.css"/>
<link href="{$PUBLIC_URL}css/tree/prettify-tree.css" type="text/css" rel="stylesheet" />
<script src="{$PUBLIC_URL}javascript/tree/jquery.tree.js"></script>

<script>
    jQuery(document).ready(function() {
        $("#tree_view").jOrgChart({
            chartElement: '#tree',
            dragAndDrop: false
        });
    });
</script>

<link href="{$PUBLIC_URL}css/tree/style_tooltip.css" rel="stylesheet" type="text/css" />
<script type = "text/javascript" src = "{$PUBLIC_URL}javascript/tree/easyTooltip.js"></script>
<script src="{$PUBLIC_URL}javascript/tree/jquery.scroll.tree.js"></script>

<script type="text/javascript">
    $(document).ready(function()
    {
    {foreach from= $tooltip_array item=v}
        {assign var="user_id" value=$v.user_id}
        $("img#userlink{$user_id}").easyTooltip(
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
            <b>{lang('name')}:</b> {$v.full_name}<br/>
            <b>{lang('joining')}:</b>{$v.date_of_joining}<br/>

            {if $MLM_PLAN == "Binary"}
                <br/><b>{lang('left')}:</b>{$v.left}
                <br/><b>{lang('right')}:</b>{$v.right}
                <br/><b>{lang('left_carry')}:</b>{$v.left_carry}
                <br/><b>{lang('right_carry')}:</b>{$v.right_carry}
            {/if}
            {*{if $MODULE_STATUS['rank_status'] == 'yes'}
                <br/><b>{lang('rank')}:</b>{$v.user_rank}
            {/if}*}
        </div>
    {/foreach}
</div>

{$display_tree}

<div id="tree" class="orgChart"></div>