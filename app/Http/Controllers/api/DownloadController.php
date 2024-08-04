<?php

namespace App\Http\Controllers\api;

use App\Models\Download;

class DownloadController extends Controller
{
    public function post_file_delete()
    {
        try {
            $params = request()->all();
            $Download = new Download($this);
            $params['MODIFY_USER'] = session('USER_ID');
            $Download->delete_S_DOWNLOADS($params);
            return $this->ok(array('RESULT' => 'OK', 'MESSAGE' => 'SUCCESS。'));
        } catch (\Exception $e) {
            return $this->ok(array('RESULT' => 'NG', 'MESSAGE' => 'ERROR。<br>' . $e->getMessage() ));
        }
    }

    public function post_file_sort()
    {
        try {
            $params = request()->all();
            $News = new Download($this);
            $sortedIDs = $params['sortedIDs'] ?? array();
            foreach ($sortedIDs as $k=>$v){
                $update_arr = array();
                $update_arr['sort'] = $k+1;
                $News->update_S_DOWNLOADS($v,$update_arr);
            }
            return $this->ok(array('RESULT' => 'OK', 'MESSAGE' => 'SUCCESS。'));
        } catch (\Exception $e) {
            return $this->ok(array('RESULT' => 'NG', 'MESSAGE' => 'ERROR。<br>' . $e->getMessage() ));
        }
    }

    public function post_category_delete()
    {
        try {
            $params = request()->all();
            $Download = new Download($this);
            $params['MODIFY_USER'] = session('USER_ID');
            $Download->delete_S_DOWNLOADS_CATEGORY($params);
            return $this->ok(array('RESULT' => 'OK', 'MESSAGE' => 'SUCCESS。'));
        } catch (\Exception $e) {
            return $this->ok(array('RESULT' => 'NG', 'MESSAGE' => 'ERROR。<br>' . $e->getMessage() ));
        }
    }

    public function post_category_sort()
    {
        try {
            $params = request()->all();
            $News = new Download($this);
            $sortedIDs = $params['sortedIDs'] ?? array();
            foreach ($sortedIDs as $k=>$v){
                $update_arr = array();
                $update_arr['sort'] = $k+1;
                $News->update_S_DOWNLOADS_CATEGORY($v,$update_arr);
            }
            return $this->ok(array('RESULT' => 'OK', 'MESSAGE' => 'SUCCESS。'));
        } catch (\Exception $e) {
            return $this->ok(array('RESULT' => 'NG', 'MESSAGE' => 'ERROR。<br>' . $e->getMessage() ));
        }
    }
}
