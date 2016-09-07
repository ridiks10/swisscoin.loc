<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>{lang('User_account')}
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
                <div class="col-sm-12"><div class="center">
                        {if !$is_valid_user_name}
                            <h4 align="center"><font color="#FF0000">{lang('Username_not_Exists')}</font></h4>
                            {else}
                        </div>
                        {if count($user_detail)!=0}
                            <div class="panel-body">
                                {assign var="k" value ="0"}
                                {assign var="class" value =""}

                                <div class="col-sm-12">
                                    <div class="col-sm-4">
                                        <div class="fileupload-new thumbnail" style=""><img src="{$PUBLIC_URL}images/profile_picture/{$file_name}" alt="" style="width:60%">
                                        </div>
                                    </div>

                                    <div class="col-sm-5">
                                        <table class="table table-hover" style="">
                                            <thead></thead>
                                            <tbody>
                                                <tr><td>{lang('user_name')}<td>: </td><td>{$user_name}</td></tr>
                                                <tr><td>{lang('first_name')}<td>:</td><td>{$user_detail['name']}</td></tr>
                                                <tr><td>{lang('last_name')}<td>:</td><td>{$user_detail['second_name']}</td></tr>
                                                <tr><td>{lang('date_of_birth')}  <td>:</td><td> {$user_detail['dob']}</td></tr>
                                                <tr><td>{lang('gender')}  <td>:</td><td> {if $user_detail['gender'] == "M"}Male{else}Female{/if}</td></tr>
                                                <tr><td>{lang('mobile_no')}  <td>:</td><td> {$user_detail['mobile']}</td></tr>
                                                <tr><td>{lang('email')}  <td>:</td><td> {$user_detail['email']}</td></tr>
                                            </tbody>
                                        </table>

                                    </div>

                                    <div class="col-sm-3 listitemsbtns">
                                        {assign var="i" value ="0"}
                                        <ul style="list-style:none;margin:0;padding:0;">
                                            <li>
                                                {form_open('admin/profile/profile_view', 'method="post"')}
                                                    <input type="hidden" name="user_name" value="{$user_name}" />
                                                    <input type="hidden" name="from_page" id="from_page" value="user_account" />
                                                    <button type="submit" name="profile_view" class="btn btn-bricky top-btn" value="profile_view" style="min-width: 247px;">{lang('view_profile')}</button>
                                                {form_close()}
                                                {$i=$i+1}{if $i%3==0}</li><li>{/if}
                                                {if $MLM_PLAN == "Binary"}    
                                                    {form_open('admin/leg_count/view_leg_count', 'method="post"')}
                                                        <button type="submit" name="user_name" class="btn btn-bricky top-btn" value="{$user_name}"style="min-width: 247px;">{lang('view_commission_details')}</button>
                                                    {form_close()}
                                                {else if $MLM_PLAN=="Matrix"}
                                                    {*<form action="../leg_count_commission/view_leg_count"  method="post">
                                                        <button type="submit" name="user_name" class="btn btn-bricky top-btn" value="{$user_name}"style="min-width: 247px;">{lang('view_commission_details')}</button> 
                                                    </form>*}
                                                {/if}
                                                {$i=$i+1}{if $i%3==0}</li><li>{/if}
                                                {form_open('admin/income_details/income', 'method="post"')}
                                                    <button type="submit" name="user_name" class="btn btn-bricky top-btn" value="{$user_name}"style="min-width: 247px;">{lang('view_income_details')}</button>
                                                {form_close()}
                                                {$i=$i+1}{if $i%3==0}</li><li>{/if}
                                                {if $referal_status=="yes"}
                                                    {form_open('admin/configuration/my_referal', 'method="post"')}
                                                        <button type="submit" name="user_name" class="btn btn-bricky top-btn" value="{$user_name}"style="min-width: 247px;">{lang('view_refferal_details')}</button>
                                                    {form_close()}
                                                    {$i=$i+1}{if $i%3==0}</li><li>{/if}
                                                {/if}
                                                {if $ewallet_status=="yes"}
                                                    {form_open('admin/ewallet/my_ewallet', 'method="post"')}
                                                        <button type="submit" name="user_name" class="btn btn-bricky top-btn" value="{$user_name}"style="min-width: 247px;">{lang('view_ewallet_details')}</button>
                                                    {form_close()}
                                                    {$i=$i+1}{if $i%3==0}</li><li>{/if}
                                                {/if}
                                                {if $pin_status=="yes"}
                                                    {form_open('admin/epin/view_pin_user', 'method="post"')}
                                                        <button type="submit" name="user_name" class="btn btn-bricky top-btn" value="{$user_name}"style="min-width: 247px;">{lang('view_user_epin')}</button>
                                                    {form_close()}
                                                    {$i=$i+1}{if $i%3==0}</li><li>{/if}
                                                {/if}
                                                    {form_open('admin/payout/my_income', 'method="post"')}
                                                    <button type="submit" name="user_name" class="btn btn-bricky top-btn" value="{$user_name}"style="min-width: 247px;">{lang('view_income_statement')}</button>
                                                    {form_close()}
                                                        {$i=$i+1}{if $i%3==0}</li><li>{/if}
                                        </ul>
                                    </div>
                                </div>

                            </div>
                        {/if}
                    {/if}
                </div>
            </div>
        </div>
        {*/if*}
    </div>
</div>

