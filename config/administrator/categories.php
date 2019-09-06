<?php

    use App\Models\Category;

    return [
        'title'     => 'Categories',
        'single'    => 'Categories',
        'model'     => Category::class,

        // Separate permission control for CRUD actions, other actions are not specified to pass by default
        'action_permissions' => [
            // Delete permission control
            'delete' => function () {
                // Only the webmaster can delete the topic category.
                return Auth::user()->hasRole('Founder');
            },
        ],

        'columns' => [
            'id' => [
                'title' => 'ID',
            ],
            'name' => [
                'title' => 'Name',
                'sortable' => false,
            ],
            'description' => [
                'title' => 'Description',
                'sortable' => false,
            ],
            'operation' => [
                'title' => 'Manage',
                'sortable' => false,
            ],
        ],
        'edit_fields' => [
            'name' => [
                'title' => 'Name',
            ],
            'description' => [
                'title' => 'Description',
                'type' => 'textarea',
            ],
        ],
        'filters' => [
            'id' => [
                'title' => 'Category ID',
            ],
            'name' => [
                'title' => 'Name',
            ],
            'description' => [
                'title' => 'Description',
            ],
        ],
        'rules' => [
            'name' => 'required|min:1|unique:categories'
        ],
        'messages' => [
            'name.unique'   => 'The category name is duplicated in the database. Please choose a different name.',
            'name.required' => 'Please make sure the name is at least one character or more.',
        ],
    ];
