<?php
//
//    ______         ______           __         __         ______
//   /\  ___\       /\  ___\         /\_\       /\_\       /\  __ \
//   \/\  __\       \/\ \____        \/\_\      \/\_\      \/\ \_\ \
//    \/\_____\      \/\_____\     /\_\/\_\      \/\_\      \/\_\ \_\
//     \/_____/       \/_____/     \/__\/_/       \/_/       \/_/ /_/
//
//   上海商创网络科技有限公司
//
//  ---------------------------------------------------------------------------------
//
//   一、协议的许可和权利
//
//    1. 您可以在完全遵守本协议的基础上，将本软件应用于商业用途；
//    2. 您可以在协议规定的约束和限制范围内修改本产品源代码或界面风格以适应您的要求；
//    3. 您拥有使用本产品中的全部内容资料、商品信息及其他信息的所有权，并独立承担与其内容相关的
//       法律义务；
//    4. 获得商业授权之后，您可以将本软件应用于商业用途，自授权时刻起，在技术支持期限内拥有通过
//       指定的方式获得指定范围内的技术支持服务；
//
//   二、协议的约束和限制
//
//    1. 未获商业授权之前，禁止将本软件用于商业用途（包括但不限于企业法人经营的产品、经营性产品
//       以及以盈利为目的或实现盈利产品）；
//    2. 未获商业授权之前，禁止在本产品的整体或在任何部分基础上发展任何派生版本、修改版本或第三
//       方版本用于重新开发；
//    3. 如果您未能遵守本协议的条款，您的授权将被终止，所被许可的权利将被收回并承担相应法律责任；
//
//   三、有限担保和免责声明
//
//    1. 本软件及所附带的文件是作为不提供任何明确的或隐含的赔偿或担保的形式提供的；
//    2. 用户出于自愿而使用本软件，您必须了解使用本软件的风险，在尚未获得商业授权之前，我们不承
//       诺提供任何形式的技术支持、使用担保，也不承担任何因使用本软件而产生问题的相关责任；
//    3. 上海商创网络科技有限公司不对使用本产品构建的商城中的内容信息承担责任，但在不侵犯用户隐
//       私信息的前提下，保留以任何方式获取用户信息及商品信息的权利；
//
//   有关本产品最终用户授权协议、商业授权与技术服务的详细内容，均由上海商创网络科技有限公司独家
//   提供。上海商创网络科技有限公司拥有在不事先通知的情况下，修改授权协议的权力，修改后的协议对
//   改变之日起的新授权用户生效。电子文本形式的授权协议如同双方书面签署的协议一样，具有完全的和
//   等同的法律效力。您一旦开始修改、安装或使用本产品，即被视为完全理解并接受本协议的各项条款，
//   在享有上述条款授予的权力的同时，受到相关的约束和限制。协议许可范围以外的行为，将直接违反本
//   授权协议并构成侵权，我们有权随时终止授权，责令停止损害，并保留追究相关责任的权力。
//
//  ---------------------------------------------------------------------------------
//
/**
 * 商品库商品基本信息类
 */

namespace Ecjia\App\Goodslib\Goodslib;

use \Ecjia\App\Goodslib\Models\GoodslibModel;

class GoodslibBasicInfo
{
    protected $model;
    
    protected $goods_id;


    public function __construct($goods_id)
    {
        $this->goods_id = $goods_id;

        $this->model = $this->goodsLibInfo();
    }
    
    /**
     * 获取商品库商品信息
     */
    public function goodsLibInfo()
    {
    	$data = GoodslibModel::where('goods_id', $this->goods_id)->first();
    	return $data;
    }

   /**
    * 获取商品库商品的相册
    * @return array
    */
    public function getGoodsLibGallery()
    {
    	$gallery = [];
    	if ($this->model->goodslib_gallery_collection) {
    		$disk = \RC_Filesystem::disk();
    		$gallery = $this->model->goodslib_gallery_collection->map(function ($item) use ($disk) {
    			if (!$disk->exists(\RC_Upload::upload_path($item['img_url'])) || empty($item['img_url'])) {
    				$item['img_url'] = \RC_Uri::admin_url('statics/images/nopic.png');
    			} else {
    				$item['img_url'] = \RC_Upload::upload_url($item['img_url']);
    			}
    	
    			if (!$disk->exists(\RC_Upload::upload_path($item['thumb_url'])) || empty($item['thumb_url'])) {
    				$item['thumb_url'] = \RC_Uri::admin_url('statics/images/nopic.png');
    			} else {
    				$item['thumb_url'] = \RC_Upload::upload_url($item['thumb_url']);
    			}
    			return $item;
    		});
    		$gallery = $gallery->toArray();
    	}
    	return $gallery;
    }
    
