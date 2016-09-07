{include file="user/layout/themes/{$USER_THEME_FOLDER}/header.tpl"  name=""}

<div id="span_js_messages" style="display:none;">
    <span id="row_msg">{lang('rows')}</span>
    <span id="show_msg">{lang('shows')}</span>
    <span id="validate_msg1">{lang('enter_to_mail_id')}</span>
    <span id="validate_msg2">{lang('enter_subject')}</span>
    <span id="validate_msg3">{lang('enter_message')}</span>
    <input type = "hidden" name = "logo" id = "logo" value = "{$PUBLIC_URL}images/logos/{$site_info["logo"]}" >
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="tabbable">
            <ul id="myTab3" class="nav nav-tabs tab-green">
                <li class="{$tab1}">
                    <a href="#panel_tab1_example1" data-toggle="tab">
                        <i class="pink fa fa-dashboard"></i>{lang('email_invites')}
                    </a>
                </li>
                <li class="{$tab2}">
                    <a href="#panel_tab1_example2" data-toggle="tab">
                        <i class="blue fa fa-user"></i>{lang('email_invite_history')}
                    </a>
                </li>
                <li class="{$tab3}">
                    <a href="#panel_tab1_example3" data-toggle="tab">
                        <i class="blue fa fa-user"></i>{lang('others')}
                    </a>
                </li>
                <li class="{$tab4}">
                    <a href="#panel_tab1_example4" data-toggle="tab">
                        <i class="blue fa fa-user"></i>{lang('banner')}
                    </a>
                </li>
                <li class="{$tab5}">
                    <a href="#panel_tab1_example5" data-toggle="tab">
                        <i class="blue fa fa-user"></i> {lang('text_invite')}
                    </a>
                </li>

            </ul>
            <div class="tab-content">
                <div class="tab-pane {$tab1}" id="panel_tab1_example1">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <i class="fa fa-external-link-square"></i>
                                    {lang('invites')}
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
                                    {form_open('', 'name="invite" id="invite" class="smart-wizard form-horizontal" method="post"')}
                                    <div class="col-md-12">
                                        <div class="errorHandler alert alert-danger no-display">
                                            <i class="fa fa-times-sign"></i> {lang('errors_check')}
                                        </div>
                                    </div>
                                    <div class="form-group"> 
                                        <label class="col-sm-2 control-label" >{lang('to')}:<span class="symbol required"></span></label>
                                        <div class="col-sm-6">
                                            <textarea class="form-control" name='to_mail_id' id='to_mail_id'   tabindex="1"></textarea>{form_error('to_mail_id')}
                                        </div>
                                    </div>
                                    <div class="form-group"> 
                                        <label class="col-sm-2 control-label" >{lang('subject')} :<span class="symbol required"></span></label>
                                        <div class="col-sm-6">
                                            <input class="form-control"  type="text"  name ="subject" id ="subject" value="{$social_invite_email['subject']}" autocomplete="Off" tabindex="2">{form_error('subject')}
                                        </div>
                                    </div>
                                    <div class="form-group"> 
                                        <label class="col-sm-2 control-label" >{lang('message')}:<span class="symbol required"></span></label>
                                        <div class="col-sm-9">
                                            <textarea class="ckeditor form-control" name='message' id='message' tabindex="3">{$social_invite_email['content']}</textarea>{form_error('message')}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-2 col-sm-offset-2">
                                            <button class="btn btn-bricky" tabindex="5"   type="submit"  value="invite" name="invite" id="invite" >{lang('invite')}</button>           
                                        </div>
                                    </div>
                                    {form_close()}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane {$tab2}" id="panel_tab1_example2">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <i class="fa fa-external-link-square"></i>
                                    {lang('email_invite_history')}
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
                                            <tr class="th" align="center">
                                                <th >{lang('sl_no')}</th>
                                                <th >{lang('email')}</th>
                                                <th >{lang('subject')}</th>
                                                <th >{lang('message')}</th>
                                                <th >{lang('date')}</th>

                                            </tr>
                                        </thead>
                                        {if count($invite_history_details)>0}
                                            <tbody>                       
                                                {assign var="i" value=0}                   
                                                {foreach from=$invite_history_details item=v}                        

                                                    {if $i%2 == 0}
                                                        {$tr_class="tr1"}	 
                                                    {else}
                                                        {$tr_class="tr2"}
                                                    {/if}
                                                    {$i=$i+1}
                                                    <tr class="{$tr_class}" align="center" >
                                                        <td>{counter}</td>
                                                        <td>{$v.mail_id}</td>
                                                        <td>{$v.subject}</td>
                                                        <td>{$v.message}</td>
                                                        <td>{$v.date}</td>
                                                    {/foreach}   
                                            </tbody>
                                        {else}
                                            <tbody><tr><td align="center" colspan="8"><b>{lang('no_invites_send')}</b></td></tr></tbody>
                                                        {/if}   
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane {$tab3}" id="panel_tab1_example3">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <i class="fa fa-external-link-square"></i>
                                    {lang('others')}
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
                                    <script src="{$PUBLIC_URL}javascript/all.js" type="text/javascript" ></script>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="col-md-6 col-md-offset-3 control-label lable-grey"> </label>
                                            <br/>
                                            <div class="row">
                                                <div class="col-md-12 center">
                                                    <iframe src="{$base_url}social_invites/facebook/{$social_invite_fb['id']}" style = "width:80%; height:300px;"></iframe>
                                                </div>
                                            </div>
                                            <div class ="row">                                                            
                                                <div class="form-group col-sm-12 center">   
                                                    <button class=""  tabindex="3" onclick="share('{$social_invite_fb['subject']}', '{$social_invite_fb['id']}')">
                                                        <img src="{$PUBLIC_URL}images/facebook.png" alt="Facebook" >
                                                    </button>   

                                                </div>
                                            </div>           
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane {$tab4}" id="panel_tab1_example4">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <i class="fa fa-external-link-square"></i>
                                    {lang('banner')}
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
                                                <th>{lang('sl_no')}</th> 
                                                <th>{lang('banner')}</th>  
                                                <th>URL</th>
                                            </tr>
                                        </thead>
                                        {if count($banners)>0}
                                            <tbody>
                                                {assign var="i" value="0"}
                                                {assign var="class" value=""}
                                                {foreach from=$banners item=v}
                                                    <tr>                                   
                                                        <td>{counter}</td>
                                                        <td><img src="{$PUBLIC_URL}images/banners/{$v.content}" height="150" width="250"></td>
                                                        <td>
                                                            <div class="form-group"> 
                                                                <div class="">
                                                                    <textarea height="500" width="500"   tabindex="3" style="margin: 0px; width: 472px; height: 113px;"> <a href="{$base_url}">  <img src="{$PUBLIC_URL}images/banners/{$v.content}" height="150" width="250">
