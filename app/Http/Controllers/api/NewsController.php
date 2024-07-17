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
}
