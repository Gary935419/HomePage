<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class Admin extends Model
{
    protected $connection = 'otb_read';
    protected $table = 'CO_ADMIN_USER';

    /**
     * @var  Database_Result  when login succeeded
     */
    protected $user = null;

    /**
     * @var  array  value for guest login
     */
    protected static $guest_login = array(
        'id' => 0,
        'USER_ID' => 'guest',
        'group' => '0',
        'LOGIN_HASH' => false,
        'email' => false
    );

    public const CREATED_AT = 'CREATED_DT';
    public const UPDATED_AT = 'LAST_MOD_DT';

    private $Lara;

    public function __construct(&$Lara)
    {
        $this->Lara = $Lara;
    }
    /**
     * Check the user exists
     * @return  bool
     */
    public function validateUser($username_or_email = '', $password = '')
    {
        $username_or_email = trim($username_or_email);
        $password = trim($password) ?: trim(request()->get(config('auth.password_post_key', 'password')));

        if (empty($username_or_email) or empty($password)) {
            return false;
        }

        $password = hash_password($password);

        $user = DB::table('CO_ADMIN_USER')
            ->where('USER_ID', '=', $username_or_email)
            ->where('USER_PASSWORD', '=', $password)
            ->first();

        if (!empty($user)){
            $user['sid'] = "";
            $user['agent_number'] = "";
            return $user;
        }

        return false;
    }
    /**
     * Check the user exists
     * @return  bool
     */
    public function getPasswordExpiredTime($paras = null)
    {
        $user_id_key = config('auth.username_post_key', 'USER_ID');
        if (isset($paras) && array_key_exists($user_id_key, $paras)) {
            $USER_ID = $paras[$user_id_key];
        } else {
            $USER_ID = session('USER_ID');
        }

        $current_values = DB::table('CO_ADMIN_USER')
            ->where($user_id_key, '=', $USER_ID)
            ->get();
        $current_values = isset($current_values[0]) ? $current_values[0] : $current_values;

        if (array_key_exists('PASSWORD_VALID_CHECK', $current_values)) {
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

    /**
     * Login user
     *
     * @param   string
     * @param   string
     * @return  bool
     */
    public function login($username_or_email = '', $password = '')
    {
        if (!($this->user = $this->validateUser($username_or_email, $password))) {
            $this->user = config('auth.guest_login', true) ? static::$guest_login : false;
            session()->forget(['USER_ID','ROLE_TYPE','LOGIN_HASH']);
            return false;
        }
        // セッション記入
        session(['USER_ID'=>$this->user['USER_ID']]);
        session(['ROLE_TYPE'=>$this->user['ROLE_TYPE']]);
        session(['LOGIN_HASH'=>$this->createLoginHash()]);
        session()->regenerate();

        return true;
    }

    /**
     * Creates a temporary hash that will validate the current login
     *
     * @return  string
     */
    public function createLoginHash()
    {

        $LAST_LOGIN = date('Y-m-d H:i:s');
        $LOGIN_HASH = sha1(config('auth.salt') . $this->user['USER_ID'] . $LAST_LOGIN);

        DB::table('CO_ADMIN_USER')
            ->where('USER_ID', '=', $this->user['USER_ID'])
            ->update(array('LAST_LOGIN' => $LAST_LOGIN, 'LOGIN_HASH' => $LOGIN_HASH));

        $this->user['LOGIN_HASH'] = $LOGIN_HASH;

        return $LOGIN_HASH;
    }

    /**
     * Logout user
     *
     * @return  bool
     */
    public function logout()
    {
        $this->user = config('auth.guest_login', false) ? static::$guest_login : false;
        session()->forget(['USER_ID','ROLE_TYPE','LOGIN_HASH']);
        return true;
    }

    /**
     * Check the user exists
     * @return  bool
     */
    public function authCheck()
    {
        // fetch the USER_ID and login hash from the session
        $USER_ID    = session('USER_ID');
        $LOGIN_HASH  = session('LOGIN_HASH');

        // only worth checking if there's both a USER_ID and login-hash
        if (!empty($USER_ID) and !empty($LOGIN_HASH)) {
            if (is_null($this->user) or ($this->user['USER_ID'] != $USER_ID and $this->user != static::$guest_login)) {
                $this->user = DB::table('CO_ADMIN_USER')
                    ->where('USER_ID', '=', $USER_ID)
                    ->first();
            }
            // return true when login was verified, and either the hash matches or multiple logins are allowed
            if ($this->user and (config('auth.multiple_logins', false) or $this->user['LOGIN_HASH'] === $LOGIN_HASH)) {
                return true;
            }
        }

        // no valid login when still here, ensure empty session and optionally set guest_login
        $this->user = config('auth.guest_login', true) ? static::$guest_login : false;
        session()->forget(['USER_ID','ROLE_TYPE','LOGIN_HASH']);

        return false;
    }
}
