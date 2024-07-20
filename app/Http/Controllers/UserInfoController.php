<?php

namespace App\Http\Controllers;

use App\Models\Imports;
use App\Models\Model;
use App\Models\Admins;
use App\Models\AuthGroupOtbSimpleGroup;
use Illuminate\Support\Facades\Log;

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
        $paramsAll = request()->all();

        $MSG_CODE = $paramsAll['msg_code'] ?? '';
        if (!empty($MSG_CODE)){
            $this->data['MSG_CODE'] = $MSG_CODE;
            $this->data['MSG'] = $paramsAll['msg'];
        }

        $this->data['USER_ID'] = $paramsAll['USER_ID'] ?? '';
        $this->data['USER_NAME'] = $paramsAll['USER_NAME'] ?? '';

        $user_id = session('USER_ID');
        $clients_info = Model::get_all_user_info($user_id,$this->data['USER_ID'],$this->data['USER_NAME']);
        $this->data['clients_info'] = $clients_info;
        return view('userinfo/admin_user_info', $this->data);
    }

    public function post_admin_user_info()
    {
        $params = request()->all();
        $user_id = session('USER_ID');
        $Admins = new Admins($this);
        $affected_rows = $Admins->set_admin_user_password_expired($params);
        $this->data['clients_info'] = Model::get_all_user_info($user_id);
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
            $USER_NAME = !isset($params['USER_NAME']) || empty($params['USER_NAME']) ? 0 : $params['USER_NAME'];
            $USER_IDENTITY = !isset($params['USER_IDENTITY']) || empty($params['USER_IDENTITY']) ? 0 : $params['USER_IDENTITY'];
            $password = $params['PASSWORD'];
            $comfirm = $params['PASSWORD_CONFIRM'];
            $this->data['MSG_CODE'] = 201;
            if ($password != $comfirm) {
                $error_message = 'パスワードが確認用パスワード情報と一致しない。';
            } else {
                $Admins = new Admins($this);
                $error_message = $Admins->check_admin_user_password(array('PASSWORD' => $password));
            }

            $check_admin_user_id_error_message = $Admins->check_admin_user_id(array('USER_ID' => $user_id));
            if (!empty($error_message) && !empty($check_admin_user_id_error_message)){
                $error_message = $error_message.",".$check_admin_user_id_error_message;
            } elseif (empty($error_message) && !empty($check_admin_user_id_error_message)){
                $error_message = $check_admin_user_id_error_message;
            }

            if (!empty(trim($error_message))) {
                $this->data['add_user_result'] = trim($error_message);
                $this->data['MSG'] = trim($error_message);
            }else{
                AuthGroupOtbSimpleGroup::create_user($user_id, $password,$USER_NAME,$USER_IDENTITY);
                AuthGroupOtbSimpleGroup::add_user_role_group(array('USER_ID' => $user_id));
                // $this->data['MSG_CODE'] = 200;
                // $this->data['MSG'] = "アカウント情報の登録が完了しました。";
                // $this->data['created_user_id'] = $user_id;
                return redirect('/userinfo/admin_user_info?msg_code=200&&msg=アカウント情報の登録が完了しました。');
            }

            return view('userinfo/admin_add_user', $this->data);
        } catch (\Exception $e) {
//            $this->data['add_user_result'] = $e->getMessage();
            $this->data['MSG'] = $e->getMessage();
            return view('userinfo/admin_add_user', $this->data);
        }
    }

    public function get_admin_edit_user($SEQ_NO)
    {
        try {
            $this->data['SEQ_NO'] = $SEQ_NO;
            $this->data['info'] = AuthGroupOtbSimpleGroup::get_user_info(array('SEQ_NO' => $SEQ_NO));
            if (empty($this->data['info'])){
                throw new \OneException(3);
            }
            return view('userinfo/admin_edit_user', $this->data);
        } catch (\OneException $e) {
            $this->data["ERROR_MESSAGE"] = $e->getMessage();
            Log::error($e->getMessage());
            return view('error/error', $this->data);
        } catch (\Exception $e) {
            $this->data["ERROR_MESSAGE"] = $e->getMessage();
            Log::error($e->getMessage());
            return view('error/error', $this->data);
        }
    }

    public function post_admin_edit_user()
    {
        $params = request()->all();
        $SEQ_NO = $params['SEQ_NO'];
        $Admins = new Admins($this);
        try {
            $info_old = AuthGroupOtbSimpleGroup::get_user_seq_no_info($SEQ_NO);
            $user_id = $params['USER_ID'];
            $USER_NAME = !isset($params['USER_NAME']) || empty($params['USER_NAME']) ? "" : $params['USER_NAME'];
            $USER_IDENTITY = !isset($params['USER_IDENTITY']) || empty($params['USER_IDENTITY']) ? 0 : $params['USER_IDENTITY'];
            $this->data['MSG_CODE'] = 201;
            $error_message = "";
            if (isset($params['PASSWORD']) && !empty($params['PASSWORD'])){
                $password = $params['PASSWORD'];
                $comfirm = $params['PASSWORD_CONFIRM'];

                if ($password != $comfirm) {
                    $error_message = 'パスワードが確認用パスワード情報と一致しない。';
                } else {
                    $error_message = $Admins->check_admin_user_password(array('PASSWORD' => $password));
                }
                if (!empty($error_message)) {
                    $this->data['add_user_result'] = $error_message;
                }else{
                    AuthGroupOtbSimpleGroup::edit_user_pwd($user_id,$password,$USER_NAME,$USER_IDENTITY,$SEQ_NO);
                }
            }else{
                AuthGroupOtbSimpleGroup::edit_user_no_pwd($user_id,$USER_NAME,$USER_IDENTITY,$SEQ_NO);
            }

            $check_admin_user_id_error_message = $Admins->check_admin_user_id(array('USER_ID' => $user_id));
            if (!empty($error_message) && !empty($check_admin_user_id_error_message)){
                $error_message = $error_message.",".$check_admin_user_id_error_message;
            } elseif (empty($error_message) && !empty($check_admin_user_id_error_message)){
                $error_message = $check_admin_user_id_error_message;
            }

            AuthGroupOtbSimpleGroup::del_user_role_group(array('USER_ID' => $info_old['USER_ID']));
            AuthGroupOtbSimpleGroup::edit_add_user_role_group(array('USER_ID' => $user_id,'SEQ_NO' => $SEQ_NO));

            if (empty(trim($error_message))) {
                // $this->data['MSG_CODE'] = 200;
                // $this->data['created_user_id'] = $user_id;
                // $this->data['MSG'] = "アカウント情報の編集が完了しました。";
                return redirect('/userinfo/admin_user_info?msg_code=200&&msg=アカウント情報の編集が完了しました。');
            }
            $this->data['MSG'] = $error_message;
            $this->data['info'] = AuthGroupOtbSimpleGroup::get_user_seq_no_info($SEQ_NO);
            return view('userinfo/admin_edit_user', $this->data);
        } catch (\Exception $e) {
            $this->data['info'] = AuthGroupOtbSimpleGroup::get_user_seq_no_info($SEQ_NO);
            $this->data['MSG'] = $e->getMessage();
            return view('userinfo/admin_edit_user', $this->data);
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
//        $client_user_id = request('client_id');
//
//        $errormsg = AuthGroupOtbSimpleGroup::remove_admin_user(array('USER_ID' => $client_user_id, ));
//
//        $this->data['remove_user_result'] = $errormsg;
//        $this->data['removed_user_id'] = $client_user_id;
//        return view('userinfo/admin_remove_user', $this->data);

        $paramsAll = request()->all();
        $client_user_id =  $paramsAll['client_id'] ?? '';
        $result = AuthGroupOtbSimpleGroup::remove_admin_user(array('USER_ID' => $client_user_id));
        $this->data['MSG'] = $result['MSG'];
        $this->data['MSG_CODE'] = $result['MSG_CODE'];

        $this->data['USER_ID'] = $paramsAll['USER_ID'] ?? '';
        $this->data['USER_NAME'] = $paramsAll['USER_NAME'] ?? '';

        $user_id = session('USER_ID');
        $clients_info = Model::get_all_user_info($user_id,$this->data['USER_ID'],$this->data['USER_NAME']);
        $this->data['clients_info'] = $clients_info;
        return view('userinfo/admin_user_info', $this->data);
    }
}
