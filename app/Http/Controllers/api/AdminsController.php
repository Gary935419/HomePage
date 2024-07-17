<?php

namespace App\Http\Controllers\api;

use App\Models\AuthGroupOtbSimpleGroup;
use App\Models\Admins;
use OSS\Core\OssException;
use OSS\OssClient;

class AdminsController extends Controller
{
    /**
     * 管理画面用户权限操作
     */
    public function action_user_rights_setting()
    {
        try {
            $input = request()->all();
            $admin_user_role_code = $input['ADMIN_ROLE_CODE'];
            $rights = $input['RIGHTS'];
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

            $result_date['clients_info'] = explode('_', $role_name)[1];
            $result_date['right_categories'] = $right_categories;
            $result_date['admin_user_role_code'] = $admin_user_role_code;
            if (is_array($rights)) {
                $result = AuthGroupOtbSimpleGroup::set_admin_user_roles($input);
                if ($result) {
                    return $this->ok($result_date);
                }
            }
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * 图片上传
     */
    public function actionUploadImg()
    {
        try {
            //获取上传文件信息
            $filename = explode(".",$_FILES["file"]['name']);
            //获取上传文件后缀名
            $file_extension_name = array_pop($filename);
            //设置文件保存目录
            if ($file_extension_name === 'jpg' || $file_extension_name === 'png' || $file_extension_name === 'gif'
                || $file_extension_name === 'bmp' || $file_extension_name === 'jpeg' || $file_extension_name === 'webp'){
                $upload_type = "images";
            }elseif ($file_extension_name === 'mp4'){
                $upload_type = "videos";
            }elseif ($file_extension_name === 'pdf'){
                $upload_type = "files";
            }else{
                $upload_type = "files";
//                $result = array('RESULT' => 'ERROR','MESSAGE' => 'ファイルアップロードの例外、指定されたタイプのファイルをアップロードしてください。');
//                return $this->ok($result);
            }

            $date = date("Ymd");
            $upload_dir = "./uploads/".$upload_type."/";
            //生成目标文件的文件名
            $name = $date."/".uniqid().".".$file_extension_name;
            $upload_file_path = $upload_dir . $name ;
            $file_relative_path = "uploads/".$upload_type."/".$date;
            $file_path = public_path($file_relative_path);
            if (!is_dir($file_path)){
                mkdir($file_path);
            }
            //服务器上传备份
            move_uploaded_file($_FILES["file"]['tmp_name'], $upload_file_path);

            $img_url = "/uploads/".$upload_type."/".$name;

            $response['SRC'] = $img_url;
            return $this->ok($response);
        } catch (\Exception $e) {
            return $this->error($e->getMessage() . chr(10) . $e->getTraceAsString());
        }
    }
}
