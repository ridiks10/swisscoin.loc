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
            <div  id="print_area" style="overflow: auto; height:500px;">
                {include file="admin/report/header.tpl" name=""}
                {if $count >= 1}
                    <br><br><table border='1'   cellpadding='5px' cellspacing='0'align='center' width='100%'>
                        <tr><td colspan = '19'><a href={$BASE_URL}admin/excel/user_profiles_excel>{lang('create_excel')}</a></td></tr>
                        <tr class='th'>
                            <th>{lang('no')}</th>
                            <th>{lang('name')}</th>              
                            <th>{lang('user_name')}</th>
                            <th>{lang('sponser_name')}</th>
                            <th>{lang('address')}</th>
                            <th>{lang('pincode')}</th>
                            <th>{lang('mobile_no')}</th>        
                            <th>{lang('email')}</th>
                            <th>{lang('bank')}</th>
                            <th>{lang('branch')}</th>
                            <th>{lang('acc_no')}</th>
                            <th>{lang('date_of_joining')}</th>
                        </tr>

                        {if count($profile_arr)!=0}
                            {foreach  from= $profile_arr item=v}
                                {assign var="tr_class" value=""}
                                {assign var="i" value="0"}
                                {if $i%2==0}
                                    {$clr='tr1'}
                                {else}
                                    {$clr='tr2'}
                                {/if}
                                {assign var="name" value="{$v.user_detail_name}"}
                                {assign var="address" value="{$v.user_detail_address}"}
                                {assign var="pincode" value="{$v.user_detail_pin}"}
                                {assign var="mobile" value="{$v.user_detail_mobile}"}
                                {assign var="email" value="{$v.user_detail_email}"}
                                {assign var="bank" value="{$v.user_detail_nbank}"}
                                {assign var="branch" value="{$v.user_detail_nbranch}"}
                                {assign var="acc" value="{$v.user_detail_acnumber}"}
                                {assign var="date" value="{$v.join_date}"}
                                {assign var="uname" value="{$v.uname}"}
                                {assign var="sponser_name" value="{$v.sponser_name}"}

                                <tr class="{$clr}">
                                    <td>{counter}</td>
                                    <td>{$name}</td>
                                    <td>{$uname}</td>
                                    <td>{$sponser_name}</td>
                                    <td>{$address}</td>
                                    <td>{$pincode}</td>
                                    <td>{$mobile}</td>
                                    <td>{$email}</td>
                                    <td>{$bank}</td>
                                    <td>{$branch}</td>
                                    <td>{$acc}</td>

                                    <td>{date('Y/m/d', strtotime($date))}</td>
                                </tr>
                            {/foreach} 
                        {else}
                            <h4 align='center'>  <font size="6">{lang('no_data')}</font ></h4>
                            {/if}
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
{/if}
