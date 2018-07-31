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

/**
 *  ECJIA 商品管理程序
 */
class merchant extends ecjia_merchant {
    private $db_link_goods;
    private $db_group_goods;
    
    private $db_goods;
    private $db_goods_article;
    private $db_goods_attr;
    private $db_goods_attr_view;
    private $db_goods_cat;
    private $db_goods_gallery;
    
    private $db_attribute;
    private $db_products;
    private $db_brand;
    private $db_category;
    
    private $db_term_meta;
    private $db_term_relationship;
    
    private $tags;

	public function __construct() {
		parent::__construct();
		
		$this->db_link_goods 		= RC_Model::model('goods/link_goods_model');
		$this->db_group_goods 		= RC_Model::model('goods/group_goods_model');
		
		$this->db_goods 			= RC_Model::model('goods/goods_model');
		$this->db_goods_article 	= RC_Model::model('goods/goods_article_model');
		$this->db_goods_attr 		= RC_Model::model('goods/goods_attr_model');
		$this->db_goods_attr_view 	= RC_Model::model('goods/goods_attr_viewmodel');
		$this->db_goods_cat 		= RC_Model::model('goods/goods_cat_model');
		$this->db_goods_gallery 	= RC_Model::model('goods/goods_gallery_model');
		
		$this->db_attribute 		= RC_Model::model('goods/attribute_model');
		$this->db_products 			= RC_Model::model('goods/products_model');
		$this->db_brand 			= RC_Model::model('goods/brand_model');
		$this->db_category 			= RC_Model::model('goods/category_model');
		
		$this->db_term_meta 		= RC_Loader::load_sys_model('term_meta_model');
		$this->db_term_relationship = RC_Model::model('goods/term_relationship_model');
		
		RC_Style::enqueue_style('jquery-placeholder');
		RC_Script::enqueue_script('jquery-imagesloaded');
		RC_Script::enqueue_script('jquery-dropper', RC_Uri::admin_url('/statics/lib/dropper-upload/jquery.fs.dropper.js'), array(), false, true);
		RC_Style::enqueue_style('goods-colorpicker-style', RC_Uri::admin_url() . '/statics/lib/colorpicker/css/colorpicker.css');
		RC_Script::enqueue_script('goods-colorpicker-script', RC_Uri::admin_url('/statics/lib/colorpicker/bootstrap-colorpicker.js'), array());
		
		RC_Script::enqueue_script('jq_quicksearch', RC_Uri::admin_url() . '/statics/lib/multi-select/js/jquery.quicksearch.js', array('jquery'), false, true);
// 		RC_Script::enqueue_script('ecjia-region', RC_Uri::admin_url('statics/ecjia.js/ecjia.region.js'), array('jquery'), false, true);
		
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('jquery-ui');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('jquery-colorbox');
		RC_Style::enqueue_style('jquery-colorbox');
		
		RC_Script::enqueue_script('ecjia-mh-editable-js');
		RC_Style::enqueue_style('ecjia-mh-editable-css');
		
		//时间控件
		RC_Script::enqueue_script('bootstrap-datepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datepicker.min.js'));
		RC_Style::enqueue_style('datepicker', RC_Uri::admin_url('statics/lib/datepicker/datepicker.css'));
		
		RC_Style::enqueue_style('goods', RC_App::apps_url('statics/styles/goods.css', __FILE__), array());
		RC_Script::enqueue_script('goods_list', RC_App::apps_url('statics/js/merchant_goods_list.js', __FILE__), array(), false, true);
// 		RC_Script::enqueue_script('product', RC_App::apps_url('statics/js/merchant_product.js', __FILE__), array(), false, true);
		
		RC_Script::localize_script('goods_list', 'js_lang', RC_Lang::get('goods::goods.js_lang'));
		
		RC_Loader::load_app_class('goods', 'goods', false);
		RC_Loader::load_app_class('goodslib', 'goodslib', false);
		RC_Loader::load_app_class('goods_image_data', 'goods', false);
		RC_Loader::load_app_class('goods_imageutils', 'goods', false);

		RC_Loader::load_app_func('merchant_goods', 'goods');
		RC_Loader::load_app_func('global', 'goods');
		RC_Loader::load_app_func('global', 'goodslib');
		RC_Loader::load_app_func('admin_category', 'goods');
		
