{include file="user/layout/themes/{$USER_THEME_FOLDER}/header.tpl" name=""}



<div id="span_js_messages" style="display:none;">
    <span id="row_msg">{lang('rows')}</span>
    <span id="show_msg">{lang('shows')}</span>
</div>

<style>
    #popuprel table td b{ padding:0px }
    #popuprel table td{ vertical-align:middle }
</style>
<div class="popupbox" id="popuprel" >
    <div id="intabdiv">
        <div  style="padding:0px;">
            <table cellpadding="0" cellspacing="0" align="center">
                <tr>
                    <td  align="right">
                        <img src="{$PUBLIC_URL}images/1335609041_special-offer.png" border="0" />
                    </td >
                    <td  align="left">
                        <h2>{lang('lead_details')}</h2>
                    </td>
                </tr>
            </table>
            <div  id="text_message" class="box12 alignleft">


            </div> 


        </div>
    </div>
</div>
<div id="fade"></div>
<div id="trigger"></div>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>
                {lang('lead')}
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
                <div class="form-group">
                    {lang('your_lead_capture_link')}:
                    <a href="{$lead_url}LCP/home?prefix={$prefix}&id={$id}" target="_blank">
                        {$lead_url}LCP/home?prefix={$prefix}&id={$id}
                    </a></div>


                <table class="table table-striped table-bordered table-hover table-full-width" id="">
                    <thead>
                        <tr class="th" align="center">
                            <th >{lang('sl_no')}</th>
                            <th >{lang('name')}</th>
                            <th >{lang('sponser_name')}</th>
                            <th >{lang('email')}</th>
                            <th >{lang('phone')}</th>
                            <th >{lang('date')}</th>
                            <th >{lang('status')}</th>
                            <th >{lang('edit')}</th>
                        </tr>
                    </thead>
                    {if count($details)>0}
                        <tbody>                       
                            {assign var="i" value=0}                   
                            {foreach from=$details item=v}                        

                                {if $i%2 == 0}
                                    {$tr_class="tr1"}	 
                                {else}
                                    {$tr_class="tr2"}
                                {/if}
                                {$i=$i+1}
                                <tr class="{$tr_class}" align="center" >
                                    <td>{counter}</td>
                                    <td>{$v.name}</td>
                                    <td>{$v.sponser_name}</td>
                                    <td>{$v.email}</td>
                                    <td>{$v.phone}</td>
                                    <td>{$v.date}</td>
                                    <td>{$v.status}</td>
                                    <td> 
                                        <a href ="javascript:getleadetails({$v.id},'{$BASE_URL}user')" rel='popuprel' class='popup' style='color:#C48189;'><input type='button' value='View' id='Update' name='update' class="btn btn-bricky"></a></td></tr>

                            {/foreach}   
                        </tbody>
                    {else}
                        <tbody><tr><td align="center" colspan="8"><b>{lang('no_lead')}</b></td></tr></tbody>

                    {/if}                    
                </table>




            </div>
        </div>
    </div>
</div>

{include file="user/layout/themes/{$USER_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}

<script>
    jQuery(document).ready(function() {
        Main.init();
        TableData.init();
    });
</script>
</script>{*{include file="user/layout/themes/{$USER_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}*}