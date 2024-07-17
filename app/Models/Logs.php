<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class Logs extends Model
{
    private $Lara;

    public function __construct(&$Lara, $is_api=true)
    {
        global $LOG_SEQ_NO;
        $this->Lara = $Lara;

        // 2020-10-14 本番環境ではログを出さない（個人情報が出力されてしまうため）
        if ($is_api && config('app.env') != 'production') {
            $data = openssl_random_pseudo_bytes(16);
            $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
            $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10
            $uniqueLogKey = vsprintf('%s%s%s%s%s%s%s%s', str_split(bin2hex($data), 4));
            $params = \Input::all();
            $all_header = getallheaders();
            $logData = array(
                'LOG_TYPE' => 1,
                'UNIQUE_KEY' => $uniqueLogKey,
                'IP' => $_SERVER['REMOTE_ADDR'],
                'UUID' => empty($params['UUID']) ? '' : $params['UUID'],
                'URI' => $_SERVER['REQUEST_URI'],
                'METHOD' => $_SERVER['REQUEST_METHOD'],
                'HEADER' => json_encode($all_header),
                'REQUEST' => json_encode($params),
                'CLIENT_SEQ_NO' => '',	// 取引API、PCサイトのログインユーザ
                'CLIENT_ID' => empty(session('USER_ID')) ? '' : session('USER_ID'),	// 管理画面の管理者アカウント
                'TYPE' => '',
                'RESPONSE' => '',
                'CREATED_USER' => (isset($_SERVER['SERVER_ADDR'])) ? $_SERVER['SERVER_ADDR'] : $_SERVER['SERVER_NAME'],
                'CREATED_DT' => get_now_jst(),
            );

            $REQUEST_URI = $_SERVER['REQUEST_URI'];
            if (strpos($REQUEST_URI, '?') !== false) {
                $REQUEST_URI = substr($REQUEST_URI, 0, strpos($REQUEST_URI, '?'));
            }
            $log_exclude = config('const.log_exclude', null);
            if ($log_exclude !== null && is_array($log_exclude) && in_array($REQUEST_URI, $log_exclude)) {
                $logData['REQUEST'] = json_encode('***');
            }

            $log_password_mask = config('const.log_password_mask', null);
            if ($log_password_mask !== null && is_array($log_password_mask) && in_array($REQUEST_URI, $log_password_mask)) {
                $pattern = '/"([^"]*)PASSWORD":"([^"]+)"/i';
                $replacement = '"${1}PASSWORD":"***"';
                $logData['REQUEST'] = preg_replace($pattern, $replacement, $logData['REQUEST']);
            }

            $logPath = APPPATH . 'logs' . DS . 'request' . DS . date('Y-m') . DS;
            if (!file_exists($logPath)) {
                mkdir($logPath, 0777, true);
            }

            file_put_contents($logPath . date('d') . '.log', implode("\t", $logData) . "\n", FILE_APPEND);
            $this->SEQ_NO = $uniqueLogKey;
            $LOG_SEQ_NO = $this->SEQ_NO;
        }
    }

    /**
     * レスポンスを保存する
     */
    public function log_save($response, $TYPE)
    {
        // 2020-10-14 本番環境ではログを出さない（個人情報が出力されてしまうため）
        $params = \Input::all();
        if (config('app.env') != 'production') {
            $logData = array(
                'LOG_TYPE' => 2,
                'UNIQUE_KEY' => $this->SEQ_NO,
                'IP' => $_SERVER['REMOTE_ADDR'],
                'UUID' => empty($params['UUID']) ? '' : $params['UUID'],
                'URI' => $_SERVER['REQUEST_URI'],
                'METHOD' => '',
                'HEADER' => '',
                'REQUEST' => '',
                'CLIENT_ID' => empty(session('USER_ID')) ? '' : session('USER_ID'),	// 管理画面の管理者アカウント
                'TYPE' => $TYPE,
                'RESPONSE' =>json_encode($response),
                'CREATED_USER' => (isset($_SERVER['SERVER_ADDR'])) ? $_SERVER['SERVER_ADDR'] : $_SERVER['SERVER_NAME'],
                'CREATED_DT' => get_now_jst(),
            );

            $logPath = APPPATH . 'logs' . DS . 'request' . DS . date('Y-m') . DS;
            if (!file_exists($logPath)) {
                mkdir($logPath, 0777, true);
            }

            file_put_contents($logPath . date('d') . '.log', implode("\t", $logData) . "\n", FILE_APPEND);
            return true;
        }
        return true;
    }

    /**
     * レスポンスを保存する（スタティックメソッド）
     */
    public static function static_save($response, $TYPE)
    {
        $params = \Input::all();
        global $LOG_SEQ_NO;
        $logData = array(
            'LOG_TYPE' => 2,
            'UNIQUE_KEY' => $LOG_SEQ_NO,
            'IP' => $_SERVER['REMOTE_ADDR'],
            'UUID' => empty($params['UUID']) ? '' : $params['UUID'],
            'URI' => $_SERVER['REQUEST_URI'],
            'METHOD' => '',
            'HEADER' => '',
            'REQUEST' => '',
            'CLIENT_SEQ_NO' => '',
            'CLIENT_ID' => '',
            'TYPE' => $TYPE,
            'RESPONSE' =>json_encode($response),
            'CREATED_USER' => (isset($_SERVER['SERVER_ADDR'])) ? $_SERVER['SERVER_ADDR'] : $_SERVER['SERVER_NAME'],
            'CREATED_DT' => gmdate('Y-m-d H:i:s', strtotime('+9 hours')),
        );

        $logPath = APPPATH . 'logs' . DS . 'request'. DS . date('Y-m') . DS;
        if (!file_exists($logPath)) {
            mkdir($logPath, 0777, true);
        }

        file_put_contents($logPath . date('d') . '.log', implode("\t", $logData) . "\n", FILE_APPEND);
        return true;
    }
}
