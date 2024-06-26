<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class Admins extends Model
{
    private $Lara;

    public function __construct(&$Lara)
    {
        $this->Lara = $Lara;
    }

    public function change_admin_user_password($paras, $force = false)
    {
        $original_password = array_key_exists('ORIGINAL_PASSWORD', $paras) ? $paras['ORIGINAL_PASSWORD'] : null;
        $new_password = $paras['NEW_PASSWORD'];
        $user_id = array_key_exists('FORCED_CHANGE_PASSWORD_USER_ID', $paras) ? $paras['FORCED_CHANGE_PASSWORD_USER_ID'] : null;
        if ($original_password == $new_password) {
            return '新的密码和现在的密码相同,请重新设定。';
        }
        $password_general_check = self::check_admin_user_password(array('PASSWORD' => $new_password, ));
        if (!empty($password_general_check)) {
            return $password_general_check;
        }
        try {
            // 現在のパスワード必須にする
            if (!$force && is_null($original_password)) {
                return '请输入现在的密码信息。';
            }

            $password_info = array('password' => $new_password);
            if (!is_null($original_password)) {
                $password_info += (array('old_password' => $original_password));
            }
            $changed = AuthGroupOtbSimpleGroup::update_user($password_info, $user_id);

            if ($changed) {
                $result = '';
            } else {
                $result = '密码修改失败';
            }
        } catch (\Exception $e) {
            $result = $e->getMessage();
            if ($result == 'Old password is invalid') {
                $result = '旧密码信息错误。';
            }
        }
        return $result;
    }

    public function check_admin_user_password($paras)
    {
        $password = array_key_exists('PASSWORD', $paras) ? $paras['PASSWORD'] : null;
        if (is_null($password)) {
            return '密码设定信息未传递。';
        }

        // 桁数チェック
//        if (!preg_match('/^.{'.config('const.PASSWORD_LIMI_MINLENGTH_ADMIN').','.config('const.PASSWORD_LIMI_MAXLENGTH_ADMIN').'}$/', $password)) {
//            return '密码位数为'.config('const.PASSWORD_LIMI_MINLENGTH_ADMIN').'~'.config('const.PASSWORD_LIMI_MAXLENGTH_ADMIN').'之间。';
//        }
        // 形式チェック
//        if (preg_match(config('const.PASSWORD_VALIDATE_STRING_ADMIN'), $password)) {
//            return '密码中含有无效的字符。';
//        }
        if (config('const.PASSWORD_REQUIRE_NUMBER_ADMIN')) {
            if (!preg_match(config('const.PASSWORD_VALIDATE_NUMBER_ADMIN'), $password)) {
                return '请在密码里包含数字。';
            }
        }
        if (config('const.PASSWORD_REQUIRE_ALPHABET_ADMIN')) {
            if (!preg_match(config('const.PASSWORD_VALIDATE_ALPHABET_ADMIN'), $password)) {
                return '请让密码包含英文字。';
            }
        }
        if (config('const.PASSWORD_REQUIRE_SIGN_ADMIN')) {
            if (!preg_match(config('const.PASSWORD_VALIDATE_SIGN_ADMIN'), $password)) {
                return '请在密码中包含符号。';
            }
        }
        return '';
    }

    public function get_password_expired_time($paras=null)
    {
        $user_id_key = config('auth.username_post_key', 'USER_ID');
        if (isset($paras) && array_key_exists($user_id_key, $paras)) {
            $USER_ID = $paras[$user_id_key];
        } else {
            $USER_ID = session('USER_ID');
        }

        $current_values = DB::connection(config('auth.db_connection'))
            ->table(config('auth.table_name'))
            ->where($user_id_key, '=', $USER_ID)
            ->select(config('auth.table_columns', array('*')))
            ->first();

        if (!empty($current_values) && array_key_exists('PASSWORD_VALID_CHECK', $current_values)) {
            $check_expired_time = $current_values['PASSWORD_VALID_CHECK'];
            if ($check_expired_time != 0 && array_key_exists('PASSWORD_EXPIRE_TIME', $current_values)) {
                $expired_time = $current_values['PASSWORD_EXPIRE_TIME'];
            }
        }
        if (!isset($expired_time)) {
            $expired_time = null;
        }
        return $expired_time;
    }

    public function set_admin_user_password_expired($paras)
    {
        $seqs = array();

        if (array_key_exists('CHECK_EXPIRED_USER_SEQS', $paras)) {
            $seqs = $paras['CHECK_EXPIRED_USER_SEQS'];
        } else {
            if (is_array($paras)) {
                foreach (array_keys($paras) as $key) {
                    if (strpos($key, 'USER_PASSWORD_VALID_CHECK') !== false) {
                        $seqs[] = $paras[$key];
                    }
                }
            }
        }

        $update = array();
        $update[config('auth.userinfo_password_valid_check')] = 0;
        $affected_rows = DB::connection(config('auth.db_connection'))
            ->table(config('auth.table_name'))
            ->update($update);

        if (count($seqs) > 0) {
            $update[config('auth.userinfo_password_valid_check')] = 1;
            $affected_rows = DB::connection(config('auth.db_connection'))
                ->table(config('auth.table_name'))
                ->whereIn('SEQ_NO', $seqs)
                ->update($update);
        }
        return $affected_rows;
    }

    public function get_user_rights()
    {
        $user_rights = DB::connection(config('auth.db_connection'))
            ->table('CO_ADMIN_USER_ROLES')
            ->get()->toArray();
        return $user_rights;
    }

}
