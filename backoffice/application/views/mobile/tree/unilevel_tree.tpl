<script>

    function getUnilevelTree(id)
    {


        $.ajax({
            type: "GET",
            url: '{$BASE_URL}server_unilevel.php',
            data: "id=" + id, // appears as $_GET['id'] @ ur backend side
            success: function(data) {
                // data is ur summary
                $('#summary').html(data);
            }

        });

    }

</script>
{include file="mobile/layout/themes/default/header.tpl"  name=""}

<!-- start: PAGE CONTENT -->
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>{$tran_select_user}  
            </div>
            <div class="panel-body">
                <form role="form" class="smart-wizard form-horizontal" name="searchform" id="searchform" action="" method="post">
                    <div class="col-md-12">
                        <div class="errorHandler alert alert-danger no-display">
                            <i class="fa fa-times-sign"></i> You have some form errors. Please check below.
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="user_name">{$tran_select_user_id}<span class="symbol required"></span></label>
                        <div class="col-sm-3">
                            <input placeholder="{$tran_type_members_name}" class="form-control" type="text" id="user_name" name="user_name" autocomplete="Off" tabindex="1" >

                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2 col-sm-offset-2">
                            <button class="btn btn-bricky" type="submit" id="profile_update" value="profile_update" name="profile_update" tabindex="2">
                                {$tran_view}
                            </button>
                        </div>
                    </div>
                    <input type="hidden" id="path_temp" name="path_temp" value="{$PUBLIC_URL}">
                </form>
            </div>
        </div>
    </div>
</div>
<!-- end: PAGE CONTENT -->

<!-- start: GENOLOGY TREE-->                                         
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-sitemap"></i>
                {$tran_sponsor_tree}
            </div>

            <div id="summary" class="panel-body tree-container1" style="height:100%;">         
            </div>
        </div>
    </div>
</div>

<!-- end: GENOLOGY TREE-->


{include file="mobile/layout/themes/default/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function() {
        Main.init();
        getUnilevelTree('{$user_id}');
        ValidateUser.init();
    });
</script>
{include file="mobile/layout/themes/default/page_footer.tpl" title="Example Smarty Page" name=""}