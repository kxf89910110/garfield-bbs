<?php

    use Spatie\Permission\Models\Role;

    return [
        'title'     => 'Character',
        'single'    => 'Character',
        'model'     => Role::class,

        'permission'=> function()
        {
            return Auth::user()->can('manage_users');
        },

        'columns' => [
            'id' => [
                'title' => 'ID',
            ],
            'name' => [
                'title' => 'Identification'
            ],
            'permissions' => [
                'title' => 'Permissions',
                'output' => function ($value, $model) {
                    $model->load('permissions');
                    $result = [];
                    foreach ($model->permissions as $permission) {
                        $result[] = $permission->name;
                    }

                    return empty($result) ? 'N/A' : implode($result, '|');
                }
            ],
            'operation' => [
                'title' => 'Manage',
                'output' => function ($value, $model) {
                    return $value;
                },
                'sortable' => false,
            ],
        ],

        'edit_fields' => [
            'name' => [
                'title' => 'Identification',
            ],
            'permissions' => [
                'type' => 'relationship',
                'title' => 'Permissions',
                'name_field' => 'name',
            ],
        ],

        'filters' => [
            'id' => [
                'title' => 'ID',
            ],
            'name' => [
                'title' => 'Identification',
            ]
        ],

        // Form validation rules for new and edited
        'rules' => [
            'name' => 'required|max:15|unique:roles,name',
        ],

        // Custom error message when form validation error
        'messages' => [
            'name.required' => '',
            'name.unique' => '',
        ]
    ];
