{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}


 {if isset($edit_career_details)}
<div class="row">
    <div class="col-sm-12">
       
        <div class="panel panel-default text-center">
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-6">{lang('careers_bv')}: <span class="text-info">{$user_bv}</span></div>
                    <div class="col-sm-6">{lang('careers_rank')}: <span class="text-info">{$user_rank}</span></div>
                </div>
            </div>
        </div>
        
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>{lang('career_management')}
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

                {form_open_multipart('admin/career/add_careers','role="form" class="smart-wizard form-horizontal"  name="add_careers" id="add_careers"')}
                <div class="col-md-12">
                    <div class="errorHandler alert alert-danger no-display">
                        <i class="fa fa-times-sign"></i> {lang('errors_check')}.
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label" for="leadership_rank">{lang('leadership_rank')}<font color="#ff0000"> *</font> </label>
                    <div class="col-sm-3">
                        <input  name="leadership_rank" id="leadership_rank" type="text" size="30" {if isset($edit_career_details)}value="{$edit_career_details['0']['leadership_rank']}"{/if} class="form-control"/>{form_error('news_title')}

                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="leadership_award">{lang('leadership_award')}<font color="#ff0000"> *</font> </label>
                    <div class="col-sm-3">
                        <textarea name="leadership_award" id="leadership_award" type="text"  class="form-control" rows="5">
                            {if isset($edit_career_details)}{$edit_career_details['0']['leadership_award']}{/if}</textarea>
                       {* <input  name="leadership_award" id="leadership_award" type="text" size="30" {if isset($edit_career_details)}value="{$edit_career_details['0']['leadership_award']}"{/if} class="form-control"/>*}{form_error('news_title')}

                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="qualifying_personal_pv">{lang('qualifying_bv')} </label>
                    <div class="col-sm-3">
                        <input  name="qualifying_personal_pv" id="qualifying_personal_pv" type="text" size="30"{if isset($edit_career_details)}value="{$edit_career_details['0']['qualifying_personal_pv']}"{/if} class="form-control"/>{form_error('news_title')}

                    </div>
                </div>

               {* <div class="form-group">
                    <label class="col-sm-2 control-label" for="qualifying_weaker_leg_bv">{lang('qualifying_weaker_leg_bv')} </label>
                    <div class="col-sm-3">
                        <input  name="qualifying_weaker_leg_bv" id="qualifying_weaker_leg_bv" type="text" size="30" {if isset($edit_career_details)}value="{$edit_career_details['0']['qualifying_weaker_leg_bv']}"{/if} class="form-control"/>{form_error('news_title')}

                    </div>
                </div>*}
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="qualifying_terms">{lang('qualifying_terms')}<font color="#ff0000"> *</font> </label>
                    <div class="col-sm-3">
                        <input  name="qualifying_terms" id="qualifying_terms" type="text" size="30" {if isset($edit_career_details)}value="{$edit_career_details['0']['qualifying_terms']}"{/if} class="form-control"/>{form_error('news_title')}

                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="product_id"> {lang('select_image')}<font color="#ff0000"> *</font> </label>
                    <div class="col-sm-10">
                        <div class="fileupload fileupload-new" data-provides="fileupload" >

                            <div class="user-edit-image-buttons">
                                <span class="btn btn-light-grey"><span class="fileupload-new"><i class="fa fa-picture"></i></span>
                                    <input type="file" id="userfile" name="userfile" >
                                </span>
                                <div>&nbsp;<br/></div>
                                    {* <a href="#" class="btn fileupload-exists btn-light-grey" data-dismiss="fileupload">
                                    <i class="fa fa-times"></i>Remove
                                    </a>*}
                            </div><span class="help-block" for="upload_doc"></span>
                        </div>
                        <!--<font color="#ff0000">{lang('kb')}({lang('Allowed_types_are_pdf_ppt_docs_xls_xlsx')})</font>-->
<div  style="color:gray;font-style: italic; font-size:15px;">(max size:40 MB  file formats support:gif,jpg,png,jpeg)</div>
                    </div>
                </div>

                {if isset($edit_career_details)}
                    <input type="hidden" name="update_id" id="update_id" value="{$edit_career_details['0']['id']}" />
                    <div class="form-group">
                        <div class="col-sm-2 col-sm-offset-2">
                            <button class="btn btn-bricky" name="career_submit" type="submit" value="update"> Update</button>   
                        </div>
                    </div>
                {else}
                    <div class="form-group">
                        <div class="col-sm-2 col-sm-offset-2">
                            <button class="btn btn-bricky" name="career_submit" type="submit" value="{lang('submit')}"> {lang('submit')} </button>   
                        </div>
                    </div>

                {/if}






            </div>     
        </div>
    </div>
</div>
{/if}
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>{lang('careers')}
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

                <table class="table table-striped table-bordered table-hover table-full-width" id="">
                    <thead>
                        <tr class="th" align="center" {*style="background-color:brown;"*}>
                            <th width='5%'>{lang('slno')}</th>
                            <th width='10%'>{lang('leadership_badge')}</th>
                            <th width='10%'>{lang('leadership_rank')}</th>
                            <th width='50%'>{lang('leadership_award')}</th>
                            <th width='10%'>{lang('qualifying_bv')}</th>
                           {* <th>{lang('qualifying_weeker_leg_bv')}</th>*}
                            <th width='10%'>{lang('qualifying_terms')}</th>
                            <th width='5%'>Action</th>
                        </tr>
                    </thead>
                    {if count($career_details)>0}
                        <tbody>
                            {$balance = 0} {assign var="i" value=0}
                            {foreach from=$career_details item=v}

                                <tr>{$i=$i+1}
                                    <td >{$i}</td>
                                    <td ><img src="{$PUBLIC_URL}images/careers/{$v.image_name}" style="width:80px;height:80px;"></td>
                                    <td  >{$v.leadership_rank}</td>
                                    <td  >{$v.leadership_award}</td>
                                    <td  >{$v.qualifying_personal_pv}</td>
                                   {* <td  >{$v.qualifying_weaker_leg_bv}</td>*}
                                    <td  >{$v.qualifying_terms}</td>
                                    <td >

                                        <div class="visible-md visible-lg hidden-sm hidden-xs">
                                            <a href="javascript:edit_career({$v.id})" class="btn btn-teal tooltips" data-placement="top" data-original-title="{lang('edit')}"><input type="hidden" name="edit_career" id="edit_career" size="35" />
                                                <i class="fa fa-edit"></i></a>


                                            <span style="display:none" id="confirm_msg_edit">sure you want to edit this career</span>

                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            {/foreach}    			
                        </tbody>
                    {else}

                    {/if}
                </table>

            </div>
        </div>
    </div>
</div>  


{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function () {
        Main.init();
        ValidateCareer.init();

    });
</script>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}