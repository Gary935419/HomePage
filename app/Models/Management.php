<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class Management extends Model
{
    private $Lara;

    public function __construct(&$Lara)
    {
        $this->Lara = $Lara;
    }


    public function select_S_MANAGEMENT_SITE_name($title)
    {
        try {
            return DB::table('S_MANAGEMENT_SITE')
                ->where('title','=',$title)
                ->first();
        } catch(\Exception $e) {
            throw $e;
        }
    }

    public function insert_S_MANAGEMENT_SITE($insert_S_MANAGEMENT_SITE_arr)
    {
        return DB::table('S_MANAGEMENT_SITE')->insertGetId($insert_S_MANAGEMENT_SITE_arr);
    }

    public function search_S_MANAGEMENT_SITE($params)
    {
        try {
            $m_goods = DB::table('S_MANAGEMENT_SITE');
            if (isset($params['title']) && $params['title'] != '') {
                $m_goods = $m_goods->where('title', 'like', '%'.$params['title'].'%');
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

    public function select_S_MANAGEMENT_SITE_ID_info($id)
    {
        try {
            return DB::table('S_MANAGEMENT_SITE')
                ->where('id','=',$id)
                ->first();
        } catch(\Exception $e) {
            throw $e;
        }
    }

    public function update_S_MANAGEMENT_SITE($id,$update_S_MANAGEMENT_SITE_arr)
    {
        try {
            DB::table('S_MANAGEMENT_SITE')
                ->where('id', '=', $id)
                ->update($update_S_MANAGEMENT_SITE_arr);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function S_MANAGEMENT_SITE_delete($params)
    {
        try {
            DB::beginTransaction();
            params_check($params, array('id'));
            DB::table('S_MANAGEMENT_SITE')
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
