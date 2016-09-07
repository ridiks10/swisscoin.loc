<div class="row">
    <div class="col-sm-12">
        <div class="alert alert-warning alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">  {lang('close')}</span></button> {lang('Answers_to_some_frequently_asked')}
        </div>

        <div class="panel-group" id="accordion">
            <div class="panel-group" id="accordion">
                {foreach from=$faq item=item} 
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse{$item.id}">{$item.question}</a>
                            </h4>
                        </div>
                        <div id="collapse{$item.id}" class="panel-collapse collapse">
                            <div class="panel-body">{$item.answer}
                            </div>
                        </div>
                    </div>
                {/foreach}
            </div>
        </div>
    </div>
</div>
<style>
    .faqHeader {
        font-size: 22px;
        margin: 15px;
    }

    .panel-heading [data-toggle="collapse"]:after {
        font-family: 'Glyphicons Halflings';
        content: "^"; /* "play" icon */
        float: right;
        color: #F58723;
        font-size: 18px;
        line-height: 22px;
        /* rotate "play" icon from > (right arrow) to down arrow */

    }

    .panel-heading [data-toggle="collapse"].collapsed:after {
        /* rotate "play" icon from > (right arrow) to ^ (up arrow) */
        -webkit-transform: rotate(180deg);
        -moz-transform: rotate(180deg);
        -ms-transform: rotate(180deg);
        -o-transform: rotate(180deg);
        transform: rotate(180deg);
        color: #454444;
    }
</style>
