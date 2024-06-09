<?php

return [
    'role_item' => array(
        // 菜单信息
        'menu' => array(
            'REF_NAME' => '控制台',
            'main' => array(
                'index',
            ),
        ),
        //账户管理
        'userinfo_common' => array(
            'REF_NAME' => '账户管理_修改密码',
            'userinfo' => array(
                'password' => array(
                    'change',
                    'changed',
                ),
            ),
        ),
        'userinfo_master' => array(
            'REF_NAME' => '账户管理_账户一览',
            'userinfo' => array(
                'admin' => array(
                    'user_info',
                    'user_rights_setting',
                    'add_user',
                    'remove_user',
                    'user_rights_download',
                ),
                'force_password_change',
            ),
            'api' => array(
                'admins' => array(
                    'user_rights_setting',
                ),
            ),
        ),

        //製品情報
        'goods_regist' => array(
            'REF_NAME' => '製品情報_追加情報',
            'goods' => array(
                'goods_add',
                'goods_regist',
            ),
        ),
        'goods_list' => array(
            'REF_NAME' => '製品情報_情報一览',
            'goods' => array(
                'goods_lists',
                'goods_search_edit',
            ),
            'api' => array(
                'goods' => array(
                    'search_goods',
                    'goods_delete',
                    'goods_restore'
                )
            )
        ),

        //设置管理
        'setting_banner_regist' => array(
            'REF_NAME' => '设置管理_Banner添加',
            'setting' => array(
                'banner_add',
                'banner_regist',
            ),
        ),
        'setting_banner' => array(
            'REF_NAME' => '设置管理_Banner一览',
            'setting' => array(
                'banner_lists',
                'banner_search_edit',
            ),
            'api' => array(
                'setting' => array(
                    'search_banner',
                    'banner_delete',
                    'banner_restore'
                )
            )
        ),
    ),
];
