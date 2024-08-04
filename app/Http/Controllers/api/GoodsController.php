<?php

namespace App\Http\Controllers\api;

use App\Models\Goods;

class GoodsController extends Controller
{
    public function post_goods_delete()
    {
        try {
            $params = request()->all();
            $Goods = new Goods($this);
            $params['MODIFY_USER'] = session('USER_ID');
            $Goods->delete_goods($params);
            return $this->ok(array('RESULT' => 'OK', 'MESSAGE' => 'SUCCESS。'));
        } catch (\Exception $e) {
            return $this->ok(array('RESULT' => 'NG', 'MESSAGE' => 'ERROR。<br>' . $e->getMessage() ));
        }
    }
    public function post_goods_sort()
    {
        try {
            $params = request()->all();
            $News = new Goods($this);
            $sortedIDs = $params['sortedIDs'] ?? array();
            foreach ($sortedIDs as $k=>$v){
                $update_arr = array();
                $update_arr['sort'] = $k+1;
                $News->update_S_PRODUCT_INFORMATION($v,$update_arr);
            }
            return $this->ok(array('RESULT' => 'OK', 'MESSAGE' => 'SUCCESS。'));
        } catch (\Exception $e) {
            return $this->ok(array('RESULT' => 'NG', 'MESSAGE' => 'ERROR。<br>' . $e->getMessage() ));
        }
    }

    public function post_goods_labledelete()
    {
        try {
            $params = request()->all();
            $Goods = new Goods($this);
            $params['MODIFY_USER'] = session('USER_ID');
            $Goods->delete_lablegoods($params);
            return $this->ok(array('RESULT' => 'OK', 'MESSAGE' => 'SUCCESS。'));
        } catch (\Exception $e) {
            return $this->ok(array('RESULT' => 'NG', 'MESSAGE' => 'ERROR。<br>' . $e->getMessage() ));
        }
    }

    public function post_goods_lable_sort()
    {
        try {
            $params = request()->all();
            $News = new Goods($this);
            $sortedIDs = $params['sortedIDs'] ?? array();
            foreach ($sortedIDs as $k=>$v){
                $update_arr = array();
                $update_arr['sort'] = $k+1;
                $News->update_S_PRODUCT_LABLES($v,$update_arr);
            }
            return $this->ok(array('RESULT' => 'OK', 'MESSAGE' => 'SUCCESS。'));
        } catch (\Exception $e) {
            return $this->ok(array('RESULT' => 'NG', 'MESSAGE' => 'ERROR。<br>' . $e->getMessage() ));
        }
    }

    public function post_goods_bannerdelete()
    {
        try {
            $params = request()->all();
            $Goods = new Goods($this);
            $params['MODIFY_USER'] = session('USER_ID');
            $Goods->delete_bannergoods($params);
            return $this->ok(array('RESULT' => 'OK', 'MESSAGE' => 'SUCCESS。'));
        } catch (\Exception $e) {
            return $this->ok(array('RESULT' => 'NG', 'MESSAGE' => 'ERROR。<br>' . $e->getMessage() ));
        }
    }

    public function post_goods_banner_sort()
    {
        try {
            $params = request()->all();
            $News = new Goods($this);
            $sortedIDs = $params['sortedIDs'] ?? array();
            foreach ($sortedIDs as $k=>$v){
                $update_arr = array();
                $update_arr['sort'] = $k+1;
                $News->update_S_PRODUCT_BANNERS($v,$update_arr);
            }
            return $this->ok(array('RESULT' => 'OK', 'MESSAGE' => 'SUCCESS。'));
        } catch (\Exception $e) {
            return $this->ok(array('RESULT' => 'NG', 'MESSAGE' => 'ERROR。<br>' . $e->getMessage() ));
        }
    }
}
