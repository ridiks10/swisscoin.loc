{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl" name=""}



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
                        <img src="{$BASE_URL}images/1335609041_special-offer.png" border="0" />
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
                <i class="fa fa-external-link-square"></i>{lang('search_leads')}
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
                        <label class="col-sm-2 control-label" for="keyword">{lang('keyword')}</label>
                        <div class="col-sm-3">
                            <input placeholder="{lang('name_email_phone')}"type="text" name="keyword" id="keyword" size="50"  autocomplete="Off" tabindex="1">
                            <br>
                            <span id="username_box" style="display:none;"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2 col-sm-offset-2">

                            <input type="hidden" name="base_url" id="base_url" value="{$BASE_URL}admin/">

                            <button class="btn btn-bricky"  type="submit" name="search_lead" id="search_lead" value="{lang('search_leads')}" tabindex="2" > {lang('search_leads')}</button>
                        </div>
                    </div>
                    <input type="hidden" id="path_temp" name="path_temp" value="{$PUBLIC_URL}">
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
                <div>
                    {lang('your_lead_capture_link')}:
                    <a href="{$lead_url}LCP/home?prefix={$prefix}&id={$id}" target="_blank">
                        {$lead_url}LCP/home?prefix={$prefix}&id={$id}
                    </a>
                </div>



                <table class="table table-striped table-bordered table-hover table-full-width" id="">
                    <thead>
                        <tr class="th" align="center">
                            <th >{lang('no')}</th>
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
                                    <td>{$i}</td>
                                    <td>{$v.name}</td>
                                    <td>{$v.sponser_name}</td>
                                    <td>{$v.email}</td>
                                    <td>{$v.phone}</td>
                                    <td>{$v.date}</td>
                                    <td>{$v.status}</td>
                                    <td> 
                                        <a href ="javascript:getleadetails({$v.id},'{$BASE_URL}admin')" rel='popuprel' class='popup' style='color:#C48189;'><button type='button'  id='Update' name='update' class="btn btn-bricky">{lang('view')}</button></td></tr>

                            {/foreach}   
                        </tbody>
                    {else}
                        <tbody>
                            <tr><td colspan="8" align="center"><h4 align="center"> {lang('no_lead')}</h4></td></tr>
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


    });
</script>
{*{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}*}