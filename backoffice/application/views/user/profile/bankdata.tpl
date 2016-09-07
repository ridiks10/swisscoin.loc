{include file="user/layout/themes/{$USER_THEME_FOLDER}/header.tpl"  name=""}

<div id="span_js_messages" style="display:none;">
    <span id="error_msg1">{lang('please_enter_bankname')}</span> 
    <span id="error_msg2">{lang('please_enter_branch_name')}</span>        
    <span id="error_msg3">{lang('please_enter_ifsc')}</span>  
    <span id="error_msg4">{lang('please_enter_acc_no')}</span>
    <span id="error_msg5">{lang('special_chars_not_allowed')}</span>
    <span id="error_msg6">{lang('digits_only')}</span>

</div>      

<style>
    .val-error {
        color:rgba(249, 6, 6, 1);
        {*		    transition-delay:0s;*}
        opacity:1;
    }
</style>


<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
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
                {lang('verify_bankdata')}
            </div>
            <div class="panel-body">

               
                <div class="col-md-12">
                    <div class="errorHandler alert alert-danger no-display">
                        <i class="fa fa-times-sign"></i> {lang('errors_check')}.
                    </div>
                </div>
                <div class="form-group col-sm-12">
                   <h4> Your documents must fulfill the following requitement</h4>
                    <p style="font-size: 15px;">
                    • As Proof of Identity is acceatable only copy of National ID Card/Passport or International Passport
                    <br>• As Proof of Reudency  is acceptable only copy of Utili Bill (gas, electricty) or Bank Statement if the address is shown. The documents must be from ore last 6 months
                    <br>• Acceptable documents formats are PDF,JPEG and PNG
                    <br>• Documents must be in English or written with Latin  letters
                    <br> • Your full name and full address must appear on the document uploaded as a Proof of Address
                    <br>• All details filled in SWISSCOIN on menu Profile , Matn informatron as name, address country, ID name ,expiry date. etc must exactly matcn the details shown on the uploaded documents
                    <br> • If the Passport/national ID card number contains letters and numbers fill in boath not only the numbers
                    <br>• Once uploaded the document can not be deleted. but upon new uploading the files replaced
                    <br> • Please Chose Oc user Whose KYC documents to be uploaded on your profile Only users with approved KYC  documents can be used
                    <br>
                    <br> Please note that  you would be allowed to upload the documents only  after all fields on menu Profile-Main information are filled in
                    </p>
                </div>
               {* <div class="form-group col-sm-8">
                    <div class="col-sm-8 col-sm-offset-4">


                        <button class="btn btn-bricky" type="submit" name="save"  id="save" value="{lang('save')}" tabindex="5">{{lang('save')}}</button>
                    </div>
                </div>*}

            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
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
                KYC
            </div>
            <div class="panel-body">

               
                <div class="col-md-12">
                    <div class="errorHandler alert alert-danger no-display">
                        <i class="fa fa-times-sign"></i> {lang('errors_check')}.
                    </div>
                </div>
                {form_open_multipart('','role="form" class="smart-wizard form-horizontal"  name="upload_kyc" id="upload_kyc"')} 
                <div class="form-group col-sm-12 ">
                   <h4> ID/PASSPORT</h4>
                   
                   
                   <div class="form-group">
                   
                    <div class="col-sm-12 ">
                        <div class="fileupload fileupload-new " data-provides="fileupload" >
                           
                            <div class="fileupload-preview fileupload" ></div>
                            <div class="user-edit-image-buttons">
                                <span class="btn btn-light-grey btn-file"><span class="fileupload-new"><i class="fa fa-picture"></i>{lang('file_upload')}</span><span class="fileupload-exists"><i class="fa fa-picture"></i> Change</span>

                                    <input type="file" id="passport" name="passport" tabindex="2" value="" >
                                </span>
                                <a href="#" class="btn fileupload-exists btn-light-grey" data-dismiss="fileupload">
                                    <i class="fa fa-times"></i>Remove
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                   
              <br>
                   <h4>PROOF OF ADDRESS</h4>
                   
                   <div class="form-group">
                   
                    <div class="col-sm-12">
                        <div class="fileupload fileupload-new " data-provides="fileupload" >
                           
                            <div class="fileupload-preview fileupload" ></div>
                            <div class="user-edit-image-buttons">
                                <span class="btn btn-light-grey btn-file"><span class="fileupload-new"><i class="fa fa-picture"></i>{lang('file_upload')}</span><span class="fileupload-exists"><i class="fa fa-picture"></i> Change</span>

                                    <input type="file" id="address" name="address" tabindex="2" value="" >
                                </span>
                                <a href="#" class="btn fileupload-exists btn-light-grey" data-dismiss="fileupload">
                                    <i class="fa fa-times"></i>Remove
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                   
                   <div  style="color:gray;font-style: italic; font-size:15px;">(max size:2MB  file formats support:gif,jpg,png,jpeg)</div>
                   
                </div>
                <div class="form-group col-sm-12">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-6">


                        <button class="btn btn-bricky" type="submit" name="upload"  id="upload" value="upload" tabindex="5">{lang('upload')}</button>
                    </div>
                    <div class="col-sm-3"></div>
                </div>
                {form_close()}

            </div>
        </div>
    </div>
</div>

{include file="user/layout/themes/{$USER_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}

<script>
    jQuery(document).ready(function () {
        Main.init();
        // ValidateBanking.init();
    });
</script>
{include file="user/layout/themes/{$USER_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}