</a>          </textarea>                  </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    {$i=$i+1}
                                                {/foreach}
                                            </tbody>
                                        {else}
                                            <tbody><tr><td align="center" colspan="8"><b>{lang('no_banners')}</b></td></tr></tbody>
                                                        {/if}
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane {$tab5}" id="panel_tab1_example5">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <i class="fa fa-external-link-square"></i>
                                    {lang('text_invite')}
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
                                    {assign var="i" value="0"}
                                    {assign var="class" value=""}
                                    {if count($invite_text)>0}
                                        {foreach from=$invite_text item=v}
                                            <div class="row">

                                                <div class="form-group"> 
                                                    <div class="col-sm-9">
                                                        <label class="col-sm-2 control-label" >{$v.subject} </label>
                                                    </div>

                                                </div>
                                                <div class="form-group">

                                                    <div class="col-sm-9">
                                                        <textarea id="mail_content"  name="mail_content"   class=" form-control"  tabindex="3"  rows='10' >

<a href="{$base_url}" > {$v.content} </a>
                                
                                                        </textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <br>
                                            {$i=$i+1}
                                        {/foreach}
                                    {else}
                                        {lang('no_data')}
                                    {/if}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{include file="user/layout/themes/{$USER_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>


    jQuery(document).ready(function() {
        Main.init();
        TableData.init();
        validate_invite.init()

    });
</script>
{include file="user/layout/themes/{$USER_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}  
