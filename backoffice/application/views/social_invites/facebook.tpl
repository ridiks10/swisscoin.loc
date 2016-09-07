{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}

<div class="row" style="margin :4%;padding: 4%; border:solid 5px #ccc;">
    <div class="row" style="margin-bottom: 2%;">
        <div class="col-md-12">    
            <div class="col-md-2">
                <img src="{$PUBLIC_URL}images/logos/{$site_info['logo']}"/>
            </div>
        </div>
    </div>

    <div class="row" style="margin-bottom: 1%;">
        <div class="col-md-12">    
            <div class="col-md-2" style="font-weight: bold;">
                {$site_info['company_name']}
            </div>
        </div>
    </div>
    <div class="row" style="margin-bottom: 4%;">
        <div class="col-md-12">    
            <div class="col-md-2">
                {$site_info['company_address']}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">    
            <div  class="col-md-12">
                {$content}
            </div>
        </div>
    </div>

    <div class="row" style="margin-bottom: 0px;">
        {$curr_date = date('Y')}
        <div class="" style=" text-align: center;  margin-top: 10px; ">
            {$curr_date} &copy; {$COMPANY_NAME} {$smarty.const.SOFTWARE_VERSION}
        </div>
    </div>
</div>

{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/login_footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function() {
        Main.init();
    });
</script>

{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}