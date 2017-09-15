<?php
return [
 //   ['class' => 'frontend\rules\url\CategoryUrlRule', 'connectionID' => 'db'],
    '<action:(login|registration|logout|recovery|reset)>' => 'auth/<action>',
    '/vybor-goroda' => 'location/vybor-goroda',
    '/im' => 'users/im',
    /**
     * Класс правила ГОРОД
     */
    [
        'class' => 'frontend\rules\url\LocationUrlRule',
        'pattern' => '/<city:\w+>',
        'route' => 'site/index',
    ],
    /**
     * Класс правила КАТЕГОРИЯ/ГОРОД
     */
    [
        'class' => 'frontend\rules\url\LocationCategoryUrlRule',
        'pattern' => '/<category:([0-9a-zA-Z\-]+)>/<city:\w+>',
        'route' => 'categories/index',
        'defaults' => ['city' => null],
    ],
    /**
     * Класс правила ПРОДАТЬ/КАТЕГОРИЯ/ГОРОД
     */
    [
        'class' => 'frontend\rules\url\LocationCategoryUrlRule',
        'pattern' => '/<category:([0-9a-zA-Z\-]+)>/<placement:\w+>/<city:\w+>',
        'route' => 'categories/index',
        'defaults' => ['city' => null],
    ],
    /**
     * Класс правила ГОРОД
     */
    [
        'class' => 'frontend\rules\url\SelectLocationUrlRule',
        'pattern' => '/<select-location>/<domain:\w+>',
        'route' => 'location/select-location',
    ],
];