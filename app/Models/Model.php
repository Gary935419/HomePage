<?php
namespace App\Models;

use App\Exceptions\BatchException;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class Model extends EloquentModel
{
    public function crypt_decode_url($str = null)
    {
        $result = $this->decrypt_url($str);
        return $result;
    }

    public function crypt_encode_url($str = null)
    {
        $result = $this->encrypt_url($str);
        $result = urlencode($result);
        return $result;
    }

    /**
     * decrypt AES 256
     *
     * @param data $edata
     * @return decrypted data
     */
    private function decrypt_url($edata)
    {
        return openssl_decrypt($edata, 'AES-128-ECB', config('const.URL_CRYPT_SALT'));
    }

    /**
     * crypt AES 256
     *
     * @param data $data
     * @return base64 encrypted data
     */
    private function encrypt_url($data)
    {
        return openssl_encrypt($data, 'AES-128-ECB', config('const.URL_CRYPT_SALT'));
    }

    /**
     * Taken from the PHP documentation website.
     * Kristof_Polleunis at yahoo dot com
     * A guid function that works in all php versions:
     * MEM 3/30/2015 : Modified the function to allow someone
     * to specify whether or not they want the curly
     * braces on the GUID.
     */

    public static function guid($opt = true)
    {
        if (function_exists('com_create_guid')) {
            if ($opt) {
                return com_create_guid();
            } else {
                return trim(com_create_guid(), '{}');
            }
        } else {
            mt_srand((float)microtime() * 10000);  // optional for php 4.2.0 and up.
            $charid = strtoupper(md5(uniqid(rand(), true)));
            $hyphen = chr(45);  // "-"
            $left_curly = $opt ? chr(123) : "";  //  "{"
            $right_curly = $opt ? chr(125) : "";  //  "}"
            $uuid = $left_curly
                . substr($charid, 0, 8) . $hyphen
                . substr($charid, 8, 4) . $hyphen
                . substr($charid, 12, 4) . $hyphen
                . substr($charid, 16, 4) . $hyphen
                . substr($charid, 20, 12)
                . $right_curly;
            return $uuid;
        }
    }

    /**
     * ハッシュを生成する
     */
    public function onehash($value)
    {
        return hash('sha256', config('const.PASSWORD_SALT'). $value);
    }

    /**
     * 必須チェック
     *
     * @param array $params   パラメータ
     * @param array $requires 必須項目のキー
     */
    public function params_check($params = array(), $requires = array())
    {
        foreach ($requires as $key => $require) {
            if (!isset($params[$require]) || $params[$require] == '') {
                throw new \OneException(4, "Missing : {$require}");
            }
        }
        return true;
    }

    /**
     * CSVファイル解析
     *
     * @param mixed  $file_info  CSVファイルの情報
     * @param string $separator  CSVファイルのseparator
     * @param int    $line_after 指定行以降から読み込む
     *
     * @return array CSVファイルをパースした結果。
     */
    public static function parse_csv_file($file_info,$is_jump_blank_line=false)
    {
        try {
            $csv_data = array();
            $data = file_get_contents($file_info['saved_to']. $file_info['saved_as']);
            $data = mb_convert_encoding($data, 'UTF-8', 'SJIS, UTF-8');
            $data = str_replace(array("\r\n", "\r", "\n"), "\n", $data);
            $data_array = explode("\n", $data);
            $cnt = count($data_array);
            for ($i = 0; $i < $cnt; $i++) {
                if ($is_jump_blank_line){
                    if($data_array[$i] != '') {
                        $csv_data[] = str_getcsv($data_array[$i], ',');
                    }
                }else{
                    $csv_data[] = str_getcsv($data_array[$i], ',');
                }
            }
            return $csv_data;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * 指定されたキー項目で、配列を作り直す
     */
    public static function get_array_by_key($array = array(), $array_key = '')
    {
        if (empty($array)) {
            return array();
        } else {
            $return_array = array();
            foreach ($array as $value) {
                $return_array[$value[$array_key]][] = $value;
            }
            return $return_array;
        }
    }

    /*
     * 単元個数
     */
    public static function fnWordCount($str)
    {
        $tmp = @iconv('gdk', 'utf-8', $str);
        if (!empty($tmp)) {
            $str = $tmp;
        }
        preg_match_all('/./us', $str, $match);
        return count($match[0]);
    }

    /*
     * 小数点以下余計な0を削除する
     */
    public static function TrimTrailingZeroes($nbr)
    {
        return strpos($nbr, '.')!==false ? rtrim(rtrim($nbr, '0'), '.') : $nbr;
    }

    public static function get_all_user_info($USER_ID)
    {
        $results_sql = DB::connection(config('auth.db_connection'))->table(config('auth.table_name'))
            ->select(config('auth.table_columns', array('*')));
        if ($USER_ID != 'admin'){
            $results_sql = $results_sql->where('USER_ID','!=','admin');
        }
        $results = $results_sql->get()->toArray();
        return $results;
    }

}
