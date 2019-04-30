<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.edit_arrt.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
	<!-- {if $ur_here}{$ur_here}{/if} -->
	<!-- {if $action_link} -->
	<a class="btn plus_or_reply data-pjax" href="{$action_link.href}" id="sticky_a"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
	<!-- {/if} -->
	</h3>
</div>

<div class="row-fluid edit-page">
	<div class="span12">
		<form class="form-horizontal" name="theForm" action="{$form_action}" method="post">
			<fieldset>
				<div class="control-group formSep">
					<label class="control-label">{t domain="goodslib"}参数名称：{/t}</label>
					<div class="controls">
						<input class="w350" type='text' name='attr_name' value="{$attr.attr_name}" size='30'/>
						<span class="input-must">*</span>
					</div>
				</div>
				
				<div class="control-group formSep">
					<label class="control-label">{t domain="goodslib"}所属参数模板：{/t}</label>
					<div class="controls no-chzn-container">
						<select class="w350" name="cat_id" data-url="{url path= 'goodslib/admin_parameter_attribute/get_attr_group'}">
							{$goods_type_list}
						</select>
						<span class="input-must">*</span>
					</div>
				</div>
				
				<div class="control-group formSep {if !$attr_groups}hide{/if}" id="attrGroups">
					<label class="control-label">{t domain="goodslib"}参数分组：{/t}</label>
					<div class="controls no-chzn-container">
						<select class="w350 attr_list" name="attr_group">
							<!-- {if $attr_groups} -->
							<!-- {html_options options=$attr_groups selected=$attr.attr_group} -->
							<!-- {/if} -->
						</select>
					</div>
				</div>
			
				<div class="control-group formSep">
					<label class="control-label">{t domain="goodslib"}参数可选值：{/t}</label>
					<div class="controls chk_radio">
                        {foreach from=$attr_types item=value key=key}
                        <input class="uni_style" name="attr_type"  id="attr_type_{$key}" type="radio" value="{$key}" {if $attr.attr_type eq $key} checked="true"{/if} autocomplete="off"/><span>{$value}</span>
                        {/foreach}
						<span class="help-block" id="noticeAttrType">{t domain="goodslib" escape=no }选择"唯一参数"时，商品的该参数值只能设置一个值，用户只能查看该值。<br/>选择"复选参数"时，可以对商品该参数设置多个值。{/t}</span>
					</div>
				</div>
				
				<div class="control-group formSep attr_input_type" {if $attr.attr_type eq 2}style="display: none;"{/if}>
					<label class="control-label">{t domain="goodslib"}该参数值的录入方式：{/t}</label>
					<div class="controls chk_radio">
                        {foreach from=$attr_input_types item=value key=key}
                        	<input class="uni_style" name="attr_input_type" id="attr_input_type_{$key}" type="radio" value="{$key}" {if $attr.attr_input_type eq $key}checked="true"{/if} autocomplete="off"/><span>{$value}</span>
                        {/foreach}
					</div>
				</div>
				
				<div class="control-group formSep attr_values">
					<label class="control-label">{t domain="goodslib"}可选值列表：{/t}</label>
					<div class="controls">
						<textarea class="w350" name="attr_values" cols="30" rows="8">{$attr.attr_values}</textarea>
						<span class="input-must">*</span>
						<span class="help-block">多个可选值时，换行输入，每行一个可选值。</span>
					</div>
				</div>
				
				<div class="control-group">
					<div class="controls">
						<button class="btn btn-gebo" type="submit">{t domain="goodslib"}确定{/t}</button>
						<input type="hidden" name="attr_id" value="{$attr.attr_id}"/>
					</div>
				</div>
			</fieldset>
		</form>
	</div>
</div>
<!-- {/block} -->