<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function root()
    {
        return view('pages.root');
    }

    public function permissionDenied()
    {
        // If the current user has permission to access the background, direct jump access.
        if (config('administrator.permission')()) {
            return redirect(url(config('administrator.uri')), 302);
        }
        // Otherwise use view
        return view('pages.permission_denied');
    }
}
