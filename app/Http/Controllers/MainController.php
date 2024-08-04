<?php

namespace App\Http\Controllers;
use App\Models\Download;
use App\Models\Goods;
use App\Models\Imports;

class MainController extends Controller
{
    /**
     * ログイン画面
     */
    public function index()
    {
//        $Goods = new Goods($this);
//        $this->data['count1'] = $Goods->select_PRODUCT_count();
//        $Imports = new Imports($this);
//        $this->data['count2'] = $Imports->select_PRECEDENTS_count();
//        $this->data['count3'] = $Imports->select_COMPANY_count();
//        $Download = new Download($this);
//        $this->data['count4'] = $Download->select_DOWNLOADS_HISTORY_count();
//        return view('main/index', $this->data);
        return redirect('/news/news_lists');
    }
}
