{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}




<div class="row">

    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>User details
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

                <center>
                    <h3>Package detailed stats</h3>
                </center>
                <canvas id="myChart">

                </canvas>
            </div>
        </div>
    </div>
</div>

<!-- end: PAGE CONTENT -->
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function () {
        Main.init();

    });

</script>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}

<script>
    jQuery(document).ready( function () {
        $.ajax({
            method: 'GET',
            dataType: 'JSON',
            url: '{$ADMIN_AJAX_URL}/packages_stats',
            beforeSend: function () {
                //rotate();
            },
            success: function (res) {
                printChart(res);
            },
            error: function () {

            }
        });

    });

    function printChart( $lines ) {
        var ctx = document.getElementById("myChart").getContext("2d");
        var scatterChart = new Chart(ctx, {
            type: 'line',
            data: $lines,
            options: {
                scales: {
                    xAxes: [{
                       // type: 'linear',
                        position: 'bottom'
                    }]
                }
            }
        });
    }


</script>
