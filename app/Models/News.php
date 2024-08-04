<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class News extends Model
{
    private $Lara;

    public function __construct(&$Lara)
    {
        $this->Lara = $Lara;
    }


    public function select_S_NEWS_name_type($n_title,$n_type)
    {
        try {
            return DB::table('S_NEWS')
                ->where('n_title','=',$n_title)
                ->where('n_type','=',$n_type)
                ->first();
        } catch(\Exception $e) {
            throw $e;
        }
    }

    public function insert_S_NEWS($insert_S_NEWS_arr)
    {
        $id = DB::table('S_NEWS')->insertGetId($insert_S_NEWS_arr);
        DB::table('S_NEWS')
            ->where('id', '=', $id)
            ->update(array(
                'sort' => $id
            ));
    }

    public function search_news($params)
    {
        try {
            $m_goods = DB::table('S_NEWS');

            if (isset($params['n_type_arr']) && !empty($params['n_type_arr'])) {
                $m_goods = $m_goods->whereIn('n_type', $params['n_type_arr']);
            }
            if (isset($params['D_FROM']) && $params['D_FROM'] != '') {
                $m_goods = $m_goods->where('n_open_date', '>=', $params['D_FROM']);
            }
            if (isset($params['D_TO']) && $params['D_TO'] != '') {
                $m_goods = $m_goods->where('n_open_date', '<=', $params['D_TO']);
            }
            if (isset($params['n_open_flg']) && !empty($params['n_open_flg'])) {
                $m_goods = $m_goods->where('n_open_flg','=', $params['n_open_flg']);
            }
            if (isset($params['key_str']) && $params['key_str'] != '') {
                $m_goods = $m_goods->where('n_title', 'like', '%'.$params['key_str'].'%');
            }

            $result = $m_goods->where('is_del', '=', 0)
                ->orderBy('sort')
                ->get()->toArray();


            return $result;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function select_S_NEWS_ID_info($id)
    {
        try {
            return DB::table('S_NEWS')
                ->where('id','=',$id)
                ->first();
        } catch(\Exception $e) {
            throw $e;
        }
    }

    public function update_S_NEWS($id,$update_S_NEWS_arr)
    {
        try {
            DB::table('S_NEWS')
                ->where('id', '=', $id)
                ->update($update_S_NEWS_arr);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function news_delete($params)
    {
        try {
            params_check($params, array('id'));
            DB::table('S_NEWS')
                ->where('id', '=', $params['id'])
                ->update(array(
                    'is_del'     => 1,
                    'MODIFY_DT' => date('Y-m-d',time()),
                    'MODIFY_USER' => $params['MODIFY_USER']
                ));
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function search_news_sort_n_open_date()
    {
        try {
            $m_goods = DB::table('S_NEWS');
            $result = $m_goods->where('is_del', '=', 0)
                ->orderBy('n_open_date','DESC')
                ->get()->toArray();
            return $result;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
