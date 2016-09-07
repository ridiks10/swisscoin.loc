<form action="add_product_image" id="product_image_form" name="product_image_form" method="post" enctype="multipart/form-data" onSubmit= "return validate_product_image(this)" class="niceform">
	<table cellspacing="3" cellpadding="0" width="60%">
		<tbody>
			<tr>
				<td>{$tran_select_product}:</td>
				<td>
					<select tabindex="1" id="product_id_img" name="product_id" >
						<option value="">{$tran_select_product}</option>
						{foreach from = $product_image_details item=i}
							{assign var="id" value="{$i.product_id}"}
							{assign var="product_name" value="{$i.product_name}"}
							{assign var="prod_id" value="{$i.prod_id}"}

							<option value="{$id}">{$prod_id}--{$product_name}</option>
						{/foreach}
					</select>
				</td>
			</tr>
			<tr>
				<td>{$tran_select_image}:</td>

				<td><input tabindex="2" type="file" id="userfile" name="userfile"></td>
			</tr>
			<tr>
				<td></td><td> <input tabindex="3" type="submit" id="upload" name="upload" value="{$tran_upload}"></td>
			</tr>
		</tbody>
	</table>
</form>
