<?php

namespace App\Http\Controllers;

use App\Models\Imports;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ImportsController extends Controller
{
    public function get_recedents_add()
    {
        $Imports = new Imports($this);
        $this->data['S_PRODECT_LABLES'] = $Imports->get_S_PRODECT_LABLES();
        return view('imports/recedents_add', $this->data);
    }

    public function post_recedents_regist()
    {
        try {
            $paramsAll = request()->all();

            if (!isset($paramsAll['pr_title']) || empty($paramsAll['pr_title'])) {
                throw new \OneException(1);
            }
            $pr_title = $paramsAll['pr_title'];

            if (!isset($paramsAll['pr_img_url']) || empty($paramsAll['pr_img_url'])) {
                throw new \OneException(1);
            }
            $pr_img_url = $paramsAll['pr_img_url'];

            if (!isset($paramsAll['guild_name']) || empty($paramsAll['guild_name'])) {
                throw new \OneException(1);
            }
            $guild_name = $paramsAll['guild_name'];

            if (!isset($paramsAll['guild_descriptions']) || empty($paramsAll['guild_descriptions'])) {
                throw new \OneException(1);
            }
            $guild_descriptions = $paramsAll['guild_descriptions'];

            if (!isset($paramsAll['pr_labels']) || empty($paramsAll['pr_labels'])) {
                throw new \OneException(1);
            }
            $pr_labels = $paramsAll['pr_labels'];

            $pr_labels_new = implode(",", $pr_labels);

            $is_del = 0;

            $main_flg = $paramsAll['main_flg'] ?? 0;
            $main_img_url = $paramsAll['main_img_url'] ?? "";
            $main_video_url = $paramsAll['main_video_url'] ?? "";

            $Imports = new Imports($this);

//            $S_PRECEDENTS_INFORMATION_info = $Imports->select_S_PRECEDENTS_INFORMATION_info($pr_title);
//            if (!empty($S_PRECEDENTS_INFORMATION_info)){
//                throw new \OneException(6);
//            }

            //数据库事务处理
            DB::beginTransaction();

            $insert_S_PRECEDENTS_INFORMATION_arr = array();
            $insert_S_PRECEDENTS_INFORMATION_arr['pr_title'] = $pr_title;
            $insert_S_PRECEDENTS_INFORMATION_arr['pr_img_url'] = $pr_img_url;
            $insert_S_PRECEDENTS_INFORMATION_arr['pr_contents'] = $paramsAll['pr_contents'] ?? "";
            $insert_S_PRECEDENTS_INFORMATION_arr['guild_name'] = $guild_name;
            $insert_S_PRECEDENTS_INFORMATION_arr['guild_descriptions'] = $guild_descriptions;
            $insert_S_PRECEDENTS_INFORMATION_arr['pr_labels'] = $pr_labels_new;
            $insert_S_PRECEDENTS_INFORMATION_arr['main_flg'] = $main_flg;
            $insert_S_PRECEDENTS_INFORMATION_arr['main_img_url'] = empty($main_flg) ? $main_img_url : "";
            $insert_S_PRECEDENTS_INFORMATION_arr['main_video_url'] = !empty($main_flg) ? $main_video_url : "";
            $insert_S_PRECEDENTS_INFORMATION_arr['CREATED_DT'] = date('Y-m-d',time());
            $insert_S_PRECEDENTS_INFORMATION_arr['CREATED_USER'] = session('USER_ID');
            $insert_S_PRECEDENTS_INFORMATION_arr['is_del'] = $is_del;
            $Imports->insert_S_PRECEDENTS($insert_S_PRECEDENTS_INFORMATION_arr);

            DB::commit();

            return redirect('/imports/recedents_lists?msg_code=200&&msg=事例情報の登録が完了しました。');
        } catch (\OneException $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            $this->data['MSG_CODE'] = 201;
            $this->data['MSG'] = $e->getMessage();
            return view('imports/recedents_add', $this->data);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            $this->data['MSG_CODE'] = 201;
            $this->data['MSG'] = $e->getMessage();
            return view('imports/recedents_add', $this->data);
        }
    }

    public function get_recedents_lists()
    {
        $paramsAll = request()->all();
        $MSG_CODE = $paramsAll['msg_code'] ?? '';
        if (!empty($MSG_CODE)){
            $this->data['MSG_CODE'] = $MSG_CODE;
            $this->data['MSG'] = $paramsAll['msg'];
        }

        $this->data['pr_title'] = $paramsAll['pr_title'] ?? '';
        $this->data['guild_name'] = $paramsAll['guild_name'] ?? '';
        $this->data['PRODECT_LABLES_ARR'] = $paramsAll['pr_labels'] ?? array();

        $Imports = new Imports($this);
        $info = $Imports->search_recedents($paramsAll);
        foreach ($info as $k=>$v){
            $pr_labels_array = explode(",", $v['pr_labels']);
            $info[$k]['pr_labels_str'] = "";
            foreach ($pr_labels_array as $kk=>$vv){
                $select_S_PRODECT_LABLES_info = $Imports->select_S_PRODECT_LABLES_info($vv);
                if ($kk>0){
                    $info[$k]['pr_labels_str'] = $info[$k]['pr_labels_str'] .",". $select_S_PRODECT_LABLES_info['p_name'];
                }else{
                    $info[$k]['pr_labels_str'] = $info[$k]['pr_labels_str'] . $select_S_PRODECT_LABLES_info['p_name'];
                }
            }
        }

        if (!empty($this->data['PRODECT_LABLES_ARR'])){
            foreach ($info as $kkk=>$vvv){
                $pr_labels_array_search_arr = explode(",", $vvv['pr_labels']);
                $commonElements = array_intersect($this->data['PRODECT_LABLES_ARR'], $pr_labels_array_search_arr);
                if (!empty($commonElements)){
                    $return_info[]=$vvv;
                }
            }
        }else{
            $return_info = $info;
        }

        $this->data['info'] = $return_info;
        $this->data['S_PRODECT_LABLES'] = $Imports->get_S_PRODECT_LABLES();


        return view('imports/recedents_lists', $this->data);
    }

    public function get_recedents_edit($id)
    {
        try {
            $Imports = new Imports($this);
            $this->data['S_PRODECT_LABLES'] = $Imports->get_S_PRODECT_LABLES();

            $this->data['info'] = $Imports->select_S_PRECEDENTS_ID_info($id);
            if (empty($this->data['info'])){
                throw new \OneException(3);
            }
            $this->data['PRODECT_LABLES_ARR'] = explode(",", $this->data['info']['pr_labels']);
            return view('imports/recedents_edit', $this->data);
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

    public function post_recedents_edit()
    {
        try {
            $paramsAll = request()->all();
            $Imports = new Imports($this);

            if (!isset($paramsAll['id']) || empty($paramsAll['id'])) {
                throw new \OneException(1);
            }
            $id = $paramsAll['id'];
            $select_S_PRECEDENTS_ID_info = $Imports->select_S_PRECEDENTS_ID_info($id);
            if (empty($select_S_PRECEDENTS_ID_info)){
                throw new \OneException(3);
            }

            if (!isset($paramsAll['pr_title']) || empty($paramsAll['pr_title'])) {
                throw new \OneException(1);
            }
            $pr_title = $paramsAll['pr_title'];

            if (!isset($paramsAll['pr_img_url']) || empty($paramsAll['pr_img_url'])) {
                throw new \OneException(1);
            }
            $pr_img_url = $paramsAll['pr_img_url'];

            if (!isset($paramsAll['guild_name']) || empty($paramsAll['guild_name'])) {
                throw new \OneException(1);
            }
            $guild_name = $paramsAll['guild_name'];

            if (!isset($paramsAll['guild_descriptions']) || empty($paramsAll['guild_descriptions'])) {
                throw new \OneException(1);
            }
            $guild_descriptions = $paramsAll['guild_descriptions'];

            if (!isset($paramsAll['pr_labels']) || empty($paramsAll['pr_labels'])) {
                throw new \OneException(1);
            }
            $pr_labels = $paramsAll['pr_labels'];

            $pr_labels_new = implode(",", $pr_labels);

            $main_flg = $paramsAll['main_flg'] ?? 0;
            $main_img_url = $paramsAll['main_img_url'] ?? "";
            $main_video_url = $paramsAll['main_video_url'] ?? "";

            //数据库事务处理
            DB::beginTransaction();

            $update_S_PRECEDENTS_arr = array();
            $update_S_PRECEDENTS_arr['pr_title'] = $pr_title;
            $update_S_PRECEDENTS_arr['pr_img_url'] = $pr_img_url;
            $update_S_PRECEDENTS_arr['guild_name'] = $guild_name;
            $update_S_PRECEDENTS_arr['guild_descriptions'] = $guild_descriptions;
            $update_S_PRECEDENTS_arr['pr_contents'] = $paramsAll['pr_contents'] ?? "";
            $update_S_PRECEDENTS_arr['pr_labels'] = $pr_labels_new;
            $update_S_PRECEDENTS_arr['main_flg'] = $main_flg;
            $update_S_PRECEDENTS_arr['main_img_url'] = empty($main_flg) ? $main_img_url : "";
            $update_S_PRECEDENTS_arr['main_video_url'] = !empty($main_flg) ? $main_video_url : "";
            $update_S_PRECEDENTS_arr['MODIFY_DT'] = date('Y-m-d',time());
            $update_S_PRECEDENTS_arr['MODIFY_USER'] = session('USER_ID');

            $Imports->update_S_PRECEDENTS($id,$update_S_PRECEDENTS_arr);

            DB::commit();

            return redirect('/imports/recedents_lists?msg_code=200&&msg=事例情報の編集が完了しました。');
        } catch (\OneException $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            $this->data['MSG_CODE'] = 201;
            $this->data['MSG'] = $e->getMessage();
            return view('imports/recedents_edit', $this->data);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            $this->data['MSG_CODE'] = 201;
            $this->data['MSG'] = $e->getMessage();
            return view('imports/recedents_edit', $this->data);
        }
    }



    public function get_company_add()
    {
        $Imports = new Imports($this);
        $this->data['S_PRODECT_LABLES'] = $Imports->get_S_PRODECT_LABLES();
        return view('imports/company_add', $this->data);
    }

    public function post_company_regist()
    {
        try {
            $paramsAll = request()->all();

            if (!isset($paramsAll['c_name']) || empty($paramsAll['c_name'])) {
                throw new \OneException(1);
            }
            $c_name = $paramsAll['c_name'];

            if (!isset($paramsAll['furigana_name']) || empty($paramsAll['furigana_name'])) {
                throw new \OneException(1);
            }
            $furigana_name = $paramsAll['furigana_name'];

            if (!isset($paramsAll['logo_url']) || empty($paramsAll['logo_url'])) {
                throw new \OneException(1);
            }
            $logo_url = $paramsAll['logo_url'];

//            if (!isset($paramsAll['precedents_url']) || empty($paramsAll['precedents_url'])) {
//                throw new \OneException(1);
//            }
//            $precedents_url = $paramsAll['precedents_url'];
            $precedents_url = $paramsAll['precedents_url'] ?? "";

//            if (!isset($paramsAll['video_url']) || empty($paramsAll['video_url'])) {
//                throw new \OneException(1);
//            }
//            $video_url = $paramsAll['video_url'];
            $video_url = $paramsAll['video_url'] ?? "";

//            if (!isset($paramsAll['c_lables']) || empty($paramsAll['c_lables'])) {
//                throw new \OneException(1);
//            }
//            $c_lables = $paramsAll['c_lables'];
//            $c_lables_new = implode(",", $c_lables);

            $c_lables = $paramsAll['c_lables'] ?? array();
            $c_lables_new = "";
            if (!empty($c_lables)){
                $c_lables_new = implode(",", $c_lables);
            }

            $select_flg = empty($paramsAll['select_flg'])?0:1;
            $open_flg = empty($paramsAll['open_flg'])?0:1;
            $is_del = 0;

            $Imports = new Imports($this);

//            $S_COMPANY_INFORMATION_info = $Imports->select_S_COMPANY_INFORMATION_info($c_name);
//            if (!empty($S_COMPANY_INFORMATION_info)){
//                throw new \OneException(7);
//            }

            //数据库事务处理
            DB::beginTransaction();

            $insert_S_COMPANY_INFORMATION_arr = array();
            $insert_S_COMPANY_INFORMATION_arr['c_name'] = $c_name;
            $insert_S_COMPANY_INFORMATION_arr['furigana_name'] = $furigana_name;
            $insert_S_COMPANY_INFORMATION_arr['logo_url'] = $logo_url;
            $insert_S_COMPANY_INFORMATION_arr['precedents_url'] = $precedents_url;
            $insert_S_COMPANY_INFORMATION_arr['video_url'] = $video_url;
            $insert_S_COMPANY_INFORMATION_arr['c_lables'] = $c_lables_new;
            $insert_S_COMPANY_INFORMATION_arr['CREATED_DT'] = date('Y-m-d',time());
            $insert_S_COMPANY_INFORMATION_arr['CREATED_USER'] = session('USER_ID');
            $insert_S_COMPANY_INFORMATION_arr['select_flg'] = $select_flg;
            $insert_S_COMPANY_INFORMATION_arr['open_flg'] = $open_flg;
            $insert_S_COMPANY_INFORMATION_arr['is_del'] = $is_del;
            $Imports->insert_S_COMPANY($insert_S_COMPANY_INFORMATION_arr);

            DB::commit();

            return redirect('/imports/company_lists?msg_code=200&&msg=企業情報の登録が完了しました。');
        } catch (\OneException $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            $this->data['MSG_CODE'] = 201;
            $this->data['MSG'] = $e->getMessage();
            return view('imports/company_add', $this->data);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            $this->data['MSG_CODE'] = 201;
            $this->data['MSG'] = $e->getMessage();
            return view('imports/company_add', $this->data);
        }
    }

    public function get_company_lists()
    {
        $paramsAll = request()->all();

        $MSG_CODE = $paramsAll['msg_code'] ?? '';
        if (!empty($MSG_CODE)){
            $this->data['MSG_CODE'] = $MSG_CODE;
            $this->data['MSG'] = $paramsAll['msg'];
        }

        $this->data['c_name'] = $paramsAll['c_name'] ?? '';
        $this->data['precedents_url'] = $paramsAll['precedents_url'] ?? '';
        $this->data['video_url'] = $paramsAll['video_url'] ?? '';
        $this->data['PRODUCT_LABLES_ARR'] = $paramsAll['c_lables'] ?? array();
        $this->data['open_flg'] = $paramsAll['open_flg'] ?? 0;
        $this->data['precedents_url_have'] = $paramsAll['precedents_url_have'] ?? 0;
        $this->data['video_url_have'] = $paramsAll['video_url_have'] ?? 0;

        $Imports = new Imports($this);
        $info = $Imports->search_company($paramsAll);
        foreach ($info as $k=>$v){
            $c_lables_array = explode(",", $v['c_lables']);
            $info[$k]['c_lables_str'] = "";
            foreach ($c_lables_array as $kk=>$vv){
                $select_S_PRODECT_LABLES_info = $Imports->select_S_PRODECT_LABLES_info($vv);
                if ($kk>0){
                    $info[$k]['c_lables_str'] = $info[$k]['c_lables_str'] .",". $select_S_PRODECT_LABLES_info['p_name'];
                }else{
                    $info[$k]['c_lables_str'] = $info[$k]['c_lables_str'] . $select_S_PRODECT_LABLES_info['p_name'];
                }
            }
            $info[$k]['open_flg_str'] = $v['open_flg'] == 0 ? "未公開" : "公開";
        }

        if (!empty($this->data['PRODUCT_LABLES_ARR'])){
            foreach ($info as $kkk=>$vvv){
                $c_lables_array_search_arr = explode(",", $vvv['c_lables']);
                $commonElements = array_intersect($this->data['PRODUCT_LABLES_ARR'], $c_lables_array_search_arr);
                if (!empty($commonElements)){
                    $return_info[]=$vvv;
                }
            }
        }else{
            $return_info = $info;
        }

        $this->data['info'] = $return_info;
        $this->data['S_PRODECT_LABLES'] = $Imports->get_S_PRODECT_LABLES();


        return view('imports/company_lists', $this->data);
    }

    public function get_company_edit($id)
    {
        try {
            $Imports = new Imports($this);
            $this->data['S_PRODECT_LABLES'] = $Imports->get_S_PRODECT_LABLES();

            $this->data['info'] = $Imports->select_S_COMPANY_ID_info($id);
            if (empty($this->data['info'])){
                throw new \OneException(3);
            }
            $this->data['PRODECT_LABLES_ARR'] = explode(",", $this->data['info']['c_lables']);
            return view('imports/company_edit', $this->data);
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

    public function post_company_edit()
    {
        try {
            $paramsAll = request()->all();
            $Imports = new Imports($this);

            if (!isset($paramsAll['id']) || empty($paramsAll['id'])) {
                throw new \OneException(1);
            }
            $id = $paramsAll['id'];
            $select_S_PRECEDENTS_ID_info = $Imports->select_S_COMPANY_ID_info($id);
            if (empty($select_S_PRECEDENTS_ID_info)){
                throw new \OneException(3);
            }

            if (!isset($paramsAll['c_name']) || empty($paramsAll['c_name'])) {
                throw new \OneException(1);
            }
            $c_name = $paramsAll['c_name'];

            if (!isset($paramsAll['furigana_name']) || empty($paramsAll['furigana_name'])) {
                throw new \OneException(1);
            }
            $furigana_name = $paramsAll['furigana_name'];

            if (!isset($paramsAll['logo_url']) || empty($paramsAll['logo_url'])) {
                throw new \OneException(1);
            }
            $logo_url = $paramsAll['logo_url'];

//            if (!isset($paramsAll['precedents_url']) || empty($paramsAll['precedents_url'])) {
//                throw new \OneException(1);
//            }
//            $precedents_url = $paramsAll['precedents_url'];
            $precedents_url = $paramsAll['precedents_url'] ?? "";

//            if (!isset($paramsAll['video_url']) || empty($paramsAll['video_url'])) {
//                throw new \OneException(1);
//            }
//            $video_url = $paramsAll['video_url'];
            $video_url = $paramsAll['video_url'] ?? "";

//            if (!isset($paramsAll['c_lables']) || empty($paramsAll['c_lables'])) {
//                throw new \OneException(1);
//            }
//            $c_lables = $paramsAll['c_lables'];
//            $c_lables_new = implode(",", $c_lables);

            $c_lables = $paramsAll['c_lables'] ?? array();
            $c_lables_new = "";
            if (!empty($c_lables)){
                $c_lables_new = implode(",", $c_lables);
            }

            $select_flg = empty($paramsAll['select_flg'])?0:1;
            $open_flg = empty($paramsAll['open_flg'])?0:1;


            //数据库事务处理
            DB::beginTransaction();

            $update_S_COMPANY_arr = array();
            $update_S_COMPANY_arr['c_name'] = $c_name;
            $update_S_COMPANY_arr['furigana_name'] = $furigana_name;
            $update_S_COMPANY_arr['logo_url'] = $logo_url;
            $update_S_COMPANY_arr['precedents_url'] = $precedents_url;
            $update_S_COMPANY_arr['video_url'] = $video_url;
            $update_S_COMPANY_arr['c_lables'] = $c_lables_new;
            $update_S_COMPANY_arr['select_flg'] = $select_flg;
            $update_S_COMPANY_arr['open_flg'] = $open_flg;
            $update_S_COMPANY_arr['MODIFY_DT'] = date('Y-m-d',time());
            $update_S_COMPANY_arr['MODIFY_USER'] = session('USER_ID');

            $Imports->update_S_COMPANY($id,$update_S_COMPANY_arr);

            DB::commit();

            return redirect('/imports/company_lists?msg_code=200&&msg=企業情報の編集が完了しました。');
        } catch (\OneException $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            $this->data['MSG_CODE'] = 201;
            $this->data['MSG'] = $e->getMessage();
            return view('imports/company_add', $this->data);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            $this->data['MSG_CODE'] = 201;
            $this->data['MSG'] = $e->getMessage();
            return view('imports/company_add', $this->data);
        }
    }


    public function get_lable_add()
    {
        return view('imports/lable_add', $this->data);
    }

    public function post_lable_regist()
    {
        try {
            $paramsAll = request()->all();

            if (!isset($paramsAll['p_name']) || empty($paramsAll['p_name'])) {
                throw new \OneException(1);
            }
            $p_name = $paramsAll['p_name'];

            if (!isset($paramsAll['p_type']) || empty($paramsAll['p_type'])) {
                throw new \OneException(1);
            }
            $p_type = $paramsAll['p_type'];

            $is_del = 0;

            $Imports = new Imports($this);

            $S_PRODECT_LABLES_name_type = $Imports->select_S_PRODECT_LABLES_name_type($p_name,$p_type);
            if (!empty($S_PRODECT_LABLES_name_type)){
                throw new \OneException(8);
            }

            //数据库事务处理
            DB::beginTransaction();

            $insert_S_PRODECT_LABLES_arr = array();
            $insert_S_PRODECT_LABLES_arr['p_name'] = $p_name;
            $insert_S_PRODECT_LABLES_arr['p_type'] = $p_type;
            $insert_S_PRODECT_LABLES_arr['CREATED_DT'] = date('Y-m-d',time());
            $insert_S_PRODECT_LABLES_arr['CREATED_USER'] = session('USER_ID');
            $insert_S_PRODECT_LABLES_arr['is_del'] = $is_del;

            $Imports->insert_S_PRODECT_LABLES($insert_S_PRODECT_LABLES_arr);

            DB::commit();

            return redirect('/imports/lable_lists?msg_code=200&&msg=タグ情報の登録が完了しました。');
        } catch (\OneException $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            $this->data['MSG_CODE'] = 201;
            $this->data['MSG'] = $e->getMessage();
            return view('imports/lable_add', $this->data);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            $this->data['MSG_CODE'] = 201;
            $this->data['MSG'] = $e->getMessage();
            return view('imports/lable_add', $this->data);
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

        $this->data['p_name'] = $paramsAll['p_name'] ?? '';
        $this->data['p_type_arr'] = $paramsAll['p_type_arr'] ?? array();

        $Imports = new Imports($this);
        $info = $Imports->search_lable($paramsAll);
        foreach ($info as $k=>$v){
            if ($v['p_type'] == 1){
                $info[$k]['type_name'] = "業種別";
            }elseif ($v['p_type'] == 2){
                $info[$k]['type_name'] = "点呼種別";
            }elseif ($v['p_type'] == 3){
                $info[$k]['type_name'] = "製品別";
            }elseif ($v['p_type'] == 4){
                $info[$k]['type_name'] = "その他";
            }else{
                $info[$k]['type_name'] = "データエラー";
            }
        }

        $this->data['info'] = $info;
        return view('imports/lable_lists', $this->data);
    }

    public function get_lable_edit($id)
    {
        try {
            $Imports = new Imports($this);

            $this->data['info'] = $Imports->select_S_PRODECT_LABLES_ID_info($id);
            if (empty($this->data['info'])){
                throw new \OneException(3);
            }

            return view('imports/lable_edit', $this->data);
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
            $Imports = new Imports($this);

            if (!isset($paramsAll['id']) || empty($paramsAll['id'])) {
                throw new \OneException(1);
            }
            $id = $paramsAll['id'];
            $select_S_PRODECT_LABLES_ID_info = $Imports->select_S_PRODECT_LABLES_ID_info($id);
            if (empty($select_S_PRODECT_LABLES_ID_info)){
                throw new \OneException(3);
            }

            if (!isset($paramsAll['p_name']) || empty($paramsAll['p_name'])) {
                throw new \OneException(1);
            }
            $p_name = $paramsAll['p_name'];

            if (!isset($paramsAll['p_type']) || empty($paramsAll['p_type'])) {
                throw new \OneException(1);
            }
            $p_type = $paramsAll['p_type'];

            //数据库事务处理
            DB::beginTransaction();

            $update_S_PRODECT_LABLES_arr = array();
            $update_S_PRODECT_LABLES_arr['p_name'] = $p_name;
            $update_S_PRODECT_LABLES_arr['p_type'] = $p_type;
            $update_S_PRODECT_LABLES_arr['MODIFY_DT'] = date('Y-m-d',time());
            $update_S_PRODECT_LABLES_arr['MODIFY_USER'] = session('USER_ID');

            $Imports->update_S_PRODECT_LABLES($id,$update_S_PRODECT_LABLES_arr);

            DB::commit();

            return redirect('/imports/lable_lists?msg_code=200&&msg=タグ情報の編集が完了しました。');
        } catch (\OneException $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            $this->data['MSG_CODE'] = 201;
            $this->data['MSG'] = $e->getMessage();
            return view('imports/lable_add', $this->data);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            $this->data['MSG_CODE'] = 201;
            $this->data['MSG'] = $e->getMessage();
            return view('imports/lable_add', $this->data);
        }
    }

    public function get_recedents_details($id)
    {
        try {
            $Imports = new Imports($this);
            $this->data['info'] = $Imports->select_S_PRECEDENTS_ID_info($id);
            if (empty($this->data['info'])){
                throw new \OneException(3);
            }
            return view('imports/recedents_details', $this->data);
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
}
