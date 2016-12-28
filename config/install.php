<?php
return [
    'modules' => [
        'install' => [
            'class' => 'nhockizi\install\InstallModule',
        ],
    ],
    'components' => [
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '<controller:\w+>/<action:[\w-]+>/<id:\d+>' => '<controller>/<action>',
                '<module:\w+>/<controller:\w+>/<action:[\w-]+>/<id:\d+>' => '<module>/<controller>/<action>'
            ],
        ],
        'formatter' => [
            'sizeFormatBase' => 1000
        ],
    ],
    'bootstrap' => ['install']
];