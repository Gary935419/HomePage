<?php

namespace App\Http\Controllers;

use App\Models\Imports;
use App\Models\Management;
use App\Models\News;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ManagementController extends Controller
{
    public function get_site_add()
    {
        return view('management/site_add', $this->data);
    }

    public function get_site_sort()
    {
        $paramsAll = request()->all();
        $Management = new Management($this);
        $info = $Management->search_S_MANAGEMENT_SITE($paramsAll);
        $this->data['info'] = $info;
        return view('management/site_sort', $this->data);
    }

    public function post_site_regist()
    {
        try {
            $paramsAll = request()->all();

            if (!isset($paramsAll['title']) || empty($paramsAll['title'])) {
                throw new \OneException(1);
            }
            $title = $paramsAll['title'];

            if (!isset($paramsAll['logo']) || empty($paramsAll['logo'])) {
                throw new \OneException(1);
            }
            $logo = $paramsAll['logo'];

            if (!isset($paramsAll['url']) || empty($paramsAll['url'])) {
                throw new \OneException(1);
            }
            $url = $paramsAll['url'];

            if (!isset($paramsAll['contents']) || empty($paramsAll['contents'])) {
                throw new \OneException(1);
            }
            $contents = $paramsAll['contents'];

            $open_flg = empty($paramsAll['open_flg'])?0:1;
            $is_del = 0;

            $Management = new Management($this);
            $S_MANAGEMENT_SITE_name = $Management->select_S_MANAGEMENT_SITE_name($title);
            if (!empty($S_MANAGEMENT_SITE_name)){
                throw new \OneException(13);
            }

            //数据库事务处理
            DB::beginTransaction();

            $insert_S_MANAGEMENT_SITE_arr = array();
            $insert_S_MANAGEMENT_SITE_arr['title'] = $title;
            $insert_S_MANAGEMENT_SITE_arr['logo'] = $logo;
            $insert_S_MANAGEMENT_SITE_arr['contents'] = $contents;
            $insert_S_MANAGEMENT_SITE_arr['open_flg'] = $open_flg;
            $insert_S_MANAGEMENT_SITE_arr['url'] = $url;
            $insert_S_MANAGEMENT_SITE_arr['CREATED_DT'] = date('Y-m-d',time());
            $insert_S_MANAGEMENT_SITE_arr['CREATED_USER'] = session('USER_ID');
            $insert_S_MANAGEMENT_SITE_arr['is_del'] = $is_del;

            $Management->insert_S_MANAGEMENT_SITE($insert_S_MANAGEMENT_SITE_arr);

            DB::commit();

            return redirect('/management/site_lists?msg_code=200&&msg=運営情報の登録が完了しました。');
        } catch (\OneException $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            $this->data['MSG_CODE'] = 201;
            $this->data['MSG'] = $e->getMessage();
            return view('management/site_add', $this->data);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            $this->data['MSG_CODE'] = 201;
            $this->data['MSG'] = $e->getMessage();
            return view('management/site_add', $this->data);
        }
    }

    public function get_site_lists()
    {
        $paramsAll = request()->all();
        $MSG_CODE = $paramsAll['msg_code'] ?? '';
        if (!empty($MSG_CODE)){
            $this->data['MSG_CODE'] = $MSG_CODE;
            $this->data['MSG'] = $paramsAll['msg'];
        }
        $this->data['title'] = $paramsAll['title'] ?? '';
        $this->data['open_flg'] = $paramsAll['open_flg'] ?? 0;

        $Management = new Management($this);
        $info = $Management->search_S_MANAGEMENT_SITE($paramsAll);

        foreach ($info as $k=>$v){
            $info[$k]['open_flg_str'] = $v['open_flg'] == 0 ? "未公開" : "公開";
        }

        $this->data['info'] = $info;
        return view('management/site_lists', $this->data);
    }

    public function get_site_edit($id)
    {
        try {
            $Management = new Management($this);

            $this->data['info'] = $Management->select_S_MANAGEMENT_SITE_ID_info($id);
            if (empty($this->data['info'])){
                throw new \OneException(3);
            }

            return view('management/site_edit', $this->data);
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

    public function post_site_edit()
    {
        try {
            $paramsAll = request()->all();
            $Management = new Management($this);

            if (!isset($paramsAll['id']) || empty($paramsAll['id'])) {
                throw new \OneException(1);
            }
            $id = $paramsAll['id'];

            $this->data['info'] = $Management->select_S_MANAGEMENT_SITE_ID_info($id);
            if (empty($this->data['info'])){
                throw new \OneException(3);
            }

            if (!isset($paramsAll['title']) || empty($paramsAll['title'])) {
                throw new \OneException(1);
            }
            $title = $paramsAll['title'];

            if (!isset($paramsAll['logo']) || empty($paramsAll['logo'])) {
                throw new \OneException(1);
            }
            $logo = $paramsAll['logo'];

            if (!isset($paramsAll['url']) || empty($paramsAll['url'])) {
                throw new \OneException(1);
            }
            $url = $paramsAll['url'];

            if (!isset($paramsAll['contents']) || empty($paramsAll['contents'])) {
                throw new \OneException(1);
            }
            $contents = $paramsAll['contents'];

            $open_flg = empty($paramsAll['open_flg'])?0:1;

            //数据库事务处理
            DB::beginTransaction();

            $update_S_MANAGEMENT_SITE_arr = array();
            $update_S_MANAGEMENT_SITE_arr['title'] = $title;
            $update_S_MANAGEMENT_SITE_arr['logo'] = $logo;
            $update_S_MANAGEMENT_SITE_arr['contents'] = $contents;
            $update_S_MANAGEMENT_SITE_arr['open_flg'] = $open_flg;
            $update_S_MANAGEMENT_SITE_arr['url'] = $url;
            $update_S_MANAGEMENT_SITE_arr['MODIFY_DT'] = date('Y-m-d',time());
            $update_S_MANAGEMENT_SITE_arr['MODIFY_USER'] = session('USER_ID');

            $Management->update_S_MANAGEMENT_SITE($id,$update_S_MANAGEMENT_SITE_arr);

            DB::commit();

            return redirect('/management/site_lists?msg_code=200&&msg=運営情報の編集が完了しました。');
        } catch (\OneException $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            $this->data['MSG_CODE'] = 201;
            $this->data['MSG'] = $e->getMessage();
            return view('management/site_edit', $this->data);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            $this->data['MSG_CODE'] = 201;
            $this->data['MSG'] = $e->getMessage();
            return view('management/site_edit', $this->data);
        }
    }
}
