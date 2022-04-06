<?php

$menu['Orders*'] = [
    [
        'title' =>  __("Ordered"),
        'link'  =>  'orders.index',
        'icon'  =>  'fas fa-th-list',
        'query' =>  ['status' => 'pending'],
        'count' =>  [
            'count' => \Modules\Orders\Models\Order::where('status', 'pending')->whereNull('seen')->count(),
            'class' => 'orders_count'
        ]
    ],
    [
        'title' =>  __("Paid"),
        'link'  =>  'orders.index',
        'icon'  =>  'fas fa-check',
        'query' =>  ['status' => 'paid']
    ],
    [
        'title' =>  __("On the way"),
        'link'  =>  'orders.index',
        'icon'  =>  'fas fa-car',
        'query' =>  ['status' => 'on the way']
    ],
    [
        'title' =>  __("Delivered"),
        'link'  =>  'orders.index',
        'icon'  =>  'fas fa-check',
        'query' =>  ['status' => 'delivered']
    ],
    [
        'title' =>  __("Canceled"),
        'link'  =>  'orders.index',
        'icon'  =>  'fas fa-times',
        'query' =>  ['status' => 'canceled']
    ],
    [
        'title' =>  __("Cancellation Requests"),
        'link'  =>  'orders.index',
        'icon'  =>  'fas fa-th-list',
        'query' =>  ['status' => 'cancel_request'],
        'count' =>  [
            'count' => \Modules\Orders\Models\Order::where('status', 'cancel_request')->whereNull('seen')->count(),
            'class' => 'cancel_orders_count'
        ]
    ],
];
