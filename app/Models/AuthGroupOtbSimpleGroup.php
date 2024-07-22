<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use App\Exceptions\SimpleUserUpdateException;

/**
 * 権限を認証する
 * @author guoy
 */
class AuthGroupOtbSimpleGroup extends Model
{
    protected static $_valid_groups = array();

    public static function _init()
    {
        static::$_valid_groups = AuthGroupOtbSimpleGroup::get_valid_groups();
    }

    public static function get_valid_groups()
    {
        $result = DB::table('CO_ADMIN_USER_GROUPS')
                ->select('CO_ADMIN_USER_GROUPS.CODE')
                ->orderBy('SEQ_NO')
                ->get()->toArray();
        $valid_groups = array();
        foreach ($result as $key => $value) {
            $valid_groups[] = $value['CODE'];
        }
        return $valid_groups;
    }

    public static function get_group_roll($groupcode = null)
    {
        if (is_null($groupcode) && !empty(session('ROLE_TYPE'))) {
            $group_code = session('ROLE_TYPE');
        } else {
            $group_code = $groupcode;
        }
        if (!empty($group_code)) {
            $results = DB::table('CO_ADMIN_USER_GROUPS')
                            ->where('CODE', '=', $group_code)
                            ->select('CO_ADMIN_USER_GROUPS.GROUP_ROLE')
                            ->get()->toArray();
            $group_role = '';
            if (!empty($results[0]['GROUP_ROLE'])) {
                $group_role = $results[0]['GROUP_ROLE'];
            }
            return $group_role;
        }
    }

    public static function get_own_rolls()
    {
        $results = AuthGroupOtbSimpleGroup::get_admin_user_roles();

        $role_item = config('admin_auth.role_item', array());

        $my_rolls = array();
        foreach ($results as $value) {
            $item = $role_item[$value];
            $item_array = array();
            foreach ($item as $func => $page) {
                if ($func == 'REF_NAME') {
                    continue;
                }
                $temp = array();
                if (is_array($page)) {
                    $temp = array();
                    $item_array[$func] = array_merge_recursive(array_key_exists($func, $item_array) ? $item_array[$func] : array(), AuthGroupOtbSimpleGroup::parallelize_array($page, $temp));
                } else {
                    $item_array[$func] = $page;
                }
            }
            $my_rolls = array_merge_recursive($my_rolls, $item_array);
        }
        return $my_rolls;
    }

    public static function get_admin_user_roles($grouprole = null)
    {
        $my_group_role = is_null($grouprole) ? AuthGroupOtbSimpleGroup::get_group_roll() : $grouprole;
        $results = DB::table('CO_ADMIN_USER_ROLES')
                ->where('ROLE_NAME', '=', $my_group_role)
                ->select('CO_ADMIN_USER_ROLES.OPERATION_AUTHORITY')
                ->get()->toArray();

        $roles = array();
        foreach ($results as $key => $value) {
            $item = $value['OPERATION_AUTHORITY'];
            $roles[] = $item;
        }
        return $roles;
    }

    public static function parallelize_array($array, &$result, $parent_key = null)
    {
        if (!is_array($array)) {
            return $array;
        }

        foreach ($array as $key => $value) {
            if (is_array($value)) {
                AuthGroupOtbSimpleGroup::parallelize_array($value, $result, $key);
            } else {
                $result[] = (is_null($parent_key) || is_numeric($parent_key)) ? print_r(AuthGroupOtbSimpleGroup::parallelize_array($value, $result, $key), true) : $parent_key.'_'.print_r(AuthGroupOtbSimpleGroup::parallelize_array($value, $result, $key), true);
            }
        }
        return $result;
    }

    public static function has_access($val)
    {
        $condition = static::_parse_conditions($val);

        $area    = $condition[0];
        $rights  = (array) $condition[1];
        $current_roles  = AuthGroupOtbSimpleGroup::get_own_rolls();
        if (! array_key_exists($area, $current_roles)) {
            return true;
            //菜单权限规避
            // return false;
        }
        $current_role_rights = $current_roles[$area];
        foreach ($current_role_rights as $roles_right) {
            if (in_array($roles_right, $rights)) {
                return true;
            }
        }
        //菜单权限规避
        // return false;
        return true;
    }

    /**
     * Parses a conditions string into it's array equivalent
     *
     * @rights	mixed	conditions array or string
     * @return	array	conditions array formatted as array(area, rights)
     *
     */
    public static function _parse_conditions($rights)
    {
        if (is_array($rights)) {
            return $rights;
        }

        if (! is_string($rights) or strpos($rights, '.') === false) {
            throw new \Exception('Given rights where not formatted proppery. Formatting should be like area.right or area.[right, other_right]. Received: '.$rights);
        }

        list($area, $rights) = explode('.', $rights);

        if (substr($rights, 0, 1) == '[' and substr($rights, -1, 1) == ']') {
            $rights = preg_split('#( *)?,( *)?#', trim(substr($rights, 1, -1)));
        }

        return array($area, $rights);
    }

