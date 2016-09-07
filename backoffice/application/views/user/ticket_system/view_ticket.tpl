
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-file"></i>
                <div class="panel-tools">
                  
                </div>
                {lang('view_tickets')}
            </div>
            <div class="panel-body">
             {*   <form role="form" class="smart-wizard form-horizontal"  name="compose" id="view_ticket_form" method="post" action="" enctype="multipart/form-data">*}
                     {form_open_multipart('', 'role="form" class="smart-wizard form-horizontal"  method="post"  name="compose" id="view_ticket_form"')}
                    <div class="col-md-12">
                        <div class="errorHandler alert alert-danger no-display">
                            <i class="fa fa-times-sign"></i> {lang('errors_check')}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            {lang('ticket')} ID  <span class="symbol required"></span>
                        </label>
                        <div class="col-sm-3">
                            <input  class="form-control" name="ticket" id="ticket" type="text" tabindex='10' size="8"  placeholder=""  />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2 col-sm-offset-2">
                            <button class="btn btn-bricky" type="submit" id="view2" value="view" name="view" tabindex="3">View</button>
                        </div>
                    </div>
                       
                {form_close()}

            </div>
        </div>
    </div>

</div>

