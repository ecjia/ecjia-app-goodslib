<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-05-06
 * Time: 09:28
 */

namespace Ecjia\App\Goodslib\GoodsImage\Product;


use Ecjia\App\Goodslib\Models\GoodslibProductsModel;
use ecjia_error;

class ProductThumb extends ProductImage
{

    /**
     * 更新图片到数据库
     */
    public function updateToDatabase($img_desc = null)
    {
        //$img_desc 用不到，不需要存储

        list($original_path, $img_path, $thumb_path) = $this->saveImageToDisk();

        if (!empty($thumb_path)) {
            return new ecjia_error('upload_goods_thumb_error', __('商品缩略图路径无效', 'goods'));
        }

        //存入数据库中
        $data = array(
            'thumb_url' 	=> $thumb_path,
        );

        $model = GoodslibProductsModel::where('goods_id', $this->goods_id)->where('product_id', $this->product_id)->update($data);
        if (! empty($model)) {
            return new ecjia_error('upload_thumb_image_fail', __('商品缩略图上传失败', 'goods'));
        }

        return true;
    }

}