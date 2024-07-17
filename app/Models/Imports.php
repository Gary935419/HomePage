<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class Imports extends Model
{
    private $Lara;

    public function __construct(&$Lara)
    {
        $this->Lara = $Lara;
    }


    public function get_S_PRODECT_LABLES()
    {
        return DB::table('S_PRODECT_LABLES')
            ->where('is_del', '=', 0)
            ->get()->toArray();
    }

    public function select_S_PRECEDENTS_INFORMATION_info($pr_title)
    {
        try {
            return DB::table('S_PRECEDENTS')
                ->where('pr_title','=',$pr_title)
                ->first();
        } catch(\Exception $e) {
            throw $e;
        }
    }

    public function select_S_PRECEDENTS_ID_info($id)
    {
        try {
            return DB::table('S_PRECEDENTS')
                ->where('id','=',$id)
                ->first();
        } catch(\Exception $e) {
            throw $e;
        }
    }

    public function insert_S_PRECEDENTS($insert_S_PRECEDENTS_INFORMATION_arr)
    {
        return DB::table('S_PRECEDENTS')->insertGetId($insert_S_PRECEDENTS_INFORMATION_arr);
    }

    public function search_recedents($params)
    {
        try {
            $m_goods = DB::table('S_PRECEDENTS');

            if (isset($params['pr_title']) && $params['pr_title'] != '') {
                $m_goods = $m_goods->where('pr_title', 'like', '%'.$params['pr_title'].'%');
            }
            if (isset($params['guild_name']) && $params['guild_name'] != '') {
                $m_goods = $m_goods->where('guild_name', 'like', '%'.$params['guild_name'].'%');
            }
            $result = $m_goods->where('is_del', '=', 0)
                ->orderBy('id')
                ->get()->toArray();
            return $result;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function select_S_PRODECT_LABLES_info($id)
    {
        try {
            return DB::table('S_PRODECT_LABLES')
                ->where('id','=',$id)
                ->first();
        } catch(\Exception $e) {
            throw $e;
        }
    }

    public function select_S_PRODECT_LABLES_name_type($p_name,$p_type)
    {
        try {
            return DB::table('S_PRODECT_LABLES')
                ->where('p_name','=',$p_name)
                ->where('p_type','=',$p_type)
                ->first();
        } catch(\Exception $e) {
            throw $e;
        }
    }

    public function delete_recedents($params)
    {
        try {
            DB::beginTransaction();
            params_check($params, array('id'));
            DB::table('S_PRECEDENTS')
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

    public function update_S_PRECEDENTS($id,$update_S_PRECEDENTS_arr)
    {
        try {
            DB::table('S_PRECEDENTS')
                ->where('id', '=', $id)
                ->update($update_S_PRECEDENTS_arr);
        } catch (\Exception $e) {
            throw $e;
        }
    }



    public function select_S_COMPANY_INFORMATION_info($c_name)
    {
        try {
            return DB::table('S_COMPANY')
                ->where('c_name','=',$c_name)
                ->first();
        } catch(\Exception $e) {
            throw $e;
        }
    }

    public function insert_S_COMPANY($insert_S_COMPANY_INFORMATION_arr)
    {
        return DB::table('S_COMPANY')->insertGetId($insert_S_COMPANY_INFORMATION_arr);
    }

    public function search_company($params)
    {
        try {
            $m_goods = DB::table('S_COMPANY');
                if (isset($params['c_name']) && $params['c_name'] != '') {
                $m_goods = $m_goods->where('c_name', 'like', '%'.$params['c_name'].'%');
            }
            if (isset($params['precedents_url']) && $params['precedents_url'] != '') {
                $m_goods = $m_goods->where('precedents_url', 'like', '%'.$params['precedents_url'].'%');
            }
            if (isset($params['video_url']) && $params['video_url'] != '') {
                $m_goods = $m_goods->where('video_url', 'like', '%'.$params['video_url'].'%');
            }
            if (isset($params['open_flg']) && !empty($params['open_flg'])) {
                $m_goods = $m_goods->whereIn('open_flg', $params['open_flg']);
            }
            $result = $m_goods->where('is_del', '=', 0)
                ->orderBy('id')
                ->get()->toArray();


            return $result;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function select_S_COMPANY_ID_info($id)
    {
        try {
            return DB::table('S_COMPANY')
                ->where('id','=',$id)
                ->first();
        } catch(\Exception $e) {
            throw $e;
        }
    }


    public function update_S_COMPANY($id,$update_S_COMPANY_arr)
    {
        try {
            DB::table('S_COMPANY')
                ->where('id', '=', $id)
                ->update($update_S_COMPANY_arr);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function company_delete($params)
    {
        try {
            DB::beginTransaction();
            params_check($params, array('id'));
            DB::table('S_COMPANY')
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

    public function insert_S_PRODECT_LABLES($insert_S_PRODECT_LABLES_arr)
    {
        return DB::table('S_PRODECT_LABLES')->insertGetId($insert_S_PRODECT_LABLES_arr);
    }

    public function search_lable($params)
    {
        try {
            $m_goods = DB::table('S_PRODECT_LABLES');
            if (isset($params['p_name']) && $params['p_name'] != '') {
                $m_goods = $m_goods->where('p_name', 'like', '%'.$params['p_name'].'%');
            }
            if (isset($params['p_type_arr']) && !empty($params['p_type_arr'])) {
                $m_goods = $m_goods->whereIn('p_type', $params['p_type_arr']);
            }
            $result = $m_goods->where('is_del', '=', 0)
                ->orderBy('id')
                ->get()->toArray();

            return $result;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function select_S_PRODECT_LABLES_ID_info($id)
    {
        try {
            return DB::table('S_PRODECT_LABLES')
                ->where('id','=',$id)
                ->first();
        } catch(\Exception $e) {
            throw $e;
        }
    }

    public function update_S_PRODECT_LABLES($id,$update_S_PRODECT_LABLES_arr)
    {
        try {
            DB::table('S_PRODECT_LABLES')
                ->where('id', '=', $id)
                ->update($update_S_PRODECT_LABLES_arr);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function lable_delete($params)
    {
        try {
            DB::beginTransaction();
            params_check($params, array('id'));
            DB::table('S_PRODECT_LABLES')
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
