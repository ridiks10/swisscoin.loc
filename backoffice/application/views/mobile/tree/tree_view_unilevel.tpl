
<style type="text/css">   
    {foreach from= $user_details item=v}
        {assign var="id" value=$v.id}
        #user{$id}{literal}{display:none;}{/literal}
    {/foreach}
</style>


<script type="text/javascript">

    $(document).ready(function()
    {
    {foreach from= $user_details item=arr_val}
        {assign var="user_id" value=$arr_val.id}
        $("a#userlink{$user_id}").easyTooltip(
                {literal} {{/literal}
                    useElement: "user{$user_id}"
        {literal}}{/literal})
    {/foreach}
})
</script>

<title>{$tran_tree_view}</title>

<div id="content" >
    {$tooltip} 
    <div>
        <input type="hidden" id="user_details" name="user_details" value="<?php echo $user_details;?>">
        <!--style="position:absolute; left:10px; font-size: 12px;" -->
        <table width ="100%" border="0">
            <tr valign="top">
                
            <img src='{$PUBLIC_URL}images/active.gif' style="border:hidden" title="Paid" align="absmiddle" width="40px" height="40px"/><b>{$tran_paid}</b>&nbsp;&nbsp;&nbsp;
            <img src='{$PUBLIC_URL}images/inactive.png' style="border:hidden" title="Not Paid" align="absmiddle" width="40px" height="40px"/><b>{$tran_inactive}</b>&nbsp;&nbsp;&nbsp;
            <img src="{$PUBLIC_URL}images/add.png" style="border:hidden" title="New One" align="absmiddle" width="24px" height="24px"/>&nbsp;<b>{$tran_vacant}</b>&nbsp; <font color="#000000"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong></font>&nbsp;&nbsp;
            
            </td>
            <td align="right">
                {form_open('', 'method="post" onSubmit= "return validate_go(this);"')}
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" value="" name="go_id" id="go_id">
                    <button class="btn btn-bricky" name="go_submit" id="go_submit" value="{$tran_find_id}">{$tran_find_id}</button>
                {form_close()}
            </td>
            </tr>
            <table>
                </div>

                {$display_tree}

                </div>
