<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Models (Database Column) Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the system text in backend platform page.
    |
    */

    'Administrator' => [
        'id' => 'ID',
        'guid' => 'GUID',
        'username' => 'Username',
        'password' => 'Password',
        'password_confirmation' => 'Confirm Password',
        'name' => 'Name',
        'allow_ip' => 'IP Whitelist',
        'active' => 'Active',
        'created_at' => 'Created At',
        'updated_at' => 'Updated At',
        'selection' => [
            'active' => [
                '1' => 'On',
                '0' => 'Off',
            ],
        ],
        'hint' => [
            'allow_ip' => 'Input ip address with enter for whitelist. Keep empty to allow everywhere.',
            'password' => 'If you do not change password, please keep empty.',
            'password_confirmation' => 'Insert password again. If you do not change password, please keep empty.',
        ],
    ],

    'Admin' => [
        'id' => 'ID',
        'guid' => 'GUID',
        'role_id' => 'Role',
        'username' => 'Username',
        'password' => 'Password',
        'password_confirmation' => 'Confirm Password',
        'name' => 'Name',
        'email' => 'Email',
        'active' => 'Active',
        'created_at' => 'Created At',
        'updated_at' => 'Updated At',
        'selection' => [
            'active' => [
                '1' => 'On',
                '0' => 'Off',
            ],
        ],
        'hint' => [
            'password' => 'If you do not change password, please keep empty.',
            'password_confirmation' => 'Insert password again. If you do not change password, please keep empty.',
        ],
    ],

    'AdminMenuClass' => [
        'id' => 'ID',
        'guid' => 'GUID',
        'title' => 'Class Name',
        'sort' => 'Sort',
        'active' => 'Active',
        'created_at' => 'Created At',
        'updated_at' => 'Updated At',
        'selection' => [
            'active' => [
                '1' => 'On',
                '0' => 'Off',
            ],
        ],
    ],

    'AdminMenuItem' => [
        'id' => 'ID',
        'guid' => 'GUID',
        'lang' => 'Language',
        'title' => 'Title',
        'uri' => 'Uri',
        'controller' => 'Controller Name',
        'model' => 'Model Name',
        'class' => 'Class',
        'parent' => 'Parent Menu',
        'link' => 'Link',
        'icon' => 'Icon Class',
        'filter' => 'Data Filter (where)',
        'keeps' => 'Keep GUID',
        'sort' => 'Sort',
        'active' => 'Active',
        'created_at' => 'Created At',
        'updated_at' => 'Updated At',
        'selection' => [
            'active' => [
                '1' => 'On',
                '0' => 'Off',
            ],
        ],
        'hint' => [
            'icon' => 'Only (root) using. Please check <a target="_blank" href="/admin/css/fonts/icon/demo.html">Icon List</a> for usage.',
        ],
    ],

    'MerchantMenuClass' => [
        'id' => 'ID',
        'guid' => 'GUID',
        'title' => 'Class Name',
        'sort' => 'Sort',
        'active' => 'Active',
        'created_at' => 'Created At',
        'updated_at' => 'Updated At',
        'selection' => [
            'active' => [
                '1' => 'On',
                '0' => 'Off',
            ],
        ],
    ],

    'MerchantMenuItem' => [
        'id' => 'ID',
        'guid' => 'GUID',
        'lang' => 'Language',
        'title' => 'Title',
        'uri' => 'Uri',
        'model' => 'Model Name',
        'class' => 'Class',
        'parent' => 'Parent Menu',
        'link' => 'Link',
        'icon' => 'Icon Class',
        'filter' => 'Data Filter (where)',
        'keeps' => 'Keep GUID',
        'sort' => 'Sort',
        'active' => 'Active',
        'created_at' => 'Created At',
        'updated_at' => 'Updated At',
        'selection' => [
            'active' => [
                '1' => 'On',
                '0' => 'Off',
            ],
        ],
        'hint' => [
            'icon' => 'Only (root) using. Please check <a target="_blank" href="/admin/css/fonts/icon/demo.html">Icon List</a> for usage.',
        ],
    ],

    'Role' => [
        'id' => 'ID',
        'guard' => 'Platform',
        'name' => 'Unique Code',
        'display_name' => 'Role Name',
        'description' => 'Description',
        'active' => 'Active',
        'created_at' => 'Created At',
        'updated_at' => 'Updated At',
        'selection' => [
            'active' => [
                '1' => 'On',
                '0' => 'Off',
            ],
        ],
    ],

    'Permission' => [
        'id' => 'ID',
        'guard' => 'Platform',
        'name' => 'Unique Code',
        'group' => 'Group',
        'label' => 'Label',
        'display_name' => 'Permission Name',
        'description' => 'Description',
        'active' => 'Active',
        'created_at' => 'Created At',
        'updated_at' => 'Updated At',
        'selection' => [
            'active' => [
                '1' => 'On',
                '0' => 'Off',
            ],
        ],
    ],

    'Language' => [
        'id' => 'ID',
        'guid' => 'GUID',
        'title' => 'Title',
        'codes' => 'Code',
        'name' => 'Name',
        'icon' => 'Icon Class',
        'sort' => 'Sort',
        'active' => 'Active',
        'created_at' => 'Created At',
        'updated_at' => 'Updated At',
        'selection' => [
            'active' => [
                '1' => 'On',
                '0' => 'Off',
            ],
        ],
    ],

    'Firewall' => [
        'id' => 'ID',
        'guid' => 'GUID',
        'guard' => 'Platform',
        'ip' => 'IP Address',
        'rule' => 'Rule',
        'active' => 'Active',
        'created_at' => 'Created At',
        'updated_at' => 'Updated At',
        'selection' => [
            'rule' => [
                '1' => 'Allow',
                '0' => 'Deny',
            ],
            'active' => [
                '1' => 'On',
                '0' => 'Off',
            ],
        ],
    ],

    'WebData' => [
        'id' => 'ID',
        'guid' => 'GUID',
        'lang' => 'Language',
        'website_name' => 'Site Name',
        'system_email' => 'System Email',
        'system_url' => 'System URL',
        'company_name' => 'Company Name',
        'company_name_en' => 'Company Name (EN)',
        'company_id' => 'Company ID',
        'phone' => 'Phone',
        'fax' => 'Fax',
        'email' => 'Service Email',
        'address' => 'Address',
        'map_lng' => 'Map Lng.',
        'map_lat' => 'Map Lat.',
        'map_url' => 'Map Link',
        'link_facebook' => 'Facebook',
        'link_instagram' => 'Instagram',
        'link_twitter' => 'Twitter',
        'link_gplus' => 'Google+',
        'link_youtube' => 'Youtube',
        'seo_description' => 'SEO Description',
        'seo_keywords' => 'SEO Keywords',
        'google_analytics' => 'Google Analytics',
        'active' => 'Active',
        'offline_text' => 'Offline Text',
        'created_at' => 'Created At',
        'updated_at' => 'Updated At',
        'hint' => [
            'seo_description' => '(Metadata Description) Short description make people understand what your website support.',
            'seo_keywords' => '(Metadata Keywords) please separate keywords with comma.',
            'offline_text' => 'The text information show out when website is offline.',
        ],
        'selection' => [
            'active' => [
                '1' => 'On',
                '0' => 'Off',
            ],
        ],
    ],

    'SystemLog' => [
        'id' => 'ID',
        'guard' => 'Platform',
        'uri' => 'URI',
        'action' => 'Action',
        'guid' => 'Action ID',
        'username' => 'Username',
        'ip' => 'IP',
        'note' => 'Note',
        'result' => 'Result',
        'created_at' => 'Created At',
        'updated_at' => 'Updated At',
        'selection' => [
            'result' => [
                '1' => 'Success',
                '0' => 'Failure',
            ],
        ],
    ],

    'LoginLog' => [
        'id' => 'ID',
        'guard' => 'Platform',
        'username' => 'Username',
        'ip' => 'IP',
        'note' => 'Note',
        'result' => 'Result',
        'created_at' => 'Created At',
        'updated_at' => 'Updated At',
        'selection' => [
            'result' => [
                '1' => 'Success',
                '0' => 'Failure',
            ],
        ],
    ],

];