<?php

return [
    'role_item' => array(
        // メニュー情報
        'menu' => array(
            'REF_NAME' => 'コンソール',
            'main' => array(
                'index',
            ),
        ),
        //アカウント管理
        'userinfo_common' => array(
            'REF_NAME' => 'アカウント管理_パスワードを変更',
            'userinfo' => array(
                'password' => array(
                    'change',
                    'changed',
                ),
            ),
        ),
        'userinfo_master' => array(
            'REF_NAME' => 'アカウント管理_アカウント一覧',
            'userinfo' => array(
                'admin' => array(
                    'user_info',
                    'user_rights_setting',
                    'add_user',
                    'remove_user',
                    'user_rights_download',
                    'edit_user',
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
//        'goods_regist' => array(
//            'REF_NAME' => '製品情報_情報登録',
//            'goods' => array(
//                'goods_add',
//                'goods_regist',
//            ),
//        ),
        'goods_list' => array(
            'REF_NAME' => '製品情報_情報一览',
            'goods' => array(
                'goods_lists',
                'goods_edit',
                'goods_add',
                'goods_regist',
            ),
            'api' => array(
                'goods' => array(
                    'goods_delete',
                    'goods_restore'
                )
            )
        ),
//        'goods_lableregist' => array(
//            'REF_NAME' => '製品情報_タグ登録',
//            'goods' => array(
//                'goods_lableadd',
//                'goods_lableregist',
//            ),
//        ),
        'goods_lablelist' => array(
            'REF_NAME' => '製品情報_タグ一覧',
            'goods' => array(
                'goods_lablelists',
                'goods_lableedit',
                'goods_lableadd',
                'goods_lableregist',
            ),
            'api' => array(
                'goods' => array(
                    'goods_labledelete',
                    'goods_lablerestore'
                )
            )
        ),
//        'goods_bannerregist' => array(
//            'REF_NAME' => '製品情報_製品バナー登録',
//            'goods' => array(
//                'goods_banneradd',
//                'goods_bannerregist',
//            ),
//        ),
        'goods_bannerlist' => array(
            'REF_NAME' => '製品情報_バナー一覧',
            'goods' => array(
                'goods_bannerlists',
                'goods_banneredit',
                'goods_banneradd',
                'goods_bannerregist',
            ),
            'api' => array(
                'goods' => array(
                    'goods_bannerdelete',
                    'goods_bannerrestore'
                )
            )
        ),

        //導入企業-事例
//        'setting_recedents_regist' => array(
//            'REF_NAME' => '導入企業-事例_導入事例登録',
//            'setting' => array(
//                'recedents_add',
//                'recedents_regist',
//            ),
//        ),
        'imports_recedents' => array(
            'REF_NAME' => '導入情報_事例一覧',
            'imports' => array(
                'recedents_lists',
                'recedents_edit',
                'recedents_add',
                'recedents_regist',
            ),
            'api' => array(
                'imports' => array(
                    'recedents_delete',
                    'recedents_restore'
                )
            )
        ),

        'imports_company' => array(
            'REF_NAME' => '導入情報_企業一覧',
            'imports' => array(
                'company_lists',
                'company_edit',
                'company_add',
                'company_regist',
            ),
            'api' => array(
                'imports' => array(
                    'company_delete',
                    'company_restore'
                )
            )
        ),

        'imports_lable' => array(
            'REF_NAME' => '導入情報_タグ一覧',
            'imports' => array(
                'lable_lists',
                'lable_edit',
                'lable_add',
                'lable_regist',
            ),
            'api' => array(
                'imports' => array(
                    'lable_delete',
                    'lable_restore'
                )
            )
        ),

        'news_news' => array(
            'REF_NAME' => '新着情報_ニュース一覧',
            'news' => array(
                'news_lists',
                'news_edit',
                'news_add',
                'news_regist',
            ),
            'api' => array(
                'news' => array(
                    'news_delete',
                    'news_restore'
                )
            )
        ),

        'seminar_exhibition' => array(
            'REF_NAME' => 'セミナー展示会情報_セミナー展示会一覧',
            'seminar' => array(
                'exhibition_lists',
                'exhibition_edit',
                'exhibition_add',
                'exhibition_regist',
            ),
            'api' => array(
                'seminar' => array(
                    'exhibition_delete',
                    'exhibition_restore'
                )
            )
        ),

        'seminar_teacher' => array(
            'REF_NAME' => 'セミナー展示会情報_講師一覧',
            'seminar' => array(
                'teacher_lists',
                'teacher_edit',
                'teacher_add',
                'teacher_regist',
            ),
            'api' => array(
                'seminar' => array(
                    'teacher_delete',
                    'teacher_restore'
                )
            )
        ),

        'seminar_lable' => array(
            'REF_NAME' => 'セミナー展示会情報_タグ一覧',
            'seminar' => array(
                'lable_lists',
                'lable_edit',
                'lable_add',
                'lable_regist',
            ),
            'api' => array(
                'seminar' => array(
                    'lable_delete',
                    'lable_restore'
                )
            )
        ),

        'management_site' => array(
            'REF_NAME' => '運営サイト_運営一覧',
            'management' => array(
                'site_lists',
                'site_edit',
                'site_add',
                'site_regist',
            ),
            'api' => array(
                'management' => array(
                    'site_delete',
                    'site_restore'
                )
            )
        ),

        'download_file' => array(
            'REF_NAME' => 'ダウンロード情報_ファイル一覧',
            'download' => array(
                'file_lists',
                'file_edit',
                'file_add',
                'file_regist',
            ),
            'api' => array(
                'download' => array(
                    'file_delete',
                    'file_restore'
                )
            )
        ),

        'download_category' => array(
            'REF_NAME' => 'ダウンロード情報_カテゴリ一覧',
            'download' => array(
                'category_lists',
                'category_edit',
                'category_add',
                'category_regist',
            ),
            'api' => array(
                'download' => array(
                    'category_delete',
                    'category_restore'
                )
            )
        ),

        'download_history' => array(
            'REF_NAME' => 'ダウンロード情報_ダウンロード履歴',
            'download' => array(
                'history_lists',
                'history_edit',
                'history_add',
                'history_regist',
            ),
            'api' => array(
                'download' => array(
                    'history_delete',
                    'history_restore'
                )
            )
        ),
    ),
];
