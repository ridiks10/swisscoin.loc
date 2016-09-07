{include file="user/layout/themes/{$USER_THEME_FOLDER}/header.tpl" name=""}

<div class="row">

    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>{lang('ticket_management')}
                <div class="panel-tools">
                    <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                    </a>
                    <a class="btn btn-xs btn-link panel-refresh" href="#">
                        <i class="fa fa-refresh"></i>
                    </a>
                    <a class="btn btn-xs btn-link panel-expand" href="#">
                        <i class="fa fa-resize-full"></i>
                    </a>
                    <a class="btn btn-xs btn-link panel-close" href="#">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>
            <div class="panel-body">						
                <!-- start: INBOX DETAILS FORM -->
                {assign var=i value=1}
                {assign var=clr value=""}
                {assign var=id value=""}
                {assign var=msg_id value=""}
                {assign var=user_name value=""}

                <!-- /.modal -->
                <!-- end: INBOX DETAILS FORM --> 						                
                <div id="span_js_messages" style="display:none;">
                    <span id="error_msg1">{lang('you_must_select_user')}</span>        
                    <span id="error_msg2">{lang('you_must_enter_subject_here')}</span>
                    <span id="error_msg3">{lang('you_must_enter_message_here')}</span>        
                </div>
                <div class="tabbable ">
                    <ul id="myTab3" class="nav nav-tabs tab-green">
                        <li class="{$tab1}">
                            <a href="#panel_tab4_example1" data-toggle="tab">
                                <i class="fa fa-dashboard"></i>{lang('ticket')} 
                            </a>
                        </li>
                        <li class="{$tab2}">
                            <a href="#panel_tab4_example2" data-toggle="tab">
                                <i class="fa fa-ticket"></i> {lang('create_ticket')} 
                            </a>
                        </li>
                        <li class="{$tab3}">
                            <a href="#panel_tab4_example3" data-toggle="tab">
                                <i class="fa fa-file"></i> {lang('view_ticket')} 
                            </a>
                        </li>
                        <li class="{$tab4}">
                            <a href="#panel_tab4_example4" data-toggle="tab">
                                <i class="fa fa-file-o"></i> {lang('resolved')} {lang('ticket')} 
                            </a>
                        </li>
                        <li class="{$tab6}">
                            <a href="#panel_tab4_example6" data-toggle="tab">
                                <i class="fa fa-file-o"></i> {lang('searchs')}  {lang('ticket')} 
                            </a>
                        </li>
                        <li class="{$tab5}">
                            <a href="#panel_tab4_example5" data-toggle="tab">
                                <i class="fa fa-question-circle"></i> {lang('FAQ')} 
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane{$tab1}" id="panel_tab4_example1">
                            <p>
                                {include file="user/ticket_system/ticket_inbox.tpl"  name=""}
                            </p>
                        </div>
                        <div class="tab-pane{$tab2}" id="panel_tab4_example2">

                            <p>
                                {include file="user/ticket_system/create_ticket.tpl"  name=""}
                            </p>
                        </div>
                        <div class="tab-pane{$tab3}" id="panel_tab4_example3">

                            <p>
                                {include file="user/ticket_system/view_ticket.tpl"  name=""}
                            </p>
                        </div>
                        <div class="tab-pane{$tab4}" id="panel_tab4_example4">

                            <p>
                                {include file="user/ticket_system/resolved_ticket.tpl"  name=""}
                            </p>
                        </div>
                        <div class="tab-pane{$tab6}" id="panel_tab4_example6">

                            <p>
                                {include file="user/ticket_system/search_ticket.tpl"  name=""}
                            </p>
                        </div>
                        <div class="tab-pane{$tab5}" id="panel_tab4_example5">
                            <p>
                                {include file="user/ticket_system/ticket_faq.tpl"  name=""}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>                   
{include file="user/layout/themes/{$USER_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function () {
        Main.init();
        TableData.init();        
        ValidateTicket.init();
        ValidateCreateTicket.init();
    });
</script>

</script>
{include file="user/layout/themes/{$USER_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}