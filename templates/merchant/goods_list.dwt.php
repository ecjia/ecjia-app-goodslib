<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!--{extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.merchant.goods_list.init();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->

{if $step}
<!-- #BeginLibraryItem "/library/goods_step.lbi" --><!-- #EndLibraryItem -->
{/if}

<div class="page-header">
	<div class="pull-left">
		<h2><!-- {if $ur_here}{$ur_here}{/if} --></h2>
  	</div>
  	<div class="pull-right">
  		{if $action_link}
		<a href="{$action_link.href}" class="btn btn-primary data-pjax">
			<i class="fa fa-plus"></i> {$action_link.text}
		</a>
		{/if}
  	</div>
  	<div class="clearfix"></div>
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="panel">
			
			<div class="panel-body panel-body-small">
				<!-- <div class="btn-group f_l">
					<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><i class="fa fa-cogs"></i> {lang key='goods::goods.batch_handle'} <span class="caret"></span></button>
					<ul class="dropdown-menu">
		                <li><a class="batch-trash-btn" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{$form_action}&type=trash&is_on_sale={$goods_list.filter.is_on_sale}&page={$smarty.get.page}" data-msg="{lang key='goods::goods.batch_trash_confirm'}" data-noSelectMsg="{lang key='goods::goods.select_trash_goods'}" href="javascript:;"><i class="fa fa-archive"></i> {lang key='goods::goods.move_to_trash'}</a></li>
						<li><a class="batch-sale-btn" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{$form_action}&type=on_sale&is_on_sale={$goods_list.filter.is_on_sale}&page={$smarty.get.page}" data-msg="{lang key='goods::goods.batch_on_sale_confirm'}" data-noSelectMsg="{lang key='goods::goods.select_sale_goods'}" href="javascript:;"><i class="fa fa-arrow-circle-o-up"></i> {lang key='goods::goods.on_sale'}</a></li>
		           	</ul>
				</div> -->
				
				<form class="form-inline f_l" action="{RC_Uri::url('goodslib/merchant/add')}" method="post" name="search_form">
					<div class="screen f_l">
						<div class="form-group">
							<input type="text" class="form-control" name="keywords" value="{$smarty.get.keywords}" placeholder="{lang key='goods::goods.enter_goods_keywords'}">
						</div>
						<button class="btn btn-primary screen-btn" type="button"><i class="fa fa-search"></i> 搜索 </button>
					</div>
				</form>
			</div>
			
			<div class="panel-body panel-body-small">
				<section class="panel">
					<table class="table table-striped table-hover table-hide-edit ecjiaf-tlf">
						<thead>
							<tr data-sorthref='{RC_Uri::url("goodslib/merchant/init", "{if $smarty.get.type}&type={$smarty.get.type}{/if}")}'>
								<th class="table_checkbox check-list w30">
									<div class="check-item">
										<input id="checkall" type="checkbox" name="select_rows" data-toggle="selectall" data-children=".checkbox"/>
										<label for="checkall"></label>
									</div>
								</th>
								<th class="w100 text-center">{lang key='goods::goods.thumb'}</th>
								<th data-toggle="sortby" data-sortby="goods_id">{lang key='goods::goods.goods_name'}</th>
								<th class="w200 sorting" data-toggle="sortby" data-sortby="goods_sn">{lang key='goods::goods.goods_sn'}</th>
								<th class="w200 sorting text-center" data-toggle="sortby" data-sortby="shop_price">{lang key='goods::goods.shop_price'}</th>
								<th class="w70 sorting text-center" data-toggle="sortby" data-sortby="store_sort_order">排序</th>
							</tr>
						</thead>
						<tbody>
							<!-- {foreach from=$goods_list.goods item=goods}-->
							<tr>
								<td class="check-list">
									<div class="check-item">
										<input id="check_{$goods.goods_id}" class="checkbox" type="checkbox" name="checkboxes[]" value="{$goods.goods_id}"/>
										<label for="check_{$goods.goods_id}"></label>
									</div>
								</td>						
								<td>
									<img class="w80 h80" alt="{$goods.goods_name}" src="{$goods.goods_thumb}">
								</td>
								<td class="hide-edit-area ">
									<span class="ecjiaf-pre ecjiaf-wsn" data-text="textarea">{$goods.goods_name|escape:html}</span>
									<br/>
									<div class="edit-list">
										<a class="data-pjax" href='{url path="goodslib/merchant/insert" args="goods_id={$goods.goods_id}"}'>导入商品</a>&nbsp;|&nbsp;
										<a target="_blank" href='{url path="goodslib/merchant/preview" args="id={$goods.goods_id}"}'>预览商品</a>
									</div>
								</td>	
								
								<td>
									<span>
										{$goods.goods_sn} 
									</span>
								</td>
								<td align="center">
									<span> 
										{$goods.shop_price}
									</span> 
								</td>
								<td align="center">
									<span> 
										{$goods.store_sort_order}
									</span>
								</td>
							</tr>
							<!-- {foreachelse}-->
							<tr>
								<td class="no-records" colspan="11">{lang key='system::system.no_records'}</td>
							</tr>
							<!-- {/foreach} -->
						</tbody>
					</table>
				</section>
				<!-- {$goods_list.page} -->
			</div>
		</div>
	</div>
</div>
<!-- {/block} -->