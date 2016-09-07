<form action="{$action_page}" method="POST" name="proadd" id="proadd" onSubmit= "return validate_product_add(this);">
	<table  cellspacing="3" cellpadding="0" >
		<tr>
			<td width="180">{$tran_name_of_the_product} :</td>
			<td><input tabindex="1" type="text" name="prod_name" id="prod_name" size="20" value="{$pr_name}" 
					   title="{$tran_Name_of_the_Product_eg}"/>
			</td>
		</tr>
		<tr>
			<td>{$tran_product_id}:</td>
			<td><input tabindex="2" type="text" name="product_id" id="product_id" size="20" value="{$pr_id_no}" 
					   title="{$tran_Product_identification_code_eg}"/>
			</td>
		</tr>
		<tr><td>{$tran_product_amount}:</td>
			<td><input tabindex="3" type="text" name="product_amount" id="product_amount" size="20" value="{$pr_value}" 
					   title="{$tran_Actual_amount_of_the_product}"/>
				<span id="errmsg1"></span>
			</td>
		</tr>
		<tr>
			<td>{$tran_pair_value}</td>
			<td><input tabindex="4" type="text" name="product_value" id="product_value" size="20" value="{$pr_pair_value}" 
					   title="{$tran_This_is_the_amount_to_be_taken_for_the_product}"/> 
				<span id="errmsg2"></span>
			</td>
		</tr>
		<tr>
			<td></td>
			<td>
			{if $action=="edit"}
				<input tabindex="5" type="hidden" name="prod_id" id="prod_id" size="35" value="{$pr_id}"/>
				<input tabindex="5" type="submit" name="update_prod" value="update Product">
			{else}
				<input tabindex="5" type="submit" name="submit_prod" value="{$tran_add_product}">
			{/if}
			</td>
		</tr>
	</table>
</form>

<script>
	// execute your scripts when the DOM is ready. this is a good habit
	$(function() {



	// select all desired input fields and attach tooltips to them
	$("#proadd :input").tooltip({

	// place tooltip on the right edge
	position: "center right",

	// a little tweaking of the position
	offset: [-2, 10],

	// use the built-in fadeIn/fadeOut effect
	effect: "fade",

	// custom opacity setting
	opacity: .9,

	// use this single tooltip element
	tip: '.tooltip'

});
});
</script>
<br />
<hr />
<hdash>
	<img src="{$PUBLIC_URL}images/1337773000_basket.png" border="0" />
	&nbsp;&nbsp;&nbsp;&nbsp;{$tran_product_available}
</hdash>
<br/>
<br/>
<br/>
<form name="pin_form" id="pin_form" method="post" action=""  >
<table width="30%">
  <tr>
	  <td>
		<input tabindex="1" type="radio" id="status_active" name="pro_status" value="yes" {if $sub_status=='yes'}checked='1'{/if} />
					<label for="status_active"></label> {$tran_active_product}
					<input tabindex="2" type="radio" name="pro_status" id="status_inactive" value="no" {if $sub_status=='no'}checked='1'{/if} />
					<label for="status_inactive"></label> {$tran_inactive_product}
	  </td>
	  <td><input type="submit" name="refine" id="refine" tabindex="3" value="{$tran_refine}" style="" title="Refine Products"></td>
  </tr>
</table>
</form>
<table id="grid">
	<thead>
		<tr class="th">
			<th>No</th>
			<th>{$tran_product_id}</th>
			<th >{$tran_product_name}</th>
			<th >{$tran_product_amount}</th>
			<th >{$tran_product_pair_value}</th>
			<th >{$tran_product_status}</th>
			<th >{$tran_action}</th>
		</tr>
	</thead>

	{if count($product_details)!=0}

		{assign var="i" value=0}
		<tbody>
			{foreach from=$product_details item=v}
				{assign var="tr_class" value=""}

				{if $i%2==0}
					{$clr='tr1'}
				{else}
					{$clr='tr2'}
				{/if}
				{assign var="id" value="{$v.product_id}"}
				{assign var="name" value="{$v.product_name}"}
				{assign var="active" value="{$v.active}"}
				{assign var="date" value="{$v.date_of_insertion}"}
				{assign var="prod_id" value="{$v.prod_id}"}
				{assign var="prod_value" value="{$v.product_value}"}
				{assign var="pair_value" value="{$v.pair_value}"}

				{if $active=='yes'}
					{$status=$tran_active}
				{else}
					{$status=$tran_inactive}
				{/if}

				<tr>
					<td>{$i}</td>
					<td>{$prod_id}</td>
					<td>{$name}</td>
					<td>{$prod_value}</td>
					<td>{$pair_value}</td>
					<td>{$status}</td>
					<td>
					{if $active=='yes'}
					<a href="javascript:edit_prod({$id})"><img src="{$PUBLIC_URL}images/edit.png" title="Edit {$name}" style="border:none">/
					<a href="javascript:delete_prod({$id})"><img src="{$PUBLIC_URL}images/delete.png" title="Delete {$name}" style="border:none;"></a>
					{else}
					<a href="javascript:activate_prod({$id})"><img src="{$PUBLIC_URL}images/tick.png" title="Activate {$name}" style="border:none;"></a>
					{/if}
					</td>
				</tr>
				{$i=$i+1}
			{/foreach}
		</tbody>            
		<counter></counter>
	{else}
		<tr><td colspan="7" align="center"><h4>{$tran_no_product_found}</h4></td></tr>
	{/if}
</table>