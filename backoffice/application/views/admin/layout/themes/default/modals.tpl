
<div class="modal fade" id="panel-config" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" >
                    &times;
                </button>
                <h4 class="modal-title">{lang('terms_and_conditions')}</h4>
            </div>
            <div class="modal-body">
                <table cellpadding="0" cellspacing="0" align="center">
                    <tr>
                        <td width="95%" id="terms-content">
                            {$TERMCONDITIONS}
                        </td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="impressum-config" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" >
                    &times;
                </button>
                <h4 class="modal-title">{lang('impressum')}</h4>
            </div>
            <div class="modal-body">
                <table cellpadding="0" cellspacing="0" align="center">
                    <tr>
                        <td width="95%" id="terms-content">
                            {$IMPRESSUM}
                        </td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>