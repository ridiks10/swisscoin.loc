
<link href="{$PUBLIC_URL}css/mail_box.css" rel="stylesheet" type="text/css" />
<link href="{$PUBLIC_URL}css/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="//code.jquery.com/ui/1.11.1/jquery-ui.min.js" type="text/javascript"></script>
<script src="{$PUBLIC_URL}javascript/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js" type="text/javascript"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  
   
<div class="col-md-3 col-sm-4">

    <!-- compose message btn -->
    <a class="btn btn-block btn-primary" href="{$BASE_URL}admin/mail/compose_mail"><i class="fa fa-pencil"></i> {lang('compose_mail')}</a>
    <!-- Navigation - folders-->
    <div style="margin-top: 15px;">
        <ul class="nav nav-pills nav-stacked">
            <li class="header">{lang('folders')}</li>
            <li {if $CURRENT_URL=="mail/mail_management"}class="active"{/if}><a href="{$BASE_URL}admin/mail/mail_management"><i class="fa fa-inbox"></i> {lang('inbox')}{if $unread_mail>0}({$unread_mail}){/if}</a></li>

            <li {if $CURRENT_URL=="mail/mail_sent"}class="active"{/if}><a href="{$BASE_URL}admin/mail/mail_sent"><i class="fa fa-mail-forward"></i>  {lang('sent')}</a></li>


        </ul>
    </div>
</div><!-- /.col (LEFT) -->