{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>    {lang('referral_status')}
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
                {form_open('', 'role="form" class="smart-wizard form-horizontal" name="set_referal_status" id="set_referal_status" method="post"')}
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="refferal_status">{lang('referral_status')}</label>



                        <div class="col-sm-6">

                            <label class="radio-inline" for="status_yes"><input tabindex="1"   type="radio" id="status_yes" name="referal_status" value="yes" {if $MODULE_STATUS['referal_status']=='yes'}checked {/if}/>
                                {lang('yes')}</label>
                            <label class="radio-inline"  for="status_no"><input tabindex="2"  type="radio" name="referal_status" id="status_no" value="no" {if $MODULE_STATUS['referal_status']=='no'}checked {/if} />
                                {lang('no')} </label> {form_error('referal_status')}

                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2 col-sm-offset-2">
                            <button class="btn btn-bricky" tabindex="3"   type="submit" value="{lang('set_referral_status')}" name="set_referal_status" id="set_referal_status" > {lang('set_referral_status')}</button>                                
                        </div>
                    </div>
                {form_close()}
            </div>
        </div>
    </div>
</div>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function() {
        Main.init();
    });
</script>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}  