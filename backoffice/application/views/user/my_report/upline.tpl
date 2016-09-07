{include file="user/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}
<div id="span_js_messages" style="display:none;"> 
    <span id="error_msg">{lang('you_must_enter_user_name')}</span>
</div> 

<div class="row">
    <div class="col-sm-12">


        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>
                {lang('upine')}
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
            <div class="panel-body" style="overflow-x: hidden;">
                <table class="table table-bordered" >
                    <tbody style="font-size: 16px; "> 
                        <tr style="height: 40px; ">
                            <td>Name</td> 
                            <td>{$upline['user_detail_name']} {$upline['user_detail_second_name']}</td>
                        </tr>
                        <tr style="height: 40px;">
                            <td>Mobile No</td>
                            <td>{$upline['user_detail_mobile']}</td>
                        </tr>
                        <tr style="height: 40px;">
                            <td>E-mail</td>
                            <td>{$upline['user_detail_email']}</td>
                        </tr>
                        <tr style="height: 40px;">
                            <td>Country</td>
                            <td>{$upline['country_name']}</td>
                        </tr>
                        <tr style="height: 40px;">
                            <td>State</td>
                            <td>{$upline['state_name']}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
{include file="user/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""} 
<script>
    jQuery(document).ready(function () {
        Main.init();
    });
</script>
{include file="user/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}