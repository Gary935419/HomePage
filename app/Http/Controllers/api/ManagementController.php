<?php

namespace App\Http\Controllers\api;

use App\Models\Management;

class ManagementController extends Controller
{
    public function post_site_delete()
    {
        try {
            $params = request()->all();
            $Management = new Management($this);
            $params['MODIFY_USER'] = session('USER_ID');
            $Management->S_MANAGEMENT_SITE_delete($params);
            return $this->ok(array('RESULT' => 'OK', 'MESSAGE' => 'SUCCESS。'));
        } catch (\Exception $e) {
            return $this->ok(array('RESULT' => 'NG', 'MESSAGE' => 'ERROR。<br>' . $e->getMessage() ));
        }
    }

    public function post_site_sort()
    {
        try {
            $params = request()->all();
            $Management = new Management($this);
            $sortedIDs = $params['sortedIDs'] ?? array();
            foreach ($sortedIDs as $k=>$v){
                $update_arr = array();
                $update_arr['sort'] = $k+1;
                $Management->update_S_MANAGEMENT_SITE($v,$update_arr);
            }
            return $this->ok(array('RESULT' => 'OK', 'MESSAGE' => 'SUCCESS。'));
        } catch (\Exception $e) {
            return $this->ok(array('RESULT' => 'NG', 'MESSAGE' => 'ERROR。<br>' . $e->getMessage() ));
        }
    }
}
