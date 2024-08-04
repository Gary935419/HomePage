<?php

namespace App\Http\Controllers\api;

use App\Models\Seminar;

class SeminarController extends Controller
{
    public function post_exhibition_delete()
    {
        try {
            $params = request()->all();
            $Seminar = new Seminar($this);
            $params['MODIFY_USER'] = session('USER_ID');
            $Seminar->S_SEMINARS_EXHIBITIONS_delete($params);
            return $this->ok(array('RESULT' => 'OK', 'MESSAGE' => 'SUCCESS。'));
        } catch (\Exception $e) {
            return $this->ok(array('RESULT' => 'NG', 'MESSAGE' => 'ERROR。<br>' . $e->getMessage() ));
        }
    }

    public function post_exhibition_sort()
    {
        try {
            $params = request()->all();
            $Seminar = new Seminar($this);
            $sortedIDs = $params['sortedIDs'] ?? array();
            foreach ($sortedIDs as $k=>$v){
                $update_arr = array();
                $update_arr['sort'] = $k+1;
                $Seminar->update_S_SEMINARS_EXHIBITIONS($v,$update_arr);
            }
            return $this->ok(array('RESULT' => 'OK', 'MESSAGE' => 'SUCCESS。'));
        } catch (\Exception $e) {
            return $this->ok(array('RESULT' => 'NG', 'MESSAGE' => 'ERROR。<br>' . $e->getMessage() ));
        }
    }

    public function post_teacher_delete()
    {
        try {
            $params = request()->all();
            $Seminar = new Seminar($this);
            $params['MODIFY_USER'] = session('USER_ID');
            $Seminar->S_TEACHER_delete($params);
            return $this->ok(array('RESULT' => 'OK', 'MESSAGE' => 'SUCCESS。'));
        } catch (\Exception $e) {
            return $this->ok(array('RESULT' => 'NG', 'MESSAGE' => 'ERROR。<br>' . $e->getMessage() ));
        }
    }

    public function post_teacher_sort()
    {
        try {
            $params = request()->all();
            $Seminar = new Seminar($this);
            $sortedIDs = $params['sortedIDs'] ?? array();
            foreach ($sortedIDs as $k=>$v){
                $update_arr = array();
                $update_arr['sort'] = $k+1;
                $Seminar->update_S_TEACHER($v,$update_arr);
            }
            return $this->ok(array('RESULT' => 'OK', 'MESSAGE' => 'SUCCESS。'));
        } catch (\Exception $e) {
            return $this->ok(array('RESULT' => 'NG', 'MESSAGE' => 'ERROR。<br>' . $e->getMessage() ));
        }
    }

    public function post_lable_delete()
    {
        try {
            $params = request()->all();
            $Seminar = new Seminar($this);
            $params['MODIFY_USER'] = session('USER_ID');
            $Seminar->S_SEMINARS_EXHIBITIONS_LABLES_delete($params);
            return $this->ok(array('RESULT' => 'OK', 'MESSAGE' => 'SUCCESS。'));
        } catch (\Exception $e) {
            return $this->ok(array('RESULT' => 'NG', 'MESSAGE' => 'ERROR。<br>' . $e->getMessage() ));
        }
    }

    public function post_lable_sort()
    {
        try {
            $params = request()->all();
            $Seminar = new Seminar($this);
            $sortedIDs = $params['sortedIDs'] ?? array();
            foreach ($sortedIDs as $k=>$v){
                $update_arr = array();
                $update_arr['sort'] = $k+1;
                $Seminar->update_S_SEMINARS_EXHIBITIONS_LABLES($v,$update_arr);
            }
            return $this->ok(array('RESULT' => 'OK', 'MESSAGE' => 'SUCCESS。'));
        } catch (\Exception $e) {
            return $this->ok(array('RESULT' => 'NG', 'MESSAGE' => 'ERROR。<br>' . $e->getMessage() ));
        }
    }

    public function post_exhibition_sorting()
    {
        try {
            $Seminar = new Seminar($this);
            $info = $Seminar->search_SEMINARS_EXHIBITIONS_sort();
            foreach ($info as $k=>$v){
                $update_arr = array();
                $update_arr['sort'] = $k+1;
                $Seminar->update_S_SEMINARS_EXHIBITIONS($v['id'],$update_arr);
            }
            return $this->ok(array('RESULT' => 'OK', 'MESSAGE' => 'SUCCESS。'));
        } catch (\Exception $e) {
            return $this->ok(array('RESULT' => 'NG', 'MESSAGE' => 'ERROR。<br>' . $e->getMessage() ));
        }
    }
}
