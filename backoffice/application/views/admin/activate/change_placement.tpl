{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}
<div id="span_js_messages" style="display:none;">
    <span id="error_msg1">{lang('you_must_enter_user_name')}</span>
    <span id="error_msg2">{lang('you_must_enter_placement_name')}</span>
    <span id="error_msg3">{lang('you_must_select_a_position')}</span>

</div>	

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>{lang('change_placement')}
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
                {form_open('', 'role="form" class="smart-wizard form-horizontal" name="change_placement" id="change_placement" method="post" onSubmit="return validate_username()"')}
                    <input type="hidden" id="path_temp" name="path_temp" value="{$PUBLIC_URL}"/>
                    <input type="hidden" id="path_root" name="path_root" value="{$PATH_TO_ROOT_DOMAIN}"/>

                    <div class="col-md-12">
                        <div class="errorHandler alert alert-danger no-display">
                            <i class="fa fa-times-sign"></i> {lang('errors_check')}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="user_name">{lang('select_user_id')}<span class="symbol required"></span></label>
                        <div class="col-sm-3">
                            <input class="form-control" type="text" id="user_name" name="user_name" autocomplete="Off" tabindex="1" >
                            <span id="error_box" style="display:none;"></span>

                            {form_error('user_name')}
                        </div>


                        <div class="col-sm-2 col-sm-offset-0">

                            <button class="btn btn-bricky" type="button" id="check_position" value="check_position" name="check_position" tabindex="2" onclick="getPosition();">
                              {lang('validate')}
                            </button>
                        </div>


                    </div>

                    <div class="form-group">
                        <div id="sponsor_name_div"> </div>
                    </div> 
                    <div id="palcement_div" style="display: none">


                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="new_user_name">{lang('select_new_placement')}<span class="symbol required"></span></label>
                            <div class="col-sm-3">
                                <input class="form-control" type="text" id="new_user_name" name="new_user_name" autocomplete="Off" tabindex="1" >

                                {form_error('new_user_name')}
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="status_id">{lang('change_position')}:<font color="#ff0000">*</font>
                            </label> 
                            <div class="col-sm-3">
                                <select name="placement" id="placement" tabindex="4"  class="form-control">

                                     <option value=''>{lang('select_position')}</option>
                                    <option value='R'>{lang('right')}</option>
                                    <option value='L'>{lang('left')}</option>

                                </select>{form_error('placement')}                            
                            </div>
                        </div>  
                        <div class="form-group">
                            <div class="col-sm-2 col-sm-offset-2">

                                <button class="btn btn-bricky" type="submit" id="change_placement" value="change_placement" name="change_sponsor" tabindex="2">
                                    {lang('change_placement')}
                                </button>
                            </div>
                        </div>
                    </div>


                    <input type="hidden" name="path" id="path" value="{$PATH_TO_ROOT_DOMAIN}admin" >
                {form_close()}
            </div>
        </div>
    </div>
</div>
<!-- end: PAGE CONTENT -->
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function () {
        Main.init();
        ValidateChangePlacement.init();
    });
</script>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}
