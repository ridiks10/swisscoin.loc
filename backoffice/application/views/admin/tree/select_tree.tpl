<script>
    var UITreeview = function() {
        //function to initiate jquery.dynatree
        var runTreeView = function() {
            //External data 
            $("#tabular_tree").dynatree({
                initAjax: {
                    url: "{$BASE_URL}admin/tree/get_children/{$user_id}"
                                    },
                                    onLazyRead: function(node) {
                                        node.appendAjax({ url: "{$BASE_URL}admin/tree/get_children/{$user_id}"
                                                            });
                                                        },
                                                        onActivate: function(node) {
                                                            node.appendAjax({ url: "{$BASE_URL}admin/tree/get_children/" + node.data.id
                                                            });
                                                        },
                                                        onDeactivate: function(node) {
                                                            $("#echoActive").text("-");
                                                        }
                                                    });
                                                };
                                                return {
                                                    //main function to initiate template pages
                                                    init: function() {
                                                        runTreeView();
                                                    }
                                                };
                                            }();
</script>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"}
<div id="span_js_messages" style="display:none;">
    <span id="error_msg">{lang('you_must_select_user')}</span>
</div>
<!-- start: PAGE CONTENT -->
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>{lang('select_user_name')} 
            </div>
            <div class="panel-body">
                {form_open('','role="form" class="smart-wizard form-horizontal" name="searchform" id="searchform" method="post"')}
                <div class="col-md-12">
                    <div class="errorHandler alert alert-danger no-display">
                        <i class="fa fa-times-sign"></i> {lang('errors_check')}.
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="user_name">{lang('user_name')}:<span class="symbol required"></span></label>
                    <div class="col-sm-3">
                        <input placeholder="{lang('type_members_user_name')}" class="form-control" type="text" id="user_name" name="user_name" autocomplete="Off" tabindex="1" />
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-2 col-sm-offset-2">
                        <button class="btn btn-bricky" type="submit" id="profile_update" value="profile_update" name="profile_update" tabindex="2">
                            {lang('view')}
                        </button>
                    </div>
                </div>
                <input type="hidden" id="path_temp" name="path_temp" value="{$PUBLIC_URL}">
                {form_close()}
            </div>
        </div>
    </div>
</div>
<!-- end: PAGE CONTENT -->
<!-- start: TABULAR TREE-->                                         
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default" id="shr">
            <div class="panel-heading">
                <i class="fa fa-sitemap"></i>
                {lang('tabular_tree')}
            </div>
            <div class="panel-body">
                <label bgcolor='#999'> <img src="{$PUBLIC_URL}images/root.png" /><b>[{$user_name}]</b></label>
                <div id="tabular_tree"></div>
                <div class="widget"> </div>
            </div>
        </div>
    </div>
</div>
<!-- end: EXTERNAL DATA PANEL -->

<!-- end: TABULAR TREE--> 

{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function() {
        Main.init();
        UITreeview.init();
        ValidateUser.init();
    });
</script>
<style type="text/css">
    #panel-config-genology .modal-dialog {
        width: 75%;
        line-height: 14px;
    }
    #panel-config-genology div.panel-body {
        height: 405px;
    }
    #member {
        font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
    }
</style>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}