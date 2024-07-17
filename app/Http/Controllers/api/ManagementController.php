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
}
