<?php

namespace App\Http\Controllers;

use App\Models\Model;
use App\Models\Admins;
use App\Models\AuthGroupOtbSimpleGroup;

class UserInfoController extends Controller
{
    /**
    * パスワード変更
    */
    public function get_password_change()
    {
        return view('userinfo/password_change', $this->data);
    }

    public function post_password_change()
    {
        $params = request()->all();
        $Admins = new Admins($this);
        $change_password_result = $Admins->change_admin_user_password($params);

        if (empty($change_password_result)) {
            //強制パスワード変更後に自動ログイン
            if (!$this->Admin->authCheck() && isset($params['FORCED_CHANGE_PASSWORD_USER_ID']) && !empty($params['FORCED_CHANGE_PASSWORD_USER_ID']) && !empty($params['NEW_PASSWORD'])) {
                $this->Admin->login($params['FORCED_CHANGE_PASSWORD_USER_ID'], $params['NEW_PASSWORD']);
            }
            $password_expired_time = $Admins->get_password_expired_time();
            if (isset($password_expired_time)) {
                $this->data[config('auth.userinfo_password_expire_time', 'PASSWORD_EXPIRE_TIME')] = $password_expired_time;
            }
            return view('userinfo/password_changed', $this->data);
        } else {
            if (isset($params['FORCED_CHANGE_PASSWORD_USER_ID']) && !empty($params['FORCED_CHANGE_PASSWORD_USER_ID'])) {
                $forced_chage_user = $params['FORCED_CHANGE_PASSWORD_USER_ID'];
                $this->data['change_password_result'] = $change_password_result;
                $this->data['USER_ID'] = $forced_chage_user;
                return view('userinfo/password_change_forced', $this->data);
            } else {
                $this->data['change_password_result'] = $change_password_result;
                return view('userinfo/password_change', $this->data);
            }
        }
    }

    public function get_force_password_change()
    {
        try {
            $params = request()->all();
            $client_seq = $params['client_seq'];
            $this->data['CLIENT_SEQ_NO'] = $client_seq;
            $result = AuthGroupOtbSimpleGroup::get_user_info(array('SEQ_NO' => $client_seq));
            $client_id = $result['USER_ID'];
            $this->data['USER_ID'] = $client_id;
            $this->data['SEQ_NO'] = $client_seq;
            return view('userinfo/force_password_change', $this->data);
        } catch (\Exception $e) {
            $this->data['ERROR_MESSAGE'] = $e->getMessage();
            return view('userinfo/force_password_change', $this->data);
        }
    }

    public function post_force_password_change()
    {
        try {
            $params = request()->all();
            $Admins = new Admins($this);
            $change_password_result = $Admins->change_admin_user_password($params, true);
            $client_seq = $params['client_seq'];
            $this->data['CLIENT_SEQ_NO'] = $client_seq;
            $result = AuthGroupOtbSimpleGroup::get_user_info(array('SEQ_NO' => $client_seq));
            $client_id = $result['USER_ID'];
            $this->data['USER_ID'] = $client_id;
            $this->data['SEQ_NO'] = $client_seq;
            if (!empty($change_password_result)) {
                $this->data['change_password_result'] =$change_password_result;
                return view('userinfo/force_password_change', $this->data);
            } else {
                $password_expired_time = $Admins->get_password_expired_time(array('USER_ID' => $client_id));
                if (isset($password_expired_time)) {
                    $this->data[config('auth.userinfo_password_expire_time', 'PASSWORD_EXPIRE_TIME')] = $password_expired_time;
                }
                $this->data['USER_ID'] = session('USER_ID');
                return view('userinfo/password_changed', $this->data);
            }
        } catch (\Exception $e) {
            $this->data['ERROR_MESSAGE'] = $e->getMessage();
            return view('userinfo/force_password_change', $this->data);
        }
    }

    /**
     * 管理画面ユーザー情報
     */
    public function get_admin_user_info()
    {
        $clients_info = Model::get_all_user_info();
        foreach ($clients_info as $k=>$v){
            $clients_info[$k]['IDENTITY_NAME'] = "";
        }
        $this->data['clients_info'] = $clients_info;
        return view('userinfo/admin_user_info', $this->data);
    }

    public function post_admin_user_info()
    {
        $params = request()->all();
        $Admins = new Admins($this);
        $affected_rows = $Admins->set_admin_user_password_expired($params);
        $this->data['clients_info'] = Model::get_all_user_info();
        if ($affected_rows > 0) {
            $this->data['data_updated'] = 1;
        }
        return view('userinfo/admin_user_info', $this->data);
    }

    public function get_admin_add_user()
    {
        return view('userinfo/admin_add_user', $this->data);
    }

    public function post_admin_add_user()
    {
        try {
            $params = request()->all();
            $user_id = $params['USER_ID'];
            $password = $params['PASSWORD'];
            $comfirm = $params['PASSWORD_CONFIRM'];

            if ($password != $comfirm) {
                $error_message = '密码与确认密码信息不一致。';
            } else {
                $Admins = new Admins($this);
                $error_message = $Admins->check_admin_user_password(array('PASSWORD' => $password));
            }

            if (!empty($error_message)) {
                $this->data['add_user_result'] = $error_message;
            }else{
                AuthGroupOtbSimpleGroup::create_user($user_id, $password);
                AuthGroupOtbSimpleGroup::add_user_role_group(array('USER_ID' => $user_id));
                //created client id successfully
                if (empty($error_message)) {
                    $this->data['created_user_id'] = $user_id;
                }
            }

            return view('userinfo/admin_add_user', $this->data);
        } catch (\Exception $e) {
            $this->data['add_user_result'] = $e->getMessage();
            return view('userinfo/admin_add_user', $this->data);
        }
    }

    public function get_admin_user_rights_setting()
    {
        $params = request()->all();
        $ADMIN_SEQ_NO = $params['ADMIN_SEQ_NO'];
        $admin_user_role_code = $params['ADMIN_ROLE_CODE'];
        $myrole = AuthGroupOtbSimpleGroup::get_group_roll($admin_user_role_code);
        $owned_roles = AuthGroupOtbSimpleGroup::get_admin_user_roles($myrole);
        $role_item = config('admin_auth.role_item', array());
        $right_categories = array();
        foreach ($role_item as $key => $value) {
            if (is_array($value) && array_key_exists('REF_NAME', $value)) {
                $ref_name = $value['REF_NAME'];
            } else {
                $ref_name = '_';
            }

            $right_categories[$key] = explode('_', $ref_name);
            if (in_array($key, $owned_roles)) {
                $right_categories[$key]['HAS_RIGHT'] = 1;
            } else {
                $right_categories[$key]['HAS_RIGHT'] = 0;
            }
        }
        $role_name = AuthGroupOtbSimpleGroup::get_name($admin_user_role_code);
        if (is_null($role_name)) {
            throw new \OneException(3);
        }
        $this->data['clients_info'] = substr($role_name,5);
        $this->data['right_categories'] = $right_categories;
        $this->data['admin_user_role_code'] = $admin_user_role_code;
        $this->data['admin_seq_no'] = $ADMIN_SEQ_NO;
        return view('userinfo/admin_user_rights_setting', $this->data);
    }

    public function action_admin_remove_user()
    {
        $client_user_id = request('client_id');

        $errormsg = AuthGroupOtbSimpleGroup::remove_admin_user(array('USER_ID' => $client_user_id, ));

        $this->data['remove_user_result'] = $errormsg;
        $this->data['removed_user_id'] = $client_user_id;
        return view('userinfo/admin_remove_user', $this->data);
    }
}
