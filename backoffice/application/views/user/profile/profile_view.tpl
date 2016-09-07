{include file="user/layout/themes/{$USER_THEME_FOLDER}/header.tpl"  name=""}

<div id="span_js_messages" style="display:none;">
    <span id="err_name_required">{lang('must_enter_first_name')}</span>
    <span id="err_name_alpha_spec">{lang('characters_only')}</span>
    <span id="err_name_minlength">{lang('enter_atleast_3_chars')}</span>
    <span id="err_second_name_required">{lang('must_enter_second_name')}</span>                     
    <span id="err_second_name_alpha_spec">{lang('characters_only')}</span>        
    <span id="err_second_name_minlength">{lang('enter_atleast_3_chars')}</span>
    <span id="err_gender_required">{lang('you_select_a_Gender')}</span>
    <span id="err_address_required">{lang('you_must_enter_your_address')}</span>
    <span id="err_address_alpha_num">{lang('only_alphanumerals')}</span>
    <span id="err_address_line2_required">{lang('you_must_enter_your_address')}</span>
    <span id="err_address_line2_alpha_num">{lang('only_alphanumerals')}</span>
    <span id="err_email_required">{lang('enter_your_email_id')}</span>
    <span id="err_email_format">{lang('enter_valid_email')}</span>
    <span id="err_city_required">{lang('you_must_enter_your_city')}</span>
    <span id="err_city_alpha_num">{lang('only_alphanumerals')}</span>
    <span id="err_mobile_required">{lang('you_must_enter_your_mobile_no')}</span>
    <span id="err_mobile_digits">{lang('digits_only')}</span>
    <span id="err_mobile_minlength">{lang('mobile_number_must_5_digits_long')}</span>
    <span id="err_pan_incorrect_format">{lang('pan_format_is_incorrect')}</span>
    <span id="err_user_name_required">{lang('username_field_is_required')}</span>
    <span id="err_pin_maxlength">{lang('pin_should_be_atleast_3_digits_long')}</span>
    <span id="err_pin_minlength">{lang('pin_should_not_be_greater_than_10_digits')}</span>
     <span id="err_passport_required">{lang('err_passport_required')}</span>
    <input name="date_of_birth" id="date_of_birth" type="hidden" size="16" maxlength="10"  {if $reg_count>0} value="{$details["detail1"]["dob"]}" {/if} />
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="tabbable">
            <ul class="nav nav-tabs tab-padding tab-space-3 tab-blue" id="myTab4">
                <li class="{$tab1}">
                    <a data-toggle="tab" href="#panel_overview">
                        {lang('overview')}
                    </a>
                </li>
                <li class="{$tab2}">
                    <a data-toggle="tab" href="#panel_edit_account">
                        {lang('edit_account')}
                    </a>
                </li>
                {*   {if $MLM_PLAN== "Binary"}
                <li class="{$tab3}">
                <a data-toggle="tab" href="#panel_edit_network">
                {lang('edit_network')}
                </a>
                </li>
                {/if}*}
            </ul>
            <div class="tab-content">
                <div id="panel_overview" class="tab-pane in{$tab1}">
                    <div class="row">
                        <div class="col-sm-5 col-md-12">
                            <div class="user-left">
                                <h4>{$u_name}{lang('s_profile')}</h4>
                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                    <div class="user-image">
                                        <div class="fileupload-new thumbnail"><img src="{$PUBLIC_URL}images/profile_picture/{$file_name}" width="122" alt="Profile Picture">
                                        </div>
                                        <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                        <div class="user-image-buttons">

                                        </div>
                                    </div>
                                </div>
                                <div class="center">

                                    {*<hr>*}
                                    <p>
                                    </p>
                                    {*<hr>*}
                                </div>
                                <table class="table table-condensed table-hover">
                                    {*<thead>
                                    <tr>
                                    <th colspan="3">Sponsor Information</th>
                                    </tr>
                                    </thead>*}
                                    <tbody>
                                        {*  <tr>
                                        <td width="180px">{lang('placement_user_name')}</td><td width="50px"> : </td>
                                        <td>{$details["detail1"]['father_name']} </td>
                                        </tr>*}
                                        <tr>
                                            <td width="180px">{lang('sponsor_name')}</td><td width="50px"> : </td>
                                            <td>{$details["detail1"]['sponsor_name']} </td>
                                        </tr>
                                        <tr>
                                            <td width="180px">Replication Link</td><td width="50px"> : </td>
                                            <td><a href="{$replica_url}/{$LOG_USER_NAME}" target="_blank">{$replica_url}/{$LOG_USER_NAME}</a></td>
                                        </tr>
                                        {*{if $MLM_PLAN!= "Board"}
                                        <tr>
                                        <td>{lang('position')}  </td><td width="50px"> : </td>
                                        <td>
                                        {if $details["detail1"]["position"]=='L'} {lang('left')} {elseif $details["detail1"]["position"]=='R'} {lang('right')} {/if} </td>

                                        </tr>
                                        {/if}*}
                                        {* {if $product_status == "yes"}
                                        <tr>
                                        <td>{lang('package')} <td width="50px"> : </td> </td>
                                        <td> {$product_name} </td>

                                        </tr>
                                        {/if}*}
                                        {if $pin_status == "yes"}
                                            <tr>
                                                <td>{lang('epin')}  <td width="50px"> : </td></td>
                                                <td>{$details["detail1"]["passcode"]}</td>

                                            </tr>
                                        {/if}

                                    </tbody>
                                </table>
                                <table class="table table-condensed table-hover">
                                    {* <thead>
                                    <tr>
                                    <th colspan="3">{lang('personal_info')}</th>
                                    </tr>
                                    </thead>*}
                                    <tbody>
                                        <tr>
                                            <td>{lang('user_name')} <td width="50px"> : </td> </td>
                                            <td>
                                                {$u_name} </td>

                                        </tr>
                                        <tr>
                                            <td  width="180px">{lang('first_name')}<td width="50px"> : </td></td>
                                            <td>{$details["detail1"]["name"]} </td>

                                        </tr>
                                        <tr>
                                            <td  width="180px">{lang('last_name')}<td width="50px"> : </td></td>
                                            <td>{$details["detail1"]["user_detail_second_name"]} </td>

                                        </tr>


                                        <tr>
                                            <td>{lang('date_of_birth')}<td width="50px"> : </td> </td>
                                            <td> {$details["detail1"]["dob"]} </td>

                                        </tr>


                                        <tr>
                                            <td>{lang('gender')} <td width="50px"> : </td> </td>
                                            <td>{if $details["detail1"]["gender"]=='M'}
                                                {lang('male')}
                                                {elseif $details["detail1"]["gender"]=='F'}
                                                    {lang('female')}
                                                    {else}
                                                        {$details["detail1"]["gender"]}

                                                        {/if}       </td>

                                                    </tr>
                                                </tbody>
                                            </table>
                                            <table class="table table-condensed table-hover">
                                                <thead>
                                                    <tr>
                                                        <th colspan="3">   {lang('contact_info')}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td  width="180px">{lang('adress_line1')}<br/></td><td width="50px"> : </td>
                                                        <td>{$details["detail1"]["address"]} </td>

                                                    </tr>
                                                    <tr>
                                                        <td  width="180px">{lang('adress_line2')}<br/></td><td width="50px"> : </td>
                                                        <td>{$details["detail1"]["user_detail_address2"]} </td>

                                                    </tr>
                                                    <tr>
                                                        <td>{lang('country')} </td><td width="50px"> : </td>
                                                        <td>{$cur_country}</td>
                                                    </tr>

                                                    <tr>
                                                        <td>{lang('state')} </td><td width="50px"> : </td>
                                                        <td>{$cur_state}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>{lang('city')}</td><td width="50px"> : </td>
                                                        <td>
                                                            {$details["detail1"]["user_detail_city"]}</td>
                                                    </tr>

                                                    <tr>
                                                        <td>{lang('zip_code')} <td width="50px"> : </td> </td>
                                                        <td>
                                                            {$details["detail1"]["pincode"]}
                                                        </td>

                                                    </tr>

                                                    <tr>
                                                        <td>{lang('mob_no_10_digit')} </td><td width="50px"> : </td>
                                                        <td>
                                                            {$details["detail1"]["mobile"]}
                                                        </td>

                                                    </tr>

                                                    <tr>
                                                        <td>{lang('land_line_no')}  <td width="50px"> : </td></td>
                                                        <td>
                                                            {$details["detail1"]["land"]}
                                                        </td>

                                                    </tr>

                                                    <tr>
                                                        <td>{lang('email')} <td width="50px"> : </td> </td>
                                                        <td>
                                                            {$details["detail1"]["email"]}
                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <td>Passport ID <td width="50px"> : </td> </td>
                                                        <td>
                                                            {$details["detail1"]["passport_id"]}
                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <td>Expiry date of ID <td width="50px"> : </td> </td>
                                                        <td>
                                                            {$details["detail1"]["id_expire"]}
                                                        </td>

                                                    </tr>


                                                </tbody>
                                            </table>

                                            <table class="table table-condensed table-hover">
                                                <thead>
                                                    <tr>
                                                        <th colspan="3"> {lang('bank_info')}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <tr>
                                                        <td>{lang('bank_name')}</td><td width="50px"> : </td> 
                                                        <td>

                                                            {$details["detail1"]["nbank"]}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>{lang('branch_name')}</td><td width="50px"> : </td>
                                                        <td>{$details["detail1"]["nbranch"]}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>IBAN/Account Nr</td>          <td width="50px"> : </td>    

                                                        <td>{$details["detail1"]["acnumber"]}</td>

                                                    </tr>
                                                    <tr>
                                                        <td>Swift Code</td><td width="50px"> : </td> 
                                                        <td>{$details["detail1"]["ifsc"]}</td>

                                                    </tr>
                                                    <tr>
                                                        <td width="180px">Bank Country</td><td width="50px"> : </td>
                                                        <td>{$details["detail1"]["bank_country"]}</td>

                                                    </tr>

                                                </tbody>
                                            </table>
                                            <table class="table table-condensed table-hover">
                                                <thead>
                                                    <tr>
                                                        <th colspan="3"> {lang('social_profiles')}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td width="180px">{lang('facebook')}</td><td width="50px"> : </td>
                                                        <td>{$details["detail1"]["facebook"]}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>{lang('twitter')}</td><td width="50px"> : </td>
                                                        <td>{$details["detail1"]["twitter"]}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                                    
                                                    <table class="table table-condensed table-hover">
                                    <thead>
                                        <tr>
                                            <th colspan="3"> Tax-Data</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td width="180px">Tax ID</td><td width="50px"> : </td>
                                            <td>{$details["detail1"]["tax-id"]}</td>

                                        </tr>
                                        <tr>
                                            <td>Tax Number</td><td width="50px"> : </td>
                                            <td>{$details["detail1"]["tax-number"]}</td>

                                        </tr>
                                    </tbody>
                                </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="panel_edit_account" class="tab-pane{$tab2}">  
                                {form_open_multipart('user/profile/profile_view','role="form" method="post" name="user_register" id="user_register" action="" enctype="multipart/form-data"')}
                                <div class="col-md-12">
                                    <div class="errorHandler alert alert-danger no-display">
                                        <i class="fa fa-times-sign"></i> {lang('errors_check')}
                                    </div>
                                </div>
                                <input type="hidden" name="path" id="path" value="{$PATH_TO_ROOT_DOMAIN}user/">
                                <input type="hidden" name="lang_id" id="lang_id" value="{$lang_id}">
                                <div class="row">
                                    {*<div class="col-md-12">
                                        <h3>{lang('sponsor_package_info')}</h3>
                                        <hr>
                                    </div>*}
                                    <div class="col-md-12">
                                        <div class="form-group">
                                           {* <label>
                                                {lang('image_upload')}
                                            </label>*}
                                            <div class="fileupload fileupload-new" data-provides="fileupload" >
                                                <div class="fileupload-new thumbnail" style="width: 150px; height: 150px;"><img src="{$PUBLIC_URL}images/profile_picture/{$file_name}" alt="">
                                                </div>
                                                <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 150px; max-height: 150px; line-height: 20px;"></div>
                                                <div class="user-edit-image-buttons">
                                                    <span class="btn btn-light-grey btn-file"><span class="fileupload-new"><i class="fa fa-picture"></i> {lang('select_image')}</span><span class="fileupload-exists"><i class="fa fa-picture"></i> {lang('change')}</span>
                                                        <input type="file" id="userfile" name="userfile">
                                                    </span>
                                                    <a href="#" class="btn fileupload-exists btn-light-grey" data-dismiss="fileupload">
                                                        <i class="fa fa-times"></i>{lang('remove')}
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label" >
                                                {lang('sponsor_name')}
                                            </label>
                                            <label class="form-control" readonly="true">
                                                {$sponser['name']}
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">
                                                {lang('user_name')}
                                            </label>
                                            <label class="form-control" readonly="true">
                                                {$u_name}
                                            </label>
                                            <input class="form-control" name="username" id="username" type="hidden"  size="22" maxlength="20" value="{$u_name}" tabindex="3" />{form_error('username')}</td>

                                        </div>
                                    </div>
                                    {* {if $MLM_PLAN!= "Board"}
                                    <div class="col-md-6">
                                    <div class="form-group">
                                    <label class="control-label">
                                    {lang('position')}
                                    </label>
                                    <label class="form-control" readonly="true">
                                    {if $details["detail1"]["position"]=='L'} {lang('left')} 
                                    {elseif $details["detail1"]["position"]=='R'} {lang('right')} {/if}
                                    </label>
                                    </div>
                                    </div>
                                    {/if}*}
                                    {* {if $product_status == "yes"}
                                    <div class="col-md-6">
                                    <div class="form-group">
                                    <label class="control-label">
                                    {lang('package')}
                                    </label>
                                    <label class="form-control" readonly="true">
                                    {$product_name}
                                    </label>
                                    </div>
                                    </div>
                                    {/if}*}
                                    {if $pin_status == "yes"}
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">
                                                    {lang('epin')}
                                                </label>
                                                <label class="form-control" readonly="true">
                                                    {$details["detail1"]["passcode"]}
                                                </label>

                                            </div>
                                        </div>
                                    {/if}

                                </div>
                                <div class="row">
                                    {*<div class="col-md-12">
                                    <h3>  {lang('personal_info')}</h3>
                                    <hr>
                                    </div>*}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">
                                                {lang('first_name')}<span class="symbol required"></span>
                                            </label>                                    	    

                                            <input  class="form-control" name="name" tabindex="1" id="name" type="text"  size="22"  maxlength="50" value="{$details["detail1"]["name"]}" /></td>

                                            {form_error('name')}


                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">
                                                {lang('last_name')}<span class="symbol required"></span>
                                            </label>                                    
                                            <input  class="form-control" name="second_name" maxlength="32" id="second_name" type="text" tabindex="2" value="{$details["detail1"]["user_detail_second_name"]}" />	    {form_error('second_name')}



                                        </div>
                                    </div>









                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">
                                                {lang('gender')}<span class="symbol required"></span>
                                            </label>
                                            <div class="row">
                                                <div class="col-md-9">                      
                                                    <select name="gender" id="gender" tabindex="4"  class="form-control">
                                                        <option value="" >{lang('select_gender')}</option>
                                                        {if $details["detail1"]["gender"]=='M'} 
                                                            <option value='M' selected='selected'>{lang('male')} </option>
                                                            <option value='F'>{lang('female')}</option>				
                                                        {else if $details["detail1"]["gender"]=='F'}                
                                                            <option value='M' >{lang('male')} </option>
                                                            <option value='F' selected='selected'>{lang('female')}</option>				
                                                        {else}
                                                            <option value='M' >{lang('male')} </option>
                                                            <option value='F'>{lang('female')}</option>
                                                        {/if}
                                                    </select>     
                                                </div>
                                            </div>
                                            {form_error('gender')}
                                        </div>
                                    </div>


                                    <div class="row">

                                        <div class="col-md-6">  
                                            <label class="control-label">
                                                {lang('date_of_birth')}<span class="symbol required"></span>
                                            </label> 
                                            <div class="form-group">



                                                <div class="col-md-3">           
                                                    <select name="year" id="year" onchange="change_year(this);" tabindex="5" class="form-control" onblur="day_year(this);">
                                                        {if $details["detail1"]['year']}
                                                            <option selected="selected" value="{$details["detail1"]["year"]}">{$details["detail1"]["year"]}</option>
                                                        {else}
                                                            <option value="">{lang('year')}</option>
                                                        {/if}					    

                                                        {foreach from = $years  item=v}
                                                            <option value="{$v}">{$v}</option>
                                                        {/foreach}
                                                    </select> {form_error('year')}
                                                </div>

                                                <div class="col-md-3">
                                                    <select name="month" id="month" onchange="change_month(this);" tabindex="6" class="form-control" onblur="day_month(this);">
                                                        {if $details["detail1"]['month']}
                                                            <option selected="selected" value="{$details["detail1"]["month"]}">{$details["detail1"]["month"]}</option>
                                                        {else}
                                                            <option value="">{lang('month')}</option>
                                                        {/if}


                                                        <option value="01">01</option>
                                                        <option value="02">02</option>
                                                        <option value="03">03</option>
                                                        <option value="04">04</option>
                                                        <option value="05">05</option>
                                                        <option value="06">06</option>
                                                        <option value="07">07</option>
                                                        <option value="08">08</option>
                                                        <option value="09">09</option>
                                                        <option value="10">10</option>
                                                        <option value="11">11</option>
                                                        <option value="12">12</option>
                                                    </select>  {form_error('month')}
                                                </div>
                                                {*</p><p>*}
                                                <div class="col-md-3">
                                                    <select name="day" id="day" onchange="change_day(this);" tabindex="7" class="form-control" >
                                                        {if $details["detail1"]["day"]!=''}
                                                            <option selected="selected" value="{$details["detail1"]["day"]}">{$details["detail1"]["day"]}</option>
                                                        {else}
                                                            <option value="">{lang('day')}</option>
                                                        {/if}

                                                        {foreach from = $month  item=v}
                                                            <option value="{$v}">{$v}</option>
                                                        {/foreach}
                                                    </select> {form_error('day')}
                                                </div>
                                            </div>
                                        </div>  
                                    </div>  

                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <h3>  {lang('contact_info')}</h3>
                                        <hr>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">
                                                {lang('adress_line1')} <span class="symbol required"></span>
                                            </label>
                                            <div class="row">
                                                <div class="col-md-12">   
                                                    <input  class="form-control" name="address" maxlength="32" id="address" type="text" tabindex="8" value="{$details["detail1"]["address"]}" />	    {form_error('address')}

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">
                                                {lang('adress_line2')} 
                                            </label>
                                            <div class="row">
                                                <div class="col-md-12">   
                                                    <input  class="form-control" name="address_line2" maxlength="32" id="address_line2" type="text" tabindex="9" value="{$details["detail1"]["user_detail_address2"]}" />{form_error('user_detail_address2')}

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">
                                                {lang('country')}
                                            </label>
                                            <div class="row">
                                                <div class="col-md-12">   
                                                    <select name="country" id="country" tabindex="10" onChange="getAllStates(this.value, 'user');" class="form-control">
                                                        {$countries}
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div id="prof_state_div">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">
                                                    {lang('state')}
                                                </label>
                                                <div class="row">
                                                    <div class="col-md-12"> 

                                                        <select name="state" id="state" tabindex="11" class="form-control">
                                                            {$state}
                                                        </select>                                    
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>

                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-group">

                                            <label class="control-label">{lang('city')}</label> <span class="symbol required"></span>
                                            <input class="form-control"  name="city" id="city" type="text"  size="22" maxlength="20" autocomplete="Off" tabindex="12" value="{$details["detail1"]["user_detail_city"]}"/>{form_error('city')}

                                        </div>
                                    </div>            


                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">{lang('zip_code')} </label> <span class="symbol required"></span>

                                            <input  class="form-control" name="pin" id="pin" type="text" tabindex="12" size="8" maxlength="6" value="{$details["detail1"]["pincode"]}" />{form_error('pin')}

                                        </div>
                                    </div>




                                </div>
                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {lang('mob_no_10_digit')}<span class="symbol required"></span>

                                            <input class="form-control"  name="mobile" id="mobile" type="text" tabindex="13" size="22" maxlength="20" autocomplete="Off" value="{$details["detail1"]["mobile"]}"/>{form_error('mobile')}


                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">{lang('land_line_no')} </label>

                                            <input class="form-control" name="land_line"  id="land_line"  type="text" tabindex="15" size="22" maxlength="20" value="{$details["detail1"]["land"]}" />

                                        </div>
                                    </div>

                                </div>



                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Passport ID<span class="symbol required"></span></label>

                                            <input class="form-control" name="passport_id"  id="passport_id" type="text" tabindex="16" size="22" maxlength="100" autocomplete="Off" value="{$details["detail1"]["passport_id"]}" /><span class='validation_error'>{form_error('passport_id')}</span>

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Expiry date of ID<span class="symbol required"></span></label>

                                            <input class="form-control date-picker" name="id_expire"  id="id_expire" type="text" tabindex="16" size="22" maxlength="100" autocomplete="Off" value="{$details["detail1"]["id_expire"]}" /><span class='validation_error'>{form_error('id_expire')}</span>

                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">{lang('email')}<span class="symbol required"></span></label>

                                            <input class="form-control" name="email"  id="email" type="text" tabindex="16" size="22" maxlength="100" autocomplete="Off" value="{$details["detail1"]["email"]}" /><span class='validation_error'>{form_error('email')}</span>

                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-12">
                                        <h3> {lang('bank_info')}</h3>
                                        <hr>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">
                                                {lang('bank_name')}
                                            </label>

                                            <input class="form-control" value="{$details["detail1"]["nbank"]}" type="text"  name="bank_name" maxlength="32" id="bank_name" tabindex="17">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">
                                                {lang('branch_name')}
                                            </label>

                                            <input class="form-control" value="{$details["detail1"]["nbranch"]}" type="text" name="bank_branch" maxlength="32" id="bank_branch" tabindex="18">
                                        </div>
                                    </div>  
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">
                                                IBAN/Account Nr.
                                            </label>

                                            <input class="form-control" value="{$details["detail1"]["acnumber"]}" type="text" name="bank_acc_no" id="bank_acc_no" maxlength="32" tabindex="19">
                                        </div>
                                    </div> 

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">
                                                Swift Code
                                            </label>             

                                            <input type="text" value="{$details["detail1"]["ifsc"]}" class="form-control" name="ifsc" id="ifsc" maxlength="32" tabindex="20">
                                        </div>
                                    </div>               

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">
                                                Bank Country
                                            </label>             

                                            <input type="text" value="{$details["detail1"]["bank_country"]}" class="form-control" name="bank_country" id="bank_country" accept="text" maxlength="32" tabindex="21">
                                        </div>
                                    </div>





                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <h3>{lang('social_profiles')}</h3>
                                        <hr>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">
                                                {lang('facebook')}
                                            </label>
                                            <input type="text" placeholder="{$details["detail1"]["facebook"]}" value="{$details["detail1"]["facebook"]}" class="form-control" name="facebook"  id="facebook" tabindex="22"><font size = "1" color = "red"><b>Eg: https://www.facebook.com/example </b></font>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">
                                                {lang('twitter')}
                                            </label>

                                            <input type="text" placeholder="{$details["detail1"]["twitter"]}" value="{$details["detail1"]["twitter"]}" class="form-control"  name="twitter"  id="twitter" tabindex="23"><font size = "1" color = "red">&nbsp;<b>Eg: https://twitter.com/#!/example </b></font>
                                        </div>
                                    </div>
                                </div>
                                        
                                        <div class="row">
                            <div class="col-md-12">
                                <h3>Tax-Data</h3>
                                <hr>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        Tax ID
                                    </label>
                                    <input type="text" value="{$details["detail1"]["tax-id"]}" class="form-control" name="tax-id"  id="tax-id" maxlength="32"  tabindex="24">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        Tax Number
                                    </label>
                                    <input type="text" value="{$details["detail1"]["tax-number"]}" class="form-control"  name="tax-number"  id="tax-number" maxlength="32"  tabindex="25">
                                </div>
                            </div>
                        </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div><span class="symbol required"></span>
                                            {lang('required_fields')}
                                            <hr>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8">
                                        <p>
                                            {lang('term')}
                                        </p>
                                    </div>
                                    <div class="col-md-4">
                                        <button class="btn btn-bricky" type="submit" name="update_profile"  id="update_profile" value="update_profile" tabindex="23">
                                            {lang('update_profile')} <i class="fa fa-arrow-circle-right"></i>
                                        </button>
                                    </div>
                                </div>
                                {form_close()}
                            </div>

                            {*     {if $MLM_PLAN!= "Board"}
                            <div id="panel_edit_network" class="tab-pane{$tab3}">
            
                            <form role="form" method="post" name="user_register1" id="user_register1" action="{$BASE_URL}user/profile/profile_view" enctype="multipart/form-data" >     
                            <div class="col-md-12">
                            <div class="errorHandler alert alert-danger no-display">
                            <i class="fa fa-times-sign"></i> {lang('errors_check')}
                            </div>
                            </div>
                            <input type="hidden" name="path" id="path" value="{$PATH_TO_ROOT_DOMAIN}">
                            <input type="hidden" name="lang_id" id="lang_id" value="{$lang_id}">
    
    
                            <div class="row">
                            <div class="col-md-12">
                            <h3>{lang('edit_network_info')} : {$u_name}</h3>
                            <hr>
                            </div>


                            <div class="row">
                            <div class="form-group">

                            <label class="col-sm-2 col-sm-offset-1 control-label" for="network">{lang('position')} :<font color="#ff0000">*</font></label>
                            <div class="col-sm-3">
                            <select name="network" id="network" tabindex="2" onChange="" class="form-control" >  
                            {if  {$position}=='L'}
                            <option value="L" selected="selected" >{lang('left')}</option>
                            <option value="R">{lang('right')}</option>
                            <option value="Balanced">{lang('balanced')}</option>
                            {elseif {$position}=='R'}
                            <option value="R" selected="selected"  >{lang('right')}</option>
                            <option value="L" >{lang('left')}</option>
                            <option value="Balanced">{lang('balanced')}</option>
                            {elseif {$position}=='Balanced'}
                            <option value="Balanced" selected="selected"  >{lang('balanced')}</option>
                            <option value="L" >{lang('left')}</option>
                            <option value="R">{lang('right')}</option>

                            {/if}
                            </select>

                            </div>
                            </div>
                            </div> 
                            <div class="form-group">
                            <div class="col-sm-8 col-sm-offset-2">
                            <br/>
                            <button class="btn btn-bricky" type="submit" name="update_network2"  id="update_network2" value="update_network2" tabindex="3" >
                            {lang('update_network')} 
                            </button>
                            </div> 
                            </div>
                            </div>
                            </form>
                            </div>
                            {/if}*}
                        </div>
                    </div>
                </div>
            </div>
            {include file="user/layout/themes/{$USER_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
            <script>
                jQuery(document).ready(function () {
                    Main.init();
                    ValidateUser.init();
                     DatePicker.init();
           
                });
            </script>
            {include file="user/layout/themes/{$USER_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}