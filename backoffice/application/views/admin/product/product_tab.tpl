<table>
    <tr>
        <td>
            {form_open('admin/product/add_product', 'class="niceform" name="AddProduct" method="POST"')}
                <input class="button1" type="submit" value="{$tran_add_product}" name="AddProduct">
            {form_close()}
        </td>
        <td>
            {form_open('admin/product/edit_product', 'class="niceform" name="EditProduct" method="POST"')}
                <input class="button1" type="submit" value="{$tran_edit_product}" name="EditProduct">
            {form_close()}
        </td>
        <td>
            {form_open('admin/product/delete_product', 'class="niceform" name="DeleteProduct" method="POST"')}
                <input class="button1" type="submit" value="{$tran_delete_product}" name="DeleteProduct">
            {form_close()}
        </td>
        <td>
            {form_open('admin/product/inactive_product', 'class="niceform" name="InactiveProduct" method="POST"')}
                <input class="button1" type="submit" value="{$tran_inactive_product}" name="InactiveProduct">
            {form_close()}
        </td>
        <td>
            {form_open('admin/product/add_product_image', 'class="niceform" name="AddProductImage" method="POST"')}
                <input class="button1" type="submit" value="{$tran_add_product_image}" name="AddProductImage">
            {form_close()}
        </td>
    </tr>
</table>