    /**
     * Update a user's properties
     * Note: Username cannot be updated, to update password the old password must be passed as old_password
     *
     * @param   Array  properties to be updated including profile fields
     * @param   string
     * @return  bool
     */
    public static function update_user($values, $USER_ID = null)
    {
        $USER_ID = $USER_ID ?: session('USER_ID');

        $current_values = DB::connection(config('auth.db_connection'))
            ->table(config('auth.table_name'))
            ->where('USER_ID', '=', $USER_ID)
            ->select(config('auth.table_columns', array('*')))
            ->first();

        $update = array();
        if (array_key_exists('password', $values)) {
            if (array_key_exists('old_password', $values)) {
                if (empty($values['old_password'])
                    or $current_values[config('auth.password_post_key', 'password')] != self::hash_password(trim($values['old_password']))) {
                    throw new \Exception('Old password is invalid');
                }
            }
            $password = trim(strval($values['password']));
            $update[config('auth.password_post_key', 'password')] = self::hash_password($password);
            unset($values['password']);
            $password_expire_time = date('Y-m-d H:i:s', time() + config('const.USER_PASSWORD_VALID_PERIOD'));
            $update[config('auth.userinfo_password_expire_time', 'expire_time')] = $password_expire_time;
            $update['LAST_MOD_USER'] = session('USER_ID');
        }

        $affected_rows = DB::connection(config('auth.db_connection'))
            ->table(config('auth.table_name'))
            ->where('USER_ID', '=', $USER_ID)
            ->update($update);
        return $affected_rows > 0;
    }

    /**
     * Default password hash method
     *
     * @param   string
     * @return  string
     */
    public static function hash_password($password)
    {
        return sha1(config('auth.salt').$password);
    }

