<?php

return [
    'title' => 'Site settings',

    // Access judgment
    'permission'=> function()
    {
        // Only allow the webmaster to manage site configuration
        return Auth::user()->hasRole('Founder');
    },

    // Site configuration form
    'edit_fields' => [
        'site_name' => [
            // Form title
            'title' => 'Site name',

            // Form entry type
            'type' => 'text',

            // Word count limit
            'limit' => 50,
        ],
        'contact_email' => [
            'title' => 'Contact mailbox',
            'type' => 'text',
            'limit' => 50,
        ],
        'seo_description' => [
            'title' => 'SEO - Description',
            'type' => 'textarea',
            'limit' => 250,
        ],
        'seo_keyword' => [
            'title' => 'SEO - Keywords',
            'type' => 'textarea',
            'limit' => 250,
        ],
    ],

    // 表单验证规则
    'rules' => [
        'site_name' => 'required|max:50',
        'contact_email' => 'email',
    ],

    'messages' => [
        'site_name.required' => 'Please fill in the site name.',
        'contact_email.email' => 'Please fill in the correct contact email format.',
    ],

    // The triggered hook of the data is about to be maintained, and the data submitted by the user can be modified.
    'before_save' => function(&$data)
    {
        // Add a suffix to the site name, plus the judgment is to prevent multiple additions.
        if (strpos($data['site_name'], 'Powered by Garfield') === false) {
            $data['site_name'] .= ' - Powered by Garfield';
        }
    },

    // You can customize multiple actions, each of which is the "Other Actions" section at the bottom of the settings page.
    'actions' => [

        // Empty the cache
        'clear_cache' => [
            'title' => 'Update system cache',

            // Reminders for pages in different states
            'messages' => [
                'active' => 'Emptying cache...',
                'success' => 'The cache has been cleared.',
                'error' => 'An error occurred while emptying the cache.',
            ],

            // Action execution code, note that you can change the configuration information by modifying the $data parameter.
            'action' => function(&$data)
            {
                \Artisan::call('cache:clear');
                return true;
            }
        ],
    ],
];
