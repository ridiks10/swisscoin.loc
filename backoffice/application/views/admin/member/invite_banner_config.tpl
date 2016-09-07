{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl" name=""}

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading"> {lang('banner')}
                <i class="fa fa-external-link-square"></i> 
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


                {form_open_multipart('','role="form" class="smart-wizard form-horizontal"  method="post"    name="banner_form" id="product_form"')}

                    <div class="form-group"  id="pdf" >

                        <div class="col-sm-2  col-sm-offset-1">
                            <div class="input-group">

                                <div class="col-sm-12">
                                    <div data-provides="fileupload" class="fileupload fileupload-new">
                                        <span class="btn btn-light-grey"></i> <span class="fileupload-new"></span>
                                            <input name="banner_image" id="banner_image" type="file" tabindex="2" >
                                        </span>
                                        <p class="help-block">
                                            {lang('please_choose_a_png_file.')} <br>{lang('max_size_20MB')}
                                        </p>
                                    </div>

                                </div>

                                <div class="form-group">
                                    <div class="col-sm-1 col-sm-offset-1">
                                        <button class="btn btn-primary" tabindex="4" name="banner" type="submit" value="submit"><i class="fa fa-plus"></i>{lang('add_Item')}</button>
                                    </div>
                                </div>



                            </div>
                        </div>

                    </div>

                {form_close()}

            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i> 
                {lang('banner')}
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
                <table border="0" align="center" width="100%" class="table table-striped table-bordered table-hover table-full-width" id="sample_1" >
                    <thead>
                        <tr class="th" >
                            <th>{lang('sl_no')}</th>                            
                            <th>{lang('banner')}</th>   
                            <th>{lang('delete')}</th>
                        </tr>
                    </thead>
                    {if count($banners)>0}
                        <tbody>
                            {assign var="i" value="0"}
                            {assign var="class" value=""}
                            {foreach from=$banners item=v}


                                <tr>   {$i=$i+1}                                
                                    <td>{$i}</td>
                                    <td><img src="{$PUBLIC_URL}images/banners/{$v.content}" height="150" width="250"></td>



                                    <td>
                                        {form_open('admin/member/delete_banner','method="post"')}
                                            <input type='hidden' id='banner_id' name='banner_id' value='{$v.id}'>
                                            <button title="{lang('delete')}" type='submit'  id='delete' name='delete' value="delete" class="btn btn-bricky"><i class="fa fa-times fa fa-white"></i></button>
                                        {form_close()}
                                    </td>


                                </tr>
                                
                            {/foreach}
                        </tbody>
                    {else}
                        <tbody>
                            <tr><td colspan="8" align="center"><h4 align="center"> {lang('no_data')}</h4></td></tr>
                        </tbody>
                    {/if}
                </table>
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