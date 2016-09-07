{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}
<div id="span_js_messages" style="display:none;">
    <span id="error_msg1">{lang('you_must_enter_mlm_plan_details')}</span>
    <span id="error_msg2">{lang('you_must_enter_reference_url')}</span>
    <span id="error_msg3">{lang('you_must_select_mlm_documents')}</span>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>
                {lang('upgrade_infinite_mlm')}
                <div class="panel-tools">                    
                    <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                    </a>
                    <a class="btn btn-xs btn-link panel-refresh" href="#">
                        <i class="fa fa-refresh"></i>
                    </a>
                    <a class="btn btn-xs btn-link panel-expand" href="#">
                        <i class="fa fa-resize-full"></i>
                    </a>
                    {*<a class="btn btn-xs btn-link panel-close" href="#">
                        <i class="fa fa-times"></i>
                    </a>*}
                </div>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    {form_open_multipart('', 'class="niceform" method="post" id="update_form" name="update_form" onsubmit="return validate_requirements(this);"')}
                        <div class="col-md-12">
                            <div class="errorHandler alert alert-danger no-display">
                                <i class="fa fa-times-sign"></i> {lang('errors_check')}
                            </div>
                        </div>
                        <table    cellspacing="10" cellpadding="3" width="100%" >
                            <div class="form-group">
                                <tr>
                                    <td width="300" valign="top">{lang('mlm_plan_details')} :<span class="symbol required"></span></td>
                                    <td><div class="col-sm-6">
                                            <textarea class="form-control" name="mlm_details" id="mlm_details" title="{lang('mlm_plan_details')}"></textarea><span id="errmsg1"> {form_error('mlm_details')}</span>
                                        </div>
                                    </td>
                                </tr>
                            </div>
                            <tr>
                                <td>{lang('do_you_need_shopping_cart_ecommerce')}</td>
                                <td ><div class="col-sm-6">
                                        <input name="shopping_status" type="radio" id="shopping_st1" value="yes"  /><label for="shopping_st1"></label>{lang('yes')} 
					<input name="shopping_status" type="radio" id="shopping_st2" value="no" checked /><label for="shopping_st2"></label>{lang('no')}  
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>{lang('do_you_need_repurchase_monthly_subscribe')}</span></td>
                                <td><div class="col-sm-6">
                                        <input name="repurchase_status" type="radio" id="repurchase_st1" value="yes"/><label for="repurchase_st1"></label>{lang('yes')} 
					<input name="repurchase_status" type="radio" id="repurchase_st2" value="no" checked /> 
                                        <label for="repurchase_st2"></label>{lang('no')}   
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>{lang('do_you_need_website_replication')}</td>
                                <td><div class="col-sm-6">
                                        <input name="replication_status" type="radio" id="replication_st1" value="yes"  /> <label for="replication_st1"></label>{lang('yes')} 
					<input name="replication_status" type="radio" id="replication_st2" value="no" checked /><label for="replication_st2"></label>{lang('no')}  
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>{lang('reference_url')} :<span class="symbol required"></span></td>
                                <td><div class="col-sm-6">
                                        <input name="reference" id="reference" type="text"  />{form_error('reference')}<span id="errmsg2"></span>
                                    </div>

                                </td>
                            </tr>
			    <tr><td></td>
				<td>
				    <div class="col-sm-6" style="color: red;" id="example" name="example" value=" Example: https://www.referenceurl.com/name">
					{lang('example')}: https://www.referenceurl.com  
				    </div>
				</td>
			    </tr>
                            <tr>
                                <td>{lang('mlm_plan_documents')} :</td>
                                <td>
				    <div class="col-sm-6">
					<div data-provides="fileupload" class="fileupload fileupload-new">
					    <span class="btn btn-file btn-light-grey"><i class="fa fa-folder-open-o"></i> <span class="fileupload-new">{lang('select_file')}</span><span class="fileupload-exists">{lang('change')}</span>
						<input  name="document" id="document" type="file" >
					    </span>{form_error('document')}
					    <span class="fileupload-preview"></span>
					    <a style="float: none" data-dismiss="fileupload" class="close fileupload-exists" href="#">
						&times;
					    </a>
					    <span id="errmsg3">
					</div>
					<p class="help-block">

					</p>
				    </div>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td ><div class="col-sm-6">
                                        <button class="btn btn-bricky" type="submit" id="update" value="{lang('update')}" name="update" tabindex="2">{lang('update')}</button>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    {form_close()}
                </div>
            </div>

        </div>
    </div>
</div>   
<!-------UPTO HERE---------->

{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}

<script>
    jQuery(document).ready(function() {
	Main.init();
	ValidateUser.init();
    });
</script>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}