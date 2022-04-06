<?php

$menu['Stores*'] = [
    [
        'title' => __("Stores"),
        'link' => 'stores.index',
        'icon' => 'fas fa-map-marker',
    ],
    [
        'title' => __("Default period"),
        'link' => 'store_periods',
        'icon' => 'fas fa-clock',
        'query' => ['store_id' => 0]
    ],
    [
        'title' => __("Categories"),
        'link' => 'categories.index',
        'icon' => 'fas fa-th-large',
    ],
    [
        'title' => __("SubCategories"),
        'link' => 'subcategories.index',
        'icon' => 'fas fa-th-large',
    ],
    [
        'title' => __("Boxes"),
        'link' => 'products.index',
        'icon' => 'fas fa-th-large',
        'query' => ['type' => 'box'],
    ],
    [
        'title' => __("Stores offers"),
        'link' => 'products.index',
        'icon' => 'fas fa-th-large',
        'query' => ['type' => 'special_box'],
    ],
    [
        'title' => __("Options"),
        'link' => 'options.index',
        'icon' => 'fas fa-th-large',
    ],
];

if (auth('stores')->check()) {
    // $menu['Places']['Categories'] = [
    //     'title' => __("Categories"),
    //     'link' => 'categories.index',
    //     'icon' => 'fas fa-th-large',
    // ];

    // $menu['Places']['Options'] = [
    //     'title' => __("Options"),
    //     'link' => 'options.index',
    //     'icon' => 'fas fa-th-list',
    // ];

    $menu['Stores*'][] = [
        'title' => __("Products"),
        'link' => 'products.index',
        'icon' => 'fab fa-apple',
    ];
}
//  else {
//     $menu['Places']['StoresRequests'] = [
//         'title' => __("Join Requests"),
//         'link' => 'stores.index',
//         'query' => ['type' => 'request'],
//         'icon' => 'fas fa-th-list',
//         'count' =>  [
//             'count' => \Modules\Stores\Models\Store::where('type' , 'request')->count(),
//             'class' =>  'requests_count'
//         ]
//     ];
// }
