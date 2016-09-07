{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"}

<div id="span_js_messages" style="display:none;">    
    <span id="row_msg">{lang('rows')}</span>
    <span id="show_msg">{lang('shows')}</span> 
</div> 

<div class="row"  >
    <div class="col-sm-12">
       
        <div class="tabbable">
            <ul class="nav nav-tabs tab-green">
                {foreach from=$languages item=l}
                <li class="{if $l.lang_id == $langId}active{else}{/if}">
                    <a href="{$l.lang_code}">{$l.lang_name_in_english}</a>
                </li>
                {/foreach}
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="panel_tab3_example4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-external-link-square"></i> {lang('translation list')}
                            <div class="panel-tools">
                                <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                                </a>
                                <a class="btn btn-xs btn-link panel-refresh" href="#">
                                    <i class="fa fa-refresh"></i>
                                </a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <p><a class="btn btn-warning" href="../translation_list/csvempty?lang={$langId}">{lang('download empty')}</a></p>
                            <table class="table table-bordered table-responsive" id="sample_1">
                                <thead>
                                    <tr>
                                        <th>Si No</th>
                                        <th>{lang('translation_key')}</th>
                                        <th>{lang('translation_text')}</th>
                                        {*<th>{lang('action')}</th>*}
                                    </tr>
                                </thead>
                                <tbody>{assign var="i" value=0}
                                    {foreach from=$translation item=v}
                                    <tr>{$i=$i+1}
                                        <td>{$i}</td>
                                        <td>{$v->key}</td>
                                        <td>{if isset($v->text)}{$v->text}{else}<b>NOT SET</b>{/if}</td>
                                        {*<td style="white-space: nowrap;">
                                            <a class="btn btn-primary" href="../translation/{$v->id}">
                                                <span class="glyphicon glyphicon glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                            </a>
                                        </td>*}
                                    </tr>
                                    {/foreach}
                                </tbody>
                            </table>
                            <a class="btn btn-warning" href="../translation_list/csvempty?lang={$langId}">{lang('download empty')}</a>
{*                            <a class="btn btn-default" href="translation_list/csvall">{lang('load all')}</a>*}
                        </div>
                    </div>
                </div>
                <form class="form-horizontal" enctype="multipart/form-data" action="../importlanguage" method="post">
                    <div class="input-group">
                        <label>{lang('upload translation')}</label>&nbsp;&nbsp;&nbsp;
                        <span class="btn btn-light-grey btn-file">
                            <span class="fileupload-new">{lang('select_csv')}</span>
                            <input type="file" name="translationfile" />
                        </span>&nbsp;&nbsp;
                        <input class="btn btn-default" type="submit" value="{lang('upload')}" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function () {
        Main.init();
        //TableData.init();
    });
</script>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}