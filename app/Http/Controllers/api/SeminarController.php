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
}
