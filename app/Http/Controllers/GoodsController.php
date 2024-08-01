<?php

namespace App\Http\Controllers;

use App\Models\Goods;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GoodsController extends Controller
{
    public function get_goods_add()
    {
        $Goods = new Goods($this);
        $this->data['S_PRODUCT_LABLES'] = $Goods->get_S_PRODUCT_LABLES();
        return view('goods/goods_add', $this->data);
    }

    public function post_goods_regist()
    {
        try {
            $paramsAll = request()->all();
            $Goods = new Goods($this);
            $this->data['S_PRODUCT_LABLES'] = $Goods->get_S_PRODUCT_LABLES();

            if (!isset($paramsAll['p_name']) || empty($paramsAll['p_name'])) {
                throw new \OneException(1);
            }
            $p_name = $paramsAll['p_name'];

            if (!isset($paramsAll['p_logo']) || empty($paramsAll['p_logo'])) {
                throw new \OneException(1);
            }
            $p_logo = $paramsAll['p_logo'];

            if (!isset($paramsAll['p_main_img']) || empty($paramsAll['p_main_img'])) {
                throw new \OneException(1);
            }
            $p_main_img = $paramsAll['p_main_img'];

//            if (!isset($paramsAll['p_contents']) || empty($paramsAll['p_contents'])) {
//                throw new \OneException(1);
//            }
//            $p_contents = $paramsAll['p_contents'];
            $p_contents = $paramsAll['p_contents'] ?? "";

//            if (!isset($paramsAll['p_pdf_url']) || empty($paramsAll['p_pdf_url'])) {
//                throw new \OneException(1);
//            }
            $p_pdf_url = $paramsAll['p_pdf_url'] ?? "";

//            if (!isset($paramsAll['p_video_url']) || empty($paramsAll['p_video_url'])) {
//                throw new \OneException(1);
//            }
            $p_video_url = $paramsAll['p_video_url'] ?? "";

//            if (!isset($paramsAll['p_special_weburl']) || empty($paramsAll['p_special_weburl'])) {
//                throw new \OneException(1);
//            }
            $p_special_weburl = $paramsAll['p_special_weburl'] ?? "";

//            if (!isset($paramsAll['p_lables']) || empty($paramsAll['p_lables'])) {
//                throw new \OneException(1);
//            }
            $p_lables = $paramsAll['p_lables'] ?? array();
            $p_lables_new = "";
            if (!empty($p_lables)){
                $p_lables_new = implode(",", $p_lables);
            }

//            if (!isset($paramsAll['b_sort']) || empty($paramsAll['b_sort'])) {
//                throw new \OneException(1);
//            }
//            $b_sort = $paramsAll['b_sort'];

            $p_flg = empty($paramsAll['p_flg'])?0:1;
            $p_open_flg = empty($paramsAll['p_open_flg'])?0:1;
            $is_del = 0;

//            $S_PRODUCT_INFORMATION_info = $Goods->select_S_PRODUCT_INFORMATION_info($p_name);
//            if (!empty($S_PRODUCT_INFORMATION_info)){
//                throw new \OneException(2);
//            }

            //数据库事务处理
            DB::beginTransaction();

            $insert_S_PRODUCT_INFORMATION_arr = array();
            $insert_S_PRODUCT_INFORMATION_arr['p_name'] = $p_name;
            $insert_S_PRODUCT_INFORMATION_arr['p_logo'] = $p_logo;
            $insert_S_PRODUCT_INFORMATION_arr['p_main_img'] = $p_main_img;
            $insert_S_PRODUCT_INFORMATION_arr['p_contents'] = $p_contents;
            $insert_S_PRODUCT_INFORMATION_arr['p_pdf_url'] = $p_pdf_url;
            $insert_S_PRODUCT_INFORMATION_arr['p_flg'] = $p_flg;
            $insert_S_PRODUCT_INFORMATION_arr['p_video_url'] = $p_video_url;
            $insert_S_PRODUCT_INFORMATION_arr['p_special_weburl'] = $p_special_weburl;
            $insert_S_PRODUCT_INFORMATION_arr['p_lables'] = $p_lables_new;
            $insert_S_PRODUCT_INFORMATION_arr['p_open_flg'] = $p_open_flg;
            $insert_S_PRODUCT_INFORMATION_arr['CREATED_DT'] = date('Y-m-d',time());
            $insert_S_PRODUCT_INFORMATION_arr['CREATED_USER'] = session('USER_ID');
//            $insert_S_PRODUCT_INFORMATION_arr['b_sort'] = $b_sort;
            $insert_S_PRODUCT_INFORMATION_arr['is_del'] = $is_del;
            $Goods->insert_S_PRODUCT_INFORMATION($insert_S_PRODUCT_INFORMATION_arr);

            DB::commit();

//            $this->data['MSG_CODE'] = 200;
//            $this->data['MSG'] = "製品情報の登録が完了しました。";
            return redirect('/goods/goods_lists?msg_code=200&&msg=製品情報の登録が完了しました。');
        } catch (\OneException $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            $this->data['MSG_CODE'] = 201;
            $this->data['MSG'] = $e->getMessage();
            return view('goods/goods_add', $this->data);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            $this->data['MSG_CODE'] = 201;
            $this->data['MSG'] = $e->getMessage();
            return view('goods/goods_add', $this->data);
        }
    }

    public function get_goods_lists()
    {
        $paramsAll = request()->all();

        $MSG_CODE = $paramsAll['msg_code'] ?? '';
        if (!empty($MSG_CODE)){
            $this->data['MSG_CODE'] = $MSG_CODE;
            $this->data['MSG'] = $paramsAll['msg'];
        }

        $this->data['p_name'] = $paramsAll['p_name'] ?? '';
        $this->data['PRODUCT_LABLES_ARR'] = $paramsAll['p_lables'] ?? array();
        $this->data['p_pdf_url'] = $paramsAll['p_pdf_url'] ?? '';
        $this->data['p_video_url'] = $paramsAll['p_video_url'] ?? '';
        $this->data['p_special_weburl'] = $paramsAll['p_special_weburl'] ?? '';
        $this->data['p_open_flg'] = $paramsAll['p_open_flg'] ?? 0;
        $this->data['p_pdf_url_have'] = $paramsAll['p_pdf_url_have'] ?? 0;
        $this->data['p_video_url_have'] = $paramsAll['p_video_url_have'] ?? 0;
        $this->data['p_special_weburl_have'] = $paramsAll['p_special_weburl_have'] ?? 0;

        $Goods = new Goods($this);
        $info = $Goods->search_goods($paramsAll);
        foreach ($info as $k=>$v){
            $p_lables_array = explode(",", $v['p_lables']);
            $info[$k]['p_lables_str'] = "";
            foreach ($p_lables_array as $kk=>$vv){
                $select_S_PRODUCT_LABLES_info = $Goods->select_S_PRODUCT_LABLES_info($vv);
                if (empty($select_S_PRODUCT_LABLES_info['is_del'])){
                    if ($kk>0){
                        $info[$k]['p_lables_str'] = $info[$k]['p_lables_str'] .",". $select_S_PRODUCT_LABLES_info['pr_name'];
                    }else{
                        $info[$k]['p_lables_str'] = $info[$k]['p_lables_str'] . $select_S_PRODUCT_LABLES_info['pr_name'];
                    }
                }
            }
            $info[$k]['p_open_flg_str'] = $v['p_open_flg'] == 0 ? "未公開" : "公開";
        }
        $return_info = array();
        if (!empty($this->data['PRODUCT_LABLES_ARR'])){
            foreach ($info as $kkk=>$vvv){
                $p_lables_array_search_arr = explode(",", $vvv['p_lables']);
                $commonElements = array_intersect($this->data['PRODUCT_LABLES_ARR'], $p_lables_array_search_arr);
                if (!empty($commonElements)){
                    $return_info[]=$vvv;
                }
            }
        }else{
            $return_info = $info;
        }

//        $sort = array_column($return_info,'id');
//        array_multisort($sort,SORT_ASC,$return_info);
        $this->data['info'] = $return_info;

        $this->data['S_PRODUCT_LABLES'] = $Goods->get_S_PRODUCT_LABLES();

        return view('goods/goods_lists', $this->data);
    }

    public function get_goods_edit($id)
    {
        try {
            $Goods = new Goods($this);
            $this->data['S_PRODUCT_LABLES'] = $Goods->get_S_PRODUCT_LABLES();

            $this->data['info'] = $Goods->select_S_PRODUCT_INFORMATION_ID_info($id);
            if (empty($this->data['info'])){
                throw new \OneException(3);
            }
            $this->data['PRODUCT_LABLES_ARR'] = explode(",", $this->data['info']['p_lables']);
            return view('goods/goods_edit', $this->data);
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

    public function post_goods_edit()
    {
        try {
            $paramsAll = request()->all();
            $Goods = new Goods($this);

            if (!isset($paramsAll['id']) || empty($paramsAll['id'])) {
                throw new \OneException(1);
            }
            $id = $paramsAll['id'];
            $this->data['info'] = $Goods->select_S_PRODUCT_INFORMATION_ID_info($id);
            if (empty($this->data['info'])){
                throw new \OneException(3);
            }

            if (!isset($paramsAll['p_name']) || empty($paramsAll['p_name'])) {
                throw new \OneException(1);
            }
            $p_name = $paramsAll['p_name'];

            if (!isset($paramsAll['p_logo']) || empty($paramsAll['p_logo'])) {
                throw new \OneException(1);
            }
            $p_logo = $paramsAll['p_logo'];

            if (!isset($paramsAll['p_main_img']) || empty($paramsAll['p_main_img'])) {
                throw new \OneException(1);
            }
            $p_main_img = $paramsAll['p_main_img'];

//            if (!isset($paramsAll['p_contents']) || empty($paramsAll['p_contents'])) {
//                throw new \OneException(1);
//            }
//            $p_contents = $paramsAll['p_contents'];
            $p_contents = $paramsAll['p_contents'] ?? "";

//            if (!isset($paramsAll['p_pdf_url']) || empty($paramsAll['p_pdf_url'])) {
//                throw new \OneException(1);
//            }
            $p_pdf_url = $paramsAll['p_pdf_url'] ?? "";

//            if (!isset($paramsAll['p_video_url']) || empty($paramsAll['p_video_url'])) {
//                throw new \OneException(1);
//            }
            $p_video_url = $paramsAll['p_video_url'] ?? "";

//            if (!isset($paramsAll['p_special_weburl']) || empty($paramsAll['p_special_weburl'])) {
//                throw new \OneException(1);
//            }
            $p_special_weburl = $paramsAll['p_special_weburl'] ?? "";

//            if (!isset($paramsAll['p_lables']) || empty($paramsAll['p_lables'])) {
//                throw new \OneException(1);
//            }
            $p_lables = $paramsAll['p_lables'] ?? array();
            $p_lables_new = "";
            if (!empty($p_lables)){
                $p_lables_new = implode(",", $p_lables);
            }

//            if (!isset($paramsAll['b_sort']) || empty($paramsAll['b_sort'])) {
//                throw new \OneException(1);
//            }
//            $b_sort = $paramsAll['b_sort'];

            $p_flg = empty($paramsAll['p_flg'])?0:1;
            $p_open_flg = empty($paramsAll['p_open_flg'])?0:1;

            //数据库事务处理
            DB::beginTransaction();

            $update_S_PRODUCT_INFORMATION_arr = array();
            $update_S_PRODUCT_INFORMATION_arr['p_name'] = $p_name;
            $update_S_PRODUCT_INFORMATION_arr['p_logo'] = $p_logo;
            $update_S_PRODUCT_INFORMATION_arr['p_main_img'] = $p_main_img;
            $update_S_PRODUCT_INFORMATION_arr['p_contents'] = $p_contents;
            $update_S_PRODUCT_INFORMATION_arr['p_pdf_url'] = $p_pdf_url;
            $update_S_PRODUCT_INFORMATION_arr['p_flg'] = $p_flg;
            $update_S_PRODUCT_INFORMATION_arr['p_video_url'] = $p_video_url;
            $update_S_PRODUCT_INFORMATION_arr['p_special_weburl'] = $p_special_weburl;
            $update_S_PRODUCT_INFORMATION_arr['p_lables'] = $p_lables_new;
            $update_S_PRODUCT_INFORMATION_arr['p_open_flg'] = $p_open_flg;
            $update_S_PRODUCT_INFORMATION_arr['MODIFY_DT'] = date('Y-m-d',time());
            $update_S_PRODUCT_INFORMATION_arr['MODIFY_USER'] = session('USER_ID');
            $Goods->update_S_PRODUCT_INFORMATION($id,$update_S_PRODUCT_INFORMATION_arr);

            DB::commit();
//
//            $this->data['MSG_CODE'] = 200;
//            $this->data['MSG'] = "編集処理完了。";
            return redirect('/goods/goods_lists?msg_code=200&&msg=製品情報の編集が完了しました。');
        } catch (\OneException $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            $this->data['MSG_CODE'] = 201;
            $this->data['MSG'] = $e->getMessage();
            return view('goods/goods_edit', $this->data);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            $this->data['MSG_CODE'] = 201;
            $this->data['MSG'] = $e->getMessage();
            return view('goods/goods_edit', $this->data);
        }
    }


    public function get_goods_lableadd()
    {
        return view('goods/goods_lableadd',$this->data);
    }

    public function post_goods_lableregist()
    {
        try {
            $paramsAll = request()->all();

            if (!isset($paramsAll['pr_name']) || empty($paramsAll['pr_name'])) {
                throw new \OneException(1);
            }
            $pr_name = $paramsAll['pr_name'];

//            if (!isset($paramsAll['pr_sort']) || empty($paramsAll['pr_sort'])) {
//                throw new \OneException(1);
//            }
//            $pr_sort = $paramsAll['pr_sort'];

            $is_del = 0;

            $Goods = new Goods($this);

            $S_PRODUCT_LABLES_info = $Goods->select_S_PRODUCT_LABLES_info_one($pr_name);
            if (!empty($S_PRODUCT_LABLES_info)){
                throw new \OneException(4);
            }

            //数据库事务处理
            DB::beginTransaction();

            $insert_S_PRODUCT_LABLES_arr = array();
            $insert_S_PRODUCT_LABLES_arr['pr_name'] = $pr_name;
            $insert_S_PRODUCT_LABLES_arr['CREATED_DT'] = date('Y-m-d',time());
            $insert_S_PRODUCT_LABLES_arr['CREATED_USER'] = session('USER_ID');
//            $insert_S_PRODUCT_LABLES_arr['pr_sort'] = $pr_sort;
            $insert_S_PRODUCT_LABLES_arr['is_del'] = $is_del;
            $Goods->insert_S_PRODUCT_LABLES($insert_S_PRODUCT_LABLES_arr);

            DB::commit();

            return redirect('/goods/goods_lablelists?msg_code=200&&msg=タグの登録が完了しました。');
        } catch (\OneException $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            $this->data['MSG_CODE'] = 201;
            $this->data['MSG'] = $e->getMessage();
            return view('goods/goods_lableadd', $this->data);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            $this->data['MSG_CODE'] = 201;
            $this->data['MSG'] = $e->getMessage();
            return view('goods/goods_lableadd', $this->data);
        }
    }

    public function get_goods_lablelists()
    {
        $paramsAll = request()->all();
        $MSG_CODE = $paramsAll['msg_code'] ?? '';
        if (!empty($MSG_CODE)){
            $this->data['MSG_CODE'] = $MSG_CODE;
            $this->data['MSG'] = $paramsAll['msg'];
        }
        $this->data['pr_name'] = $paramsAll['pr_name'] ?? '';
        $Goods = new Goods($this);
        $info = $Goods->search_lablegoods($paramsAll);
        $this->data['info'] = $info;
        return view('goods/goods_lablelists', $this->data);
    }

    public function get_goods_lableedit($id)
    {
        try {
            $Goods = new Goods($this);
            $this->data['info'] = $Goods->select_S_PRODUCT_LABLES_ID_info($id);
            if (empty($this->data['info'])){
                throw new \OneException(3);
            }
            return view('goods/goods_lableedit', $this->data);
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

    public function post_goods_lableedit()
    {
        try {
            $paramsAll = request()->all();
            $Goods = new Goods($this);

            if (!isset($paramsAll['id']) || empty($paramsAll['id'])) {
                throw new \OneException(1);
            }
            $id = $paramsAll['id'];
            $this->data['info'] = $Goods->select_S_PRODUCT_LABLES_ID_info($id);
            if (empty($this->data['info'])){
                throw new \OneException(3);
            }

            if (!isset($paramsAll['pr_name']) || empty($paramsAll['pr_name'])) {
                throw new \OneException(1);
            }
            $pr_name = $paramsAll['pr_name'];

            $S_PRODUCT_LABLES_info = $Goods->select_S_PRODUCT_LABLES_info_one($pr_name);
            if (!empty($S_PRODUCT_LABLES_info) && $S_PRODUCT_LABLES_info['id'] != $id){
                throw new \OneException(4);
            }

            //数据库事务处理
            DB::beginTransaction();

            $update_S_PRODUCT_LABLES_arr = array();
            $update_S_PRODUCT_LABLES_arr['pr_name'] = $pr_name;
            $update_S_PRODUCT_LABLES_arr['MODIFY_DT'] = date('Y-m-d',time());
            $update_S_PRODUCT_LABLES_arr['MODIFY_USER'] = session('USER_ID');
            $Goods->update_S_PRODUCT_LABLES($id,$update_S_PRODUCT_LABLES_arr);

            DB::commit();

            return redirect('/goods/goods_lablelists?msg_code=200&&msg=タグの編集が完了しました。');
        } catch (\OneException $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            $this->data['MSG_CODE'] = 201;
            $this->data['MSG'] = $e->getMessage();
            return view('goods/goods_lableedit', $this->data);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            $this->data['MSG_CODE'] = 201;
            $this->data['MSG'] = $e->getMessage();
            return view('goods/goods_lableedit', $this->data);
        }
    }


    public function get_goods_banneradd()
    {
        return view('goods/goods_banneradd',$this->data);
    }

    public function post_goods_bannerregist()
    {
        try {
            $paramsAll = request()->all();

            if (!isset($paramsAll['b_name']) || empty($paramsAll['b_name'])) {
                throw new \OneException(1);
            }
            $b_name = $paramsAll['b_name'];

            if (!isset($paramsAll['b_url']) || empty($paramsAll['b_url'])) {
                throw new \OneException(1);
            }
            $b_url = $paramsAll['b_url'];

            if (!isset($paramsAll['link_url']) || empty($paramsAll['link_url'])) {
                throw new \OneException(1);
            }
            $link_url = $paramsAll['link_url'];

            $b_flg = empty($paramsAll['b_flg'])?0:1;
            $is_del = 0;

            $Goods = new Goods($this);

            $S_PRODUCT_BANNERS_info = $Goods->select_S_PRODUCT_BANNERS_info_one($b_name);
            if (!empty($S_PRODUCT_BANNERS_info)){
                throw new \OneException(5);
            }

            //数据库事务处理
            DB::beginTransaction();

            $insert_S_PRODUCT_BANNERS_arr = array();
            $insert_S_PRODUCT_BANNERS_arr['b_name'] = $b_name;
            $insert_S_PRODUCT_BANNERS_arr['b_url'] = $b_url;
            $insert_S_PRODUCT_BANNERS_arr['link_url'] = $link_url;
            $insert_S_PRODUCT_BANNERS_arr['CREATED_DT'] = date('Y-m-d',time());
            $insert_S_PRODUCT_BANNERS_arr['CREATED_USER'] = session('USER_ID');
            $insert_S_PRODUCT_BANNERS_arr['b_flg'] = $b_flg;
            $insert_S_PRODUCT_BANNERS_arr['is_del'] = $is_del;
            $Goods->insert_S_PRODUCT_BANNERS($insert_S_PRODUCT_BANNERS_arr);

            DB::commit();

            return redirect('/goods/goods_bannerlists?msg_code=200&&msg=製品バナーの登録が完了しました。');
        } catch (\OneException $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            $this->data['MSG_CODE'] = 201;
            $this->data['MSG'] = $e->getMessage();
            return view('goods/goods_banneradd', $this->data);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            $this->data['MSG_CODE'] = 201;
            $this->data['MSG'] = $e->getMessage();
            return view('goods/goods_banneradd', $this->data);
        }
    }

    public function get_goods_bannerlists()
    {
        $paramsAll = request()->all();
        $MSG_CODE = $paramsAll['msg_code'] ?? '';
        if (!empty($MSG_CODE)){
            $this->data['MSG_CODE'] = $MSG_CODE;
            $this->data['MSG'] = $paramsAll['msg'];
        }
        $this->data['b_name'] = $paramsAll['b_name'] ?? '';
        $this->data['b_flg'] = $paramsAll['b_flg'] ?? 0;

        $Goods = new Goods($this);
        $info = $Goods->search_bannergoods($paramsAll);
        foreach ($info as $k=>$v){
            $info[$k]['b_flg_str'] = $v['b_flg'] == 0 ? "未公開" : "公開";
        }
        $this->data['info'] = $info;
        return view('goods/goods_bannerlists', $this->data);
    }

    public function get_goods_banneredit($id)
    {
        try {
            $Goods = new Goods($this);
            $this->data['info'] = $Goods->select_S_PRODUCT_BANNERS_ID_info($id);
            if (empty($this->data['info'])){
                throw new \OneException(3);
            }
            return view('goods/goods_banneredit', $this->data);
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

    public function post_goods_banneredit()
    {
        try {
            $paramsAll = request()->all();
            $Goods = new Goods($this);

            if (!isset($paramsAll['id']) || empty($paramsAll['id'])) {
                throw new \OneException(1);
            }
            $id = $paramsAll['id'];

            $this->data['info'] = $Goods->select_S_PRODUCT_BANNERS_ID_info($id);
            if (empty($this->data['info'])){
                throw new \OneException(3);
            }

            $paramsAll = request()->all();

            if (!isset($paramsAll['b_name']) || empty($paramsAll['b_name'])) {
                throw new \OneException(1);
            }
            $b_name = $paramsAll['b_name'];

            if (!isset($paramsAll['b_url']) || empty($paramsAll['b_url'])) {
                throw new \OneException(1);
            }
            $b_url = $paramsAll['b_url'];

            if (!isset($paramsAll['link_url']) || empty($paramsAll['link_url'])) {
                throw new \OneException(1);
            }
            $link_url = $paramsAll['link_url'];

            $b_flg = empty($paramsAll['b_flg'])?0:1;

            //数据库事务处理
            DB::beginTransaction();

            $update_S_PRODUCT_BANNERS_arr = array();
            $update_S_PRODUCT_BANNERS_arr['b_name'] = $b_name;
            $update_S_PRODUCT_BANNERS_arr['b_url'] = $b_url;
            $update_S_PRODUCT_BANNERS_arr['link_url'] = $link_url;
            $update_S_PRODUCT_BANNERS_arr['MODIFY_DT'] = date('Y-m-d',time());
            $update_S_PRODUCT_BANNERS_arr['MODIFY_USER'] = session('USER_ID');
            $update_S_PRODUCT_BANNERS_arr['b_flg'] = $b_flg;
            $Goods->update_S_PRODUCT_BANNERS($id,$update_S_PRODUCT_BANNERS_arr);

            DB::commit();

            return redirect('/goods/goods_bannerlists?msg_code=200&&msg=製品バナーの編集が完了しました。');
        } catch (\OneException $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            $this->data['MSG_CODE'] = 201;
            $this->data['MSG'] = $e->getMessage();
            return view('goods/goods_banneredit', $this->data);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            $this->data['MSG_CODE'] = 201;
            $this->data['MSG'] = $e->getMessage();
            return view('goods/goods_banneredit', $this->data);
        }
    }
}
