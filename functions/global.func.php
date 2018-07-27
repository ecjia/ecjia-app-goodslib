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
defined('IN_ECJIA') or exit('No permission resources.');

/*返回商品详情页面的导航条数组*/
function goodslib_get_goods_info_nav($goods_id = 0, $extension_code = '') {
    return array(
        'edit'                  => array('name' => RC_Lang::get('goods::goods.tab_general'), 'pjax' => 1, 'href' => RC_Uri::url('goodslib/admin/edit', "goods_id=$goods_id".$extension_code)),
        'edit_goods_desc'       => array('name' => RC_Lang::get('goods::goods.tab_detail'), 'pjax' => 1, 'href' => RC_Uri::url('goodslib/admin/edit_goods_desc', "goods_id=$goods_id".$extension_code)),
        'edit_goods_photo'      => array('name' => RC_Lang::get('goods::goods.tab_gallery'), 'pjax' => 1, 'href' => RC_Uri::url('goodslib/admin_gallery/init', "goods_id=$goods_id".$extension_code)),
        'edit_goods_attr'       => array('name' => '规格属性', 'pjax' => 1, 'href' => RC_Uri::url('goodslib/admin/edit_goods_attr', "goods_id=$goods_id".$extension_code)),
        'product_list'          => array('name' => RC_Lang::get('goods::goods.tab_product'), 'pjax' => 1, 'href' => RC_Uri::url('goodslib/admin/product_list', "goods_id=$goods_id".$extension_code)),
    );
}

/**
 * 获得商品已添加的规格列表
 *
 * @access public
 * @param
 *            s integer $goods_id
 * @return array
 */
function get_goodslib_specifications_list($goods_id) {
    if (empty($goods_id)) {
        return array(); // $goods_id不能为空
    }
    return RC_DB::table('goodslib_attr as ga')
    ->leftJoin('goodslib_attribute as a', RC_DB::raw('a.attr_id'), '=', RC_DB::raw('ga.attr_id'))
    ->where('goods_id', $goods_id)
    ->where(RC_DB::raw('a.attr_type'), 1)
    ->selectRaw('ga.goods_attr_id, ga.attr_value, ga.attr_id, a.attr_name')
    ->orderBy(RC_DB::raw('ga.attr_id'), 'asc')
    ->get();
}

/**
 * 取得通用属性和某分类的属性，以及某商品的属性值
 *
 * @param int $cat_id
 *            分类编号
 * @param int $goods_id
 *            商品编号
 * @return array 规格与属性列表
 */
function get_goodslib_cat_attr_list($cat_id, $goods_id = 0) {
    if (empty ($cat_id)) {
        return array();
    }
    $row = RC_DB::table('goodslib_attribute as a')
        ->leftJoin('goodslib_attr as ga', RC_DB::raw('ga.attr_id'), '=', RC_DB::raw('a.attr_id'))
        ->select(RC_DB::raw('a.attr_id, a.attr_name, a.attr_input_type, a.attr_type, a.attr_values, ga.attr_value, ga.attr_price'))
        ->where(RC_DB::raw('a.cat_id'), RC_DB::raw($cat_id))
        ->orderBy(RC_DB::raw('a.sort_order'), 'asc')->orderBy(RC_DB::raw('a.attr_type'), 'asc')
        ->orderBy(RC_DB::raw('a.attr_id'), 'asc')->orderBy(RC_DB::raw('ga.goods_attr_id'), 'asc')
        ->get();
    return $row;
}

/**
 * 获取商品类型中包含规格的类型列表
 *
 * @access public
 * @return array
 */
function get_goodslib_type_specifications() {
    $row = RC_DB::table('goodslib_attribute')->selectRaw('DISTINCT cat_id')->where('attr_type', 1)->get();
    $return_arr = array();
    if (!empty($row)) {
        foreach ($row as $value) {
            $return_arr[$value['cat_id']] = $value['cat_id'];
        }
    }
    return $return_arr;
}

/**
 * 获取属性列表
 *
 * @return  array
 */
