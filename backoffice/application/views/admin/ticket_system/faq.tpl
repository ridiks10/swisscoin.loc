{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl" name=""}


<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>{lang('Create_faq')}
                <div class="panel-tools">
                    <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                    </a>

                    <a class="btn btn-xs btn-link panel-expand" href="#">
                        <i class="fa fa-resize-full"></i>
                    </a>
                </div>
            </div>

           {* <form role="form" class="smart-wizard form-horizontal" id="faq" name="faq" method="post" >*}
           {form_open('','role="form" class="smart-wizard form-horizontal" method="post" name="faq" id="faq"')}
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="category">{lang('category')} :<font color="#ff0000">*</font></label>
                        <div class="col-sm-8">
                            <select name="category"  id="category" class="form-control"  >


                                {foreach from=$category item=v}
                                    <option value='{$v.id}'>{$v.category_name}</option>
                                {/foreach}
                            </select>
                        </div>

                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="question">{lang('question')} :<font color="#ff0000">*</font></label>
                        <div class="col-sm-8">
                            <textarea name="question" id="question"   autocomplete="Off" class="form-control"  ></textarea>
                        </div>

                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="answer">{lang('answer')} :<font color="#ff0000">*</font></label>
                        <div class="col-sm-8">
                            <textarea name="answer" id="answer" class="form-control" ></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-3">
                            <input name="new_faq" type="submit" id="new_faq" value="Create" class="btn btn-primary"  />
                        </div>
                    </div>
                </div>
            {form_close()}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading ">
                <i class="fa fa-question-circle"></i>
                <div class="panel-tools">
                </div> {lang('faq')} 
            </div>
            <div class="panel-body">
                <div class="alert alert-warning alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span>

                        <span class="sr-only">{lang('close')}</span>
                    </button>
                        {lang('Answers_to_some_frequently_asked')}
                </div>
                <br />
                <div class="panel-group" id="accordion">
                    {foreach from=$faq item=item} 
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5 class="panel-title">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse{$item.id}">{$item.question}</a>
                                </h5>
                                <span class="pull-right clickable" id='close_icon' onclick='deleteFaq({$item.id});' title='Delete this Question'><i class="glyphicon glyphicon-remove" ></i></span>
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
</div>
<style>
    .glyphicon-remove {
        top:-13px;
    }
    .faqHeader {
        font-size: 21px;
        margin: 20px;
    }
    #close_icon:hover {
        color: red;
        font-size: 15px;
    }

    .panel-heading [data-toggle="collapse"]:after {
        font-family: 'Glyphicons Halflings';
        content: ""; /* "play" icon */
        float: right;
        color: #F58723;
        font-size: 18px;
        line-height: 22px;
        /* rotate "play" icon from > (right arrow) to down arrow */
        -webkit-transform: rotate(-90deg);
        -moz-transform: rotate(-90deg);
        -ms-transform: rotate(-90deg);
        -o-transform: rotate(-90deg);
        transform: rotate(-90deg);
    }

    .panel-heading [data-toggle="collapse"].collapsed:after {
        /* rotate "play" icon from > (right arrow) to ^ (up arrow) */
        -webkit-transform: rotate(90deg);
        -moz-transform: rotate(90deg);
        -ms-transform: rotate(90deg);
        -o-transform: rotate(90deg);
        transform: rotate(90deg);
        color: #454444;
    }
</style>


{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function () {
        Main.init();
        ValidateFAQ.init();

    });
</script>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}

