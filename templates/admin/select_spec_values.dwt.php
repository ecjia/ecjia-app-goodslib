<?php defined('IN_ECJIA') or exit('No permission resources.');?>

<div class="modal-header">
	<button class="close sprc_close" data-dismiss="modal">×</button>
	<h3 class="modal-title">{t domain="goodslib"}设置规格属性{/t}</h3>
</div> 

<div class="modal-body">
	{if $goods_attr_html}
	 <form class="form-horizontal" method="post" name="insertForm" id="insertForm" action='{url path="goodslib/admin/select_spec_values_insert"}'>
		<div id="tbody-goodsAttr"> 
			{if $goods_attr_html}{$goods_attr_html}{/if}
		</div>
		
		<div class="control-group">
			<div class="controls">
			 	<input  type="hidden" name="template_id" value="{$template_id}">
 				<input  type="hidden" name="goods_id" value="{$goods_id}">
		        <a class="btn btn-gebo insertSubmit" href="javascript:;" {if $has_product}disabled="disabled"{/if}>{t domain="goodslib"}确定{/t}</a>
			</div>
		</div>
	</form>
	{else}
	 <form class="form-horizontal" method="post" name="insertForm" id="insertForm" action='{url path="goodslib/admin/select_spec_values_insert"}'>
		<div class="control-group">
			<label class="control-label"></label>
			<div class="controls l_h35">
				<i class="fontello-icon-attention-circled ecjiafc-red"></i><span class="ecjiafc-red">您当前绑定的模板还未设置规格属性。</span>
			</div>
		</div>
		
		<div class="control-group">
			<div class="controls l_h35">
				<a href='{url path="goods/admin_spec_attribute/init" args="cat_id={$template_id}"}'><button type="button" class="btn btn-info" >{t domain="goodslib"}查看{/t}</button></a>
			</div>
		</div>
	</form>
	{/if}
</div>