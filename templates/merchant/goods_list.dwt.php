<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!--{extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.merchant.goods_list.init();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->

<div class="modal fade" id="insertGoods">
	<div class="modal-dialog">
    	<div class="modal-content">
			<div class="modal-header">
				<button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
				<h4 class="modal-title">导入商品</h4>
			</div>
			<div class="modal-body" style="height:auto;">
				<form class="form-horizontal" action="{$form_action}" method="post" name="insertForm">
					<div class="form-group">
          				<label class="control-label col-lg-2">商品名称</label>
          				<div class="controls col-lg-7">
                        	<input class="form-control" name="goods_name" type="text" value="" />
                      	</div>
                      	<span class="input-must m_l15">{lang key='system::system.require_field'}</span>
          			</div>
          			<div class="form-group">
          				<label class="control-label col-lg-2">商品货号</label>
          				<div class="controls col-lg-7">
                        	<input class="form-control" name="goods_sn" type="text" value="" />
                      	</div>
          			</div>
          			<div class="form-group">
          				<label class="control-label col-lg-2">本店售价</label>
          				<div class="controls col-lg-7">
                        	<input class="form-control" name="shop_price" type="text" value="" />
                      	</div>
                      	<div class="col-lg-2 p_l0">
                          	<a class="btn btn-primary" data-toggle="marketPriceSetted">{lang key='goods::goods.compute_by_mp'}</a>
						</div>
						<span class="input-must m_l15">{lang key='system::system.require_field'}</span>
          			</div>
              			
          			<div class="form-group">
          				<label class="control-label col-lg-2">市场售价</label>
          				<div class="col-lg-7">
                        	<input class="form-control" name="market_price" type="text" value="" />
                      	</div>
                      	<div class="col-lg-2 p_l0">
                          	<button class="btn btn-primary" type="button" data-toggle="integral_market_price">{lang key='goods::goods.integral_market_price'}</button>
						</div>
          			</div>
              			
          			<div class="form-group">
          				<label class="control-label col-lg-2">库存数量</label>
          				<div class="controls col-lg-7">
                        	<input class="form-control" name="goods_number" type="text" value="{ecjia::config('default_storage')}" />
                      	</div>
                      	<span class="input-must">{lang key='system::system.require_field'}</span>
          			</div>
          			<div class="form-group">
          				<label class="control-label col-lg-2">加入推荐</label>
          				<div class="col-lg-10">
          					<div class="checkbox-inline">
              					<input id="is_best" type="checkbox" name="is_best" value="1" {if $goods.store_best}checked{/if}>
              					<label for="is_best">{lang key='goods::goods.is_best'}</label>
                  				
                  				<input id="is_new" type="checkbox" name="is_new" value="1" {if $goods.store_new}checked{/if}>
                  				<label for="is_new">{lang key='goods::goods.is_new'}</label>
                  				
                  				<input id="is_hot" type="checkbox" name="is_hot" value="1" {if $goods.store_hot}checked{/if}>
                  				<label for="is_hot">{lang key='goods::goods.is_hot'}</label>
                  			</div>
                   		</div>
                  	</div>
          			<div class="form-group">
              			<label class="control-label col-lg-2">包邮</label>
              			<div class="col-lg-10">
              				<div class="checkbox-inline">
                            	<input id="is_shipping" type="checkbox" name="is_shipping" value="1" {if $goods.is_shipping}checked{/if}>
                            	<label for="is_shipping">{lang key='goods::goods.free_shipping'}</label>
                            </div>
                   		</div>
              		</div>
              		<div class="form-group">
          				<label class="control-label col-lg-2">上架</label>
          				<div class="col-lg-10">
              				<div class="checkbox-inline">
                     			<input id="is_on_sale" type="checkbox" name="is_on_sale" value="1" {if $goods.is_on_sale}checked{/if}>
                       			<label for="is_on_sale">{lang key='goods::goods.on_sale_desc'}</label>
                       		</div>
                   		</div>
                  	</div>
                  	<input type="hidden" name="goods_id" value="" />
                  	
					<div class="form-group t_c">
						<a class="btn btn-primary insertSubmit" href="javascript:;">开始导入</a>
					</div>
				</form>
           </div>
		</div>
	</div>
</div>

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
				
				<form class="form-inline f_l" action='{RC_Uri::url("goodslib/merchant/add", "cat_id={$smarty.get.cat_id}")}' method="post" name="search_form">
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
							<tr data-sorthref='{RC_Uri::url("goodslib/merchant/add", "{if $smarty.get.cat_id}&cat_id={$smarty.get.cat_id}{/if}{if $smarty.get.keywords}&keywords={$smarty.get.keywords}{/if}")}'>
								<th class="table_checkbox check-list w30">
									<div class="check-item">
										<input id="checkall" type="checkbox" name="select_rows" data-toggle="selectall" data-children=".checkbox"/>
										<label for="checkall"></label>
									</div>
								</th>
								<th class="w100 text-center">{lang key='goods::goods.thumb'}</th>
								<th class="w200" data-toggle="sortby" data-sortby="goods_id">{lang key='goods::goods.goods_name'}</th>
								<th class="w200 sorting" data-toggle="sortby" data-sortby="goods_sn">{lang key='goods::goods.goods_sn'}</th>
								<th class="w130 sorting text-center" data-toggle="sortby" data-sortby="shop_price">{lang key='goods::goods.shop_price'}</th>
								<th class="w130 sorting text-center" >市场价</th>
								<!-- <th class="w70 sorting text-center" data-toggle="sortby" data-sortby="store_sort_order">排序</th> -->
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
									<a target="_blank" href='{url path="goodslib/merchant/preview" args="id={$goods.goods_id}"}'><img class="w80 h80" alt="{$goods.goods_name}" src="{$goods.goods_thumb}"></a>
								</td>
								<td class="hide-edit-area ">
									<span class="ecjiaf-pre ecjiaf-wsn" data-text="textarea">{$goods.goods_name|escape:html}</span>
									<br/>
									<div class="edit-list">
										<a class="insert-goods-btn" href="javascript:;" data-href='{url path="goodslib/merchant/insert" args="goods_id={$goods.goods_id}"}' 
										data-id="{$goods.goods_id}" data-name="{$goods.goods_name}" data-sn="{$goods.goods_sn}" data-shopprice="{$goods.shop_price}" data-marketprice="{$goods.market_price}">导入商品</a>&nbsp;|&nbsp;
										<a target="_blank" href='{url path="goodslib/merchant/preview" args="id={$goods.goods_id}"}'>预览商品</a>
									</div>
								</td>	
								
								<td>{$goods.goods_sn}</td>
								<td align="center">{$goods.shop_price}</td>
								<td align="center">{$goods.market_price}</td>
								<!-- <td align="center">{$goods.store_sort_order}</td> -->
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
			<div class="panel">
    			<div class="form-group">
    				<fieldset class="t_c">
    					<input type="hidden" name="goods_id" value="{$goods_id}" />
    					<input type="hidden" name="cat_id" />
    					<a class="btn btn-info" href='{url path="goodslib/merchant/init"}'>上一步</a>
    					<button class="btn btn-info m_l20 batchInsert" type="button" data-url='{url path="goodslib/merchant/add"}'>开始导入</button>
    				</fieldset>
    			</div>
    		</div>
		</div>
	</div>
</div>
<!-- {/block} -->