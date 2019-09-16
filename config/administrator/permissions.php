<?php

    use Spatie\Permission\Models\Permission;

    return [
        'title'     => 'Permission',
        'single'    => 'Permission',
        'model'     => Permission::class,

        'permission' => function () {
            return Auth::user()->can('manage_users');
        },

        // Separate permission control for CRUD actions, controlling permissions by returning Boolean values.
        'action_permissions' => [
            // Control the display of the "New Button"
            'create' => function ($model) {
                return true;
            },
            // Allow updates
            'update' => function ($model) {
                return true;
            },
            // Don't allow deletion
            'delete' => function ($model) {
                return false;
            },
            // Allow viewing
            'view' => function ($model) {
                return true;
            },
        ],

        'columns' => [
            'id' => [
                'title' => 'ID',
            ],
            'name' => [
                'title' => 'Marking',
            ],
            'operation' => [
                'title' => 'Manage',
                'sortable' => false,
            ],
        ],

        'edit_fields' => [
            'name' => [
                'title' => 'Marking(Please modify carefully)',

                // "Prompt information" next to the title of the form entry
                'hint' => 'Modifying the permission ID will affect the call of the code, please do not change it easily.'
            ],
            'roles' => [
                'type' => 'relationship',
                'title' => 'Character',
                'name_field' => 'name',
            ],
        ],

        'filters' => [
            'name' => [
                'title' => 'Marking',
            ],
        ],
    ];
