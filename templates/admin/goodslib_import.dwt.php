<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!--{extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.goods_info.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div class="alert alert-info">
	<a class="close" data-dismiss="alert">×</a>
	<p><strong>温馨提示：</strong></p>
	<p>1.您将通过上传的Excel文件，快速导入商品信息至平台商品库中；</p>
	<p>2.请先添加好商品库分类、品牌、规格；</p>
	<p>3.在导入商品信息前，请务必先下载商品导入模版，填写完成后再上传表格。</p>
</div>
<div>
	<h3 class="heading"> 
		<!-- {if $ur_here}{$ur_here}{/if} --> 
		{if $action_link}
		<a href="{$action_link.href}" class="btn plus_or_reply data-pjax" id="sticky_a">
			<i class="fontello-icon-reply"></i>{$action_link.text}
		</a>{/if}
	</h3>
</div>

<div class="row-fluid batch">

	<form class="form-inline" action="{RC_Uri::url('goodslib/admin/init')}{if $smarty.get.type}&type={$smarty.get.type}{/if}" method="post" name="filterForm">
 		
	</form>
	<form class="f_r form-inline" action='{RC_Uri::url("goodslib/admin/init")}{if $smarty.get.type}&type={$smarty.get.type}{/if}' method="post" name="searchForm">
	</form>
</div>

<div class="row-fluid list-page">
	<div class="span12">
	<form class="form-horizontal" enctype="multipart/form-data" action="{$form_action}" method="post" name="theForm">
		<div class="control-group control-group-small formSep">
			<label class="control-label">下载模板：</label>
			<div class="controls">
				<a>下载模板</a>
				<span class="help-block" id="">请先下载商品导入模版，再上传数据</span>
			</div>
		</div>
		<div class="control-group control-group-small formSep">
			<label class="control-label">上传文件：</label>
			<div class="controls">
			<!-- <span class="btn btn-file">
					<span class="fileupload-new">上传文件</span>
					<input type="file" name="cat_img" />
				</span> -->
				<input class="" type="file" name="goodslib" value=""/>
				<span class="help-block" id="">{lang key='goods::goods.notice_goods_sn'}</span>
			</div>
		</div>
		<div class="row-fluid">
        	<label class="control-label"></label>
        	<input type="hidden" name="goods_id" value="{$goods.goods_id}"/>
        	<input type="hidden" name="goods_copyid" value="{$goods.goods_copyid}"/>
        	<button class="btn btn-gebo" type="submit">{if $goods.goods_id}{lang key='goods::goods.update'}{else}{lang key='goods::goods.next_step'}{/if}</button>
        	<input type="hidden" id="type" value="{$link.type}"/>
        </div>
	
	</form>
	</div>
</div>
<!-- {/block} -->