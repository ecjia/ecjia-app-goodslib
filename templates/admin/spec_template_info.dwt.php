<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->
<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.goods_type.init();
</script>
<!-- {/block} -->
<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
	<!-- {if $ur_here}{$ur_here}{/if} -->
	<!-- {if $action_link} -->
	<a class="btn plus_or_reply data-pjax" href="{$action_link.href}"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
	<!-- {/if} -->
	</h3>
</div>
<div class="row-fluid edit-page">
	<div class="span12">
		<form class="form-horizontal" action="{$form_action}" method="post" name="theForm">
			<fieldset>
				<div class="control-group formSep">
					<label class="control-label">{t domain="goodslib"}规格模板名称：{/t}</label>
					<div class="controls">
						<input class="w355" type="text" name="cat_name" value="{$spec_template_info.cat_name|escape}"/>
						<span class="input-must">*</span>
					</div>
				</div>
				
				<div class="control-group formSep">
					<label class="control-label">{t domain="goodslib"}状态：{/t}</label>
					<div class="controls chk_radio">
						<input class="uni_style" type="radio" name="enabled" value="1" {if $spec_template_info.enabled eq 1} checked="checked" {/if}/><span>{t domain="goodslib"}启用{/t}</span>
						<input class="uni_style" type="radio" name="enabled" value="0" {if $spec_template_info.enabled eq 0} checked="checked" {/if}/><span>{t domain="goodslib"}禁用{/t}</span>
					</div>
				</div>
				
				<div class="control-group">
					<div class="controls">
						<button class="btn btn-gebo" type="submit">{t domain="goodslib"}确定{/t}</button>
						<input type="hidden" name="cat_id" value="{$spec_template_info.cat_id}"/>
					</div>
				</div>
			</fieldset>
		</form>
	</div>
</div>
<!-- {/block} -->