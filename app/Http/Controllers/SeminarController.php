<?php

namespace App\Http\Controllers;

use App\Models\Imports;
use App\Models\News;
use App\Models\Seminar;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SeminarController extends Controller
{
    public function get_exhibition_add()
    {
        $Seminar = new Seminar($this);
        $this->data['S_SEMINARS_EXHIBITIONS_LABLES'] = $Seminar->get_S_SEMINARS_EXHIBITIONS_LABLES();
        return view('seminar/exhibition_add', $this->data);
    }

    public function get_exhibition_sort()
    {
        $paramsAll = request()->all();
        $Seminar = new Seminar($this);
        $info = $Seminar->search_S_SEMINARS_EXHIBITIONS($paramsAll);
        $this->data['info'] = $info;
        return view('seminar/exhibition_sort', $this->data);
    }

    public function post_exhibition_regist()
    {
        try {
            $paramsAll = request()->all();

            if (!isset($paramsAll['title']) || empty($paramsAll['title'])) {
                throw new \OneException(1);
            }
            $title = $paramsAll['title'];

            if (!isset($paramsAll['category']) || empty($paramsAll['category'])) {
                throw new \OneException(1);
            }
            $category = $paramsAll['category'];

//            if (!isset($paramsAll['apply_url']) || empty($paramsAll['apply_url'])) {
//                throw new \OneException(1);
//            }
            $apply_url = $paramsAll['apply_url'] ?? "";

            if (!isset($paramsAll['b_url']) || empty($paramsAll['b_url'])) {
                throw new \OneException(1);
            }
            $b_url = $paramsAll['b_url'];

            if (!isset($paramsAll['p_contents']) || empty($paramsAll['p_contents'])) {
                throw new \OneException(1);
            }
            $p_contents = $paramsAll['p_contents'];

            if (!isset($paramsAll['opening_times']) || empty($paramsAll['opening_times'])) {
                throw new \OneException(1);
            }
            $opening_times = $paramsAll['opening_times'];

            if (!isset($paramsAll['closeing_times']) || empty($paramsAll['closeing_times'])) {
                throw new \OneException(1);
            }
            $closeing_times = $paramsAll['closeing_times'];

            if (!isset($paramsAll['c_lables']) || empty($paramsAll['c_lables'])) {
                throw new \OneException(1);
            }
            $c_lables = $paramsAll['c_lables'];

            $c_lables_new = implode(",", $c_lables);

//            if (!isset($paramsAll['address_info']) || empty($paramsAll['address_info'])) {
//                throw new \OneException(1);
//            }
            $address_info = $paramsAll['address_info'] ?? "";
            $address_flg = empty($paramsAll['address_flg'])?0:1;
            $open_flg = empty($paramsAll['open_flg'])?0:1;
            $is_del = 0;

            $Seminar = new Seminar($this);
//            $S_SEMINARS_EXHIBITIONS_name_type = $Seminar->select_S_SEMINARS_EXHIBITIONS_name_type($title,$category);
//            if (!empty($S_SEMINARS_EXHIBITIONS_name_type)){
//                throw new \OneException(10);
//            }

            //数据库事务处理
            DB::beginTransaction();

            $insert_S_SEMINARS_EXHIBITIONS_arr = array();
            $insert_S_SEMINARS_EXHIBITIONS_arr['title'] = $title;
            $insert_S_SEMINARS_EXHIBITIONS_arr['category'] = $category;
            $insert_S_SEMINARS_EXHIBITIONS_arr['apply_url'] = $apply_url;
            $insert_S_SEMINARS_EXHIBITIONS_arr['b_url'] = $b_url;
            $insert_S_SEMINARS_EXHIBITIONS_arr['p_contents'] = $p_contents;
            $insert_S_SEMINARS_EXHIBITIONS_arr['opening_times'] = $opening_times;
            $insert_S_SEMINARS_EXHIBITIONS_arr['closeing_times'] = $closeing_times;
            $insert_S_SEMINARS_EXHIBITIONS_arr['open_flg'] = $open_flg;
            $insert_S_SEMINARS_EXHIBITIONS_arr['c_lables'] = $c_lables_new;
            $insert_S_SEMINARS_EXHIBITIONS_arr['address_flg'] = $address_flg;
            $insert_S_SEMINARS_EXHIBITIONS_arr['address_info'] = $address_info;
            $insert_S_SEMINARS_EXHIBITIONS_arr['exhibition_dates1'] = $paramsAll['exhibition_dates1'] ?? '';
            $insert_S_SEMINARS_EXHIBITIONS_arr['exhibition_dates2'] = $paramsAll['exhibition_dates2'] ?? '';
            $insert_S_SEMINARS_EXHIBITIONS_arr['exhibition_dates3'] = $paramsAll['exhibition_dates3'] ?? '';
            $insert_S_SEMINARS_EXHIBITIONS_arr['exhibition_dates4'] = $paramsAll['exhibition_dates4'] ?? '';
            $insert_S_SEMINARS_EXHIBITIONS_arr['exhibition_dates5'] = $paramsAll['exhibition_dates5'] ?? '';
            $insert_S_SEMINARS_EXHIBITIONS_arr['exhibition_dates6'] = $paramsAll['exhibition_dates6'] ?? '';
            $insert_S_SEMINARS_EXHIBITIONS_arr['exhibition_dates7'] = $paramsAll['exhibition_dates7'] ?? '';
            $insert_S_SEMINARS_EXHIBITIONS_arr['exhibition_dates8'] = $paramsAll['exhibition_dates8'] ?? '';
            $insert_S_SEMINARS_EXHIBITIONS_arr['exhibition_dates9'] = $paramsAll['exhibition_dates9'] ?? '';
            $insert_S_SEMINARS_EXHIBITIONS_arr['exhibition_dates10'] = $paramsAll['exhibition_dates10'] ?? '';
            $insert_S_SEMINARS_EXHIBITIONS_arr['CREATED_DT'] = date('Y-m-d',time());
            $insert_S_SEMINARS_EXHIBITIONS_arr['CREATED_USER'] = session('USER_ID');
            $insert_S_SEMINARS_EXHIBITIONS_arr['is_del'] = $is_del;

            $Seminar->insert_S_SEMINARS_EXHIBITIONS($insert_S_SEMINARS_EXHIBITIONS_arr);

            DB::commit();

            return redirect('/seminar/exhibition_lists?msg_code=200&&msg=セミナー展示会情報の登録が完了しました。');
        } catch (\OneException $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            $this->data['MSG_CODE'] = 201;
            $this->data['MSG'] = $e->getMessage();
            $Seminar = new Seminar($this);
            $this->data['S_SEMINARS_EXHIBITIONS_LABLES'] = $Seminar->get_S_SEMINARS_EXHIBITIONS_LABLES();
            return view('seminar/exhibition_add', $this->data);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            $this->data['MSG_CODE'] = 201;
            $this->data['MSG'] = $e->getMessage();
            $Seminar = new Seminar($this);
            $this->data['S_SEMINARS_EXHIBITIONS_LABLES'] = $Seminar->get_S_SEMINARS_EXHIBITIONS_LABLES();
            return view('seminar/exhibition_add', $this->data);
        }
    }

    public function get_exhibition_lists()
    {
        $paramsAll = request()->all();
        $MSG_CODE = $paramsAll['msg_code'] ?? '';
        if (!empty($MSG_CODE)){
            $this->data['MSG_CODE'] = $MSG_CODE;
            $this->data['MSG'] = $paramsAll['msg'];
        }

        $this->data['title'] = $paramsAll['title'] ?? '';
        $this->data['n_type_arr'] = $paramsAll['n_type_arr'] ?? array();

        $this->data['D_FROM'] = $paramsAll['D_FROM'] ?? '';
        $this->data['D_TO'] = $paramsAll['D_TO'] ?? '';
        $this->data['D_FROM_D_TO'] = !empty($this->data['D_FROM']) && !empty($this->data['D_TO']) ? $this->data['D_FROM']." - ".$this->data['D_TO'] : '';

        $Seminar = new Seminar($this);
        $info = $Seminar->search_S_SEMINARS_EXHIBITIONS($paramsAll);

        foreach ($info as $k=>$v){
            if ($v['category'] == 1){
                $info[$k]['type_name'] = "セミナー";
            }elseif ($v['category'] == 2){
                $info[$k]['type_name'] = "展示会";
            }else{
                $info[$k]['type_name'] = "データエラー";
            }

            $exhibition_dates1 = empty($v['exhibition_dates1']) ? '' : $v['exhibition_dates1']."、";
            $exhibition_dates2 = empty($v['exhibition_dates2']) ? '' : $v['exhibition_dates2']."、";
            $exhibition_dates3 = empty($v['exhibition_dates3']) ? '' : $v['exhibition_dates3']."、";
            $exhibition_dates4 = empty($v['exhibition_dates4']) ? '' : $v['exhibition_dates4']."、";
            $exhibition_dates5 = empty($v['exhibition_dates5']) ? '' : $v['exhibition_dates5']."、";
            $exhibition_dates6 = empty($v['exhibition_dates6']) ? '' : $v['exhibition_dates6']."、";
            $exhibition_dates7 = empty($v['exhibition_dates7']) ? '' : $v['exhibition_dates7']."、";
            $exhibition_dates8 = empty($v['exhibition_dates8']) ? '' : $v['exhibition_dates8']."、";
            $exhibition_dates9 = empty($v['exhibition_dates9']) ? '' : $v['exhibition_dates9']."、";
            $exhibition_dates10 = empty($v['exhibition_dates10']) ? '' : $v['exhibition_dates10']."、";
            $info[$k]['exhibition_dates_str'] =  $exhibition_dates1.$exhibition_dates2.$exhibition_dates3.$exhibition_dates4.$exhibition_dates5.$exhibition_dates6.$exhibition_dates7.$exhibition_dates8.$exhibition_dates9.$exhibition_dates10;
        }

        $this->data['info'] = $info;
        return view('seminar/exhibition_lists', $this->data);
    }

    public function get_exhibition_edit($id)
    {
        try {
            $Seminar = new Seminar($this);
            $this->data['S_SEMINARS_EXHIBITIONS_LABLES'] = $Seminar->get_S_SEMINARS_EXHIBITIONS_LABLES();

            $this->data['info'] = $Seminar->select_S_SEMINARS_EXHIBITIONS_ID_info($id);
            if (empty($this->data['info'])){
                throw new \OneException(3);
            }
            $this->data['S_SEMINARS_EXHIBITIONS_LABLES_ARR'] = explode(",", $this->data['info']['c_lables']);
            return view('seminar/exhibition_edit', $this->data);
        } catch (\OneException $e) {
            $this->data["ERROR_MESSAGE"] = $e->getMessage();
            Log::error($e->getMessage());
            return view('error/error', $this->data);
        } catch (\Exception $e) {
            $this->data["ERROR_MESSAGE"] = $e->getMessage();
            Log::error($e->getMessage());
            return view('error/error', $this->data);
        }
    }

    public function post_exhibition_edit()
    {
        try {
            $paramsAll = request()->all();
            $Seminar = new Seminar($this);

            if (!isset($paramsAll['id']) || empty($paramsAll['id'])) {
                throw new \OneException(1);
            }
            $id = $paramsAll['id'];

            $this->data['info'] = $Seminar->select_S_SEMINARS_EXHIBITIONS_ID_info($id);
            if (empty($this->data['info'])){
                throw new \OneException(3);
            }
            $this->data['S_SEMINARS_EXHIBITIONS_LABLES_ARR'] = explode(",", $this->data['info']['c_lables']);

            if (!isset($paramsAll['title']) || empty($paramsAll['title'])) {
                throw new \OneException(1);
            }
            $title = $paramsAll['title'];

            if (!isset($paramsAll['category']) || empty($paramsAll['category'])) {
                throw new \OneException(1);
            }
            $category = $paramsAll['category'];

            if (!isset($paramsAll['apply_url']) || empty($paramsAll['apply_url'])) {
                throw new \OneException(1);
            }
            $apply_url = $paramsAll['apply_url'];

            if (!isset($paramsAll['b_url']) || empty($paramsAll['b_url'])) {
                throw new \OneException(1);
            }
            $b_url = $paramsAll['b_url'];

            if (!isset($paramsAll['p_contents']) || empty($paramsAll['p_contents'])) {
                throw new \OneException(1);
            }
            $p_contents = $paramsAll['p_contents'];

            if (!isset($paramsAll['opening_times']) || empty($paramsAll['opening_times'])) {
                throw new \OneException(1);
            }
            $opening_times = $paramsAll['opening_times'];

            if (!isset($paramsAll['closeing_times']) || empty($paramsAll['closeing_times'])) {
                throw new \OneException(1);
            }
            $closeing_times = $paramsAll['closeing_times'];

            if (!isset($paramsAll['c_lables']) || empty($paramsAll['c_lables'])) {
                throw new \OneException(1);
            }
            $c_lables = $paramsAll['c_lables'];

            $c_lables_new = implode(",", $c_lables);

//            if (!isset($paramsAll['address_info']) || empty($paramsAll['address_info'])) {
//                throw new \OneException(1);
//            }
            $address_info = $paramsAll['address_info'] ?? "";
            $address_flg = empty($paramsAll['address_flg'])?0:1;
            $open_flg = empty($paramsAll['open_flg'])?0:1;

            //数据库事务处理
            DB::beginTransaction();

            $update_S_SEMINARS_EXHIBITIONS_arr = array();
            $update_S_SEMINARS_EXHIBITIONS_arr['title'] = $title;
            $update_S_SEMINARS_EXHIBITIONS_arr['category'] = $category;
            $update_S_SEMINARS_EXHIBITIONS_arr['apply_url'] = $apply_url;
            $update_S_SEMINARS_EXHIBITIONS_arr['b_url'] = $b_url;
            $update_S_SEMINARS_EXHIBITIONS_arr['p_contents'] = $p_contents;
            $update_S_SEMINARS_EXHIBITIONS_arr['opening_times'] = $opening_times;
            $update_S_SEMINARS_EXHIBITIONS_arr['closeing_times'] = $closeing_times;
            $update_S_SEMINARS_EXHIBITIONS_arr['open_flg'] = $open_flg;
            $update_S_SEMINARS_EXHIBITIONS_arr['c_lables'] = $c_lables_new;
            $update_S_SEMINARS_EXHIBITIONS_arr['address_flg'] = $address_flg;
            $update_S_SEMINARS_EXHIBITIONS_arr['address_info'] = $address_info;
            $update_S_SEMINARS_EXHIBITIONS_arr['exhibition_dates1'] = $paramsAll['exhibition_dates1'] ?? '';
            $update_S_SEMINARS_EXHIBITIONS_arr['exhibition_dates2'] = $paramsAll['exhibition_dates2'] ?? '';
            $update_S_SEMINARS_EXHIBITIONS_arr['exhibition_dates3'] = $paramsAll['exhibition_dates3'] ?? '';
            $update_S_SEMINARS_EXHIBITIONS_arr['exhibition_dates4'] = $paramsAll['exhibition_dates4'] ?? '';
            $update_S_SEMINARS_EXHIBITIONS_arr['exhibition_dates5'] = $paramsAll['exhibition_dates5'] ?? '';
            $update_S_SEMINARS_EXHIBITIONS_arr['exhibition_dates6'] = $paramsAll['exhibition_dates6'] ?? '';
            $update_S_SEMINARS_EXHIBITIONS_arr['exhibition_dates7'] = $paramsAll['exhibition_dates7'] ?? '';
            $update_S_SEMINARS_EXHIBITIONS_arr['exhibition_dates8'] = $paramsAll['exhibition_dates8'] ?? '';
            $update_S_SEMINARS_EXHIBITIONS_arr['exhibition_dates9'] = $paramsAll['exhibition_dates9'] ?? '';
            $update_S_SEMINARS_EXHIBITIONS_arr['exhibition_dates10'] = $paramsAll['exhibition_dates10'] ?? '';
            $update_S_SEMINARS_EXHIBITIONS_arr['MODIFY_DT'] = date('Y-m-d',time());
            $update_S_SEMINARS_EXHIBITIONS_arr['MODIFY_USER'] = session('USER_ID');

            $Seminar->update_S_SEMINARS_EXHIBITIONS($id,$update_S_SEMINARS_EXHIBITIONS_arr);

            DB::commit();

            return redirect('/seminar/exhibition_lists?msg_code=200&&msg=セミナー展示会情報の編集が完了しました。');
        } catch (\OneException $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            $this->data['MSG_CODE'] = 201;
            $this->data['MSG'] = $e->getMessage();
            return view('seminar/exhibition_edit', $this->data);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            $this->data['MSG_CODE'] = 201;
            $this->data['MSG'] = $e->getMessage();
            return view('seminar/exhibition_edit', $this->data);
        }
    }


    public function get_teacher_add()
    {
        return view('seminar/teacher_add', $this->data);
    }

    public function get_teacher_sort()
    {
        $paramsAll = request()->all();
        $Seminar = new Seminar($this);
        $info = $Seminar->search_S_TEACHER($paramsAll);
        $this->data['info'] = $info;
        return view('seminar/teacher_sort', $this->data);
    }

    public function post_teacher_regist()
    {
        try {
            $paramsAll = request()->all();

            if (!isset($paramsAll['b_url']) || empty($paramsAll['b_url'])) {
                throw new \OneException(1);
            }
            $b_url = $paramsAll['b_url'];

            if (!isset($paramsAll['l_name']) || empty($paramsAll['l_name'])) {
                throw new \OneException(1);
            }
            $l_name = $paramsAll['l_name'];

            if (!isset($paramsAll['l_professions']) || empty($paramsAll['l_professions'])) {
                throw new \OneException(1);
            }
            $l_professions = $paramsAll['l_professions'];

            if (!isset($paramsAll['l_career_qualifications']) || empty($paramsAll['l_career_qualifications'])) {
                throw new \OneException(1);
            }
            $l_career_qualifications = $paramsAll['l_career_qualifications'];

            if (!isset($paramsAll['l_seminar_results']) || empty($paramsAll['l_seminar_results'])) {
                throw new \OneException(1);
            }
            $l_seminar_results = $paramsAll['l_seminar_results'];

            if (!isset($paramsAll['l_area']) || empty($paramsAll['l_area'])) {
                throw new \OneException(1);
            }
            $l_area = $paramsAll['l_area'];

            if (!isset($paramsAll['l_contents']) || empty($paramsAll['l_contents'])) {
                throw new \OneException(1);
            }
            $l_contents = $paramsAll['l_contents'];

            $is_del = 0;

            $Seminar = new Seminar($this);
            $S_TEACHER_name = $Seminar->select_S_TEACHER_name($l_name);
            if (!empty($S_TEACHER_name)){
                throw new \OneException(11);
            }

            //数据库事务处理
            DB::beginTransaction();

            $insert_S_TEACHER_arr = array();
            $insert_S_TEACHER_arr['b_url'] = $b_url;
            $insert_S_TEACHER_arr['l_name'] = $l_name;
            $insert_S_TEACHER_arr['l_professions'] = $l_professions;
            $insert_S_TEACHER_arr['l_career_qualifications'] = $l_career_qualifications;
            $insert_S_TEACHER_arr['l_seminar_results'] = $l_seminar_results;
            $insert_S_TEACHER_arr['l_area'] = $l_area;
            $insert_S_TEACHER_arr['l_contents'] = $l_contents;
            $insert_S_TEACHER_arr['CREATED_DT'] = date('Y-m-d',time());
            $insert_S_TEACHER_arr['CREATED_USER'] = session('USER_ID');
            $insert_S_TEACHER_arr['is_del'] = $is_del;

            $Seminar->insert_S_TEACHER($insert_S_TEACHER_arr);

            DB::commit();

            return redirect('/seminar/teacher_lists?msg_code=200&&msg=講師情報の登録が完了しました。');
        } catch (\OneException $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            $this->data['MSG_CODE'] = 201;
            $this->data['MSG'] = $e->getMessage();
            return view('seminar/teacher_add', $this->data);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            $this->data['MSG_CODE'] = 201;
            $this->data['MSG'] = $e->getMessage();
            return view('seminar/teacher_add', $this->data);
        }
    }

    public function get_teacher_lists()
    {
        $paramsAll = request()->all();
        $MSG_CODE = $paramsAll['msg_code'] ?? '';
        if (!empty($MSG_CODE)){
            $this->data['MSG_CODE'] = $MSG_CODE;
            $this->data['MSG'] = $paramsAll['msg'];
        }
        $this->data['l_name'] = $paramsAll['l_name'] ?? '';
        $this->data['l_professions'] = $paramsAll['l_professions'] ?? '';

        $Seminar = new Seminar($this);
        $info = $Seminar->search_S_TEACHER($paramsAll);

        $this->data['info'] = $info;
        return view('seminar/teacher_lists', $this->data);
    }

    public function get_teacher_edit($id)
    {
        try {
            $Seminar = new Seminar($this);

            $this->data['info'] = $Seminar->select_S_TEACHER_ID_info($id);
            if (empty($this->data['info'])){
                throw new \OneException(3);
            }

            return view('seminar/teacher_edit', $this->data);
        } catch (\OneException $e) {
            $this->data["ERROR_MESSAGE"] = $e->getMessage();
            Log::error($e->getMessage());
            return view('error/error', $this->data);
        } catch (\Exception $e) {
            $this->data["ERROR_MESSAGE"] = $e->getMessage();
            Log::error($e->getMessage());
            return view('error/error', $this->data);
        }
    }

    public function post_teacher_edit()
    {
        try {
            $paramsAll = request()->all();
            $Seminar = new Seminar($this);

            if (!isset($paramsAll['id']) || empty($paramsAll['id'])) {
                throw new \OneException(1);
            }
            $id = $paramsAll['id'];

            $this->data['info'] = $Seminar->select_S_TEACHER_ID_info($id);
            if (empty($this->data['info'])){
                throw new \OneException(3);
            }

            if (!isset($paramsAll['b_url']) || empty($paramsAll['b_url'])) {
                throw new \OneException(1);
            }
            $b_url = $paramsAll['b_url'];

            if (!isset($paramsAll['l_name']) || empty($paramsAll['l_name'])) {
                throw new \OneException(1);
            }
            $l_name = $paramsAll['l_name'];

            if (!isset($paramsAll['l_professions']) || empty($paramsAll['l_professions'])) {
                throw new \OneException(1);
            }
            $l_professions = $paramsAll['l_professions'];

            if (!isset($paramsAll['l_career_qualifications']) || empty($paramsAll['l_career_qualifications'])) {
                throw new \OneException(1);
            }
            $l_career_qualifications = $paramsAll['l_career_qualifications'];

            if (!isset($paramsAll['l_seminar_results']) || empty($paramsAll['l_seminar_results'])) {
                throw new \OneException(1);
            }
            $l_seminar_results = $paramsAll['l_seminar_results'];

            if (!isset($paramsAll['l_area']) || empty($paramsAll['l_area'])) {
                throw new \OneException(1);
            }
            $l_area = $paramsAll['l_area'];

            if (!isset($paramsAll['l_contents']) || empty($paramsAll['l_contents'])) {
                throw new \OneException(1);
            }
            $l_contents = $paramsAll['l_contents'];

            //数据库事务处理
            DB::beginTransaction();

            $update_S_TEACHER_arr = array();
            $update_S_TEACHER_arr['b_url'] = $b_url;
            $update_S_TEACHER_arr['l_name'] = $l_name;
            $update_S_TEACHER_arr['l_professions'] = $l_professions;
            $update_S_TEACHER_arr['l_career_qualifications'] = $l_career_qualifications;
            $update_S_TEACHER_arr['l_seminar_results'] = $l_seminar_results;
            $update_S_TEACHER_arr['l_area'] = $l_area;
            $update_S_TEACHER_arr['l_contents'] = $l_contents;
            $update_S_TEACHER_arr['MODIFY_DT'] = date('Y-m-d',time());
            $update_S_TEACHER_arr['MODIFY_USER'] = session('USER_ID');

            $Seminar->update_S_TEACHER($id,$update_S_TEACHER_arr);

            DB::commit();

            return redirect('/seminar/teacher_lists?msg_code=200&&msg=講師情報の編集が完了しました。');
        } catch (\OneException $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            $this->data['MSG_CODE'] = 201;
            $this->data['MSG'] = $e->getMessage();
            return view('seminar/teacher_edit', $this->data);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            $this->data['MSG_CODE'] = 201;
            $this->data['MSG'] = $e->getMessage();
            return view('seminar/teacher_edit', $this->data);
        }
    }



    public function get_lable_add()
    {
        return view('seminar/lable_add', $this->data);
    }

    public function get_lable_sort()
    {
        $paramsAll = request()->all();
        $Seminar = new Seminar($this);
        $this->data['info'] = $Seminar->search_lable($paramsAll);
        return view('seminar/lable_sort', $this->data);
    }

    public function post_lable_regist()
    {
        try {
            $paramsAll = request()->all();

            if (!isset($paramsAll['s_name']) || empty($paramsAll['s_name'])) {
                throw new \OneException(1);
            }
            $s_name = $paramsAll['s_name'];

            $is_del = 0;

            $Seminar = new Seminar($this);

            $S_SEMINARS_EXHIBITIONS_LABLES_name = $Seminar->select_S_SEMINARS_EXHIBITIONS_LABLES_name($s_name);
            if (!empty($S_SEMINARS_EXHIBITIONS_LABLES_name)){
                throw new \OneException(12);
            }

            //数据库事务处理
            DB::beginTransaction();

            $insert_S_SEMINARS_EXHIBITIONS_LABLES_arr = array();
            $insert_S_SEMINARS_EXHIBITIONS_LABLES_arr['s_name'] = $s_name;
            $insert_S_SEMINARS_EXHIBITIONS_LABLES_arr['CREATED_DT'] = date('Y-m-d',time());
            $insert_S_SEMINARS_EXHIBITIONS_LABLES_arr['CREATED_USER'] = session('USER_ID');
            $insert_S_SEMINARS_EXHIBITIONS_LABLES_arr['is_del'] = $is_del;

            $Seminar->insert_S_SEMINARS_EXHIBITIONS_LABLES($insert_S_SEMINARS_EXHIBITIONS_LABLES_arr);

            DB::commit();

            return redirect('/seminar/lable_lists?msg_code=200&&msg=タグ情報の登録が完了しました。');
        } catch (\OneException $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            $this->data['MSG_CODE'] = 201;
            $this->data['MSG'] = $e->getMessage();
            return view('seminar/teacher_add', $this->data);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            $this->data['MSG_CODE'] = 201;
            $this->data['MSG'] = $e->getMessage();
            return view('seminar/teacher_add', $this->data);
        }
    }

    public function get_lable_lists()
    {
        $paramsAll = request()->all();
        $MSG_CODE = $paramsAll['msg_code'] ?? '';
        if (!empty($MSG_CODE)){
            $this->data['MSG_CODE'] = $MSG_CODE;
            $this->data['MSG'] = $paramsAll['msg'];
        }
        $this->data['s_name'] = $paramsAll['s_name'] ?? '';

        $Seminar = new Seminar($this);
        $this->data['info'] = $Seminar->search_lable($paramsAll);

        return view('seminar/lable_lists', $this->data);
    }

    public function get_lable_edit($id)
    {
        try {
            $Seminar = new Seminar($this);

            $this->data['info'] = $Seminar->select_S_SEMINARS_EXHIBITIONS_LABLES_ID_info($id);
            if (empty($this->data['info'])){
                throw new \OneException(3);
            }

            return view('seminar/lable_edit', $this->data);
        } catch (\OneException $e) {
            $this->data["ERROR_MESSAGE"] = $e->getMessage();
            Log::error($e->getMessage());
            return view('error/error', $this->data);
        } catch (\Exception $e) {
            $this->data["ERROR_MESSAGE"] = $e->getMessage();
            Log::error($e->getMessage());
            return view('error/error', $this->data);
        }
    }

    public function post_lable_edit()
    {
        try {
            $paramsAll = request()->all();
            $Seminar = new Seminar($this);

            if (!isset($paramsAll['id']) || empty($paramsAll['id'])) {
                throw new \OneException(1);
            }
            $id = $paramsAll['id'];
            $select_S_SEMINARS_EXHIBITIONS_LABLES_ID_info = $Seminar->select_S_SEMINARS_EXHIBITIONS_LABLES_ID_info($id);
            if (empty($select_S_SEMINARS_EXHIBITIONS_LABLES_ID_info)){
                throw new \OneException(3);
            }

            if (!isset($paramsAll['s_name']) || empty($paramsAll['s_name'])) {
                throw new \OneException(1);
            }
            $s_name = $paramsAll['s_name'];

            //数据库事务处理
            DB::beginTransaction();

            $update_S_SEMINARS_EXHIBITIONS_LABLES_arr = array();
            $update_S_SEMINARS_EXHIBITIONS_LABLES_arr['s_name'] = $s_name;
            $update_S_SEMINARS_EXHIBITIONS_LABLES_arr['MODIFY_DT'] = date('Y-m-d',time());
            $update_S_SEMINARS_EXHIBITIONS_LABLES_arr['MODIFY_USER'] = session('USER_ID');

            $Seminar->update_S_SEMINARS_EXHIBITIONS_LABLES($id,$update_S_SEMINARS_EXHIBITIONS_LABLES_arr);

            DB::commit();

            return redirect('/seminar/lable_lists?msg_code=200&&msg=タグ情報の編集が完了しました。');
        } catch (\OneException $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            $this->data['MSG_CODE'] = 201;
            $this->data['MSG'] = $e->getMessage();
            return view('seminar/teacher_edit', $this->data);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            $this->data['MSG_CODE'] = 201;
            $this->data['MSG'] = $e->getMessage();
            return view('seminar/teacher_edit', $this->data);
        }
    }
}
