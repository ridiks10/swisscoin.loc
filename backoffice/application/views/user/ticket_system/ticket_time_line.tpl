{include file="user/layout/themes/{$USER_THEME_FOLDER}/header.tpl" name=""}
<style>


    h2 {
        margin-bottom: 30px;
        color: #4679bd;
        font-weight: 400;
        text-align: center;
    }

    p.footer {
        margin-bottom: 20px;
        color: #999999;
        font-size: 18px;
        text-align: center;
    }


    .timeline {
        list-style: none;
        padding: 10px 0;
        position: relative;
        font-weight: 300;
        overflow: hidden;

    }
    .timeline:before {
        top: 0;
        bottom: 0;
        position: absolute;
        content:" ";
        width: 2px;
        background: rgb(237, 237, 237) none repeat scroll 0% 0%;
        left: 50%;
        margin-left: -1.5px;
    }


    .timeline > li {
        margin-bottom: 20px;
        position: relative;
        width: 50%;
        float: left;
        clear: left;
    }
    .timeline > li:before, .timeline > li:after {
        content:" ";
        display: table;
    }
    .timeline > li:after {
        clear: both;
    }
    .timeline > li:before, .timeline > li:after {
        content:" ";
        display: table;
    }
    .timeline > li:after {
        clear: both;
    }
    .timeline > li > .timeline-panel {
        width: calc(100% - 25px);
        width: -moz-calc(100% - 25px);
        width: -webkit-calc(100% - 25px);
        float: left;
        border: 1px solid #dcdcdc;
        background: #ffffff;
        position: relative;
    }
    .timeline > li > .timeline-panel:before {
        position: absolute;
        top: 26px;
        right: -15px;
        display: inline-block;
        border-top: 15px solid transparent;
        border-left: 15px solid #dcdcdc;
        border-right: 0 solid #dcdcdc;
        border-bottom: 15px solid transparent;
        content:" ";
    }
    .timeline > li > .timeline-panel:after {
        position: absolute;
        top: 27px;
        right: -14px;
        display: inline-block;
        border-top: 14px solid transparent;
        border-left: 14px solid #ffffff;
        border-right: 0 solid #ffffff;
        border-bottom: 14px solid transparent;
        content:" ";
    }
    .timeline > li > .timeline-badge {
        color: #ffffff;
        width: 24px;
        height: 24px;
        line-height: 50px;
        text-align: center;
        position: absolute;
        top: 16px;
        right: -12px;
        z-index: 100;
    }
    .timeline > li.timeline-inverted > .timeline-panel {
        float: right;
    }
    .timeline > li.timeline-inverted > .timeline-panel:before {
        border-left-width: 0;
        border-right-width: 15px;
        left: -15px;
        right: auto;
    }
    .timeline > li.timeline-inverted > .timeline-panel:after {
        border-left-width: 0;
        border-right-width: 14px;
        left: -14px;
        right: auto;
    }
    .timeline-badge > a {
        color: #e6e6e6 !important;
    }
    .timeline-badge a:hover {
        color: #dcdcdc !important;
    }
    .timeline-title {
        margin-top: 0;
        color: inherit;
    }
    .timeline-heading h4 {
        font-weight: 400;
        padding: 0 15px;
        color: #4679bd;
    }
    .timeline-body > p, .timeline-body > ul {
        padding: 10px 15px;
        margin-bottom: 0;
    }
    .timeline-footer {
        padding: 5px 15px;
        background-color:#f4f4f4;
    }
    .timeline-footer p { margin-bottom: 0; }
    .timeline-footer > a {
        cursor: pointer;
        text-decoration: none;
    }
    .timeline > li.timeline-inverted {
        float: right;
        clear: right;
    }
    .timeline > li:nth-child(2) {
        margin-top: 60px;
    }
    .timeline > li.timeline-inverted > .timeline-badge {
        left: -12px;
    }
    .no-float {
        float: none !important;
    }
    @media (max-width: 767px) {
        ul.timeline:before {
            left: 40px;
        }
        ul.timeline > li {
            margin-bottom: 0px;
            position: relative;
            width:100%;
            float: left;
            clear: left;
        }
        ul.timeline > li > .timeline-panel {
            width: calc(100% - 65px);
            width: -moz-calc(100% - 65px);
            width: -webkit-calc(100% - 65px);
        }
        ul.timeline > li > .timeline-badge {
            left: 28px;
            margin-left: 0;
            top: 16px;
        }
        ul.timeline > li > .timeline-panel {
            float: right;
        }
        ul.timeline > li > .timeline-panel:before {
            border-left-width: 0;
            border-right-width: 15px;
            left: -15px;
            right: auto;
        }
        ul.timeline > li > .timeline-panel:after {
            border-left-width: 0;
            border-right-width: 14px;
            left: -14px;
            right: auto;
        }
        .timeline > li.timeline-inverted {
            float: left;
            clear: left;
            margin-top: 30px;
            margin-bottom: 30px;
        }
        .timeline > li.timeline-inverted > .timeline-badge {
            left: 28px;
        }
    }
</style>

<div class="row">
    <div class="col-sm-12">
        <div style="text-align:right;">

            <a href="{$BASE_URL}user/ticket_system/my_ticket"> <font  style="font-weight: bold; font-size: 15px">Back</font></a>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-ticket"></i>{lang('ticket')} - <strong>{$ticket_id}</strong>

            </div>
            <div class="panel-body">
                {if $count > 0} 

                    <ul class="timeline">
                        {assign var="i" value="0"}
                        {foreach from=$activity_history item=v}
                            {if $i%2==0}
                                <li>
                                    <div class="timeline-badge">
                                        <a><i class="fa fa-circle invert" id=""></i></a>
                                    </div>
                                    <div class="timeline-panel">

                                        <div class="timeline-body">
                                            <p>{$v.activity}{if $v.comments!=""} : " {$v.comments} "{/if}</p>
                                            <p>Done By : {$v.done_by}</p>

                                        </div>
                                        <div class="timeline-footer">
                                            <p class="text-right">{$v.date}</p>
                                        </div>
                                    </div>
                                </li>
                            {else}
                                <li class="timeline-inverted">
                                    <div class="timeline-badge">
                                        <a><i class="fa fa-circle invert" id=""></i></a>
                                    </div>
                                    <div class="timeline-panel">

                                        <div class="timeline-body">
                                            <p>{$v.activity}{if $v.comments!=""} : " {$v.comments} "{/if}</p>
                                            <p>Done By : {$v.done_by}</p>
                                        </div>
                                        <div class="timeline-footer">
                                            <p class="text-right">{$v.date}</p>
                                        </div>
                                    </div>
                                </li>
                            {/if}
                            {$i=$i+1}
                        {/foreach}
                    {else}
                        <h3>{$tran_no_details_found}</h3>
                    {/if}    
                </ul>  
                {if $ticket_status!="Resolved"}
                    <div class="col-sm-6 col-sm-offset-5">                         

                        <a href="{$BASE_URL}user/ticket_system/view_ticket_details/{$v.ticket_id}" target="_blank"> <button class="btn btn-bricky blue" type="submit" name="reply"  id="referal_details" value="" style="width:25%;">Reply</button></a>

                    </div>
                {/if}

            </div> 
        </div> 
    </div> 
</div>
{include file="user/layout/themes/{$USER_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function () {
    });
</script>
{include file="user/layout/themes/{$USER_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}