function get_goodslib_attr_list() {
    $db_attribute = RC_DB::table('goodslib_attribute as a');
    /* 查询条件 */
    $filter = array();
    $filter['cat_id'] 		= empty($_REQUEST['cat_id']) 		? 0 			: intval($_REQUEST['cat_id']);
    $filter['sort_by'] 		= empty($_REQUEST['sort_by']) 		? 'sort_order' 	: trim($_REQUEST['sort_by']);
    $filter['sort_order']	= empty($_REQUEST['sort_order']) 	? 'asc' 		: trim($_REQUEST['sort_order']);
    
    $where = (!empty($filter['cat_id'])) ? " a.cat_id = '".$filter['cat_id']."' " : '';
    if (!empty($filter['cat_id'])) {
        $db_attribute->whereRaw($where);
    }
    $count = $db_attribute->count('attr_id');
    $page = new ecjia_page($count, 15, 5);
    
    $row = $db_attribute
    ->leftJoin('goods_type as t', RC_DB::raw('a.cat_id'), '=', RC_DB::raw('t.cat_id'))
    ->selectRaw('a.*, t.cat_name')
    ->orderby($filter['sort_by'], $filter['sort_order'])
    ->take(15)->skip($page->start_id-1)->get();
    
    if (!empty($row)) {
        foreach ($row AS $key => $val) {
            $row[$key]['attr_input_type_desc'] = RC_Lang::get('goods::attribute.value_attr_input_type.'.$val['attr_input_type']);
            $row[$key]['attr_values'] = str_replace("\n", ", ", $val['attr_values']);
        }
    }
    return array('item' => $row, 'page' => $page->show(5), 'desc' => $page->page_desc());
}

/**
 * 获得指定的商品类型下所有的属性分组
 *
 * @param   integer     $cat_id     商品类型ID
 *
 * @return  array
 */
function get_goodslib_attr_groups($cat_id) {
    $data = RC_DB::table('goodslib_type')->where('cat_id', $cat_id)->pluck('attr_group');
    $grp = str_replace("\r", '', $data);
    if ($grp) {
        return explode("\n", $grp);
    } else {
        return array();
    }
}

/**
 * 获得店铺商品类型的列表
 *
 * @access  public
 * @param   integer     $selected   选定的类型编号
 * @param   integer     $store_id	店铺id
 * @param   boolean		是否显示平台规格
 * @return  string
 */
function goodslib_type_list($selected, $show_all = false) {
    $db_goods_type = RC_DB::table('goodslib_type')->select('cat_id', 'cat_name');
    
    $data = $db_goods_type->get();
    
    $opt = '';
    if (!empty($data)) {
        foreach ($data as $row){
            $opt .= "<option value='$row[cat_id]'";
            $opt .= ($selected == $row['cat_id']) ? ' selected="true"' : '';
            $opt .= '>' . htmlspecialchars($row['cat_name']). '</option>';
        }
    }
    return $opt;
}

/**
 * 获得所有商品类型
 *
 * @access  public
 * @return  array
 */
function get_goodslib_type() {
    $filter['keywords'] = !empty($_GET['keywords']) ? trim($_GET['keywords']) : '';
    
    $db_goods_type = RC_DB::table('goodslib_type as gt');
    
    
    if (!empty($filter['keywords'])) {
        $db_goods_type->where(RC_DB::raw('gt.cat_name'), 'like', '%'.mysql_like_quote($filter['keywords']).'%');
    }
    
    $filter_count = $db_goods_type
    ->select(RC_DB::raw('count(*) as count'))
    ->first();
    
    $filter['count']	= $filter_count['count'] > 0 ? $filter_count['count'] : 0;
    $filter['self'] 	= $filter_count['self'] > 0 ? $filter_count['self'] : 0;
    
    $filter['type'] = isset($_GET['type']) ? $_GET['type'] : '';
    if (!empty($filter['type'])) {
        $db_goods_type->where(RC_DB::raw('s.manage_mode'), 'self');
    }
    
    $count = $db_goods_type->count();
    $page = new ecjia_page($count, 15, 5);
    
    $field = 'gt.*, count(a.cat_id) as attr_count';
    $goods_type_list = $db_goods_type
        ->leftJoin('goodslib_attribute as a', RC_DB::raw('a.cat_id'), '=', RC_DB::raw('gt.cat_id'))
        ->selectRaw($field)
        ->groupBy(RC_DB::Raw('gt.cat_id'))
        ->orderby(RC_DB::Raw('gt.cat_id'), 'desc')
        ->take(15)
        ->skip($page->start_id-1)
        ->get();
    
    if (!empty($goods_type_list)) {
        foreach ($goods_type_list AS $key=>$val) {
            $goods_type_list[$key]['attr_group'] = strtr($val['attr_group'], array("\r" => '', "\n" => ", "));
        }
    }
    return array('item' => $goods_type_list, 'filter' => $filter, 'page' => $page->show(2), 'desc' => $page->page_desc());
}

