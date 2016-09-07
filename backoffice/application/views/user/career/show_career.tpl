{include file="user/layout/themes/{$USER_THEME_FOLDER}/header.tpl"  name=""}

 <div class="row">
        <div class="col-sm-12">
           
            <div class="panel panel-default text-center">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-6">{lang('careers_bv')}: <span class="text-info" id="user_bv">{$user_bv}</span></div>
                        <div class="col-sm-6">{lang('careers_rank')}: <span class="text-info" id="user_rank">{$user_rank}</span><span style="margin-left: 15px;cursor:pointer;" id="refresh_stats" class="glyphicon glyphicon-refresh"></span></div>
                    </div>
                </div>
            </div>
            
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
                                <th width='15%'> {lang('leadership_badge')}</th>
                                <th width='15%'>{lang('leadership_rank')}</th>
                                <th width='40%'>{lang('leadership_award')}</th>
                                <th width='10%'>{lang('qualifying_bv')} </th>
                               {* <th>{lang('qualifying_weeker_leg_bv')}</th>*}
                                <th width='15%'>{lang('qualifying_terms')}</th>
                            </tr>
                        </thead>
                        {if count($career_details)>0}
                            <tbody>
                                {$balance = 0}
                                {assign var="i" value=0}
                                {foreach from=$career_details item=v}
                                    
                                    <tr>
                                        {$i=$i+1}
                                        <td {*style="background-color: black;color: white;"*}>{$i}</td>
                                        <td {*style="background-color: black;"*}><img src="{$PUBLIC_URL}images/careers/{$v.image_name}" style="width:80px;height:80px;"></td>
                                        <td {*style="background-color: black;color: white;"*}>{$v.leadership_rank}</td>
                                        <td {*style="background-color: black;color: white;"*}>{$v.leadership_award}</td>
                                        <td {*style="background-color: black;color: white;"*}>{$v.qualifying_personal_pv}</td>
                                       {* <td style="background-color: black;color: white;">{$v.qualifying_weaker_leg_bv}</td>*}
                                        <td {*style="background-color: black;color: white;"*}>{$v.qualifying_terms}</td>
                                        
                                        
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




{include file="user/layout/themes/{$USER_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function ($) {

        var processing = false,
            degree     = 0,
            $button    = $('#refresh_stats'),
            timer;

        function rotate() {

            $button.css({ WebkitTransform: 'rotate(' + degree + 'deg)'});
            $button.css({ '-moz-transform': 'rotate(' + degree + 'deg)'});
            timer = setTimeout(function() {
                ++degree; rotate();
            },5);
        }

        $button.click(function () {
            if( processing )
                return;
            processing = true;
            $.ajax({
                method: 'GET',
                dataType: 'JSON',
                url: '{$USER_AJAX_URL}/update_career_stats',
                beforeSend: function () {
                    rotate();
                },
                success: function (res) {
                    processing = false;
                    clearTimeout(timer);
                    if( res ) {
                        $('#user_bv').empty().text(res.aq_team_bv);
                        $('#user_rank').empty().text( res.career );
                    }
                },
                error: function () {
                    processing = false;
                    clearTimeout(timer);
                }
            });
        });

    });
</script>
<script>
    jQuery(document).ready(function() {
        Main.init();
        TableData.init();
        ValidateUser.init();
        DateTimePicker.init();
    });
</script>

{include file="user/layout/themes/{$USER_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}