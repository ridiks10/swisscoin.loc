{include file="super_admin/layout/header.tpl" name=""}

<div id="span_js_messages" style="display: none;"> 
    <span id="row_msg">{lang('rows')}</span>
    <span id="show_msg">{lang('shows')}</span>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>
                Delete Software
            </div>
            <div class="panel-body">
                {form_open('', 'name="update_super_admin" id="update_super_admin" class="smart-wizard form-horizontal" method="post"')}

                    <div class="col-md-12">
                        <div class="errorHandler alert alert-danger no-display">
                            <i class="fa fa-times-sign"></i> {lang('errors_check')}
                        </div>
                    </div>


                    <div class="form-group" >
                        <div class="col-sm-9" >
                            <label class="col-sm-2 control-label" for="delete_reason" style="width: 194px;">
                                Reason For Deletion:<span class="symbol required"></span>
                            </label>


                        </div>
                    </div>

                    <div class="form-group">

                        <div class="col-sm-9" style="width: 258px; margin-top: 2px; margin-right: -38px; margin-left: 228px;">
                            <textarea id="delete_reason"  name="delete_reason" class="tinymce form-control"  tabindex="3"  rows='10' >
                                    
                            </textarea>{form_error('delete_reason')}


                        </div>

                    </div>

                    <div class="form-group">
                        <div class="col-sm-2 col-sm-offset-2">
                            <button class="btn btn-bricky" tabindex="5"   type="submit"  value="Delete Software" name="delete_software" id="delete_software" style="width: 162px; margin-left: 66px;">Delete Software</button>                                
                        </div>
                    </div>
                {form_close()}
            </div>
        </div>
    </div>
</div>

{include file="super_admin/layout/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function () {
        Main.init();


    });
</script>

{include file="super_admin/layout/page_footer.tpl" title="Example Smarty Page" name=""}  