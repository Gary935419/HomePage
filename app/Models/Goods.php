<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class Goods extends Model
{
    private $Lara;

    public function __construct(&$Lara)
    {
        $this->Lara = $Lara;
    }


    public function get_S_PRODUCT_LABLES()
    {
        return DB::table('S_PRODUCT_LABLES')
            ->where('is_del', '=', 0)
            ->get()->toArray();
    }

    public function select_S_PRODUCT_INFORMATION_info($p_name)
    {
        try {
            return DB::table('S_PRODUCT_INFORMATION')
                ->where('p_name','=',$p_name)
                ->first();
        } catch(\Exception $e) {
            throw $e;
        }
    }

    public function select_S_PRODUCT_INFORMATION_ID_info($id)
    {
        try {
            return DB::table('S_PRODUCT_INFORMATION')
                ->where('id','=',$id)
                ->first();
        } catch(\Exception $e) {
            throw $e;
        }
    }

    public function insert_S_PRODUCT_INFORMATION($insert_S_PRODUCT_INFORMATION_arr)
    {
        return DB::table('S_PRODUCT_INFORMATION')->insertGetId($insert_S_PRODUCT_INFORMATION_arr);
    }

    public function search_goods($params)
    {
        try {
            $m_goods = DB::table('S_PRODUCT_INFORMATION');

//            if (isset($params['D_FROM']) && $params['D_FROM'] != '') {
//                $m_goods = $m_goods->where('mg.create_time', '>=', strtotime($params['D_FROM']));
//            }
//            if (isset($params['D_TO']) && $params['D_TO'] != '') {
//                $m_goods = $m_goods->where('mg.create_time', '<=', strtotime($params['D_TO'])+86400);
//            }
            if (isset($params['p_name']) && $params['p_name'] != '') {
                $m_goods = $m_goods->where('p_name', 'like', '%'.$params['p_name'].'%');
            }

            if (isset($params['p_pdf_url_have']) && !empty($params['p_pdf_url_have'])) {
                $m_goods = $m_goods->whereNotNull('p_pdf_url');
            }

            if (isset($params['p_video_url_have']) && !empty($params['p_video_url_have'])) {
                $m_goods = $m_goods->whereNotNull('p_video_url');
            }

            if (isset($params['p_special_weburl_have']) && !empty($params['p_special_weburl_have'])) {
                $m_goods = $m_goods->whereNotNull('p_special_weburl');
            }

            if (isset($params['p_open_flg']) && !empty($params['p_open_flg'])) {
                $m_goods = $m_goods->where('p_open_flg','=', $params['p_open_flg']);
            }

            $result = $m_goods->where('is_del', '=', 0)
                ->orderBy('id')
                ->get()->toArray();
            return $result;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function select_S_PRODUCT_LABLES_info($id)
    {
        try {
            return DB::table('S_PRODUCT_LABLES')
                ->where('id','=',$id)
                ->first();
        } catch(\Exception $e) {
            throw $e;
        }
    }

    public function delete_goods($params)
    {
        try {
            DB::beginTransaction();
            params_check($params, array('id'));
            DB::table('S_PRODUCT_INFORMATION')
                ->where('id', '=', $params['id'])
                ->update(array(
                    'is_del'     => 1,
                    'MODIFY_DT' => date('Y-m-d',time()),
                    'MODIFY_USER' => $params['MODIFY_USER']
                ));
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update_S_PRODUCT_INFORMATION($id,$update_S_PRODUCT_INFORMATION_arr)
    {
        try {
            DB::table('S_PRODUCT_INFORMATION')
                ->where('id', '=', $id)
                ->update($update_S_PRODUCT_INFORMATION_arr);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function delete_lablegoods($params)
    {
        try {
            DB::beginTransaction();
            params_check($params, array('id'));
            DB::table('S_PRODUCT_LABLES')
                ->where('id', '=', $params['id'])
                ->update(array(
                    'is_del'     => 1,
                    'MODIFY_DT' => date('Y-m-d',time()),
                    'MODIFY_USER' => $params['MODIFY_USER']
                ));
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function select_S_PRODUCT_LABLES_info_one($pr_name)
    {
        try {
            return DB::table('S_PRODUCT_LABLES')
                ->where('pr_name','=',$pr_name)
                ->first();
        } catch(\Exception $e) {
            throw $e;
        }
    }

    public function insert_S_PRODUCT_LABLES($insert_S_PRODUCT_LABLES_arr)
    {
        return DB::table('S_PRODUCT_LABLES')->insertGetId($insert_S_PRODUCT_LABLES_arr);
    }

    public function search_lablegoods($params)
    {
        try {
            $m_goods = DB::table('S_PRODUCT_LABLES');

            if (isset($params['pr_name']) && $params['pr_name'] != '') {
                $m_goods = $m_goods->where('pr_name', 'like', '%'.$params['pr_name'].'%');
            }
            $result = $m_goods->where('is_del', '=', 0)
                ->orderBy('id')
                ->get()->toArray();
            return $result;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function select_S_PRODUCT_LABLES_ID_info($id)
    {
        try {
            return DB::table('S_PRODUCT_LABLES')
                ->where('id','=',$id)
                ->first();
        } catch(\Exception $e) {
            throw $e;
        }
    }

    public function update_S_PRODUCT_LABLES($id,$update_S_PRODUCT_LABLES_arr)
    {
        try {
            DB::table('S_PRODUCT_LABLES')
                ->where('id', '=', $id)
                ->update($update_S_PRODUCT_LABLES_arr);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function select_S_PRODUCT_BANNERS_info_one($b_name)
    {
        try {
            return DB::table('S_PRODUCT_BANNERS')
                ->where('b_name','=',$b_name)
                ->first();
        } catch(\Exception $e) {
            throw $e;
        }
    }

    public function insert_S_PRODUCT_BANNERS($insert_S_PRODUCT_BANNERS_arr)
    {
        return DB::table('S_PRODUCT_BANNERS')->insertGetId($insert_S_PRODUCT_BANNERS_arr);
    }

    public function search_bannergoods($params)
    {
        try {
            $m_goods = DB::table('S_PRODUCT_BANNERS');

            if (isset($params['b_name']) && $params['b_name'] != '') {
                $m_goods = $m_goods->where('b_name', 'like', '%'.$params['b_name'].'%');
            }
            $result = $m_goods->where('is_del', '=', 0)
                ->orderBy('id')
                ->get()->toArray();
            return $result;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function select_S_PRODUCT_BANNERS_ID_info($id)
    {
        try {
            return DB::table('S_PRODUCT_BANNERS')
                ->where('id','=',$id)
                ->first();
        } catch(\Exception $e) {
            throw $e;
        }
    }

    public function update_S_PRODUCT_BANNERS($id,$update_S_PRODUCT_BANNERS_arr)
    {
        try {
            DB::table('S_PRODUCT_BANNERS')
                ->where('id', '=', $id)
                ->update($update_S_PRODUCT_BANNERS_arr);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function delete_bannergoods($params)
    {
        try {
            DB::beginTransaction();
            params_check($params, array('id'));
            DB::table('S_PRODUCT_BANNERS')
                ->where('id', '=', $params['id'])
                ->update(array(
                    'is_del'     => 1,
                    'MODIFY_DT' => date('Y-m-d',time()),
                    'MODIFY_USER' => $params['MODIFY_USER']
                ));
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
