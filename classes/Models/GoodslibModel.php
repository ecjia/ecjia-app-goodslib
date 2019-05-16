<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-02-19
 * Time: 18:16
 */

namespace Ecjia\App\Goodslib\Models;

use Royalcms\Component\Database\Eloquent\Model;

class GoodslibModel extends Model
{

    protected $table = 'goodslib';

    protected $primaryKey = 'goods_id';

    /**
     * 可以被批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = [
        'cat_id',
        'cat_level1_id',
        'cat_level2_id',
        'goods_sn',
        'goods_barcode',
        'goods_name',
        'goods_name_style',
        'brand_id',
        'provider_name',
        'goods_weight',
        'weight_unit',
        'market_price',
        'shop_price',
        'generate_date',
        'expiry_date',
        'limit_days',
        'keywords',
        'pinyin_keyword',
        'goods_brief',
        'goods_desc',
        'goods_thumb',
        'goods_img',
        'original_img',
        'is_real',
        'extension_code',
        'add_time',
        'sort_order',
        'is_delete',
        'last_update',
        'goods_type',
        'review_status',
        'review_content',
        'goods_rank',
        'is_display',
        'used_count',
    ];

    /**
     * 该模型是否被自动维护时间戳
     *
     * @var bool
     */
    public $timestamps = false;
    
    /**
     * 一对多
     * 商品库商品货品集合
     */
    public function goodslib_products_collection()
    {
    	return $this->hasMany('Ecjia\App\Goodslib\Models\GoodslibProductsModel', 'goods_id', 'goods_id');
    }
    
    /**
     * 商品属性信息
     */
    public function goods_attr()
    {
    	return $this->hasMany('Ecjia\App\Goodslib\Models\GoodslibAttrModel', 'goods_id', 'goods_id');
    }

}