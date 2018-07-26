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
class admin extends ecjia_admin {
    
    private $db_goods;
    
    public function __construct() {
        parent::__construct();
        
        $this->orm_goods_db = RC_Model::model('goods/orm_goods_model');
        
        RC_Script::enqueue_script('goods_list', RC_App::apps_url('statics/js/goods_list.js', __FILE__), array('ecjia-utils', 'smoke', 'jquery-validate', 'jquery-form', 'bootstrap-placeholder', 'jquery-wookmark', 'jquery-imagesloaded', 'jquery-colorbox'));
        RC_Script::enqueue_script('jquery-dropper', RC_Uri::admin_url('/statics/lib/dropper-upload/jquery.fs.dropper.js'), array(), false, true);
        RC_Script::enqueue_script('jquery-chosen');
        RC_Style::enqueue_style('chosen');
        RC_Script::enqueue_script('product', RC_App::apps_url('statics/js/product.js', __FILE__), array());
        RC_Style::enqueue_style('goods-colorpicker-style', RC_Uri::admin_url() . '/statics/lib/colorpicker/css/colorpicker.css');
        RC_Script::enqueue_script('goods-colorpicker-script', RC_Uri::admin_url('/statics/lib/colorpicker/bootstrap-colorpicker.js'), array());
        
        RC_Script::enqueue_script('bootstrap-editable-script', RC_Uri::admin_url() . '/statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js', array(), false, false);
        RC_Style::enqueue_style('bootstrap-editable-css', RC_Uri::admin_url() . '/statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css');
        
        //时间控件
        RC_Script::enqueue_script('bootstrap-datepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datepicker.min.js'));
        RC_Style::enqueue_style('datepicker', RC_Uri::admin_url('statics/lib/datepicker/datepicker.css'));
        
        RC_Script::enqueue_script('jquery-uniform');
        RC_Style::enqueue_style('uniform-aristo');
        RC_Script::enqueue_script('jq_quicksearch', RC_Uri::admin_url() . '/statics/lib/multi-select/js/jquery.quicksearch.js', array('jquery'), false, true);
        
        // 		RC_Style::enqueue_style('goodsapi', RC_Uri::home_url('content/apps/goods/statics/styles/goodsapi.css'));
//         RC_Script::enqueue_script('ecjia-region', RC_Uri::admin_url('statics/ecjia.js/ecjia.region.js'), array('jquery'), false, true);
        
        RC_Script::localize_script('goods_list', 'js_lang', RC_Lang::get('goods::goods.js_lang'));
        RC_Style::enqueue_style('goods', RC_App::apps_url('statics/styles/goods.css', __FILE__), array());
        
        RC_Loader::load_app_class('goods', 'goods', false );
        RC_Loader::load_app_class('goodslib', 'goodslib' );
        RC_Loader::load_app_class('goods_image_data', 'goodslib', false);
//         RC_Loader::load_app_class('goods_imageutils', 'goodslib', false);
        
        RC_Loader::load_app_func('admin_category', 'goods');
        RC_Loader::load_app_func('global', 'goods');
        RC_Loader::load_app_func('admin_goods', 'goods');
        
        RC_Loader::load_app_func('admin_user', 'user');
        $goods_list_jslang = array(
            'user_rank_list'	=> get_rank_list(),
            'marketPriceRate'	=> ecjia::config('market_price_rate'),
            'integralPercent'	=> ecjia::config('integral_percent'),
        );
        RC_Script::localize_script( 'goods_list', 'admin_goodsList_lang', $goods_list_jslang );
        
        $goods_id = isset($_REQUEST['goods_id']) ? $_REQUEST['goods_id'] : 0;
//         $extension_code = isset($_GET['extension_code']) ? '&extension_code='.$_GET['extension_code'] : '';
        
        $this->tags = get_goods_info_nav($goods_id);
        $this->tags[ROUTE_A]['active'] = 1;
        
