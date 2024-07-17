<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class Seminar extends Model
{
    private $Lara;

    public function __construct(&$Lara)
    {
        $this->Lara = $Lara;
    }

    public function get_S_SEMINARS_EXHIBITIONS_LABLES()
    {
        return DB::table('S_SEMINARS_EXHIBITIONS_LABLES')
            ->where('is_del', '=', 0)
            ->get()->toArray();
    }

    public function select_S_SEMINARS_EXHIBITIONS_name_type($title,$category)
    {
        try {
            return DB::table('S_SEMINARS_EXHIBITIONS')
                ->where('title','=',$title)
                ->where('category','=',$category)
                ->first();
        } catch(\Exception $e) {
            throw $e;
        }
    }

    public function insert_S_SEMINARS_EXHIBITIONS($insert_S_SEMINARS_EXHIBITIONS_arr)
    {
        return DB::table('S_SEMINARS_EXHIBITIONS')->insertGetId($insert_S_SEMINARS_EXHIBITIONS_arr);
    }

    public function search_S_SEMINARS_EXHIBITIONS($params)
    {
        try {
            $m_goods = DB::table('S_SEMINARS_EXHIBITIONS');
            if (isset($params['title']) && $params['title'] != '') {
                $m_goods = $m_goods->where('title', 'like', '%'.$params['title'].'%');
            }
            if (isset($params['n_type_arr']) && !empty($params['n_type_arr'])) {
                $m_goods = $m_goods->whereIn('category', $params['n_type_arr']);
            }
            if (isset($params['D_FROM']) && $params['D_FROM'] != '') {
                $m_goods = $m_goods->where('exhibition_dates1', '>=', $params['D_FROM'])
                    ->orWhere('exhibition_dates2', '>=', $params['D_FROM'])
                    ->orWhere('exhibition_dates3', '>=', $params['D_FROM'])
                    ->orWhere('exhibition_dates4', '>=', $params['D_FROM'])
                    ->orWhere('exhibition_dates5', '>=', $params['D_FROM'])
                    ->orWhere('exhibition_dates6', '>=', $params['D_FROM']);
            }
            if (isset($params['D_TO']) && $params['D_TO'] != '') {
                $m_goods = $m_goods->where('exhibition_dates1', '<=', $params['D_TO'])
                    ->where('exhibition_dates2', '<=', $params['D_TO'])
                    ->where('exhibition_dates3', '<=', $params['D_TO'])
                    ->where('exhibition_dates4', '<=', $params['D_TO'])
                    ->where('exhibition_dates5', '<=', $params['D_TO'])
                    ->where('exhibition_dates6', '<=', $params['D_TO']);
            }
            $result = $m_goods->where('is_del', '=', 0)
                ->orderBy('id')
                ->get()->toArray();


            return $result;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function select_S_SEMINARS_EXHIBITIONS_ID_info($id)
    {
        try {
            return DB::table('S_SEMINARS_EXHIBITIONS')
                ->where('id','=',$id)
                ->first();
        } catch(\Exception $e) {
            throw $e;
        }
    }

    public function update_S_SEMINARS_EXHIBITIONS($id,$update_S_SEMINARS_EXHIBITIONS_arr)
    {
        try {
            DB::table('S_SEMINARS_EXHIBITIONS')
                ->where('id', '=', $id)
                ->update($update_S_SEMINARS_EXHIBITIONS_arr);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function S_SEMINARS_EXHIBITIONS_delete($params)
    {
        try {
            DB::beginTransaction();
            params_check($params, array('id'));
            DB::table('S_SEMINARS_EXHIBITIONS')
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

    public function select_S_TEACHER_name($l_name)
    {
        try {
            return DB::table('S_TEACHER')
                ->where('l_name','=',$l_name)
                ->first();
        } catch(\Exception $e) {
            throw $e;
        }
    }

    public function insert_S_TEACHER($insert_S_TEACHER_arr)
    {
        return DB::table('S_TEACHER')->insertGetId($insert_S_TEACHER_arr);
    }

    public function search_S_TEACHER($params)
    {
        try {
            $m_goods = DB::table('S_TEACHER');
            if (isset($params['l_name']) && $params['l_name'] != '') {
                $m_goods = $m_goods->where('l_name', 'like', '%'.$params['l_name'].'%');
            }
            if (isset($params['l_professions']) && $params['l_professions'] != '') {
                $m_goods = $m_goods->where('l_professions', 'like', '%'.$params['l_professions'].'%');
            }
            $result = $m_goods->where('is_del', '=', 0)
                ->orderBy('id')
                ->get()->toArray();

            return $result;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function select_S_TEACHER_ID_info($id)
    {
        try {
            return DB::table('S_TEACHER')
                ->where('id','=',$id)
                ->first();
        } catch(\Exception $e) {
            throw $e;
        }
    }

    public function update_S_TEACHER($id,$update_S_TEACHER_arr)
    {
        try {
            DB::table('S_TEACHER')
                ->where('id', '=', $id)
                ->update($update_S_TEACHER_arr);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function S_TEACHER_delete($params)
    {
        try {
            DB::beginTransaction();
            params_check($params, array('id'));
            DB::table('S_TEACHER')
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

    public function select_S_SEMINARS_EXHIBITIONS_LABLES_name($s_name)
    {
        try {
            return DB::table('S_SEMINARS_EXHIBITIONS_LABLES')
                ->where('s_name','=',$s_name)
                ->first();
        } catch(\Exception $e) {
            throw $e;
        }
    }

    public function insert_S_SEMINARS_EXHIBITIONS_LABLES($insert_S_SEMINARS_EXHIBITIONS_LABLES_arr)
    {
        return DB::table('S_SEMINARS_EXHIBITIONS_LABLES')->insertGetId($insert_S_SEMINARS_EXHIBITIONS_LABLES_arr);
    }

    public function search_lable($params)
    {
        try {
            $m_goods = DB::table('S_SEMINARS_EXHIBITIONS_LABLES');
            if (isset($params['s_name']) && $params['s_name'] != '') {
                $m_goods = $m_goods->where('s_name', 'like', '%'.$params['s_name'].'%');
            }
            $result = $m_goods->where('is_del', '=', 0)
                ->orderBy('id')
                ->get()->toArray();

            return $result;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function select_S_SEMINARS_EXHIBITIONS_LABLES_ID_info($id)
    {
        try {
            return DB::table('S_SEMINARS_EXHIBITIONS_LABLES')
                ->where('id','=',$id)
                ->first();
        } catch(\Exception $e) {
            throw $e;
        }
    }

    public function update_S_SEMINARS_EXHIBITIONS_LABLES($id,$update_S_SEMINARS_EXHIBITIONS_LABLES_arr)
    {
        try {
            DB::table('S_SEMINARS_EXHIBITIONS_LABLES')
                ->where('id', '=', $id)
                ->update($update_S_SEMINARS_EXHIBITIONS_LABLES_arr);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function S_SEMINARS_EXHIBITIONS_LABLES_delete($params)
    {
        try {
            DB::beginTransaction();
            params_check($params, array('id'));
            DB::table('S_SEMINARS_EXHIBITIONS_LABLES')
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