    public static function remove_admin_user($params)
    {
        $result = array();
        try {
            if (array_key_exists('USER_ID', $params)) {
                $user_id = $params['USER_ID'];
                $CO_ADMIN_USER = DB::table('CO_ADMIN_USER')->where('USER_ID', '=', $user_id)->get()->first();
            } else {
                $result['MSG_CODE'] = 201;
                $result['MSG'] = 'アカウントを削除失敗しました。';
                return $result;
            }
            self::delete_user($user_id);
            DB::table('CO_ADMIN_USER_GROUPS')
            ->where('GROUP_ROLE', '=', 'ROLE_'.$user_id)
            ->delete();
            DB::table('CO_ADMIN_USER_ROLES')
            ->where('ROLE_NAME', '=', 'ROLE_'.$user_id)
            ->delete();
            $result['MSG_CODE'] = 200;
            $result['MSG'] = $CO_ADMIN_USER['USER_NAME'].'さんのアカウントを削除しました。';
            return $result;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Deletes a given user
     *
     * @param   string
     * @return  bool
     */
    public static function delete_user($USER_ID)
    {
        if (empty($USER_ID)) {
            throw new SimpleUserUpdateException('Cannot delete user with empty USER_ID', 9);
        }

        $affected_rows = DB::table(config('auth.table_name'))
            ->where('USER_ID', '=', $USER_ID)
            ->delete();

        return $affected_rows > 0;
    }

    /**
     * Create new user
     *
     * @param   string
     * @param   string
     * @param   string  must contain valid email address
     * @param   int     group id
     * @param   Array
     * @return  bool
     */
    public static function create_user($USER_ID, $password,$USER_NAME,$USER_IDENTITY,$group = 1)
    {
        $password = trim($password);

        if (empty($USER_ID) or empty($password) or empty($USER_NAME)) {
            throw new SimpleUserUpdateException('ユーザー名、パスワード、アカウント名は与えられません', 1);
        }

        $same_users = DB::table(config('auth.table_name'))
            ->where('USER_ID', '=', $USER_ID)
            ->select(config('auth.table_columns'))
            ->get()->toArray();
        if (comcount($same_users) > 0) {
            throw new SimpleUserUpdateException('そのログインIDは既に登録されています', 3);
        }

        $user = array(
            'USER_ID'         => (string) $USER_ID,
            'USER_PASSWORD'   => self::hash_password((string) $password),
            'USER_NAME'         => (string) $USER_NAME,
            'USER_IDENTITY'     => $USER_IDENTITY,
            'ROLE_TYPE'       => (int) $group,
            'LAST_LOGIN'      => 0,
            'LOGIN_HASH'      => '',
            'CREATED_USER' => 'SYSTEM',
            'CREATED_DT'      => DB::raw('NOW()')
        );
        $result = DB::table(config('auth.table_name'))->insert($user);
        return $result;
    }

    public static function edit_user_pwd($USER_ID,$password,$USER_NAME,$USER_IDENTITY,$SEQ_NO)
    {
        $password = trim($password);

        if (empty($USER_ID) or empty($password) or empty($USER_NAME)) {
            throw new SimpleUserUpdateException('ユーザー名、パスワード、アカウント名は与えられません', 1);
        }

        $user = array(
            'USER_ID'         => (string) $USER_ID,
            'USER_PASSWORD'   => self::hash_password((string) $password),
            'USER_NAME'         => (string) $USER_NAME,
            'USER_IDENTITY'     => $USER_IDENTITY,
            'ROLE_TYPE'       => 1,
            'LAST_LOGIN'      => 0,
            'LOGIN_HASH'      => '',
            'CREATED_USER' => 'SYSTEM',
            'CREATED_DT'      => DB::raw('NOW()')
        );
        $result = DB::table(config('auth.table_name'))->where('SEQ_NO', '=', $SEQ_NO)->update($user);
        return $result;
    }

    public static function edit_user_no_pwd($USER_ID,$USER_NAME,$USER_IDENTITY,$SEQ_NO)
    {

        if (empty($USER_ID) or empty($USER_NAME)) {
            throw new SimpleUserUpdateException('ユーザー名、アカウント名は与えられません', 1);
        }

        $user = array(
            'USER_ID'         => (string) $USER_ID,
            'USER_NAME'         => (string) $USER_NAME,
            'USER_IDENTITY'     => $USER_IDENTITY,
            'ROLE_TYPE'       => 1,
            'LAST_LOGIN'      => 0,
            'LOGIN_HASH'      => '',
            'CREATED_USER' => 'SYSTEM',
            'CREATED_DT'      => DB::raw('NOW()')
        );
        $result = DB::table(config('auth.table_name'))->where('SEQ_NO', '=', $SEQ_NO)->update($user);
        return $result;
    }

    public static function del_user_role_group($params)
    {
        $user_id = $params['USER_ID'];
        try {
            DB::table('CO_ADMIN_USER_GROUPS')->where('GROUP_ROLE', '=', 'ROLE_'.$user_id)->delete();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public static function add_user_role_group($params)
    {
        $user_id = $params['USER_ID'];
        try {
            $seq_no = DB::table('CO_ADMIN_USER')
                    ->select('SEQ_NO')
                    ->where('USER_ID', '=', $user_id)
                    ->value('SEQ_NO');
            DB::table('CO_ADMIN_USER')
                    ->where('USER_ID', '=', $user_id)
                    ->update(array('ROLE_TYPE' => $seq_no));

            $insert_array['CODE'] = $seq_no;
            $insert_array['GROUP_NAME'] = 'GROUP_MASTER';
            $insert_array['GROUP_ROLE'] = 'ROLE_'.$user_id;
            DB::table('CO_ADMIN_USER_GROUPS')->insert($insert_array);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public static function edit_add_user_role_group($params)
    {
        $user_id = $params['USER_ID'];
        $SEQ_NO = $params['SEQ_NO'];
        try {
            DB::table('CO_ADMIN_USER')
                ->where('SEQ_NO', '=', $SEQ_NO)
                ->update(array('ROLE_TYPE' => $SEQ_NO,'USER_ID' => $user_id));

            $insert_array['CODE'] = $SEQ_NO;
            $insert_array['GROUP_NAME'] = 'GROUP_MASTER';
            $insert_array['GROUP_ROLE'] = 'ROLE_'.$user_id;
            DB::table('CO_ADMIN_USER_GROUPS')->insert($insert_array);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public static function get_user_info($params)
    {
        if (array_key_exists('SEQ_NO', $params)) {
            $seq_no = $params['SEQ_NO'];
        }

        $query = DB::table('CO_ADMIN_USER');
        if (isset($seq_no)) {
            $query->where('SEQ_NO', '=', $seq_no);
        }

        return $query->get()->first();
    }

    public static function get_user_seq_no_info($SEQ_NO)
    {
        return DB::table('CO_ADMIN_USER')->where('SEQ_NO', '=', $SEQ_NO)->get()->first();
    }

    public static function get_name($group = null)
    {
        if ($group === null) {
            if (! is_array($groups = self::get_groups())) {
                return false;
            }
            $group = isset($groups[0][1]) ? $groups[0][1] : null;
        }

        $GROUP_ROLE = DB::table('CO_ADMIN_USER_GROUPS')
            ->select('GROUP_ROLE')
            ->where('CODE', '=', $group)
            ->value('GROUP_ROLE');

        return $GROUP_ROLE;
    }

    /**
     * Get the user's groups
     *
     * @return  Array  containing the group driver ID & the user's group ID
     */
    public static function get_groups()
    {
        if (empty(session('USER_ID'))) {
            return false;
        }

        return array(array('Otb_Simplegroup', session('ROLE_TYPE')));
    }

    public static function set_admin_user_roles($params)
    {
        $role_name = $params['ROLE_NAME'];
        $rights = $params['RIGHTS'];
        DB::beginTransaction();
        DB::table('CO_ADMIN_USER_ROLES')->where('ROLE_NAME', '=', $role_name)->delete();
        foreach ($rights as $right) {
            if (empty($right)) {
                continue;
            }
            $insert_array[] = array(
                'ROLE_NAME' => $role_name,
                'OPERATION_AUTHORITY' => $right
            );
        }
        if (!empty($insert_array)){
            $results = DB::table('CO_ADMIN_USER_ROLES')->insert($insert_array);
            DB::commit();
            return $results;
        }
        DB::commit();
        return true;
    }
}