    /**
     * 商品库商品的货品
     * @return array
     */
    public function goodslibProducts()
    {
    	$product_list = [];
    	$disk = \RC_Filesystem::disk();
    	if ($this->model->goodslib_products_collection) {
    		$goods = $this->model;
    		$time = \RC_Time::gmtime();
    		$product_list = $goods->goodslib_products_collection->map(function ($item) use ($goods, $time, $disk) {
    			if (empty($item->product_name)) {
    				$item['product_name'] = $goods->goods_name;
    			}
    			$product_thumb = $item->product_thumb;
    			if (empty($product_thumb)) {
    				$product_thumb = $goods->goods_thumb;
    			}
    			
    			if (!$disk->exists(\RC_Upload::upload_path($product_thumb)) || empty($product_thumb)) {
    				$item['product_thumb'] = \RC_Uri::admin_url('statics/images/nopic.png');
    			} else {
    				$item['product_thumb'] = \RC_Upload::upload_url($product_thumb);
    			}
    			
    			$item['product_shop_price'] = $item->product_shop_price <= 0 ? ecjia_price_format($goods->shop_price, false) : ecjia_price_format($item->product_shop_price, false);
    			$item['product_attr_value'] = '';
    			$item['is_promote_now'] = 0 ;
    			if (($goods->promote_start_date <= $time && $goods->promote_end_date >= $time) && $item->is_promote == '1' && $item->promote_price > 0) {
    				$item['is_promote_now'] = 1;
    			}
    			if ($item->goods_attr) {
    				$goods_attr = explode('|', $item->goods_attr);
    				if ($goods->goodslib_attr_collection) {
    					$product_attr_value = $goods->goodslib_attr_collection->whereIn('goods_attr_id', $goods_attr)->sortBy('goods_attr_id')->lists('attr_value');
    					$product_attr_value = $product_attr_value->implode('/');
    					$item['product_attr_value'] = $product_attr_value;
    				}
    			}
    			return $item;
    		});
    		$product_list = $product_list->toArray();
    	}
    	return $product_list;
    }
    
    /**
     * 获取商品规格参数
     */
    public function getGoodsSpecPra()
    {
    	$parameter 		= $this->getGoodsParameter();
    	$specification 	= $this->getGoodsSpecification();
    	 
    	return ['pra' => $parameter, 'spe' => $specification];
    }
    
    /**
     * 商品绑定的参数模板参数有分组
     * @return array
     */
    public function getGoodsGroupParameter()
    {
    	$result = [];
    	if ($this->model->goods_type_parameter_model) {
    		$parameter_id = $this->model->goods_type_parameter_model->cat_id;
    	} else {
    		$parameter_id = 0;
    	}
    	$attr_group = $this->attrGroup();
    	
    	if (!empty($parameter_id)) {
    		if ($this->model->goodslib_attr_collection) {
				//参数分组
				if (!empty($attr_group)) {
					$pra_attr_ids = $this->model->goods_type_parameter_model->attribute_collection->lists('attr_id');
					$goods_attr_collection = $this->model->goodslib_attr_collection->whereIn('attr_id', $pra_attr_ids);
					$res = $goods_attr_collection->map(function ($item) use ($attr_group) {
						if ($item->attribute_model) {
								$parameter = collect($attr_group)->map(function ($val, $key) use ($item, $attr_group){
									if ($item->attribute_model->attr_group == $key) {
											$arr = array(
													'attr_group_id' 	=> $key,
													'attr_group_name'	=> $val,
													'values'			=> array(
																				'attr_id'	=>  $item->attr_id,
																				'attr_name' => 	$item->attribute_model->attr_name,
																				'attr_value'=> 	$item->attr_value,
																				'attr_type'	=> 	$item->attribute_model->attr_type,
																			)
											); 
											
											return $arr;
										}
								});
							
						}
						return $parameter;
					});
				}
    		}
    	}
    	if ($res) {
    		$result = $this->handleGroupParameter($res->toArray());
    	}
    	return $result;
    }
    
