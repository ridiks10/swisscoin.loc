{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}
<div id="span_js_messages" style="display: none;"> 
    <span id="validate_msg1">{$tran_you_must_select_a_link}</span>
    <span id="validate_msg2">{$tran_you_must_enter_the_text}</span>
    <span id="validate_msg3">{$tran_you_must_select_one_option}</span>     
</div>
<innerdashes>

    <rdash>
        {$tran_add_menu_item}
    </rdash>
    <cdash-inner>
        {form_open_multipart('', 'method="post" name="main_menu_chenge" id= "main_menu_chenge"')}
            <table border="0" width="100%" class ='tbl'   id="grid">
                <thead>
                    <tr align='center' class="th">
                        <th>No</th>
                        <th>{$tran_menu_name}</th>
                        <th> {$tran_link}</th>
                        <th>{$tran_admin}</th>
                        <th> Emp</th>
                        <th>{$tran_user}</th>
                        <th>{$tran_icon}</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    {assign var="i" value=0}
                    {foreach from=$menu_item item=v}
                        {if $i%2==0}
                            {assign var="class" value=tr1} 
                        {else}
                            {assign var="class" value=tr2} 
                        {/if}
                    <input type='hidden' name='menu_id{$i}' value= '{$v.id}' >
                    <tr>{$i=$i+1}
                        <td> 
                            {counter}
                        </td>
                        <td> 
                            <input type ='text'  name ='menu_text{$i}' value='{$v.text}'  id='menu_text{$i}' readonly="" > 
                        </td>
                        <td>
                            <input type ='text' size="5px"  name='menu_link{$i}' value='{$v.link}'  id='menu_link{$i}'  size='8' readonly=""> 
                        </td>
                        <td>
                            <input type ='text' size="1"  name='perm_admin{$i}' value='{$v.perm_admin}' maxlength ='1' id='perm_admin{$i}' size= '1' >
                        </td>
                        <td>
                            <input type ='text' size="1"  name='perm_emp{$i}' value='{$v.perm_emp}' maxlength ='1' id='perm_emp{$i}' size= '1' > 
                        </td> 
                        <td> 
                            <input type ='text' size="1"  name='perm_dist{$i}' value='{$v.perm_dist}' maxlength ='1' id='perm_dist{$i}' size= '1' >
                        </td>
                        <td>
                            <input tabindex="2" type="file" size="5px" id="userfile{$i}" name="userfile{$i}">
                        </td>
                        <td align='center'>
                            <input type= 'checkbox' value= 'yes'  id ='active{$i}'   name='active{$i}'><label for="active{$i}"></label>
                        </td>
                    </tr>
                    
                {/foreach}
                </tbody>
            </table>
            <table>
                <input type='hidden' name='total_count' value= "{$i}" >
                <tr> 
                    <td>
                        <input type= 'submit' value= '{$tran_update}'  id ='update'   name='update'>
                    </td>
                </tr>
            </table>
        {form_close()}
    </cdash-inner>
    <rdash>
        {$tran_add_item}
    </rdash>
    <cdash-inner>
        {form_open_multipart('', 'method="post" name="main_menu_add" id= "main_menu_add" onsubmit="return validate_menu_item(this)"')}
            <table border="2"  id="grid" >
                <thead>
                    <tr>
                        <td>
                            {$tran_add_one_item}
                        </td>
                        <td>
                            <select type="select" name="menu_id" id="menu_id">

                                {assign var="i" value=0}
                                {foreach from=$menu_item item=v}

                                    <option value= "{$v.order_id}">{$v.text}</option>

                                    {$i=$i+1}
                                {/foreach}

                            </select>
                        </td>
                    </tr>
                </thead>
                <tbody>     

                    <tr>
                        <td>
                            {$tran_menu_link}
                        </td>
                        <td>
                            <input type ="text" name="link" id="link" size= '50'>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {$tran_menu_text}
                        </td>
                        <td>
                            <input type ="text" name="text" id="text" size= '50' >
                        </td>
                    </tr>

                    <tr>
                        <td>
                            {$tran_target}
                        </td>
                        <td>
                            <input type ="text" name="target" id="target"  >
                        </td>
                    </tr>

                    <tr>
                        <td>
                            {$tran_permision_admin}
                        </td>
                        <td>
                            <input type ="text" name="perm_admin"  maxlength ='1'  id="perm_admin" size= '1' >
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {$tran_permision_emp}
                        </td>
                        <td>
                            <input type ="text" name="perm_emp"  maxlength ='1' id="perm_emp" size= '1' >
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {$tran_permision_user}
                        </td>
                        <td>
                            <input type ="text" name="perm_user" maxlength ='1' id="perm_user" size= '1' >
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {$tran_icon}
                        </td>
                        <td>
                            <input tabindex="2" type="file" id="userfile" name="userfile">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type= "submit" value= "{$tran_submit}"  id ="submit"   name="submit"> 
                        </td>
                    </tr>
                </tbody>
            </table>
        {form_close()}
    </cdash-inner>
</innerdashes>

{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function() {
        Main.init();
    });
</script>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}  