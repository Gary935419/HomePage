<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Admins;
use App\Models\AuthGroupOtbSimpleGroup;
use App\Models\Logs;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;
    public $Admin;
    public $data;
    public $Logs;
    public $Errors;
    public $config;
    public $app_api_url;
    public $env;
    /**
     * @var  array  value for guest login
     */
    protected static $guest_login = array(
        'id' => 0,
        'USER_ID' => 'guest',
        'group' => '0',
        'login_hash' => false,
        'email' => false
    );
    public function __construct()
    {
        $this->Admin = new Admin($this);
        $this->Logs = new Logs($this);
        $this->Admins = new Admins($this);

        // エラー文言テキストファイル読み込み
        $path = base_path();
        $errer = '';
        if (file_exists($path . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'lang' . DIRECTORY_SEPARATOR . 'ja' . DIRECTORY_SEPARATOR . 'errors.json')) {
            $errer = file_get_contents($path . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'lang' . DIRECTORY_SEPARATOR . 'ja' . DIRECTORY_SEPARATOR . 'errors.json');
        }
        $this->Errors = json_decode($errer, true);
        $this->config = config('const');
        $this->app_api_url = config('config.app_api_url');
        $this->env = getenv();

        $myrollname = AuthGroupOtbSimpleGroup::get_group_roll();
        $myrolls = AuthGroupOtbSimpleGroup::get_own_rolls();
        $user_info = $this->Admins->get_user_info(session('USER_ID'));
        $myrollname = str_replace("ROLE_", "", $myrollname);

        // グループ情報
        $controller = "";
        $actionMethod = request()->route()->getActionMethod();
        $pos = strpos($actionMethod, '_');
        $name = $pos === false ? $actionMethod : substr($actionMethod, $pos + 1);
        $group = request()->route()->getprefix();
        if (!empty($group)) {
            $controller = "Controller_".ucfirst(str_replace('/', '', $group));
        } elseif ($name == 'index') {
            $controller = "Controller_Main";
        } elseif ($name == 'login') {
            $controller = "Controller_Login";
        } elseif ($name == 'logout') {
            $controller = "Controller_Logout";
        }

        view()->share("myrolls", $myrolls);

        $is_show = true;
        if (!isset($myrolls['main'])){
            $is_show = false;
        }

        $this->data = array(
            'app_api_url' => $this->app_api_url,
            'is_show' => $is_show,
            'Config' => $this->config,
            'Env' => $this->env,
            'controller' => $controller,
            'action' => $name,
            'myrollname' => $myrollname,
            'USER_IDENTITY' => $user_info['USER_IDENTITY'],
            'USER_ID' => $user_info['USER_ID'],
            'USER_NAME' => $user_info['USER_NAME']
        );
    }
}
