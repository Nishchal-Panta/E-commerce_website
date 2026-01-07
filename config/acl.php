<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Authorized Admin Emails
    |--------------------------------------------------------------------------
    |
    | List of email addresses that are authorized to access the admin panel.
    | Users with these emails will automatically be granted admin access
    | regardless of their role in the database.
    |
    */

    'authorized_admin_emails' => [
        'admin@ecommerce.com',
        // Add more admin emails here
        // 'another.admin@example.com',
    ],

    /*
    |--------------------------------------------------------------------------
    | Super Admin Emails
    |--------------------------------------------------------------------------
    |
    | Super admins have full access to all system features including
    | user management and system settings.
    |
    */

    'super_admin_emails' => [
        'admin@ecommerce.com',
    ],
];
