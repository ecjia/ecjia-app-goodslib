<?php defined('IN_ECJIA') or exit('No permission resources.');?>

<div class="modal-header">
	<button class="close" data-dismiss="modal">×</button>
	<h3 class="modal-title">{t domain="express"}设置色值{/t}</h3>
</div> 

<div class="modal-body">
	<div class="success-msg"></div>
	<div class="error-msg"></div>
	<form class="form-horizontal" method="post" id="actionForm" name="actionForm" action='{url path="goods/admin_spec_attribute/set_color_values_insert"}' >
		<!-- {foreach from=$color_list_array key=key item=val} --> 
			<div class="control-group control-group-small">
				<input class="f_l w100" type="text" name="attr_values[]" value="{$key}"  />
				<input class="f_l w100" type="text" name="color_values[]" value="{$val}"  />
			</div>
		<!-- {/foreach} -->	
		
		<div class="form-group t_c m_t50">
		    <input  type="hidden" name="cat_id" value="{$cat_id}">
		    <input  type="hidden" name="attr_id" value="{$attr_id}">
		    <button type="submit" id="note_btn" class="btn btn-gebo">{t domain="goodslib"}确认{/t}</button>
		</div>
	</form>
</div>