/**
 * 根据属性数组创建属性的表单
 *
 * @access public
 * @param int $cat_id
 *            分类编号
 * @param int $goods_id
 *            商品编号
 * @return string
 */
function goodslib_build_attr_html($cat_id, $goods_id = 0) {
    $attr = get_goodslib_cat_attr_list($cat_id, $goods_id);
    $html = '';
    $spec = 0;
    
    if (!empty($attr)) {
        foreach ($attr as $key => $val) {
            $html .= "<div class='control-group formSep'><label class='control-label'>";
            $html .= "$val[attr_name]</label><div class='controls'><input type='hidden' name='attr_id_list[]' value='$val[attr_id]' />";
            if ($val ['attr_input_type'] == 0) {
                $html .= '<input name="attr_value_list[]" type="text" value="' . htmlspecialchars($val ['attr_value']) . '" size="40" /> ';
            } elseif ($val ['attr_input_type'] == 2) {
                $html .= '<textarea name="attr_value_list[]" rows="3" cols="40">' . htmlspecialchars($val ['attr_value']) . '</textarea>';
            } else {
                $html .= '<select name="attr_value_list[]" autocomplete="off">';
                $html .= '<option value="">' . RC_Lang::get('goods::goods.select_please') . '</option>';
                $attr_values = explode("\n", $val ['attr_values']);
                foreach ($attr_values as $opt) {
                    $opt = trim(htmlspecialchars($opt));
                    
                    $html .= ($val ['attr_value'] != $opt) ? '<option value="' . $opt . '">' . $opt . '</option>' : '<option value="' . $opt . '" selected="selected">' . $opt . '</option>';
                }
                $html .= '</select> ';
            }
            $html .= ($val ['attr_type'] == 1 || $val ['attr_type'] == 2) ? '<span class="m_l5 m_r5">' . RC_Lang::get('goods::goods.spec_price') . '</span>' . ' <input type="text" name="attr_price_list[]" value="' . $val ['attr_price'] . '" size="5" maxlength="10" />' : ' <input type="hidden" name="attr_price_list[]" value="0" />';
            if ($val ['attr_type'] == 1 || $val ['attr_type'] == 2) {
                $html .= ($spec != $val ['attr_id']) ? "<a class='m_l5' href='javascript:;' data-toggle='clone-obj' data-parent='.control-group'><i class='fontello-icon-plus'></i></a>" : "<a class='m_l5' href='javascript:;' data-trigger='toggleSpec'><i class='fontello-icon-minus'></i></a>";
                $spec = $val ['attr_id'];
            }
            $html .= '</div></div>';
        }
    }
    $html .= '';
    return $html;
}

/**
 * 获得商品的货品列表
 *
 * @access public
 * @param
 *            s integer $goods_id
 * @param
 *            s string $conditions
 * @return array
 */
