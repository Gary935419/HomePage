<?php

namespace App\Http\Controllers\api;

use App\Models\Imports;

class ImportsController extends Controller
{
    public function post_recedents_delete()
    {
        try {
            $params = request()->all();
            $Imports = new Imports($this);
            $params['MODIFY_USER'] = session('USER_ID');
            $Imports->delete_recedents($params);
            return $this->ok(array('RESULT' => 'OK', 'MESSAGE' => 'SUCCESS。'));
        } catch (\Exception $e) {
            return $this->ok(array('RESULT' => 'NG', 'MESSAGE' => 'ERROR。<br>' . $e->getMessage() ));
        }
    }

    public function post_recedents_sort()
    {
        try {
            $params = request()->all();
            $Imports = new Imports($this);
            $sortedIDs = $params['sortedIDs'] ?? array();
            foreach ($sortedIDs as $k=>$v){
                $update_arr = array();
                $update_arr['sort'] = $k+1;
                $Imports->update_S_PRECEDENTS($v,$update_arr);
            }
            return $this->ok(array('RESULT' => 'OK', 'MESSAGE' => 'SUCCESS。'));
        } catch (\Exception $e) {
            return $this->ok(array('RESULT' => 'NG', 'MESSAGE' => 'ERROR。<br>' . $e->getMessage() ));
        }
    }

    public function post_company_delete()
    {
        try {
            $params = request()->all();
            $Imports = new Imports($this);
            $params['MODIFY_USER'] = session('USER_ID');
            $Imports->company_delete($params);
            return $this->ok(array('RESULT' => 'OK', 'MESSAGE' => 'SUCCESS。'));
        } catch (\Exception $e) {
            return $this->ok(array('RESULT' => 'NG', 'MESSAGE' => 'ERROR。<br>' . $e->getMessage() ));
        }
    }

    public function post_company_sort()
    {
        try {
            $params = request()->all();
            $Imports = new Imports($this);
            $sortedIDs = $params['sortedIDs'] ?? array();
            foreach ($sortedIDs as $k=>$v){
                $update_arr = array();
                $update_arr['sort'] = $k+1;
                $Imports->update_S_COMPANY($v,$update_arr);
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
            $Imports = new Imports($this);
            $params['MODIFY_USER'] = session('USER_ID');
            $Imports->lable_delete($params);
            return $this->ok(array('RESULT' => 'OK', 'MESSAGE' => 'SUCCESS。'));
        } catch (\Exception $e) {
            return $this->ok(array('RESULT' => 'NG', 'MESSAGE' => 'ERROR。<br>' . $e->getMessage() ));
        }
    }

    public function post_lable_sort()
    {
        try {
            $params = request()->all();
            $Imports = new Imports($this);
            $sortedIDs = $params['sortedIDs'] ?? array();
            foreach ($sortedIDs as $k=>$v){
                $update_arr = array();
                $update_arr['sort'] = $k+1;
                $Imports->update_S_PRODECT_LABLES($v,$update_arr);
            }
            return $this->ok(array('RESULT' => 'OK', 'MESSAGE' => 'SUCCESS。'));
        } catch (\Exception $e) {
            return $this->ok(array('RESULT' => 'NG', 'MESSAGE' => 'ERROR。<br>' . $e->getMessage() ));
        }
    }
}