		RC_Loader::load_app_func('admin_user', 'user');
		$goods_list_jslang = array(
			'user_rank_list'	=> get_rank_list(),
			'marketPriceRate'	=> ecjia::config('market_price_rate'),
			'integralPercent'	=> ecjia::config('integral_percent'),
		);
		RC_Script::localize_script( 'goods_list', 'admin_goodsList_lang', $goods_list_jslang );
		
		$goods_id = isset($_REQUEST['goods_id']) ? $_REQUEST['goods_id'] : 0;
		$extension_code = isset($_GET['extension_code']) ? '&extension_code='.$_GET['extension_code'] : '';
		
// 		$this->tags = get_merchant_goods_info_nav($goods_id, $extension_code);
// 		$this->tags[ROUTE_A]['active'] = 1;
		
		ecjia_merchant_screen::get_current_screen()->set_parentage('goods', 'goods/merchant.php');
		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('goods::goods.goods_manage'), RC_Uri::url('goods/merchant/init')));
	}

	/**
	* 商品列表
	*/
	public function init() {
	    // 检查权限
	    $this->admin_priv('goodslib_manage');
	    
	    $href = strpos($_SERVER['HTTP_REFERER'], 'm=goods&c=admin&a=init') ? $_SERVER['HTTP_REFERER'] : RC_Uri::url('goods/merchant/init');
	    
	    ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here('一键导入', RC_Uri::url('goodslib/merchant/init')));
	    
	    $cat_id 	= !empty($_GET['cat_id']) 		? intval($_GET['cat_id']) 		: 0;
// 	    $brand_id  	= !empty($_POST['brand_id']) 	? intval($_POST['brand_id']) 	: 0;
	    
	    //所属平台分类
        $cat_list = cat_list(0, 0, false, 1, false);	//平台分类
        $ur_here = '选择商品分类';
        $this->assign('step', 1);
        $this->assign('cat_list', $cat_list);
	    
	    $this->assign('ur_here', $ur_here);
	    ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here($ur_here));
	    
// 	    $goods = array(
// 	        'goods_id'				=> 0,
// 	        'goods_desc'			=> '',
// 	        'cat_id'				=> $cat_id,
// 	        'brand_id'				=> $brand_id,
// 	        'is_on_sale'			=> '1',
// 	        'is_alone_sale'			=> '1',
// 	        'is_shipping'			=> '0',
// 	        'other_cat'				=> array(), // 扩展分类
// 	        'goods_type'			=> 0, 		// 商品类型
// 	        'shop_price'			=> 0,
// 	        'promote_price'			=> 0,
// 	        'market_price'			=> 0,
// 	        'integral'				=> 0,
// 	        'goods_number'			=> ecjia::config('default_storage'),
// 	        'warn_number'			=> 1,
// 	        'promote_start_date'	=> RC_Time::local_date('Y-m-d'),
// 	        'promote_end_date'		=> RC_Time::local_date('Y-m-d', RC_Time::local_strtotime('+1 month')),
// 	        'goods_weight'			=> 0,
// 	        'give_integral'			=> -1,
// 	        'rank_integral'			=> -1
// 	    );
	    
// 	    /* 商品名称样式 */
// 	    $goods_name_style = isset($goods['goods_name_style']) ? $goods['goods_name_style'] : '';
// 	    /* 模板赋值 */
// 	    $this->assign('tags', array('edit' => array('name' => RC_Lang::get('goods::goods.tab_general'), 'active' => 1, 'pjax' => 1, 'href' => RC_Uri::url('goodslib/merchant/add'))));
	    
// 	    $this->assign('goods', $goods);
// 	    $this->assign('goods_name_color', $goods_name_style);
	    
// 	    $this->assign('brand_list', get_brand_list());
// 	    $this->assign('unit_list', goods::unit_list());
// 	    $this->assign('user_rank_list', get_rank_list());
	    
	    $this->assign('cfg', ecjia::config());
	    $this->assign('goods_attr_html', build_merchant_attr_html($goods['goods_type'], $goods['goods_id']));
	    
