<?php

namespace App\Http\Controllers\api;

use App\Models\News;

class NewsController extends Controller
{
    public function post_news_delete()
    {
        try {
            $params = request()->all();
            $News = new News($this);
            $params['MODIFY_USER'] = session('USER_ID');
            $News->news_delete($params);
            return $this->ok(array('RESULT' => 'OK', 'MESSAGE' => 'SUCCESS。'));
        } catch (\Exception $e) {
            return $this->ok(array('RESULT' => 'NG', 'MESSAGE' => 'ERROR。<br>' . $e->getMessage() ));
        }
    }

    public function post_news_sort()
    {
        try {
            $params = request()->all();
            $News = new News($this);
            $sortedIDs = $params['sortedIDs'] ?? array();
            foreach ($sortedIDs as $k=>$v){
                $update_arr = array();
                $update_arr['sort'] = $k+1;
                $News->update_S_NEWS($v,$update_arr);
            }
            return $this->ok(array('RESULT' => 'OK', 'MESSAGE' => 'SUCCESS。'));
        } catch (\Exception $e) {
            return $this->ok(array('RESULT' => 'NG', 'MESSAGE' => 'ERROR。<br>' . $e->getMessage() ));
        }
    }

    public function post_news_sorting()
    {
        try {
            $News = new News($this);
            $info = $News->search_news_sort_n_open_date();
            foreach ($info as $k=>$v){
                $update_arr = array();
                $update_arr['sort'] = $k+1;
                $News->update_S_NEWS($v['id'],$update_arr);
            }
            return $this->ok(array('RESULT' => 'OK', 'MESSAGE' => 'SUCCESS。'));
        } catch (\Exception $e) {
            return $this->ok(array('RESULT' => 'NG', 'MESSAGE' => 'ERROR。<br>' . $e->getMessage() ));
        }
    }
}
