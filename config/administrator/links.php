<?php

use App\Models\Link;

return [
    'title'     => 'Resource recommendation',
    'single'    => 'Resource recommendation',

    'model'     => Link::class,

    //
    'permission'=> function()
    {
        //
        return Auth::user()->hasRole('Founder');
    },

    'columns' => [
        'id' => [
            'title' => 'ID',
        ],
        'title' => [
            'title'     => 'Name',
            'sortable'  => false,
        ],
        'link' => [
            'title'     => 'Link',
            'sortable'  => false,
        ],
        'operation' => [
            'title' => 'Manage',
            'sortable' => false,
        ],
    ],
    'edit_fields' => [
        'title' => [
            'title'     => 'Name',
        ],
        'link' => [
            'title'     => 'Link',
        ],
    ],
    'filters' => [
        'id' => [
            'title' => 'Tag ID',
        ],
        'title' => [
            'title' => 'Name',
        ],
    ],
];