// 	    $volume_price_list = '';
// 	    if (isset($_GET['goods_id'])) {
// 	        $volume_price_list = get_volume_price_list($_GET['goods_id']);
// 	    }
// 	    if (empty($volume_price_list)) {
// 	        $volume_price_list = array('0' => array('number' => '', 'price' => ''));
// 	    }
// 	    $this->assign('volume_price_list', $volume_price_list);
	    $this->assign('form_action', RC_Uri::url('goodslib/merchant/insert', array('cat_id' => $cat_id)));
	    
	    if (!empty($cat_id)) {
	        $this->display('goods_info.dwt');
	    } else {
	        $this->display('goods_cat_select.dwt');
	    }
	}
	
	
	public function add() {
	    // 检查权限
	    $this->admin_priv('goodslib_manage');
	    
	    ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here('一键导入', RC_Uri::url('goodslib/merchant/init')));
	    
	    $cat_id 	= !empty($_GET['cat_id']) 		? intval($_GET['cat_id']) 		: 0;
	    
	    if(empty($cat_id)) {
	        return $this->showmessage('请先选择分类', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('pjaxurl' => RC_Uri::url('goods/merchant/select_cat')));
	    }
	    
        $ur_here = '选择商品';
        $this->assign('step', 2);
        
        $goods_list = goodslib::goods_list(0);
        
        $this->assign('goods_list', $goods_list);
        $this->assign('filter', $goods_list['filter']);
	    
	    $this->assign('ur_here', $ur_here);
	    ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here($ur_here));
	    
	    $this->assign('form_action', RC_Uri::url('goodslib/merchant/insert', array('cat_id' => $cat_id)));
	    
        $this->display('goods_list.dwt');
	}
	
	/**
	 * 导入
	 */
	public function insert() {
	    //规格属性货品
	    //主表
	    
// 	    $id = !empty($_POST['goods_id']) 		? intval($_POST['goods_id']) 		: 0;
	    $id = !empty($_GET['goods_id']) 		? intval($_GET['goods_id']) 		: 0;
	    if(empty($id)) {
	        return $this->showmessage('请先选择分类', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('pjaxurl' => RC_Uri::url('goods/merchant/select_cat')));
	    }
	    
	    $manage_mode = RC_DB::table('store_franchisee')->where('store_id', $_SESSION['store_id'])->pluck('manage_mode');
	    
	    /* 商品信息 */
	    $goods = RC_DB::table('goodslib')->where('goods_id', $id)->first();
	    if (empty($goods)) {
	        return $this->showmessage(RC_Lang::get('goods::goods.no_goods'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR, array('links' => array(array('text' => RC_Lang::get('goods::goods.return_last_page'), 'href' => 'javascript:history.go(-1)'))));
	    }
	    
	    $count_goods_sn = RC_DB::table('goods')->where('goods_sn', $goods['goods_sn'])->where('goods_sn', $_SESSION['store_id'])->where('is_delete', 0)->count();
	    if($count_goods_sn) {
	        $goods['goods_sn'] = '';
	    }
	    unset($goods['goods_id']);unset($goods['is_display']);unset($goods['used_count']);unset($goods['is_delete']);
	    $goods['store_id'] = $_SESSION['store_id'];
	    $goods['is_on_sale'] = 0;
	    
	    $new_id = RC_DB::table('goods')->insertGetId($goods);
	    RC_DB::table('goodslib')->where('goods_id', $id)->increment('used_count');
	    if(!empty($goods['goods_thumb'])) {
	        
	    }
	    if(!empty($goods['goods_desc'])) {
	        
	    }
	    $goods_gallery = RC_DB::table('goodslib_gallery')->where('goods_id', $id)->get();
	    if (!empty($goods_gallery)) {
	        
	        RC_DB::table('goods_gallery')->insert($goods_gallery);
	        //TODO复制图片-重命名
	    }
	    
	    /* 获取商品类型存在规格的类型 */
// 	    $specifications = get_goods_type_specifications();
// 	    if (isset($specifications[$goods['goods_type']])) {
// 	        $goods['specifications_id'] = $specifications[$goods['goods_type']];
// 	    }
// 	    $_attribute = get_goodslib_specifications_list($id);
// 	    _dump($specifications,1);
	    if ($goods['goods_type']) {
	        $goods_attr = RC_DB::table('goodslib_attr')->where('goods_id', $id)->get();
	        if($goods_attr) {
	            $attr_arr = [];
	            foreach ($goods_attr as $row) {
	                $attr_arr[] = $row['attr_id'];
	            }
	            $attr_arr = array_unique($attr_arr);
	            
	            $goods_attribute = RC_DB::table('goodslib_attribute')->whereIn('attr_id', $attr_arr)->get();
	            if ($goods_attribute) {
	                $cat_id = $goods_attribute[0]['cat_id'];
	            }
	            
	            $goods_type = RC_DB::table('goodslib_type')->where('cat_id', $cat_id)->first();
	            if($goods_type) {
	                //判断有无
	                if ($manage_mode == 'self') {
	                    $goods_type_store = RC_DB::table('goods_type')->where('cat_name', $goods_type['cat_name'])
	                    ->where(function ($query) {
	                           $query->where('store_id', $_SESSION['store_id'])
	                           ->orWhere('store_id', 0);
    	                    })->first();
	                } else {
	                    $goods_type_store = RC_DB::table('goods_type')->where('cat_name', $goods_type['cat_name'])->where('store_id', $_SESSION['store_id'])->first();
	                }
	                //goods_type
	                if($goods_type_store) {
	                    if($goods_type_store['enabled'] == 0) {
	                        RC_DB::table('goods_type')->where('cat_id', $goods_type_store['cat_id'])->update(array('enabled' => 1));
	                    }
	                    RC_DB::table('goods')->where('goods_id', $new_id)->where('store_id', $_SESSION['store_id'])->update(array('goods_type' => $goods_type_store['cat_id']));
	                    //attribute
	                    $goods_attribute_store = RC_DB::table('attribute')->whereIn('cat_id', $goods_type_store['cat_id'])->get();
	                    //判断和商品库是否一致
	                    foreach ($goods_attribute as $row) {
	                        unset($row['attr_id']);unset($row['cat_id']);
	                        $have_attr = 0;
	                        foreach ($goods_attribute_store as $row_store) {
	                            unset($row_store['attr_id']);unset($row_store['cat_id']);
	                            if ($row == $row_store) {
	                                $have_attr = 1;
	                                break;
	                            }
	                        }
	                        if ($have_attr == 0) {
	                            $row['cat_id'] = $goods_type_store['cat_id'];
	                            RC_DB::table('attribute')->insert($row);
	                        }
	                    }
	                    
	                    //goods_attr attr_id
	                    foreach ($goods_attr as $row) {
	                        unset($row['goods_attr_id']);
	                        $row_attr = RC_DB::table('goodslib_attribute')->where('attr_id', $row['attr_id'])->first();
	                        $attr_id = RC_DB::table('attribute')->where('cat_id', $goods_type_store['cat_id'])->where('attr_name', $row_attr['attr_name'])->where('attr_values', $row_attr['attr_values'])->pluck('attr_id');
	                        $row['goods_id'] = $new_id;
	                        $row['attr_id'] = $attr_id;
	                        RC_DB::table('goods_attr')->insert($row);
	                    }
	                    
	                    //product
	                    
	                    
	                } else {
	                    unset($goods_type['cat_id']);
	                    $goods_type['store_id'] = $_SESSION['store_id'];
	                    $cat_id_new = RC_DB::table('goods_type')->insertGetId($goods_type);
	                    RC_DB::table('goods')->where('goods_id', $new_id)->where('store_id', $_SESSION['store_id'])->update(array('goods_type' => $cat_id_new));
	                    
	                    foreach ($goods_attribute as $row) {
	                        unset($row['attr_id']);unset($row['cat_id']);
	                        $row['cat_id'] = $cat_id_new;
	                        RC_DB::table('attribute')->insert($row);
	                    }
	                    
	                    //goods_attr attr_id
	                    foreach ($goods_attr as $row) {
	                        unset($row['goods_attr_id']);
	                        $row_attr = RC_DB::table('goodslib_attribute')->where('attr_id', $row['attr_id'])->first();
	                        $attr_id = RC_DB::table('attribute')->where('cat_id', $cat_id_new)->where('attr_name', $row_attr['attr_name'])->where('attr_values', $row_attr['attr_values'])->pluck('attr_id');
	                        $row['goods_id'] = $new_id;
	                        $row['attr_id'] = $attr_id;
	                        RC_DB::table('goods_attr')->insert($row);
	                    }
	                    
	                    //product
	                    
	                    
	                }
	                
	                
	                
	            }
	            
	        }
	    }
	    
	       
	    
	    
	    $url = RC_Uri::url('goodslib/merchant/done', array());
	    return $this->showmessage('导入成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('url' => $url, 'goods_id' => $new_id));
	    
	}
	
	public function done() {
	    $ur_here = '导入成功';
	    $this->assign('step', 3);
	    
	    
	    $this->assign('ur_here', $ur_here);
	    ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here($ur_here));
	    
	    $this->display('done.dwt');
	}
	
	
	/**
	 * 预览
	 */
	public function preview() {
	    $this->admin_priv('goods_manage');
	    
	    $goods_id = !empty($_GET['id']) ? intval($_GET['id']) : 0;
	    if (empty($goods_id)) {
	        return $this->showmessage(RC_Lang::get('goods::goods.no_goods'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR, array('links' => array(array('text' => RC_Lang::get('goods::goods.return_last_page'), 'href' => 'javascript:history.go(-1)'))));
	    }
	    
	    //RC_Hook::do_action('goods_merchant_priview_handler', $goods_id);
	    
	    ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('goods::goods.goods_preview')));
	    
	    $this->assign('ur_here', RC_Lang::get('goods::goods.goods_preview'));
// 	    $this->assign('action_link', array('text' => RC_Lang::get('goods::goods.goods_list'), 'href' => RC_Uri::url('goods/merchant/init')));
	    
	    $goods = RC_DB::table('goodslib')->where('goods_id', $goods_id)->where('is_display', 1)->where('is_delete', 0)->first();
	    
	    if (empty($goods)) {
	        return $this->showmessage(RC_Lang::get('goods::goods.no_goods'), ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_HTML, array('links' => array(array('text'=> RC_Lang::get('goods::goods.back_goods_list'),'href'=>RC_Uri::url('goods/merchant/init')))));
	    }
	    
	    if (!empty($goods['goods_desc'])) {
	        $goods['goods_desc'] = stripslashes($goods['goods_desc']);
	    }
	    
	    $cat_name = RC_DB::table('category')->where('cat_id', $goods['cat_id'])->pluck('cat_name');
	    $brand_name = RC_DB::table('brand')->where('brand_id', $goods['brand_id'])->pluck('brand_name');
	    $disk = RC_Filesystem::disk();
	    if (!$disk->exists(RC_Upload::upload_path($goods['goods_thumb'])) || empty($goods['goods_thumb'])) {
	        $goods['goods_thumb'] = RC_Uri::admin_url('statics/images/nopic.png');
	        $goods['goods_img'] = RC_Uri::admin_url('statics/images/nopic.png');
	    } else {
	        $goods['goods_thumb'] = RC_Upload::upload_url($goods['goods_thumb']);
	        $goods['goods_img'] = RC_Upload::upload_url($goods['goods_img']);
	    }
	    if (!empty($goods['add_time'])) {
	        $goods['add_time'] = RC_Time::local_date(ecjia::config('time_format'), $goods['add_time']);
	    }
	    if (!empty($goods['last_update'])) {
	        $goods['last_update'] = RC_Time::local_date(ecjia::config('time_format'), $goods['last_update']);
	    }
	    
	    $code = isset($_GET['extension_code']) ? 'virtual_card' : '';
	    $this->assign('code', $code);
	    
	    $images_url = RC_App::apps_url('statics/images', __FILE__);
	    $this->assign('images_url', $images_url);
	    
	    //商品相册
	    $goods_photo_list = RC_DB::table('goodslib_gallery')->where('goods_id', $goods['goods_id'])->get();
	    if (!empty($goods_photo_list)) {
	        $disk = RC_Filesystem::disk();
	        foreach ($goods_photo_list as $k => $v) {
	            if (!$disk->exists(RC_Upload::upload_path($v['img_url'])) || empty($v['img_url'])) {
	                $goods_photo_list[$k]['img_url'] = RC_Uri::admin_url('statics/images/nopic.png');
	            } else {
	                $goods_photo_list[$k]['img_url'] = RC_Upload::upload_url($v['img_url']);
	            }
	            
	            if (!$disk->exists(RC_Upload::upload_path($v['thumb_url'])) || empty($v['thumb_url'])) {
	                $goods_photo_list[$k]['thumb_url'] = RC_Uri::admin_url('statics/images/nopic.png');
	            } else {
	                $goods_photo_list[$k]['thumb_url'] = RC_Upload::upload_url($v['thumb_url']);
	            }
	        }
	    }
	    $this->assign('goods_photo_list', $goods_photo_list);
	    
	    //商品属性
	    $attr_list = get_goodslib_cat_attr_list($goods['goods_type'], $goods_id);
	    $this->assign('attr_list', $attr_list);
	    
	    $this->assign('no_picture', RC_Uri::admin_url('statics/images/nopic.png'));
	    /* 取得分类、品牌 */
	    $this->assign('goods', $goods);
	    $this->assign('cat_name', $cat_name);
	    $this->assign('brand_name', $brand_name);
	    
	    $this->display('preview.dwt');
	}

}

// end