{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}
{assign var="report_name" value="{lang('profile_report')}"}
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i> {lang('profile_report')}
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
            <div class='box' id="print_area" style="overflow: auto; max-height:1000px;">

                {include file="admin/report/header.tpl" name=""}

                <a href={$BASE_URL}admin/excel/create_excel_profile_view_report>{lang('create_excel')}</a>

                <table width="100%" border="1" cellpadding="5px" cellspacing="0" align="center" id="datastore" class="profile_report_tbl" >
                    <tr class="text">
                        {foreach from=$details item=v}
                            <td><strong>{lang('name')}</strong></td>
                            <td>{$v.user_detail_name}</td>
                        </tr>
                       {* <tr>
                            <td><strong>{lang('epin')}</strong></td>
                            <td>{$v.user_detail_passcode}</td>
                        </tr>*}
                        <tr>
                            <td><strong>{lang('user_name')}</strong></td>
                            <td>{$user_name}</td>
                        </tr>

                        <tr>
                            <td><strong>{lang('sponser_name')}</strong></td>
                            <td>{$sponser['name']}</td>
                        </tr>
                        <tr>
                            <td><strong>{lang('resident')}</strong></td>
                            <td>{$v.user_detail_address}</td>
                        </tr>
                        <tr >
                            <td><strong>{lang('pincode')}</strong></td>
                            <td>{$v.user_detail_pin}</td>
                        </tr>
                        <tr>
                            <td><strong>{lang('country')}</strong></td>
                            <td>{$v.user_detail_country}</td>
                        </tr>

                        <tr>
                            <td><strong>{lang('state')}</strong></td>
                            <td>{$v.user_detail_state}</td>
                        </tr>
                        <tr >
                            <td><strong>{lang('mobile_no')}</strong></td>
                            <td>{$v.user_detail_mobile}</td>
                        </tr>
                        <tr>
                            <td><strong>{lang('land_line_no')}</strong></td>
                            <td>{$v.user_detail_land}</td>
                        </tr>
                        <tr>
                            <td><strong>{lang('email')}</strong></td>
                            <td>{$v.user_detail_email}</td>
                        </tr>
                        <tr>
                            <td><strong>{lang('date_of_birth')} </strong></td>
                            <td>{$v.user_detail_dob}</td>
                        </tr>
                        <tr>
                            <td><strong>{lang('gender')}</strong></td>
                            <td>
                                {if $v.user_detail_gender=='M'}
                                    {lang('male')} 
                                {elseif $v.user_detail_gender=='F'}
                                    {lang('female')}
                                    {else}
                                        NA
                                {/if}     
                            </td>
                        </tr>
                    {/foreach}

                </table>

                {include file="admin/report/footer.tpl" name=""}
            </div>
            <div class="row"  >
                <div id = "frame" style="margin-left: 470px;">
                    <a href="" onClick="print_report();
                            return false;"><img src="{$PUBLIC_URL}images/1335779082_document-print.png" alt="Print" height="20" width="20" border="none" align="center" >{lang('click_here_to_print')}</a>
                </div>
            </div>
        </div>
    </div>
</div>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function() {
        Main.init();
    });
    function print_report() {
        var myPrintContent = document.getElementById('print_area');
        var myPrintWindow = window.open("", "Print Report", 'left=300,top=100,width=700,height=500', '_blank');
        myPrintWindow.document.write(myPrintContent.innerHTML);
        myPrintWindow.document.close();
        myPrintWindow.focus();
        myPrintWindow.print();
        myPrintWindow.close();
        return false;
    }
</script>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}