function goodslib_product_list($goods_id, $conditions = '') {
    /* 过滤条件 */
    $param_str = '-' . $goods_id;
    
    $day 	= getdate();
    $today 	= RC_Time::local_mktime(23, 59, 59, $day ['mon'], $day ['mday'], $day ['year']);
    $filter ['goods_id'] 		= $goods_id;
    $filter ['keyword'] 		= empty ($_REQUEST ['keyword']) ? '' : trim($_REQUEST ['keyword']);
    $filter ['sort_by'] 		= empty ($_REQUEST ['sort_by']) ? 'product_id' : trim($_REQUEST ['sort_by']);
    $filter ['sort_order'] 		= empty ($_REQUEST ['sort_order']) ? 'DESC' : trim($_REQUEST ['sort_order']);
    $filter ['extension_code'] 	= empty ($_REQUEST ['extension_code']) ? '' : trim($_REQUEST ['extension_code']);
    $filter ['page_count'] 		= isset ($filter ['page_count']) ? $filter ['page_count'] : 1;
    
    $where = '';
    
    /* 关键字 */
    if (!empty ($filter ['keyword'])) {
        $where .= " AND (product_sn LIKE '%" . $filter ['keyword'] . "%')";
    }
    
    $where .= $conditions;
    
    /* 记录总数 */
    $count = RC_DB::table('goodslib_products')->whereRaw('goods_id = ' . $goods_id . $where)->count();
    $filter ['record_count'] = $count;
    
    $row = RC_DB::table('goodslib_products')
    ->selectRaw('product_id, goods_id, goods_attr as goods_attr_str, goods_attr, product_sn')
    ->whereRaw('goods_id = ' . $goods_id . $where)
    ->orderBy($filter ['sort_by'], $filter['sort_order'])
    ->get();
    
    /* 处理规格属性 */
    $goods_attr = product_goodsattr_attr_list($goods_id);
    if (!empty ($row)) {
        foreach ($row as $key => $value) {
            $_goods_attr_array = explode('|', $value ['goods_attr']);
            if (is_array($_goods_attr_array)) {
                $_temp = '';
                foreach ($_goods_attr_array as $_goods_attr_value) {
                    $_temp[] = $goods_attr [$_goods_attr_value];
                }
                $row [$key] ['goods_attr'] = $_temp;
            }
        }
    }
    return array(
        'product'		=> $row,
        'filter'		=> $filter,
        'page_count'	=> $filter ['page_count'],
        'record_count'	=> $filter ['record_count']
    );
}

/**
 * 获得商品的规格属性值列表
 *
 * @access public
 * @param
 *            s integer $goods_id
 * @return array
 */
function product_goodsattr_attr_list($goods_id) {
    $results = RC_DB::table('goodslib_attr')->select('goods_attr_id', 'attr_value')->where('goods_id', $goods_id)->get();
    
    $return_arr = array();
    if (!empty ($results)) {
        foreach ($results as $value) {
            $return_arr [$value ['goods_attr_id']] = $value ['attr_value'];
        }
    }
    return $return_arr;
}

/**
 * 插入或更新商品属性
 *
 * @param int $goods_id
 *            商品编号
 * @param array $id_list
 *            属性编号数组
 * @param array $is_spec_list
 *            是否规格数组 'true' | 'false'
 * @param array $value_price_list
 *            属性值数组
 * @return array 返回受到影响的goods_attr_id数组
 */
function handle_goodslib_attr($goods_id, $id_list, $is_spec_list, $value_price_list) {
    $goods_attr_id = array();
    /* 循环处理每个属性 */
    if (!empty($id_list)) {
        foreach ($id_list as $key => $id) {
            $is_spec = $is_spec_list [$key];
            if ($is_spec == 'false') {
                $value = $value_price_list [$key];
                $price = '';
            } else {
                $value_list = array();
                $price_list = array();
                if ($value_price_list [$key]) {
                    $vp_list = explode(chr(13), $value_price_list [$key]);
                    foreach ($vp_list as $v_p) {
                        $arr = explode(chr(9), $v_p);
                        $value_list [] = $arr [0];
                        $price_list [] = $arr [1];
                    }
                }
                $value = join(chr(13), $value_list);
                $price = join(chr(13), $price_list);
            }
            
            // 插入或更新记录
            $result_id = RC_DB::table('goodslib_attr')->where('goods_id', $goods_id)->where('attr_id', $id)->where('attr_value', $value)->pluck('goods_attr_id');
            
            if (!empty ($result_id)) {
                $data = array(
                    'attr_value' => $value
                );
                RC_DB::table('goodslib_attr')->where('goods_id', $goods_id)->where('attr_id', $id)->where('goods_attr_id', $result_id)->update($data);
                
                $goods_attr_id [$id] = $result_id;
            } else {
                $data = array(
                    'goods_id' 		=> $goods_id,
                    'attr_id' 		=> $id,
                    'attr_value' 	=> $value,
                    'attr_price' 	=> $price
                );
                $goods_attr_id [$id] = RC_DB::table('goodslib_attr')->insertGetId($data);
            }
        }
    }
    return $goods_attr_id;
}

