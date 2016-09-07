{assign var="report_name" value="Profile Report"}
{include file="user/layout/themes/{$USER_THEME_FOLDER}/header.tpl"  name=""}

<div class='box'>

    <table width="100%" border="1" cellpadding="0" cellspacing="0" align="center">
        <tr class="text">
            {foreach from=$details item=v}
                <td><strong>{$tran_name}</strong></td>
                <td>{$v.user_detail_name}</td>
            </tr>

            <tr>
                <td><strong>{$tran_epin}</strong></td>
                <td>{$v.user_detail_passcode}</td>
            </tr>
            <tr>
                <td><strong>{$tran_user_name}</strong></td>
                <td>{$u_name}</td>
            </tr>
            <tr>

                <td><strong>{$tran_sponser_id}</strong></td>
                <td>{$sponser['id']} </td>
            </tr>
            <tr>
                <td><strong>{$tran_sponser_name}</strong></td>

                <td>{$sponser['name']}</td>

            </tr>



            <tr>
                <td><strong>{$tran_resident}</strong></td>
                <td>
                    {$v.user_detail_address}</td>
            </tr>

            <tr>
                <td><strong>{$tran_post_office}</strong></td>
                <td>{$v.user_detail_po}</td>
            </tr>

            <tr >
                <td><strong>{$tran_pincode}</strong></td>
                <td>{$v.user_detail_pin}</td>
            </tr>

            <tr>
                <td><strong>{$tran_town}</strong></td>
                <td>{$v.user_detail_town}</td>
            </tr>
            <tr>
                <td><strong>{$tran_state}</strong></td>
                <td>{$v.user_detail_state}</td>
            </tr>





            <tr >
                <td><strong>{$tran_mobile_no}</strong></td>
                <td>{$v.user_detail_mobile}</td>
            </tr>

            <tr>
                <td><strong>{$tran_land_line_no}</strong></td>
                <td>{$v.user_detail_land}</td>
            </tr>

            <tr>
                <td><strong>{$tran_email}</strong></td>
                <td>{$v.user_detail_email}</td>
            </tr>

            <tr>
                <td><strong>{$tran_date_of_birth} </strong></td>
                <td>{$v.user_detail_dob}</td>
            </tr>

            <tr>
                <td><strong>{$tran_blood_group}</strong></td>
                <td>{$v.user_detail_blood_group}
                </td>
            </tr>

            <tr>
                <td><strong>{$tran_marital_status} </strong></td>
                <td>{$v.user_detail_blood_group}
                </td>
            </tr>

            <tr>
                <td><strong>{$tran_occupation}</strong></td>
                <td>{$v.user_detail_designation}
                </td>
            </tr>
            <tr>
                <td><strong>{$tran_gender}</strong></td>
                <td>

                    {if $v.user_detail_gender=='M'}
                        {$tran_male}
                    {else}
                        {$tran_female}
                    {/if}      

            </tr>

            <tr>
                <td><strong>{$tran_nominee}</strong></td>
                <td>{$v.user_detail_nominee}
                </td>
            </tr>

            <tr>
                <td><strong>{$tran_relationship}</strong></td>
                <td>{$v.user_detail_relation}
                </td>
            </tr>
        {/foreach}

    </table>

</div>
{include file="user/layout/themes/{$USER_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function() {
        Main.init();
    });
</script>
{include file="user/layout/themes/{$USER_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}