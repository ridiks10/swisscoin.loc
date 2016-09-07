<script>
    var UITreeview = function() {
        //function to initiate jquery.dynatree
        var runTreeView = function() {
            //External data 
            $("#tabular_tree").dynatree({
                // In real life we would call a URL on the server like this:
                //          initAjax: {
                //              url: "/getTopLevelNodesAsJson",
                //              data: { mode: "funnyMode" }
                //              },
                // .. but here we use a local file instead:

                initAjax: {
                    url: "{$BASE_URL}user/tree/get_children/{$user_id}"
                                    },
                                    onLazyRead: function(node) {
                                        node.appendAjax({ url: "{$BASE_URL}user/tree/get_children/{$user_id}"
                                                            });
                                                        },
                                                        onActivate: function(node) {
                                                            node.appendAjax({ url: "{$BASE_URL}user/tree/get_children/" + node.data.id
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

{include file="user/layout/themes/{$USER_THEME_FOLDER}/header.tpl"  name=""}

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

{include file="user/layout/themes/{$USER_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function() {
        Main.init();
        UITreeview.init();
    });
</script>
{include file="user/layout/themes/{$USER_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}