        $this->db_goods 			= RC_Model::model('goods/goods_model');
    }
    
    /**
     * 商品列表
     */
    public function init() {
        $this->admin_priv('goodslib_manage');
        
        $cat_id = empty($_GET['cat_id']) ? 0 : intval($_GET['cat_id']);
        
        $this->assign('ur_here', '商品库');
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('商品库'));
        
        $this->assign('cat_list', cat_list(0, $cat_id, false));
        $this->assign('brand_list', get_brand_list());
        
        $goods_list = goodslib::goods_list(0);
        
        $this->assign('goods_list', $goods_list);
        $this->assign('filter', $goods_list['filter']);
        
        $specifications = get_goods_type_specifications();
        $this->assign('specifications', $specifications);
        
        $this->assign('action_link',      	array('text' => '添加商品', 'href' => RC_Uri::url('goodslib/admin/add')));
        $this->assign('form_action', RC_Uri::url('goodslib/admin/batch'));
        
        $this->display('goodslib_list.dwt');
    }
    
    public function goods_spec() {
        $this->admin_priv('goodslib_goods_type');
        
        
        $this->display('goods_list.dwt');
    }
    
    /**
     * 添加新商品
     */
    public function add() {
        $this->admin_priv('goods_manage'); // 检查权限
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('商品库',  RC_Uri::url('goodslib/admin/init')));
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('添加商品'));
        $this->assign('ur_here', '添加商品库商品');
        $this->assign('action_link', array('href' =>  RC_Uri::url('goodslib/admin/init'), 'text' => '商品列表'));
        
        /* 默认值 */
        $goods = array(
            'goods_id'				=> 0,
            'goods_desc'			=> '',
            'cat_id'				=> $last_choose[0],
            'brand_id'				=> $last_choose[1],
            'goods_type'			=> 0, // 商品类型
            'shop_price'			=> 0,
            'market_price'			=> 0,
            'goods_weight'			=> 0,
        );
        /* 商品名称样式 */
        $goods_name_style = isset($goods['goods_name_style']) ? $goods['goods_name_style'] : '';
        
        /* 模板赋值 */
        $this->assign('tags', array('edit' => array('name' => _('通用信息'), 'active' => 1, 'pjax' => 1, 'href' => RC_Uri::url('goodslib/admin/add'))));
        $this->assign('goods', $goods);
        $this->assign('goods_name_color', $goods_name_style);
        $this->assign('cat_list', cat_list(0, $goods['cat_id'], false));
        $this->assign('brand_list', get_brand_list());
        $this->assign('unit_list',  goods::unit_list());
