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


// end