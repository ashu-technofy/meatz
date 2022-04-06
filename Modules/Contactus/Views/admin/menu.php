<?php

$menu['Content']['Contactus'] = [
    'title' => __("Messages & Claims"),
    'link' => 'contactus.index',
    'icon' => 'fas fa-envelope',
    'count' => [
        'count' => \Modules\Contactus\Models\Contactus::where('seen', null)->count(),
        'class' => 'messages_count',
    ],
];
