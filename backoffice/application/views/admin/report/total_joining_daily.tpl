{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}
{assign var="report_name" value="{lang('user_joining_report')}"}

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i> {lang('user_joining_report')}
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
            <div  id="print_area" style="overflow: auto; max-height:1000px;">
                {include file="admin/report/header.tpl" name=""}
                {if $count >= 1}
                    <br><br><table border='1'  cellpadding='5px' cellspacing='0' align='center' width="100%">
                        <tr>
                            <td colspan = '19'><a href={$BASE_URL}admin/excel/create_excel_joining_report_daily>{lang('create_excel')}</a></td>
                        </tr>
                        <tr class='th'>
                            <th>{lang('no')}</th>
                            <th>{lang('user_name')}</th>
                            <th>{lang('full_name')}</th>
                            <th>{lang('upline_name')}</th>
                            <th>{lang('sponser_name')}</th>
                            <th>{lang('status')}</th>
                            <th>{lang('date_of_joining')}</th>
                        </tr>
                        {assign var="i" value=0}
                        {foreach from=$todays_join item=v}

                            {if $i%2==0}
                                {assign var="class" value="tr1"}
                            {else}
                                {assign var="class" value="tr2"}
                            {/if}

                            {if $v.active=="yes"}
                                {assign var="stat" value="ACTIVE"}

                            {else}
                                {assign var="stat" value="BLOCKED"}
                            {/if}
                            {$i=$i+1}
                            <tr class="{$class}">

                                <td>{$i}</td>
                                <td>{$v.user_name}</td>
                                <td>{$v.user_full_name}</td>
                                <td>{if $v.father_user}{$v.father_user}{else}NA{/if}</td>
                                <td>{if $v.sponsor_name}{$v.sponsor_name}{else}NA{/if}</td>
                                <td>{$stat}</td>
                                <td>{date('Y/m/d', strtotime($v.date_of_joining))}</td>

                            </tr>


                        {/foreach}

                    {else}
                        <h4 align='center'>  <font size="6">{lang('no_data')}</font ></h4>
                        {/if}
                </table>
                {include file="admin/report/footer.tpl" name=""}
            </div>

            {if $count >= 1}
                <div class="row"  >
                    <div id = "frame" style="margin-left: 470px;">
                        <a href="" onClick="print_report();
                            return false;"><img src="{$PUBLIC_URL}images/1335779082_document-print.png" alt="Print" height="20" width="20" border="none" align="center" >{lang('click_here_to_print')}</a>
                    </div>
                </div>
            {/if}
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
