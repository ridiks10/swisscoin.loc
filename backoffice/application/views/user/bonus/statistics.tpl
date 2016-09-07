{include file="user/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}
{if $LOG_USER_TYPE!='employee'}
    <!-- start: PAGE CONTENT -->

    <style>
        .dash01
        {
            min-height: 115px;
            background-color: #02A8F3;
        }
        .dashft
        {
            min-height: 30px;
            background-color: #0297DA;
            padding-top: 5px;
        }
        .dashft p{
            color: #fff;
            padding-left: 15px;
            font-size: 14px;
        }
        .dashtx{
            float: left;
        }  
        .dashtx h4{
            color: rgba(255, 255, 255, 0.57);
            padding-left: 15px;
        }
        .dashtx p{
            color: #fff;
            padding-left: 15px;
            font-size: 18px;
        }
        .dashicon{
            float:right;
            color: rgba(255, 255, 255, 0.57);
            margin-top: 25px;
            margin-right: 20px;
            font-size: 32px;
        }
    </style>



    <div class="row">
        <div class="col-sm-6 sm-fifty">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="clip-stats"></i>
                    {lang('joinings')}
                    <div class="panel-tools">
                        <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                        </a>
                        <a class="btn btn-xs btn-link panel-config" href="#panel-config" data-toggle="modal">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <a class="btn btn-xs btn-link panel-refresh" href="#">
                            <i class="fa fa-refresh"></i>
                        </a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="flot-medium-container">
                        <div id="placeholder-h1" class="flot-placeholder"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 sm-fifty">
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="clip-pie"></i>
                            {lang('payout')}
                            <div class="panel-tools">
                                <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                                </a>
                                <a class="btn btn-xs btn-link panel-config" href="#panel-config" data-toggle="modal">
                                    <i class="fa fa-wrench"></i>
                                </a>
                                <a class="btn btn-xs btn-link panel-refresh" href="#">
                                    <i class="fa fa-refresh"></i>
                                </a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="flot-medium-container">
                                <div id="placeholder-h2" class="flot-placeholder"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
{/if}
{*!-- end: PAGE CONTENT--*}
{include file="user/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}

<script>
    var Index = function () {
        // function to initiate Chart 1
        var runChart1 = function () {
            var pageviews = [
    {assign var=array_count value=$joining_details_per_month|@count}
    {foreach from=$joining_details_per_month key=k item=i}

            [{$k}, {$i.joining}]
        {if $array_count != $k}
            ,
        {/if}

    {/foreach}
            ];
                    var plot = $.plot($("#placeholder-h1"), [{
                            data: pageviews,
                            label: ""
                        }], {
                        series: {
                            lines: {
                                show: true,
                                lineWidth: 2,
                                fill: true,
                                fillColor: {
                                    colors: [{
                                            opacity: 0.08
                                        }, {
                                            opacity: 0.01
                                        }]
                                }
                            },
                            points: {
                                show: true
                            },
                            bars: {
                                show: false
                            },
                            shadowSize: 2
                        },
                        grid: {
                            hoverable: true,
                            clickable: true,
                            tickColor: "#eee",
                            borderWidth: 0
                        },
                        colors: ["#d12610", "#37b7f3", "#52e136"],
                        xaxis: {
                            ticks: [[1, "Jan"], [2, "Feb"], [3, "Mar"], [4, "Apr"], [5, "May"], [6, "Jun"], [7, "Jul"], [8, "Aug"], [9, "Sep"], [10, "Oct"], [11, "Nov"], [12, "Dec"]],
                        },
                        yaxis: {
                            ticks: 15,
                            tickDecimals: 0
                        }
                    });

            function showTooltip(x, y, contents) {
                $('<div id="tooltip">' + contents + '</div>').css({
                    position: 'absolute',
                    display: 'none',
                    top: y + 5,
                    left: x + 15,
                    border: '1px solid #333',
                    padding: '4px',
                    color: '#fff',
                    'border-radius': '3px',
                    'background-color': '#333',
                    opacity: 0.80
                }).appendTo("body").fadeIn(200);
            }
            var previousPoint = null;
            $("#placeholder-h1").bind("plothover", function (event, pos, item) {
                $("#x").text(pos.x.toFixed(2));
                $("#y").text(pos.y.toFixed(2));
                if (item) {
                    if (previousPoint != item.dataIndex) {
                        previousPoint = item.dataIndex;
                        $("#tooltip").remove();
                        var x = item.datapoint[0].toFixed(2),
                                y = item.datapoint[1];
                        var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
                        showTooltip(item.pageX, item.pageY, item.series.label + monthNames[x - 1] + " : " + y);
                    }
                } else {
                    $("#tooltip").remove();
                    previousPoint = null;
                }
            });
        };
        // function to initiate Chart 2
        var runChart2 = function () {
            var data_pie = [];

            data_pie[0] = {
                label: "{lang('released_amount')}",
                data: {$released_payouts_percentage}
            },
            data_pie[1] = {
                label: "{lang('pending_amount')}",
                data: {$pending_payouts_percentage},
            };

            $.plot('#placeholder-h2', data_pie, {
                series: {
                    pie: {
                        show: true,
                        radius: 1,
                        tilt: 0.5,
                        label: {
                            show: true,
                            radius: 1,
                            formatter: labelFormatter,
                            background: {
                                opacity: 0.8
                            }
                        },
                        combine: {
                            color: '#999',
                            threshold: 0.1
                        }
                    }
                },
                legend: {
                    show: false
                }
            });

            function labelFormatter(label, series) {
                return "<div style='font-size:8pt; text-align:center; padding:2px; color:white;'>" + label + "<br/>" + Math.round(series.percent) + "%</div>";
            }
        };


        return {
            init: function () {
                runChart1();
                runChart2();
            }
        };
    }();
</script>

<script>
    jQuery(document).ready(function () {
        Main.init();
        Index.init();
        $(".core-box").addClass("slideUp");
        $(".badge").addClass("fadeIn");
        //$(".panel").addClass("bigEntrance");
    });
</script>
{include file="user/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}