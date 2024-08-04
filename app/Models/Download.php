<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class Download extends Model
{
    private $Lara;

    public function __construct(&$Lara)
    {
        $this->Lara = $Lara;
    }

    public function get_S_DOWNLOADS_CATEGORY()
    {
        return DB::table('S_DOWNLOADS_CATEGORY')
            ->where('is_del', '=', 0)
            ->orderBy('sort')
            ->get()->toArray();
    }

    public function select_S_DOWNLOADS_info($d_file_name)
    {
        try {
            return DB::table('S_DOWNLOADS')
                ->where('d_file_name','=',$d_file_name)
                ->first();
        } catch(\Exception $e) {
            throw $e;
        }
    }

    public function select_S_DOWNLOADS_ID_info($id)
    {
        try {
            return DB::table('S_DOWNLOADS')
                ->where('id','=',$id)
                ->first();
        } catch(\Exception $e) {
            throw $e;
        }
    }

    public function insert_S_DOWNLOADS($insert_S_DOWNLOADS_arr)
    {
        $id = DB::table('S_DOWNLOADS')->insertGetId($insert_S_DOWNLOADS_arr);
        DB::table('S_DOWNLOADS')
            ->where('id', '=', $id)
            ->update(array(
                'd_sort' => $id
            ));
    }

    public function search_S_DOWNLOADS($params)
    {
        try {
            $m_goods = DB::table('S_DOWNLOADS');

            if (isset($params['d_file_name']) && $params['d_file_name'] != '') {
                $m_goods = $m_goods->where('d_file_name', 'like', '%'.$params['d_file_name'].'%');
            }
            $result = $m_goods->where('is_del', '=', 0)
                ->orderBy('d_sort')
                ->get()->toArray();
            return $result;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function select_S_DOWNLOADS_name_info($d_file_name)
    {
        try {
            return DB::table('S_DOWNLOADS')
                ->where('d_file_name','=',$d_file_name)
                ->first();
        } catch(\Exception $e) {
            throw $e;
        }
    }

    public function delete_S_DOWNLOADS($params)
    {
        try {
            params_check($params, array('id'));
            DB::table('S_DOWNLOADS')
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

    public function update_S_DOWNLOADS($id,$update_S_DOWNLOADS_arr)
    {
        try {
            DB::table('S_DOWNLOADS')
                ->where('id', '=', $id)
                ->update($update_S_DOWNLOADS_arr);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function select_S_DOWNLOADS_CATEGORY_info($id)
    {
        try {
            return DB::table('S_DOWNLOADS_CATEGORY')
                ->where('id','=',$id)
                ->first();
        } catch(\Exception $e) {
            throw $e;
        }
    }


    public function select_S_DOWNLOADS_CATEGORY_info_name($category_name)
    {
        try {
            return DB::table('S_DOWNLOADS_CATEGORY')
                ->where('category_name','=',$category_name)
                ->first();
        } catch(\Exception $e) {
            throw $e;
        }
    }

    public function insert_S_DOWNLOADS_CATEGORY($insert_S_DOWNLOADS_CATEGORY_arr)
    {
        $id = DB::table('S_DOWNLOADS_CATEGORY')->insertGetId($insert_S_DOWNLOADS_CATEGORY_arr);
        DB::table('S_DOWNLOADS_CATEGORY')
            ->where('id', '=', $id)
            ->update(array(
                'sort' => $id
            ));

    }

    public function search_S_DOWNLOADS_CATEGORY($params)
    {
        try {
            $m_goods = DB::table('S_DOWNLOADS_CATEGORY');
            if (isset($params['category_name']) && $params['category_name'] != '') {
                $m_goods = $m_goods->where('category_name', 'like', '%'.$params['category_name'].'%');
            }
            if (isset($params['open_flg']) && !empty($params['open_flg'])) {
                $m_goods = $m_goods->where('open_flg', $params['open_flg']);
            }
            $result = $m_goods->where('is_del', '=', 0)
                ->orderBy('sort')
                ->get()->toArray();

            return $result;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function update_S_DOWNLOADS_CATEGORY($id,$update_S_DOWNLOADS_CATEGORY_arr)
    {
        try {
            DB::table('S_DOWNLOADS_CATEGORY')
                ->where('id', '=', $id)
                ->update($update_S_DOWNLOADS_CATEGORY_arr);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function delete_S_DOWNLOADS_CATEGORY($params)
    {
        try {
            params_check($params, array('id'));
            DB::table('S_DOWNLOADS_CATEGORY')
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

    public function search_S_DOWNLOADS_HISTORY($params)
    {
        try {
            $m_goods = DB::table('S_DOWNLOADS_HISTORY');
            if (isset($params['user_name']) && $params['user_name'] != '') {
                $m_goods = $m_goods->where('user_name', 'like', '%'.$params['user_name'].'%');
            }
            if (isset($params['company_name']) && $params['company_name'] != '') {
                $m_goods = $m_goods->where('company_name', 'like', '%'.$params['company_name'].'%');
            }
            if (isset($params['phone_number']) && $params['phone_number'] != '') {
                $m_goods = $m_goods->where('phone_number', 'like', '%'.$params['phone_number'].'%');
            }
            if (isset($params['email']) && $params['email'] != '') {
                $m_goods = $m_goods->where('email', 'like', '%'.$params['email'].'%');
            }
            $result = $m_goods->where('is_del', '=', 0)
                ->orderBy('id')
                ->get()->toArray();

            return $result;
        } catch (\Exception $e) {
            throw $e;
        }
    }
    public function select_DOWNLOADS_HISTORY_count()
    {
        try {
            return DB::table('S_DOWNLOADS_HISTORY')
                ->select(DB::raw('count(*) as count'))
                ->where('is_del','=',0)
                ->value('count');
        } catch(\Exception $e) {
            throw $e;
        }
    }
}
