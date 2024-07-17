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
}
