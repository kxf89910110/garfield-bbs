<?php

use App\Models\Link;

return [
<<<<<<< HEAD
    'title'     => 'Resource recommendation',
    'single'    => 'Resource recommendation',

    'model'     => Link::class,

    //
    'permission'=> function()
    {
        //
=======
    'title'   => 'Resource recommendation',
    'single'  => 'Resource recommendation',

    'model'   => Link::class,

    // Access judgment
    'permission'=> function()
    {
        // Only the webmaster management resource recommendation link is allowed
>>>>>>> L03_5.8
        return Auth::user()->hasRole('Founder');
    },

    'columns' => [
        'id' => [
            'title' => 'ID',
        ],
        'title' => [
<<<<<<< HEAD
            'title'     => 'Name',
            'sortable'  => false,
        ],
        'link' => [
            'title'     => 'Link',
            'sortable'  => false,
        ],
        'operation' => [
            'title' => 'Manage',
=======
            'title'    => 'Name',
            'sortable' => false,
        ],
        'link' => [
            'title'    => 'Link',
            'sortable' => false,
        ],
        'operation' => [
            'title'  => 'Manage',
>>>>>>> L03_5.8
            'sortable' => false,
        ],
    ],
    'edit_fields' => [
        'title' => [
<<<<<<< HEAD
            'title'     => 'Name',
        ],
        'link' => [
            'title'     => 'Link',
=======
            'title'    => 'Name',
        ],
        'link' => [
            'title'    => 'Link',
>>>>>>> L03_5.8
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