    /**
     * 商品绑定的参数模板参数未分组
     * @return array
     */
    public function getGoodsCommonParameter()
    {
    	$result = [];
    	
    	if ($this->model->goods_type_parameter_model) {
    		$parameter_id = $this->model->goods_type_parameter_model->cat_id;
    	}
    	$arr = [];
    	 
    	if ($this->model->goodslib_attr_collection) {
    		$res = $this->model->goodslib_attr_collection->map(function ($item) use ($parameter_id) {
    			if ($item->attribute_model) {
    				if ($item->attribute_model->cat_id == $parameter_id || intval($item->attribute_model->attr_type) === 0) {
    					if ($item->attribute_model->attr_name && $item->attr_value) {
    						return [
    						'attr_id'	=> $item->attr_id,
    						'name'     	=> $item->attribute_model->attr_name,
    						'value'		=> $item->attr_value,
    						];
    	
    					}
    				}
    			}
    		})->filter()->all();
    		$result = $this->formatAdminCommonPra($res);
    	}
    	return $result;
    	
    }
    
    /**
     * 分组参数处理
     * @param array $res
     * @return array
     */
    protected function handleGroupParameter ($res = []) 
    {
    	$attr = [];
    	
    	if (!empty($res)) {
    		$res = array_merge($res);
    		foreach ($res as $key => $val) {
    			if ($val) {
    				foreach ($val as $k => $v) {
    					$arr[] = $v;
    				}
    			}
    		}
    		$result  = collect($arr)->filter()->all();
    		
    		$arr = [];
    		if ($result) {
    			foreach ($result as $row) {
    				if (!isset($arr[$row['attr_group_id']])) {
    					$arr[$row['attr_group_id']] = [
    						'attr_group_id' 	=> $row['attr_group_id'],
    						'attr_group_name'	=> $row['attr_group_name'],
    					];
    				}
    				$arr[$row['attr_group_id']]['values'][] = $row['values'];
    			}
    			if ($arr) {
    				foreach ($arr as $k => $attr) {
    					if ($attr['values']) {
    						$attr['values'] = $this->formatAttrValue($attr['values']);
    					}
    					$list[] = $attr;
    				}
    			}
    		}
    	}
    	return $list;
    }
    
    /**
     * 商品绑定的参数模板分组信息
     */
    public function attrGroup()
    {
    	$grp = [];
    	if (!empty($this->model->goods_type_parameter_model->attr_group)) {
    		$data = $this->model->goods_type_parameter_model->attr_group;
    		$grp = str_replace("\r", '', $data);
    		if ($grp) {
    			$grp =  explode("\n", $grp);
    		} 
    	}
    	return $grp;
    }
    
    /**
     * 商品参数
     * @return array
     */
    protected function getGoodsParameter()
    {
    	$res = [];
    	 
    	if ($this->model->goods_type_parameter_model) {
    		$parameter_id = $this->model->goods_type_parameter_model->cat_id;
    	} else {
    		$parameter_id = 0;
    	}
    	
    	if (!empty($parameter_id)) {
    		if ($this->model->goods_attr_collection) {
    			$res = $this->model->goods_attr_collection->map(function ($item) use ($parameter_id) {
    				if ($item->attribute_collection) {
    					$parameter = $item->attribute_collection->map(function ($v) use ($item, $parameter_id) {
    						if ($v['cat_id'] == $parameter_id || $v->attr_type == '0') {
    							if ($v->attr_name) {
    								return [
    								'attr_name'     => $v->attr_name,
    								'attr_value'	=> $v->attr_input_type == '1' ? str_replace ( "\n", '/', $v->attr_values) : $item->attr_value,
    								];
    							}
    						}
    					});
    				}
    				return $parameter;
    			})->map(function ($val) {
    				return $val['0'];
    			});
    		}
    	}
    	 
    	if (!empty($res)) {
    		$res = $this->formatPra($res);
    	}
    	return $res;
    }
    
