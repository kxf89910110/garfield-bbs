<?php

use App\Models\User;

return [
    // Page title
    'title' => 'User',

    // Model singular, used as the page 『new $single』
    'single' => 'User',

    // Data model, CRUD used as data
    'model' => User::class,

    // Set the access rights of the current page and control the permissions by returning a Boolean value.
    // Returning True means that by permission, False has no access and is hidden from the Menu.
    'permission' => function()
    {
        return Auth::user()->can('manage_users');
    },

    // The field is responsible for rendering the 『data table』, which consists of a myriad of 『columns』.
    'columns' => [

        // Column labeling, this is an example of minimizing the configuration of the 『coulumn』 information, reading the corresponding in the model, such as $model->id
        'id',

        'avatar' => [
            // The name of the column in the data table. By default, the column identifier is used.
            'title' => 'Avatar',

            // By default, data is output directly, or you can use the output option to customize the output.
            'output' => function ($avatar, $model) {
                return empty($avatar) ? 'N/A' : '<img src="'.$avatar.'" width="40">';
            },

            // Whether to allow sorting
            'sortable' => false,
        ],

        'name' => [
            'title' => 'Username',
            'sortable' => false,
            'output' => function ($name, $model) {
                return '<a href="/users/'.$model->id.'" target=_blank>'.$name.'</a>';
            },
        ],

        'email' => [
            'title' => 'Email',
        ],

        'operation' => [
            'title' => 'Manage',
            'sortable' => false,
        ],
    ],

    // 『Model Form』 setting item
    'edit_fields' => [
        'name' => [
            'title' => 'Username',
        ],
        'email' => [
            'title' => 'Email',
        ],
        'password' => [
            'title' => 'Password',

            // Form use input type password
            'type' => 'password',
        ],
        'avatar' => [
            'title' => 'Profile Picture',

            // Set the type of the form entry, the default type is input
            'type' => 'image',

            // Image upload must set the image storage path
            'location' => public_path() . '/uploads/images/avatars/'
        ],
        'roles' => [
            'title' => 'User role',

            // Specify the type of data as an association model
            'type' => 'relationship',

            // The field of the associated model, used to display the association
            'name_field' => 'name',
        ],
    ],

    // 『Data filtering』 settings
    'filters' => [
        'id' => [

            // Filter form entry display name
            'title' => 'User id',
        ],
        'name' => [
            'title' => 'Username',
        ],
        'email' => [
            'title' => 'Email',
       ],
    ],
];