/**
 * 将 goods_attr_id 的序列按照 attr_id 重新排序
 *
 * 注意：非规格属性的id会被排除
 *
 * @access public
 * @param array $goods_attr_id_array
 *        	一维数组
 * @param string $sort
 *        	序号：asc|desc，默认为：asc
 *
 * @return string
 */
function sort_goodslib_attr_id_array($goods_attr_id_array, $sort = 'asc') {
    if (empty($goods_attr_id_array)) {
        return $goods_attr_id_array;
    }
    // 重新排序
    $row = RC_DB::table('goodslib_attribute as a')
    ->leftJoin('goodslib_attr as v', function($join){
        $join->on(RC_DB::raw('v.attr_id'), '=', RC_DB::raw('a.attr_id'))->on(RC_DB::raw('a.attr_type'), '=', RC_DB::raw('1'));
    })
    ->selectRaw('a.attr_type, v.attr_value, v.goods_attr_id')
    ->whereIn(RC_DB::raw('v.goods_attr_id'), $goods_attr_id_array)
    ->orderby(RC_DB::raw('a.attr_id'), $sort)
    ->get();
    
    $return_arr = array();
    if (! empty($row)) {
        foreach ($row as $value) {
            $return_arr['sort'][] = $value['goods_attr_id'];
            
            $return_arr['row'][$value['goods_attr_id']] = $value;
        }
    }
    return $return_arr;
}

/**
 * 商品的货品规格是否存在
 *
 * @param string $goods_attr
 *            商品的货品规格
 * @param string $goods_id
 *            商品id
 * @param int $product_id
 *            商品的货品id；默认值为：0，没有货品id
 * @return bool true，重复；false，不重复
 */
function check_goodslib_attr_exist($goods_attr, $goods_id, $product_id = 0) {
    $db_products = RC_DB::table('goodslib_products');
    $goods_id = intval($goods_id);
    if (strlen($goods_attr) == 0 || empty ($goods_id)) {
        return true; // 重复
    }
    
    $db_products->where('goods_attr', $goods_attr)->where('goods_id', $goods_id);
    if (!empty ($product_id)) {
        $db_products->where('product_id', '!=', $product_id);
    }
    $res = $db_products->pluck('product_id');
    if (empty ($res)) {
        return false; // 不重复
    } else {
        return true; // 重复
    }
}

/**
 * 商品货号是否重复
 *
 * @param string $goods_sn
 *            商品货号；请在传入本参数前对本参数进行SQl脚本过滤
 * @param int $goods_id
 *            商品id；默认值为：0，没有商品id
 * @return bool true，重复；false，不重复
 */
function check_goodslib_sn_exist($goods_sn, $goods_id = 0) {
    $goods_sn = trim($goods_sn);
    $goods_id = intval($goods_id);
    
    if (strlen($goods_sn) == 0) {
        return true; // 重复
    }
    $db_goods = RC_DB::table('goodslib');
    
    $db_goods->where('goods_sn', $goods_sn);
    if (!empty ($goods_id)) {
        $db_goods->where('goods_id', '!=', $goods_id);
    }
    $res = $db_goods->first();
    
    if (empty ($res)) {
        return false; // 不重复
    } else {
        return true; // 重复
    }
}

/**
 * 商品的货品货号是否重复
 *
 * @param string $product_sn
 *            商品的货品货号；请在传入本参数前对本参数进行SQl脚本过滤
 * @param int $product_id
 *            商品的货品id；默认值为：0，没有货品id
 * @return bool true，重复；false，不重复
 */
