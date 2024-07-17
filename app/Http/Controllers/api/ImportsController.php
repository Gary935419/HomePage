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
}
