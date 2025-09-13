<?php

return [
    /**
     * Control if the seeder should create a user per role while seeding the data.
     */
    'create_users' => false,

    /**
     * Control if all the laratrust tables should be truncated before running the seeder.
     */
    'truncate_tables' => true,

    'roles_structure' => [
        'administrator' => [
            'permissions' => [
                'profile' => 'r,u',
                'employees' => 'l',
                'posts' => 'c,r,u,l,d',
                'settings' => 'l,u'
            ]
        ],
        'employee' => [
            'permissions' => [
                'profile' => 'r,u',
                'posts' => 'c,r,u,l,d',
            ]
        ]

    ],

    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete',
        'l' => 'list',
    ],
];
