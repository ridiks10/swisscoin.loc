<ul class='main-navigation-menu'>
    {assign var=sub_menu_count value=0}
    {foreach from=$LEFT_MENU item=v key=k}
        {$sub_menu_count=count($v->children)}
        <li {if {$v->selected} } class='active open' {/if}>
            <a href= '{$v->link}' {if $v->target!='none'}target="{$v->target}"{/if}>
                
                <i class='{$v->icon}' ></i>
                <span class='title'>
                    {$v->text}
                </span>
                {if $sub_menu_count}
                    <span class='clip-chevron-right pull-right'></span>
                {/if}
                <span class='selected'></span>
            </a>
            {if $sub_menu_count}
                <ul class='sub-menu'>
                    {foreach from=$v->children item=i}
                        <li {if {$i->selected} } class='active' {/if}>
                            <a href='{$i->link}'>
                                <i class='{$i->icon}' ></i>
                                <span class='title'>
                                    {$i->text}
                                </span>
                            </a>
                        </li>
                    {/foreach}
                </ul>
            {/if}
        </li>
    {/foreach}
</ul>