    /**
     * 商品规格
     * @return array
     */
    protected function getGoodsSpecification()
    {
    	$result = [];
    	if ($this->model->goods_type_specification_model) {
    		$specification_id = $this->model->goods_type_specification_model->cat_id;
    	} else {
    		$specification_id = 0;
    	}
    	if (!empty($specification_id)) {
    		if ($this->model->goods_attr_collection) {
    			$result = $this->model->goods_attr_collection->map(function ($item) use ($specification_id) {
    				if ($item->attribute_collection) {
    					$specification = $item->attribute_collection->map(function ($v) use ($item, $specification_id){
    						if ($v['cat_id'] == $specification_id) {
    							return [
    							'goods_attr_id' => $item->goods_attr_id,
    							'attr_value'	=> $item->attr_value,
    							'attr_price'	=> $item->attr_price,
    							'attr_id'		=> $v->attr_id,
    							'attr_name'		=> $v->attr_name,
    							'attr_group'	=> $v->attr_group,
    							'is_linked'		=> $v->is_linked,
    							'attr_type'		=> $v->attr_type
    							];
    						}
    					});
    					return $specification;
    				}
    			})->map(function ($val) {
    				return $val['0'];
    			});
    		}
    	}
    	if ($result) {
    		$result = $this->formatSpec($result);
    	}
    	return $result;
    }
    
    /**
     * 商品规格处理
     * @param array $specification
     * @return array
     */
    protected function formatSpec($specification)
    {
    	$arr = [];
    	$spec = [];
    	foreach ($specification as $row ) {
    		if ($row ['attr_type'] != 0) {
    			$arr [$row ['attr_id']] ['attr_type'] = $row ['attr_type'];
    			$arr [$row ['attr_id']] ['name'] = $row ['attr_name'];
    			$arr [$row ['attr_id']] ['value'] [] = array (
    					'label' => $row ['attr_value'],
    					'price' => $row ['attr_price'],
    					'format_price' => price_format ( abs ( $row ['attr_price'] ), false ),
    					'id' => $row ['goods_attr_id']
    			);
    		}
    
    	}
    	if (!empty($arr)) {
    		foreach ($arr as $key => $value) {
    			if (!empty($value['values'])) {
    				$value['value'] = $value['values'];
    				unset($value['values']);
    			}
    			$spec[] = $value;
    		}
    	}
    	return $spec;
    }
    
    /**
     * 商品参数处理
     * @param array $parameter
     */
    protected function formatPra($parameter = [])
    {
    	if (!empty($parameter)) {
    		foreach ($parameter as $k => $v) {
    			if (empty($v['attr_name'])) {
    				unset($parameter[$k]);
    			}
    		}
    		return $parameter->toArray();
    	}
    }
    
    protected function formatAdminCommonPra($parameter)
    {
    	$arr = [];
    	$result = [];
    	if ($parameter) {
    		foreach ($parameter as $row) {
    			$arr[$row['attr_id']]['name'] = $row['name'];
    			$arr[$row['attr_id']]['value'] .= $row['value'].'/';
    		}
    		$arr = array_merge($arr);
    		foreach ($arr as $row) {
    			$result[] = [
    			'attr_name' 		=>  $row['name'],
    			'attr_value'		=> rtrim($row['value'], '/')
    			];
    		}
    	}
    	return $result;
    }
    
    protected function formatAttrValue($attr)
    {
    	$arr = [];
    	$result = [];
    	 
    	if ($attr) {
    		foreach ($attr as $row) {
    			if ($row['attr_value']) {
    				$arr[$row['attr_id']]['attr_name'] = $row['attr_name'];
    				if ($row['attr_type'] == '2') {
    					$arr[$row['attr_id']]['attr_value'] .= $row['attr_value'].'/';
    				} else {
    					$arr[$row['attr_id']]['attr_value'] = $row['attr_value'];
    				}
    			}
    		}
    		$arr = array_merge($arr);
    		if (!empty($arr)) {
    			foreach ($arr as $rows) {
    				$result[] = [
    				'attr_name' 		=>  $rows['attr_name'],
    				'attr_value'		=> rtrim($rows['attr_value'], '/')
    				];
    			}
    		}
    	}
    	return $result;
    }

}