function check_goodslib_product_sn_exist($product_sn, $product_id = 0) {
    $product_sn = trim($product_sn);
    $product_id = intval($product_id);
    
    if (strlen($product_sn) == 0) {
        return true; // 重复
    }
    
    $query = RC_DB::table('goodslib')->where('goods_sn', $product_sn)->pluck('goods_id');
    if ($query) {
        return true; // 重复
    }
    $db_product = RC_DB::table('goodslib_products')->where('product_sn', $product_sn);
    if (!empty($product_id)) {
        $db_product->where('product_id', '!=', $product_id);
    }
    $res = $db_product->pluck('product_id');
    
    if (empty ($res)) {
        return false; // 不重复
    } else {
        return true; // 重复
    }
}

/**
 * 取货品信息
 *
 * @access public
 * @param int $product_id
 *            货品id
 * @param int $filed
 *            字段
 * @return array
 */
function get_goodslib_product_info($product_id, $field = '') {
    $return_array = array();
    if (empty ($product_id)) {
        return $return_array;
    }
    $filed = trim($filed);
    if (empty ($filed)) {
        $filed = '*';
    }
    return RC_DB::table('goodslib_products')->selectRaw($field)->where('product_id', $product_id)->first();
}

/**
 * 修改商品某字段值
 *
 * @param string $goods_id
 *            商品编号，可以为多个，用 ',' 隔开
 * @param string $field
 *            字段名
 * @param string $value
 *            字段值
 * @return bool
 */
function update_goodslib($goods_id, $field, $value) {
    if ($goods_id) {
        $data = array(
            $field 			=> $value,
            'last_update' 	=> RC_Time::gmtime()
        );
        $db_goods = RC_DB::table('goodslib')->whereIn('goods_id', $goods_id);
        $db_goods->update($data);
    } else {
        return false;
    }
}

/**
 * 从回收站删除多个商品
 *
 * @param mix $goods_id
 *            商品id列表：可以逗号格开，也可以是数组
 * @return void
 */
function delete_goodslib($goods_id) {
    if (empty($goods_id)) {
        return;
    }
    $data = RC_DB::table('goodslib')->select('goods_thumb', 'goods_img', 'original_img')->whereIn('goods_id', $goods_id)->get();
    
    if (!empty($data)) {
        $disk = RC_Filesystem::disk();
        foreach ($data as $goods) {
            if (!empty($goods['goods_thumb'])) {
                $disk->delete(RC_Upload::upload_path() . $goods['goods_thumb']);
            }
            if (!empty($goods['goods_img'])) {
                $disk->delete(RC_Upload::upload_path() . $goods['goods_img']);
            }
            if (!empty($goods['original_img'])) {
                $disk->delete(RC_Upload::upload_path() . $goods['original_img']);
            }
        }
    }
    /* 删除商品 */
    $db_goods = RC_DB::table('goodslib')->whereIn('goods_id', $goods_id)->delete();
    
    /* 删除商品的货品记录 */
    RC_DB::table('goodslib_products')->whereIn('goods_id', $goods_id)->delete();
    
    /* 删除商品相册的图片文件 */
    $data = RC_DB::table('goodslib_gallery')->select('img_url', 'thumb_url', 'img_original')->whereIn('goods_id', $goods_id)->get();
    
    if (!empty($data)) {
        $disk = RC_Filesystem::disk();
        foreach ($data as $row) {
            if (!empty($row ['img_url'])) {
                $disk->delete(RC_Upload::upload_path() . $row['img_url']);
            }
            if (!empty($row['thumb_url'])) {
                $disk->delete(RC_Upload::upload_path() . $row['thumb_url']);
            }
            if (!empty($row['img_original'])) {
                strrpos($row['img_original'], '?') && $row['img_original'] = substr($row['img_original'], 0, strrpos($row['img_original'], '?'));
                $disk->delete(RC_Upload::upload_path() . $row['img_original']);
            }
        }
    }
    /* 删除商品相册 */
    RC_DB::table('goodslib_gallery')->whereIn('goods_id', $goods_id)->delete();
    
    /* 删除相关表记录 */
    RC_DB::table('goodslib_attr')->whereIn('goods_id', $goods_id)->delete();
}

// end