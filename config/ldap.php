<?php

return [
    'plugins' => [
        'adldap' => [
            'account_suffix'     => '@canoas.ifrs.edu.br',
            'domain_controllers' => [
                '200.17.91.3',
                // 'dc02.domain.local',
            ], // Load balancing domain controllers
            'base_dn'        => 'DC=canoas,DC=ifrs,DC=edu,DC=br',
            // 'admin_username' => 'admin', // This is required for session persistance in the application
            // 'admin_password' => 'yourPassword',
        ],
    ],
];
