<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>{lang('user_account')}
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
            <div class="row">
                <div class="col-sm-12">                   
                    <div class="panel-body">
                        {form_open_multipart('','role="form" class="smart-wizard form-horizontal" name="searchform" id="searchform" action="" method="post"')}
                            <div class="col-md-12">
                                <div class="errorHandler alert alert-danger no-display">
                                    <i class="fa fa-times-sign"></i> {lang('errors_check')}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="user_name"> {lang('select_user_name')}:<font color="#ff0000" >*</font> </label>
                                <div class="col-sm-3">
                                    <input  name="user_name" id="user_name" type="text" size="30" onkeyup="ajax_showOptions(this, 'getCountriesByLetter', event)" autocomplete="off" tabindex="1">
                                    <span class="help-block" for="user_name"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-2 col-sm-offset-2">
                                    <button class="btn btn-bricky" type="submit" id="user_details" value="user_details" name="user_details" tabindex="2">
                                        {lang('view')}
                                    </button>
                                </div>
                            </div>
                        {form_close()}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 