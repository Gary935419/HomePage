<?php

namespace App\Http\Controllers;

use App\Models\Imports;
use App\Models\News;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class NewsController extends Controller
{
    public function get_news_add()
    {
        return view('news/news_add', $this->data);
    }

    public function get_news_sort()
    {
        $paramsAll = request()->all();
        $News = new News($this);
        $info = $News->search_news($paramsAll);
        $this->data['info'] = $info;
        return view('news/news_sort', $this->data);
    }

    public function post_news_regist()
    {
        try {
            $paramsAll = request()->all();

            if (!isset($paramsAll['n_title']) || empty($paramsAll['n_title'])) {
                throw new \OneException(1);
            }
            $n_title = $paramsAll['n_title'];

            if (!isset($paramsAll['n_type']) || empty($paramsAll['n_type'])) {
                throw new \OneException(1);
            }
            $n_type = $paramsAll['n_type'];

//            if (!isset($paramsAll['n_contents']) || empty($paramsAll['n_contents'])) {
//                throw new \OneException(1);
//            }
//            $n_contents = $paramsAll['n_contents'];
            $n_contents = $paramsAll['n_contents'] ?? "";

//            if (!isset($paramsAll['n_open_date']) || empty($paramsAll['n_open_date'])) {
//                throw new \OneException(1);
//            }
//            $n_open_date = $paramsAll['n_open_date'];
            $n_open_date = $paramsAll['n_open_date'] ?? "";

//            if (!isset($paramsAll['n_close_date']) || empty($paramsAll['n_close_date'])) {
//                throw new \OneException(1);
//            }
//            $n_close_date = $paramsAll['n_close_date'];
            $n_close_date = $paramsAll['n_close_date'] ?? "";

            $n_important_flg = empty($paramsAll['n_important_flg'])?0:1;
            $n_open_flg = empty($paramsAll['n_open_flg'])?0:1;
            $n_fixed_flg = empty($paramsAll['n_fixed_flg'])?0:1;
            $is_del = 0;

            $fix_open_date = $paramsAll['fix_open_date'] ?? "";
            $fix_close_date = $paramsAll['fix_close_date'] ?? "";

            $News = new News($this);

//            $S_NEWS_name_type = $News->select_S_NEWS_name_type($n_title,$n_type);
//            if (!empty($S_NEWS_name_type)){
//                throw new \OneException(9);
//            }

            //数据库事务处理
            DB::beginTransaction();

            $insert_S_NEWS_arr = array();
            $insert_S_NEWS_arr['n_title'] = $n_title;
            $insert_S_NEWS_arr['n_type'] = $n_type;
            $insert_S_NEWS_arr['n_contents'] = $n_contents;
            $insert_S_NEWS_arr['n_open_date'] = $n_open_date;
            $insert_S_NEWS_arr['n_close_date'] = $n_close_date;
            $insert_S_NEWS_arr['n_important_flg'] = $n_important_flg;
            $insert_S_NEWS_arr['n_open_flg'] = $n_open_flg;
            $insert_S_NEWS_arr['n_fixed_flg'] = $n_fixed_flg;
            $insert_S_NEWS_arr['fix_open_date'] = $fix_open_date;
            $insert_S_NEWS_arr['fix_close_date'] = $fix_close_date;
            $insert_S_NEWS_arr['CREATED_DT'] = date('Y-m-d',time());
            $insert_S_NEWS_arr['CREATED_USER'] = session('USER_ID');
            $insert_S_NEWS_arr['is_del'] = $is_del;

            $News->insert_S_NEWS($insert_S_NEWS_arr);

            DB::commit();

            return redirect('/news/news_lists?msg_code=200&&msg=ニュース情報の登録が完了しました。');
        } catch (\OneException $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            $this->data['MSG_CODE'] = 201;
            $this->data['MSG'] = $e->getMessage();
            return view('news/news_add', $this->data);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            $this->data['MSG_CODE'] = 201;
            $this->data['MSG'] = $e->getMessage();
            return view('news/news_add', $this->data);
        }
    }

    public function get_news_lists()
    {
        $paramsAll = request()->all();

        $MSG_CODE = $paramsAll['msg_code'] ?? '';
        if (!empty($MSG_CODE)){
            $this->data['MSG_CODE'] = $MSG_CODE;
            $this->data['MSG'] = $paramsAll['msg'];
        }

        $this->data['key_str'] = $paramsAll['key_str'] ?? '';
        $this->data['n_type_arr'] = $paramsAll['n_type_arr'] ?? array();
        $this->data['n_open_flg'] = $paramsAll['n_open_flg'] ?? array();

        $this->data['D_FROM'] = $paramsAll['D_FROM'] ?? '';
        $this->data['D_TO'] = $paramsAll['D_TO'] ?? '';
        $this->data['D_FROM_D_TO'] = !empty($this->data['D_FROM']) && !empty($this->data['D_TO']) ? $this->data['D_FROM']." - ".$this->data['D_TO'] : '';

        $News = new News($this);
        $info = $News->search_news($paramsAll);

        foreach ($info as $k=>$v){
            if ($v['n_type'] == 1){
                $info[$k]['type_name'] = "新着情報";
            }elseif ($v['n_type'] == 2){
                $info[$k]['type_name'] = "セミナー展示会";
            }elseif ($v['n_type'] == 3){
                $info[$k]['type_name'] = "ニュースリリース";
            }elseif ($v['n_type'] == 4){
                $info[$k]['type_name'] = "メディア";
            }elseif ($v['n_type'] == 5){
                $info[$k]['type_name'] = "障害連絡	";
            }else{
                $info[$k]['type_name'] = "データエラー";
            }
            $info[$k]['n_open_flg_str'] = $v['n_open_flg'] == 0 ? "未公開" : "公開";
        }

        $this->data['info'] = $info;
        return view('news/news_lists', $this->data);
    }

    public function get_news_edit($id)
    {
        try {
            $News = new News($this);

            $this->data['info'] = $News->select_S_NEWS_ID_info($id);
            if (empty($this->data['info'])){
                throw new \OneException(3);
            }

            return view('news/news_edit', $this->data);
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

    public function post_news_edit()
    {
        try {
            $paramsAll = request()->all();
            $News = new News($this);

            if (!isset($paramsAll['id']) || empty($paramsAll['id'])) {
                throw new \OneException(1);
            }
            $id = $paramsAll['id'];

            $this->data['info'] = $News->select_S_NEWS_ID_info($id);
            if (empty($this->data['info'])){
                throw new \OneException(3);
            }

            if (!isset($paramsAll['n_title']) || empty($paramsAll['n_title'])) {
                throw new \OneException(1);
            }
            $n_title = $paramsAll['n_title'];

            if (!isset($paramsAll['n_type']) || empty($paramsAll['n_type'])) {
                throw new \OneException(1);
            }
            $n_type = $paramsAll['n_type'];

//            if (!isset($paramsAll['n_contents']) || empty($paramsAll['n_contents'])) {
//                throw new \OneException(1);
//            }
//            $n_contents = $paramsAll['n_contents'];
            $n_contents = $paramsAll['n_contents'] ?? "";

//            if (!isset($paramsAll['n_open_date']) || empty($paramsAll['n_open_date'])) {
//                throw new \OneException(1);
//            }
//            $n_open_date = $paramsAll['n_open_date'];
            $n_open_date = $paramsAll['n_open_date'] ?? "";

//            if (!isset($paramsAll['n_close_date']) || empty($paramsAll['n_close_date'])) {
//                throw new \OneException(1);
//            }
//            $n_close_date = $paramsAll['n_close_date'];
            $n_close_date = $paramsAll['n_close_date'] ?? "";

            $n_important_flg = empty($paramsAll['n_important_flg'])?0:1;
            $n_open_flg = empty($paramsAll['n_open_flg'])?0:1;
            $n_fixed_flg = empty($paramsAll['n_fixed_flg'])?0:1;

            $fix_open_date = $paramsAll['fix_open_date'] ?? "";
            $fix_close_date = $paramsAll['fix_close_date'] ?? "";

            //数据库事务处理
            DB::beginTransaction();

            $update_S_NEWS_arr = array();
            $update_S_NEWS_arr['n_title'] = $n_title;
            $update_S_NEWS_arr['n_type'] = $n_type;
            $update_S_NEWS_arr['n_contents'] = $n_contents;
            $update_S_NEWS_arr['n_open_date'] = $n_open_date;
            $update_S_NEWS_arr['n_close_date'] = $n_close_date;
            $update_S_NEWS_arr['n_important_flg'] = $n_important_flg;
            $update_S_NEWS_arr['n_open_flg'] = $n_open_flg;
            $update_S_NEWS_arr['n_fixed_flg'] = $n_fixed_flg;
            $update_S_NEWS_arr['fix_open_date'] = $fix_open_date;
            $update_S_NEWS_arr['fix_close_date'] = $fix_close_date;
            $update_S_NEWS_arr['MODIFY_DT'] = date('Y-m-d',time());
            $update_S_NEWS_arr['MODIFY_USER'] = session('USER_ID');

            $News->update_S_NEWS($id,$update_S_NEWS_arr);

            DB::commit();

            return redirect('/news/news_lists?msg_code=200&&msg=ニュース情報の編集が完了しました。');
        } catch (\OneException $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            $this->data['MSG_CODE'] = 201;
            $this->data['MSG'] = $e->getMessage();
            return view('news/news_edit', $this->data);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            $this->data['MSG_CODE'] = 201;
            $this->data['MSG'] = $e->getMessage();
            return view('news/news_edit', $this->data);
        }
    }
}