//         $this->assign('user_rank_list', get_user_rank_list());
        $this->assign('cfg', ecjia::config());
        $this->assign('goods_attr_html', build_attr_html($goods['goods_type'], $goods['goods_id']));
        $volume_price_list = '';
        if (isset($_REQUEST['goods_id'])) {
            $volume_price_list = get_volume_price_list($_REQUEST['goods_id']);
        }
        if (empty($volume_price_list)) {
            $volume_price_list = array('0' => array('number' => '', 'price' => ''));
        }
        $this->assign('volume_price_list', $volume_price_list);
        $this->assign('form_action', RC_Uri::url('goodslib/admin/insert'));
        $this->assign_lang();
        
        $this->display('goodslib_info.dwt');
    }
    
    public function insert() {
        $this->admin_priv('goods_manage'); // 检查权限
        
        /* 检查货号是否重复 */
        if (trim($_POST['goods_sn'])) {
            $count = RC_DB::table('goodslib')->where('goods_sn', $_POST['goods_sn'])->where('is_delete', 0)->count();
            if ($count > 0) {
                return $this->showmessage(RC_Lang::lang('goods_sn_exists'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
        }
        //         RC_Loader::load_app_class('goods_image', 'goods', false);
        
        /* 处理商品图片 */
        $goods_img = ''; // 初始化商品图片
        $goods_thumb = ''; // 初始化商品缩略图
        $img_original = ''; // 初始化原始图片
        
        $upload = RC_Upload::uploader('image', array('save_path' => 'images', 'auto_sub_dirs' => true));
        $upload->add_saving_callback(function ($file, $filename) {
            return true;
        });
            
            /* 是否处理商品图 */
            $proc_goods_img = true;
            if (isset($_FILES['goods_img']) && !$upload->check_upload_file($_FILES['goods_img'])) {
                $proc_goods_img = false;
            }
            /* 是否处理缩略图 */
            //$proc_thumb_img = true;
            $proc_thumb_img = isset($_FILES['thumb_img']) ? true : false;
            if (isset($_FILES['thumb_img']) && !$upload->check_upload_file($_FILES['thumb_img'])) {
                $proc_thumb_img = false;
            }
            
            if ($proc_goods_img) {
                if (isset($_FILES['goods_img'])) {
                    $image_info = $upload->upload($_FILES['goods_img']);
                    if (empty($image_info)) {
                        return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                    }
                }
                
            }
            if ($proc_thumb_img) {
                if (isset($_FILES['thumb_img'])) {
                    $thumb_info = $upload->upload($_FILES['thumb_img']);
                    if (empty($thumb_info)) {
                        return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                    }
                }
            }
            
            /* 如果没有输入商品货号则自动生成一个商品货号 */
            if (empty($_POST['goods_sn'])) {
                $max_id = $this->db_goods->join(null)->field('MAX(goods_id) + 1|max')->find();
                if (empty($max_id['max'])) {
                    $goods_sn_bool = true;
                    $goods_sn = '';
                } else {
                    $goods_sn_bool = false;
                    $goods_sn = generate_goods_sn($max_id['max']);
                }
            } else {
                $goods_sn_bool = false;
                $goods_sn = $_POST['goods_sn'];
            }
            
            /* 处理商品图片 */
            $goods_img = ''; // 初始化商品图片
            $goods_thumb = ''; // 初始化商品缩略图
            $img_original = ''; // 初始化原始图片
            
            /* 处理商品数据 */
            $shop_price = !empty($_POST['shop_price']) ? $_POST['shop_price'] : 0;
            $market_price 	= !empty($_POST['market_price']) && is_numeric($_POST['market_price']) ? $_POST['market_price'] : 0;
            $goods_weight = !empty($_POST['goods_weight']) ? $_POST['goods_weight'] * $_POST['weight_unit'] : 0;
            $goods_type = isset($_POST['goods_type']) ? $_POST['goods_type'] : 0;
            $goods_name = htmlspecialchars($_POST['goods_name']);
            $goods_name_style = htmlspecialchars($_POST['goods_name_color']);
            
            $catgory_id = empty($_POST['cat_id']) ? '' : intval($_POST['cat_id']);
            $brand_id = empty($_POST['brand_id']) ? '' : intval($_POST['brand_id']);
            
            if (empty($goods_name)) {
                return $this->showmessage(__('商品名称不能为空！'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            if (empty($catgory_id)) {
                return $this->showmessage('请选择商品分类', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            
            /* 入库 */
            $data = array(
                'goods_name'            => $goods_name,
                'goods_name_style'      => $goods_name_style,
                'goods_sn'              => $goods_sn,
                'cat_id'                => $catgory_id,
                'brand_id'              => $brand_id,
                'shop_price'            => $shop_price,
                'market_price'          => $market_price,
                'keywords'              => $_POST['keywords'],
                'goods_brief'           => $_POST['goods_brief'],
                'goods_weight'          => $goods_weight,
                'goods_desc'            => !empty($_POST['goods_desc']) ? $_POST['goods_desc'] : '',
                'add_time'              => RC_Time::gmtime(),
                'last_update'           => RC_Time::gmtime(),
                'goods_type'            => $goods_type,
                'review_status'			=> 5,
            );
            
            $insert_id = RC_DB::table('goodslib')->insertGetId($data);
            /* 商品编号 */
            $goods_id = $insert_id;
            
            if ($goods_sn_bool){
                $goods_sn = generate_goods_sn($goods_id);
                $data = array('goods_sn' => $goods_sn);
                $this->db_goods->where('goods_id='.$goods_id)->update($data);
            }
            /* 记录日志 */
            ecjia_admin::admin_log($_POST['goods_name'], 'add', 'goods');
            
            
            /* 更新上传后的商品图片 */
            if ($proc_goods_img) {
                if (isset($image_info)) {
                    $goods_image = new goods_image_data($image_info['name'], $image_info['tmpname'], $image_info['ext'], $goods_id);
                    if ($proc_thumb_img) {
                        $goods_image->set_auto_thumb(false);
                    }
                    $result = $goods_image->update_goods($goods_id);
                    if (is_ecjia_error($result)) {
                        return $this->showmessage($result->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                    }
                }
                
            }
            //TODO 上传图片 good_id 唯一问题，和普通商品冲突
            
            /* 更新上传后的缩略图片 */
            if ($proc_thumb_img) {
                if (isset($thumb_info)) {
                    $thumb_image = new goods_image_data($thumb_info['name'], $thumb_info['tmpname'], $thumb_info['ext'], $goods_id);
                    $result = $thumb_image->update_thumb($goods_id);
                    if (is_ecjia_error($result)) {
                        return $this->showmessage($result->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                    }
                }
            }
            
            /* 记录上一次选择的分类和品牌 */
            setcookie('ECSCP[last_choose]', $catgory_id . '|' . $brand_id, RC_Time::gmtime() + 86400);
            /* 提示页面 */
            $link[] = array(
                'href' => RC_Uri::url('goodslib/admin/init'),
                'text' => '商品列表'
            );
            $link[] = array(
                'href' => RC_Uri::url('goodslib/admin/add'),
                'text' => '继续添加'
            );
            
            for ($i = 0; $i < count($link); $i++) {
                $key_array[] = $i;
            }
            krsort($link);
            $link = array_combine($key_array, $link);
            return $this->showmessage(RC_Lang::lang('add_goods_ok'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array( 'pjaxurl' => RC_Uri::url('goodslib/admin/edit', "goods_id=$goods_id"), 'links' => $link, 'max_id' => $goods_id));
    }
    
    /**
     * 编辑商品
     */
    public function edit() {
        $this->admin_priv('goods_update');
        
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('商品库', RC_Uri::url('goodslib/admin/init')));
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('编辑商品'));
        
        $this->assign('ur_here', '编辑商品');
        $this->assign('action_link', array('href' => RC_Uri::url('goodslib/admin/init'), 'text' => RC_Lang::get('goods::goods.goods_list')));
        
        /* 商品信息 */
        $goods = RC_DB::table('goodslib')->where('goods_id', $_GET['goods_id'])->first();
        if (empty($goods)) {
            return $this->showmessage(RC_Lang::get('goods::goods.no_goods'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR, array('links' => array(array('text' => RC_Lang::get('goods::goods.return_last_page'), 'href' => 'javascript:history.go(-1)'))));
        }
        
        /* 获取商品类型存在规格的类型 */
        $specifications = get_goods_type_specifications();
        if (isset($specifications[$goods['goods_type']])) {
            $goods['specifications_id'] = $specifications[$goods['goods_type']];
        }
        $_attribute = get_goods_specifications_list($goods['goods_id']);
        $goods['_attribute'] = empty($_attribute) ? '' : 1;
        
        if (empty($goods) === true) {
            /* 默认值 */
            $goods = array(
                'goods_id'				=> 0,
                'goods_desc'			=> '',
                'cat_id'				=> 0,
                'shop_price'			=> 0,
                'market_price'			=> 0,
                'goods_weight'			=> 0,
            );
        }
        /* 根据商品重量的单位重新计算 */
        if ($goods['goods_weight'] > 0) {
            $goods['goods_weight_by_unit'] = ($goods['goods_weight'] >= 1) ? $goods['goods_weight'] : ($goods['goods_weight'] / 0.001);
        }
        
        if (!empty($goods['goods_brief'])) {
            $goods['goods_brief'] = $goods['goods_brief'];
        }
        if (!empty($goods['keywords'])) {
            $goods['keywords'] = $goods['keywords'];
        }
        
        /* 商品图片路径 */
        if (!empty($goods['goods_img'])) {
            $goods['goods_img'] = goods_imageutils::getAbsoluteUrl($goods['goods_img']);
            $goods['goods_thumb'] = goods_imageutils::getAbsoluteUrl($goods['goods_thumb']);
            $goods['original_img'] = goods_imageutils::getAbsoluteUrl($goods['original_img']);
        }
        
        /* 拆分商品名称样式 */
        $goods_name_style = explode('+', empty($goods['goods_name_style']) ? '+' : $goods['goods_name_style']);
        
        $cat_list = cat_list(0, $goods['cat_id'], false);
        
        foreach ($cat_list as $k => $v) {
            if (!empty($goods['other_cat']) && is_array($goods['other_cat'])){
                if (in_array($v['cat_id'], $goods['other_cat'])) {
                    $cat_list[$k]['is_other_cat'] = 1;
                }
            }
        }
        
        //设置选中状态,并分配标签导航
        $this->assign('action', 			ROUTE_A);
        $this->assign('tags', 				$this->tags);
        
        $this->assign('goods', 				$goods);
        $this->assign('goods_name_color', 	$goods_name_style[0]);
        $this->assign('cat_list', 			$cat_list);
        
        $this->assign('brand_list', 		get_brand_list());
        $this->assign('unit_list', 			goods::unit_list());
        
        $this->assign('weight_unit', 		$goods['goods_weight'] >= 1 ? '1' : '0.001');
        $this->assign('cfg', 				ecjia::config());
        
        $this->assign('form_act', 			RC_Uri::url('goodslib/admin/edit'));
        $this->assign('form_tab', 			'edit');
        $this->assign('gd', 				RC_ENV::gd_version());
        $this->assign('thumb_width', 		ecjia::config('thumb_width'));
        $this->assign('thumb_height', 		ecjia::config('thumb_height'));
        
        /* 显示商品信息页面 */
        $this->assign('form_action', RC_Uri::url('goodslib/admin/update'));
        
        $this->display('goodslib_info.dwt');
    }
    
    /**
     * 编辑商品
     */
    public function update() {
        $this->admin_priv('goods_update', ecjia::MSGTYPE_JSON);
        $goods_id = $_POST['goods_id'];
        
        /* 检查货号是否重复 */
        if (trim($_POST['goods_sn'])) {
            $count = RC_DB::table('goodslib')->where('goods_sn', trim($_POST['goods_sn']))->where('is_delete', 0)->where('goods_id', '!=', $goods_id)->count();
            if ($count > 0) {
                return $this->showmessage(RC_Lang::get('goods::goods.goods_sn_exists'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
        }
        
        $upload = RC_Upload::uploader('image', array('save_path' => 'images', 'auto_sub_dirs' => true));
        $upload->add_saving_callback(function ($file, $filename) {
            return true;
        });
        /* 是否处理商品图 */
        $proc_goods_img = true;
        if (isset($_FILES['goods_img']) && !$upload->check_upload_file($_FILES['goods_img'])) {
            $proc_goods_img = false;
        }
        /* 是否处理缩略图 */
        //$proc_thumb_img = true;
        $proc_thumb_img = isset($_FILES['thumb_img']) ? true : false;
        if (isset($_FILES['thumb_img']) && !$upload->check_upload_file($_FILES['thumb_img'])) {
            $proc_thumb_img = false;
        }
        
        if ($proc_goods_img) {
            if (isset($_FILES['goods_img'])) {
                $image_info = $upload->upload($_FILES['goods_img']);
                if (empty($image_info)) {
                    return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                }
            }
        }
        if ($proc_thumb_img) {
            if (isset($_FILES['thumb_img'])) {
                $thumb_info = $upload->upload($_FILES['thumb_img']);
                if (empty($thumb_info)) {
                    return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                }
            }
        }
        
        /* 处理商品图片 */
        $goods_img = ''; // 初始化商品图片
        $goods_thumb = ''; // 初始化商品缩略图
        $img_original = ''; // 初始化原始图片
        
        /* 如果没有输入商品货号则自动生成一个商品货号 */
        if (empty($_POST['goods_sn'])) {
            $goods_sn = generate_goods_sn($goods_id);
        } else {
            $goods_sn = trim($_POST['goods_sn']);
        }
        
        /* 处理商品数据 */
        $shop_price 	= !empty($_POST['shop_price']) 		? $_POST['shop_price'] 				: 0;
        $market_price 	= !empty($_POST['market_price']) && is_numeric($_POST['market_price']) ? $_POST['market_price'] : 0;
        
        $goods_weight 	= !empty($_POST['goods_weight']) && is_numeric($_POST['goods_weight']) ? $_POST['goods_weight'] * $_POST['weight_unit'] : 0;
        
        $suppliers_id 	= isset($_POST['suppliers_id']) 	? intval($_POST['suppliers_id']) 	: '0';
        
        $goods_name 		= htmlspecialchars($_POST['goods_name']);
        $goods_name_style 	= htmlspecialchars($_POST['goods_name_color']);
        
        $catgory_id = empty($_POST['cat_id']) 	? 0 : intval($_POST['cat_id']);
        $brand_id 	= empty($_POST['brand_id']) ? 0 : intval($_POST['brand_id']);
        
        if (empty($catgory_id)) {
            return $this->showmessage('请选择商品分类', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        
        if (empty($goods_name)) {
            return $this->showmessage(RC_Lang::get('goods::category.goods_name_null'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        
        $data = array(
            'goods_name'				=> rc_stripslashes($goods_name),
            'goods_name_style'	  		=> $goods_name_style,
            'goods_sn'			  		=> $goods_sn,
            'cat_id'					=> $catgory_id,
            'brand_id'			  		=> $brand_id,
            'shop_price'				=> $shop_price,
            'market_price'		  		=> $market_price,
//             'suppliers_id'		  		=> $suppliers_id,
            'is_real'			   		=> empty($code) ? '1' : '0',
            'extension_code'			=> $code,
            'keywords'			  		=> $_POST['keywords'],
            'goods_brief'		   		=> $_POST['goods_brief'],
            'goods_weight'		 		=> $goods_weight,
            'last_update'		   		=> RC_Time::gmtime(),
        );
        RC_DB::table('goodslib')->where('goods_id', $goods_id)->update($data);
        /* 记录日志 */
        ecjia_admin::admin_log($_POST['goods_name'], 'edit', 'goods');
        
        /* 更新上传后的商品图片 */
        if ($proc_goods_img) {
            if (isset($image_info)) {
                $goods_image = new goods_image_data($image_info['name'], $image_info['tmpname'], $image_info['ext'], $goods_id);
                if ($proc_thumb_img) {
                    $goods_image->set_auto_thumb(false);
                }
                
                $result = $goods_image->update_goods();
                if (is_ecjia_error($result)) {
                    return $this->showmessage($result->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                }
                
            }
        }
        
        /* 更新上传后的缩略图片 */
        if ($proc_thumb_img) {
            if (isset($thumb_info)) {
                $thumb_image = new goods_image_data($thumb_info['name'], $thumb_info['tmpname'], $thumb_info['ext'], $goods_id);
                $result = $thumb_image->update_thumb();
                if (is_ecjia_error($result)) {
                    return $this->showmessage($result->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                }
            }
        }
        
        /* 记录上一次选择的分类和品牌 */
        setcookie('ECSCP[last_choose]', $catgory_id . '|' . $brand_id, RC_Time::gmtime() + 86400);
        
        $link[] = array(
            'href' => RC_Uri::url('goodslib/admin/init'),
            'text' => '商品列表'
        );
        
        return $this->showmessage(RC_Lang::get('goods::goods.edit_goods_ok'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $link, 'pjaxurl' => RC_Uri::url('goodslib/admin/edit', array('goods_id' => $goods_id))));
    }
    
    /**
     * 修改商品价格
     */
    public function edit_goods_price() {
        $this->admin_priv('goods_update', ecjia::MSGTYPE_JSON);
        
        $goods_id = intval($_POST['pk']);
        $goods_price = floatval($_POST['value']);
        $price_rate = floatval(ecjia::config('market_price_rate') * $goods_price);
        $data = array(
            'shop_price'	=> $goods_price,
            'market_price'  => $price_rate,
            'last_update'   => RC_Time::gmtime()
        );
        if ($goods_price < 0 || $goods_price == 0 && $_POST['val'] != "$goods_price") {
            return $this->showmessage(RC_Lang::get('goods::goods.shop_price_invalid'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        } else {
            RC_DB::table('goodslib')->where('goods_id', $goods_id)->update($data);
            return $this->showmessage(RC_Lang::get('goods::goods.edit_ok'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('goodslib/admin/init'), 'content' => number_format($goods_price, 2, '.', '')));
        }
    }
    
    /**
     * 修改上架状态
     */
    public function toggle_on_sale() {
        $this->admin_priv('goods_update', ecjia::MSGTYPE_JSON);
        
        $goods_id = intval($_POST['id']);
        $on_sale = intval($_POST['val']);
        
        $data = array(
            'is_display' => $on_sale,
            'last_update' => RC_Time::gmtime()
        );
        RC_DB::table('goodslib')->where('goods_id', $goods_id)->update($data);
        
        return $this->showmessage(RC_Lang::get('goods::goods.toggle_on_sale'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $on_sale));
    }
    
    /**
     * 修改商品排序
     */
    public function edit_sort_order() {
        $this->admin_priv('goods_update', ecjia::MSGTYPE_JSON);
        
        $goods_id = intval($_POST['pk']);
        $sort_order = intval($_POST['value']);
        $data = array(
            'sort_order' => $sort_order,
            'last_update' => RC_Time::gmtime()
        );
        RC_DB::table('goodslib')->where('goods_id', $goods_id)->update($data);
        
        return $this->showmessage(RC_Lang::get('goods::goods.edit_ok'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_uri::url('goodslib/admin/init', 'cat_id='.$_GET['cat_id'].'&brand_id='.$_GET['brand_id'].'&intro_type='.$_GET['intro_type'].'&page='.$_GET['page'].'&sort_by='.$_GET['sort_by'].'&sort_order='.$_GET['sort_order']), 'content' => $sort_order));
    }
}