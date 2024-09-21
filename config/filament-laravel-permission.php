<?php

return [
    'styling' => [
        'show_form_permissions_header_actions' => true,
        'permissions_columns' => 3,
        'permissions_collapsible' => false,
        'permissions_collapsed' => false,
    ],

    'guards' => [
        'use_single_default_guard' => false,
        'default_guard' => 'nova',

        'options' => [
            'web' => 'Web',
            'api' => 'API',
            'nova' => 'Nova',
        ],
    ],
];
