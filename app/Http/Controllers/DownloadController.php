<?php

namespace App\Http\Controllers;

use App\Models\Download;
use App\Models\Goods;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DownloadController extends Controller
{
    public function get_file_add()
    {
        $Download = new Download($this);
        $this->data['S_DOWNLOADS_CATEGORY'] = $Download->get_S_DOWNLOADS_CATEGORY();
        return view('/download/file_add', $this->data);
    }

    public function post_file_regist()
    {
        try {
            $paramsAll = request()->all();

            if (!isset($paramsAll['d_file_url']) || empty($paramsAll['d_file_url'])) {
                throw new \OneException(1);
            }
            $d_file_url = $paramsAll['d_file_url'];

            if (!isset($paramsAll['d_file_name']) || empty($paramsAll['d_file_name'])) {
                throw new \OneException(1);
            }
            $d_file_name = $paramsAll['d_file_name'];

            if (!isset($paramsAll['d_category']) || empty($paramsAll['d_category'])) {
                throw new \OneException(1);
            }
            $d_category = $paramsAll['d_category'];

            $d_category_new = implode(",", $d_category);

            $confirm_flg = empty($paramsAll['confirm_flg'])?0:1;
            $open_flg = empty($paramsAll['open_flg'])?0:1;

            $is_del = 0;

            $Download = new Download($this);

            $S_DOWNLOADS_INFORMATION_info = $Download->select_S_DOWNLOADS_info($d_file_name);
            if (!empty($S_DOWNLOADS_INFORMATION_info)){
                throw new \OneException(2);
            }

            //数据库事务处理
            DB::beginTransaction();

            $insert_S_DOWNLOADS_arr = array();
            $insert_S_DOWNLOADS_arr['d_file_url'] = $d_file_url;
            $insert_S_DOWNLOADS_arr['d_file_name'] = $d_file_name;
            $insert_S_DOWNLOADS_arr['d_category'] = $d_category_new;
            $insert_S_DOWNLOADS_arr['confirm_flg'] = $confirm_flg;
            $insert_S_DOWNLOADS_arr['open_flg'] = $open_flg;
            $insert_S_DOWNLOADS_arr['CREATED_DT'] = date('Y-m-d',time());
            $insert_S_DOWNLOADS_arr['CREATED_USER'] = session('USER_ID');
            $insert_S_DOWNLOADS_arr['is_del'] = $is_del;
            $Download->insert_S_DOWNLOADS($insert_S_DOWNLOADS_arr);

            DB::commit();

            return view('/download/file_add_complete', $this->data);
        } catch (\OneException $e) {
            DB::rollBack();
            $this->data["ERROR_MESSAGE"] = $e->getMessage();
            Log::error($e->getMessage());
            return view('error/error', $this->data);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return view('error/error', $this->data);
        }
    }

    public function get_file_lists()
    {
        $paramsAll = request()->all();
        $this->data['d_file_name'] = $paramsAll['d_file_name'] ?? '';
        $this->data['d_category_arr'] = $paramsAll['d_category'] ?? array();

        $Download = new Download($this);
        $info = $Download->search_S_DOWNLOADS($paramsAll);
        foreach ($info as $k=>$v){
            $d_category_array = explode(",", $v['d_category']);
            $info[$k]['d_category_str'] = "";
            foreach ($d_category_array as $kk=>$vv){
                $select_select_S_DOWNLOADS_CATEGORY_info_info = $Download->select_S_DOWNLOADS_CATEGORY_info($vv);
                if ($kk>0){
                    $info[$k]['d_category_str'] = $info[$k]['d_category_str'] .",". $select_select_S_DOWNLOADS_CATEGORY_info_info['category_name'];
                }else{
                    $info[$k]['d_category_str'] = $info[$k]['d_category_str'] . $select_select_S_DOWNLOADS_CATEGORY_info_info['category_name'];
                }
            }
        }

        if (!empty($this->data['d_category_arr'])){
            foreach ($info as $kkk=>$vvv){
                $d_category_array_search_arr = explode(",", $vvv['d_category']);
                $commonElements = array_intersect($this->data['d_category_arr'], $d_category_array_search_arr);
                if (!empty($commonElements)){
                    $return_info[]=$vvv;
                }
            }
        }else{
            $return_info = $info;
        }

        $this->data['info'] = $return_info;

        $this->data['S_DOWNLOADS_CATEGORY'] = $Download->get_S_DOWNLOADS_CATEGORY();

        return view('/download/file_lists', $this->data);
    }

    public function get_file_edit($id)
    {
        try {
            $Download = new Download($this);
            $this->data['S_DOWNLOADS_CATEGORY'] = $Download->get_S_DOWNLOADS_CATEGORY();

            $this->data['info'] = $Download->select_S_DOWNLOADS_ID_info($id);
            if (empty($this->data['info'])){
                throw new \OneException(3);
            }
            $this->data['d_category_arr'] = explode(",", $this->data['info']['d_category']);
            return view('/download/file_edit', $this->data);
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

    public function post_file_edit()
    {
        try {
            $paramsAll = request()->all();
            $Download = new Download($this);

            if (!isset($paramsAll['id']) || empty($paramsAll['id'])) {
                throw new \OneException(1);
            }
            $id = $paramsAll['id'];
            $this->data['info'] = $Download->select_S_DOWNLOADS_ID_info($id);
            if (empty($this->data['info'])){
                throw new \OneException(3);
            }

            if (!isset($paramsAll['d_file_url']) || empty($paramsAll['d_file_url'])) {
                throw new \OneException(1);
            }
            $d_file_url = $paramsAll['d_file_url'];

            if (!isset($paramsAll['d_file_name']) || empty($paramsAll['d_file_name'])) {
                throw new \OneException(1);
            }
            $d_file_name = $paramsAll['d_file_name'];

            if (!isset($paramsAll['d_category']) || empty($paramsAll['d_category'])) {
                throw new \OneException(1);
            }
            $d_category = $paramsAll['d_category'];

            $d_category_new = implode(",", $d_category);

            $confirm_flg = empty($paramsAll['confirm_flg'])?0:1;
            $open_flg = empty($paramsAll['open_flg'])?0:1;

            //数据库事务处理
            DB::beginTransaction();

            $update_S_DOWNLOADS_arr = array();
            $update_S_DOWNLOADS_arr['d_file_url'] = $d_file_url;
            $update_S_DOWNLOADS_arr['d_file_name'] = $d_file_name;
            $update_S_DOWNLOADS_arr['d_category'] = $d_category_new;
            $update_S_DOWNLOADS_arr['confirm_flg'] = $confirm_flg;
            $update_S_DOWNLOADS_arr['open_flg'] = $open_flg;
            $update_S_DOWNLOADS_arr['MODIFY_DT'] = date('Y-m-d',time());
            $update_S_DOWNLOADS_arr['MODIFY_USER'] = session('USER_ID');
            $Download->update_S_DOWNLOADS($id,$update_S_DOWNLOADS_arr);

            DB::commit();

            return view('/download/file_edit_complete', $this->data);
        } catch (\OneException $e) {
            DB::rollBack();
            $this->data["ERROR_MESSAGE"] = $e->getMessage();
            Log::error($e->getMessage());
            return view('error/error', $this->data);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return view('error/error', $this->data);
        }
    }


    public function get_category_add()
    {
        return view('/download/category_add', $this->data);
    }

    public function post_category_regist()
    {
        try {
            $paramsAll = request()->all();

            if (!isset($paramsAll['category_name']) || empty($paramsAll['category_name'])) {
                throw new \OneException(1);
            }
            $category_name = $paramsAll['category_name'];

            $open_flg = empty($paramsAll['open_flg'])?0:1;

            $is_del = 0;

            $Download = new Download($this);

            $S_DOWNLOADS_CATEGORY_info_name = $Download->select_S_DOWNLOADS_CATEGORY_info_name($category_name);
            if (!empty($S_DOWNLOADS_CATEGORY_info_name)){
                throw new \OneException(14);
            }

            //数据库事务处理
            DB::beginTransaction();

            $insert_S_DOWNLOADS_CATEGORY_arr = array();
            $insert_S_DOWNLOADS_CATEGORY_arr['category_name'] = $category_name;
            $insert_S_DOWNLOADS_CATEGORY_arr['open_flg'] = $open_flg;
            $insert_S_DOWNLOADS_CATEGORY_arr['CREATED_DT'] = date('Y-m-d',time());
            $insert_S_DOWNLOADS_CATEGORY_arr['CREATED_USER'] = session('USER_ID');
            $insert_S_DOWNLOADS_CATEGORY_arr['is_del'] = $is_del;
            $Download->insert_S_DOWNLOADS_CATEGORY($insert_S_DOWNLOADS_CATEGORY_arr);

            DB::commit();

            return view('/download/category_add_complete', $this->data);
        } catch (\OneException $e) {
            DB::rollBack();
            $this->data["ERROR_MESSAGE"] = $e->getMessage();
            Log::error($e->getMessage());
            return view('error/error', $this->data);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return view('error/error', $this->data);
        }
    }

    public function get_category_lists()
    {
        $paramsAll = request()->all();
        $this->data['category_name'] = $paramsAll['category_name'] ?? '';
        $this->data['open_flg'] = $paramsAll['open_flg'] ?? array();

        $Download = new Download($this);
        $info = $Download->search_S_DOWNLOADS_CATEGORY($paramsAll);
        foreach ($info as $k=>$v){
            $info[$k]['open_flg_str'] = $v['open_flg'] == 1 ?"未公開":"公開";
        }

        $this->data['info'] = $info;

        return view('/download/category_lists', $this->data);
    }

    public function get_category_edit($id)
    {
        try {
            $Download = new Download($this);

            $this->data['info'] = $Download->select_S_DOWNLOADS_CATEGORY_info($id);
            if (empty($this->data['info'])){
                throw new \OneException(3);
            }
            return view('/download/category_edit', $this->data);
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

    public function post_category_edit()
    {
        try {
            $paramsAll = request()->all();
            $Download = new Download($this);

            if (!isset($paramsAll['id']) || empty($paramsAll['id'])) {
                throw new \OneException(1);
            }
            $id = $paramsAll['id'];
            $this->data['info'] = $Download->select_S_DOWNLOADS_CATEGORY_info($id);
            if (empty($this->data['info'])){
                throw new \OneException(3);
            }

            if (!isset($paramsAll['category_name']) || empty($paramsAll['category_name'])) {
                throw new \OneException(1);
            }
            $category_name = $paramsAll['category_name'];

            $open_flg = empty($paramsAll['open_flg'])?0:1;

            //数据库事务处理
            DB::beginTransaction();

            $update_S_DOWNLOADS_CATEGORY_arr = array();
            $update_S_DOWNLOADS_CATEGORY_arr['category_name'] = $category_name;
            $update_S_DOWNLOADS_CATEGORY_arr['open_flg'] = $open_flg;
            $update_S_DOWNLOADS_CATEGORY_arr['MODIFY_DT'] = date('Y-m-d',time());
            $update_S_DOWNLOADS_CATEGORY_arr['MODIFY_USER'] = session('USER_ID');
            $Download->update_S_DOWNLOADS_CATEGORY($id,$update_S_DOWNLOADS_CATEGORY_arr);

            DB::commit();

            return view('/download/category_edit_complete', $this->data);
        } catch (\OneException $e) {
            DB::rollBack();
            $this->data["ERROR_MESSAGE"] = $e->getMessage();
            Log::error($e->getMessage());
            return view('error/error', $this->data);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return view('error/error', $this->data);
        }
    }

    public function get_history_lists()
    {
        $paramsAll = request()->all();
        $this->data['user_name'] = $paramsAll['user_name'] ?? '';
        $this->data['company_name'] = $paramsAll['company_name'] ?? '';
        $this->data['phone_number'] = $paramsAll['phone_number'] ?? '';
        $this->data['email'] = $paramsAll['email'] ?? '';

        $Download = new Download($this);
        $info = $Download->search_S_DOWNLOADS_HISTORY($paramsAll);
        foreach ($info as $k=>$v){
            $info[$k]['agreement_flg_str'] = $v['agreement_flg'] == 1 ? "同意": "未同意";
        }

        $this->data['info'] = $info;

        return view('/download/history_lists', $this->data);
    }
}
